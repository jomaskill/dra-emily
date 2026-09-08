<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ConvertImagesToWebp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:webp
        {--path=* : Directories to scan, relative to public/. Defaults to the whole public directory.}
        {--quality=82 : WebP encoding quality, 0-100.}
        {--force : Re-encode even when an up-to-date .webp already exists.}
        {--dry-run : Report what would be converted without writing any file.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a .webp companion for every JPEG and PNG under public/';

    /**
     * Source extensions eligible for conversion.
     *
     * @var list<string>
     */
    private const SOURCE_EXTENSIONS = ['jpg', 'jpeg', 'png'];

    /**
     * Directories never worth scanning.
     *
     * @var list<string>
     */
    private const EXCLUDED_DIRECTORIES = ['build', 'vendor', 'storage', 'hot'];

    public function handle(): int
    {
        $quality = (int) $this->option('quality');

        if ($quality < 0 || $quality > 100) {
            $this->error('Quality must be between 0 and 100.');

            return self::FAILURE;
        }

        if (! function_exists('imagewebp')) {
            $this->error('The GD extension is missing WebP support (imagewebp is undefined).');

            return self::FAILURE;
        }

        $directories = $this->resolveDirectories();

        if ($directories === []) {
            $this->error('None of the requested paths exist under public/.');

            return self::FAILURE;
        }

        $dryRun = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');

        /** @var list<array{0: string, 1: int, 2: int}> $rows */
        $rows = [];
        $skipped = 0;
        $failed = 0;
        $sourceBytes = 0;
        $webpBytes = 0;

        foreach ($this->sourceFiles($directories) as $file) {
            $source = $file->getRealPath();

            if ($source === false) {
                continue;
            }

            $target = $this->targetPath($source);

            if (! $force && $this->isUpToDate($source, $target)) {
                $skipped++;

                continue;
            }

            if ($dryRun) {
                $rows[] = [$this->relative($source), $file->getSize(), 0];

                continue;
            }

            if (! $this->encode($source, $target, $quality)) {
                $this->warn('Failed to convert '.$this->relative($source));
                $failed++;

                continue;
            }

            $before = (int) $file->getSize();
            $after = (int) filesize($target);

            $sourceBytes += $before;
            $webpBytes += $after;
            $rows[] = [$this->relative($source), $before, $after];
        }

        $this->renderReport($rows, $sourceBytes, $webpBytes, $skipped, $failed, $dryRun);

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Absolute directories to scan.
     *
     * @return list<string>
     */
    private function resolveDirectories(): array
    {
        /** @var list<string> $paths */
        $paths = $this->option('path');

        if ($paths === []) {
            return [public_path()];
        }

        $resolved = [];

        foreach ($paths as $path) {
            $absolute = public_path(trim($path, '/'));

            if (is_dir($absolute)) {
                $resolved[] = $absolute;

                continue;
            }

            $this->warn('Skipping missing directory: '.$path);
        }

        return $resolved;
    }

    /**
     * Every convertible image inside the given directories.
     *
     * @param  list<string>  $directories
     * @return iterable<SplFileInfo>
     */
    private function sourceFiles(array $directories): iterable
    {
        return Finder::create()
            ->files()
            ->in($directories)
            ->exclude(self::EXCLUDED_DIRECTORIES)
            ->name('/\.('.implode('|', self::SOURCE_EXTENSIONS).')$/i')
            ->sortByName();
    }

    /**
     * The .webp path that sits alongside a source image.
     */
    private function targetPath(string $source): string
    {
        return preg_replace('/\.[^.]+$/', '', $source).'.webp';
    }

    /**
     * Whether an existing .webp is at least as new as its source.
     */
    private function isUpToDate(string $source, string $target): bool
    {
        return is_file($target) && filemtime($target) >= filemtime($source);
    }

    /**
     * Encode one source image to WebP, preserving PNG transparency.
     */
    private function encode(string $source, string $target, int $quality): bool
    {
        $info = @getimagesize($source);

        if ($info === false) {
            return false;
        }

        $image = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($source),
            IMAGETYPE_PNG => @imagecreatefrompng($source),
            default => false,
        };

        if ($image === false) {
            return false;
        }

        if ($info[2] === IMAGETYPE_PNG) {
            imagepalettetotruecolor($image);
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        $written = @imagewebp($image, $target, $quality);
        imagedestroy($image);

        return $written && is_file($target);
    }

    /**
     * Path relative to public/, for readable output.
     */
    private function relative(string $absolute): string
    {
        return ltrim(str_replace(public_path(), '', $absolute), '/');
    }

    /**
     * Print the conversion table and totals.
     *
     * @param  list<array{0: string, 1: int, 2: int}>  $rows
     */
    private function renderReport(array $rows, int $sourceBytes, int $webpBytes, int $skipped, int $failed, bool $dryRun): void
    {
        if ($rows === []) {
            $this->info('Nothing to convert. '.$skipped.' image(s) already up to date.');

            return;
        }

        if ($dryRun) {
            $this->table(
                ['Image', 'Current size'],
                array_map(fn (array $row): array => [$row[0], $this->humanize($row[1])], $rows)
            );
            $this->info(count($rows).' image(s) would be converted, '.$skipped.' already up to date.');

            return;
        }

        $this->table(
            ['Image', 'Before', 'WebP', 'Saved'],
            array_map(function (array $row): array {
                $saved = $row[1] > 0 ? round(100 - ($row[2] / $row[1] * 100)) : 0;

                return [$row[0], $this->humanize($row[1]), $this->humanize($row[2]), $saved.'%'];
            }, $rows)
        );

        $totalSaved = $sourceBytes > 0 ? round(100 - ($webpBytes / $sourceBytes * 100)) : 0;

        $this->info(sprintf(
            'Converted %d image(s): %s to %s, %d%% smaller. %d skipped, %d failed.',
            count($rows),
            $this->humanize($sourceBytes),
            $this->humanize($webpBytes),
            $totalSaved,
            $skipped,
            $failed
        ));
    }

    /**
     * Format a byte count for display.
     */
    private function humanize(int $bytes): string
    {
        return $bytes >= 1048576
            ? round($bytes / 1048576, 1).' MB'
            : round($bytes / 1024).' KB';
    }
}
