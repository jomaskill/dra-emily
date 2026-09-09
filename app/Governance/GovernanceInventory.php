<?php

namespace App\Governance;

use DOMDocument;
use DOMXPath;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use RuntimeException;
use Symfony\Component\Process\Process;
use Throwable;

class GovernanceInventory
{
    public const COMMAND_VERSION = '1.0.0';

    public function __construct(
        private readonly Router $router,
        private readonly Kernel $kernel,
    ) {}

    /**
     * @return array{
     *     schema_version: int,
     *     decision: string,
     *     run: array{generated_at: string, revision: string, dirty_tree: string, command_version: string, target: string},
     *     items: list<array{id: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     * }
     */
    public function snapshot(string $target): array
    {
        $items = $this->canonicalizeItems([$this->homepageHeading()]);

        return [
            'schema_version' => 1,
            'decision' => 'no-change',
            'run' => [
                'generated_at' => now()->utc()->format('Y-m-d\TH:i:s.u\Z'),
                'revision' => $this->gitOutput(['git', 'rev-parse', 'HEAD'], 'unavailable'),
                'dirty_tree' => $this->gitOutput(
                    ['git', 'status', '--porcelain', '--untracked-files=no'],
                    'unavailable',
                    static fn (string $output): string => $output === '' ? 'clean' : 'dirty',
                ),
                'command_version' => self::COMMAND_VERSION,
                'target' => $target,
            ],
            'items' => $items,
        ];
    }

    /**
     * @param  array<string, mixed>  $inventory
     */
    public function write(string $target, array $inventory): void
    {
        $contents = json_encode(
            $inventory,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
        ).PHP_EOL;

        $this->writeAtomically($target, $contents);
    }

    public function writeAtomically(string $target, string $contents): void
    {
        $directory = dirname($target);

        if (! is_dir($directory) || is_link($directory) || is_link($target)) {
            throw new RuntimeException('Inventory target must be in an existing non-symlink directory.');
        }

        $canonicalTarget = (string) realpath($directory).'/'.basename($target);
        $lockPath = sys_get_temp_dir().'/draemily-governance-'.hash('sha256', $canonicalTarget).'.lock';
        $lock = fopen($lockPath, 'c');

        if ($lock === false) {
            throw new RuntimeException('Unable to open the inventory target lock.');
        }

        $temporary = $directory.'/.'.basename($target).'.tmp.'.getmypid().'.'.bin2hex(random_bytes(8));

        try {
            if (! flock($lock, LOCK_EX)) {
                throw new RuntimeException('Unable to acquire the inventory target lock.');
            }

            if (is_link($target)) {
                throw new RuntimeException('Inventory target cannot be a symlink.');
            }

            $temporaryHandle = fopen($temporary, 'x+b');

            if ($temporaryHandle === false) {
                throw new RuntimeException('Unable to create the inventory temporary file.');
            }

            try {
                $this->writeAll($temporaryHandle, $contents);
                fflush($temporaryHandle);

                if (function_exists('fsync')) {
                    fsync($temporaryHandle);
                }
            } finally {
                fclose($temporaryHandle);
            }

            if (! rename($temporary, $target)) {
                throw new RuntimeException('Unable to atomically publish the inventory.');
            }
        } finally {
            if (is_file($temporary)) {
                unlink($temporary);
            }

            flock($lock, LOCK_UN);
            fclose($lock);
        }
    }

    /**
     * @param  list<array{id: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>  $items
     * @return list<array{id: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}>
     */
    public function canonicalizeItems(array $items): array
    {
        if ($items === []) {
            throw new RuntimeException('A required public-surface inventory cannot be empty.');
        }

        $this->sortItems($items);
        $this->assertUniqueIdentities($items);

        return $items;
    }

    /**
     * @return array{id: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}
     */
    public function publicationItem(
        string $content,
        string $route,
        string $context,
        string $source,
        string $visibility = 'visible',
        string $routeName = 'home',
        ?string $locale = null,
    ): array {
        $this->assertSafeSource($source);

        $publicationLocale = $locale ?? (string) config('governance.locale', 'pt-BR');
        $stableIdentity = implode("\0", [$publicationLocale, $route, $context, $source]);

        return [
            'id' => 'publication.'.substr(hash('sha256', $stableIdentity), 0, 24),
            'content' => $content,
            'content_hash' => hash('sha256', $content),
            'locale' => $publicationLocale,
            'route' => $route,
            'route_name' => $routeName,
            'context' => $context,
            'visibility' => $visibility,
            'source' => $source,
        ];
    }

    /**
     * @return array{id: string, content: string, content_hash: string, locale: string, route: string, route_name: string, context: string, visibility: string, source: string}
     */
    private function homepageHeading(): array
    {
        $homeRoute = collect($this->router->getRoutes()->getRoutes())
            ->first(static fn ($route): bool => $route->getName() === 'home');

        if ($homeRoute === null || ! in_array('GET', $homeRoute->methods(), true)) {
            throw new RuntimeException('The named homepage route is unavailable.');
        }

        $route = '/'.ltrim($homeRoute->uri(), '/');
        $request = Request::create($route, 'GET');
        $response = $this->kernel->handle($request);

        try {
            if (! $response->isSuccessful()) {
                throw new RuntimeException('The named homepage route could not be rendered.');
            }

            $content = $this->mainHeadingText((string) $response->getContent());
        } finally {
            $this->kernel->terminate($request, $response);
        }

        $context = 'visible:main:h1';
        $source = 'resources/views/welcome.blade.php';

        return $this->publicationItem($content, $route, $context, $source);
    }

    private function mainHeadingText(string $html): string
    {
        $previousErrors = libxml_use_internal_errors(true);

        try {
            $document = new DOMDocument('1.0', 'UTF-8');

            if (! $document->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING)) {
                throw new RuntimeException('The homepage response is not parseable HTML.');
            }

            $heading = (new DOMXPath($document))->query('//main//h1')?->item(0);

            if ($heading === null || $heading->textContent === '') {
                throw new RuntimeException('The homepage has no main heading publication item.');
            }

            if (! mb_check_encoding($heading->textContent, 'UTF-8')) {
                throw new RuntimeException('The homepage heading is not valid UTF-8.');
            }

            return $heading->textContent;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrors);
        }
    }

    /**
     * @param  list<array{id: string, content_hash: string, route: string, context: string}>  $items
     */
    private function sortItems(array &$items): void
    {
        usort($items, static function (array $left, array $right): int {
            foreach (['id', 'route', 'context', 'content_hash'] as $key) {
                $comparison = strcmp($left[$key], $right[$key]);

                if ($comparison !== 0) {
                    return $comparison;
                }
            }

            return 0;
        });
    }

    /**
     * @param  list<array{id: string, content_hash: string, locale: string, route: string, context: string}>  $items
     */
    private function assertUniqueIdentities(array $items): void
    {
        $identities = [];

        foreach ($items as $item) {
            $identity = implode("\0", [
                $item['id'],
                $item['content_hash'],
                $item['locale'],
                $item['route'],
                $item['context'],
            ]);

            if (isset($identities[$identity])) {
                throw new RuntimeException('Duplicate publication identity detected.');
            }

            $identities[$identity] = true;
        }
    }

    private function assertSafeSource(string $source): void
    {
        if ($source === '' || str_starts_with($source, '/') || str_contains($source, '\\')) {
            throw new RuntimeException('Publication source must be a repository-relative POSIX path.');
        }

        $segments = explode('/', $source);

        if (in_array('..', $segments, true) || in_array('', $segments, true)) {
            throw new RuntimeException('Publication source cannot escape an allowed scan root.');
        }

        /** @var list<string> $forbiddenRoots */
        $forbiddenRoots = config('governance.forbidden_roots', []);

        foreach ($forbiddenRoots as $forbiddenRoot) {
            if ($source === $forbiddenRoot || str_starts_with($source, $forbiddenRoot.'/')) {
                throw new RuntimeException('Publication source is inside a forbidden root.');
            }
        }

        $absoluteSource = base_path($source);
        $realSource = realpath($absoluteSource);

        if ($realSource === false || is_link($absoluteSource)) {
            throw new RuntimeException('Publication source must be an existing non-symlink path.');
        }

        /** @var list<string> $scanRoots */
        $scanRoots = config('governance.scan_roots', []);
        $insideAllowedRoot = false;

        foreach ($scanRoots as $scanRoot) {
            $realRoot = realpath(base_path($scanRoot));

            if ($realRoot !== false && ($realSource === $realRoot || str_starts_with($realSource, $realRoot.DIRECTORY_SEPARATOR))) {
                $insideAllowedRoot = true;

                break;
            }
        }

        if (! $insideAllowedRoot) {
            throw new RuntimeException('Publication source is outside the allowed scan roots.');
        }
    }

    /**
     * @param  list<string>  $command
     * @param  callable(string): string|null  $transform
     */
    private function gitOutput(array $command, string $fallback, ?callable $transform = null): string
    {
        try {
            $process = new Process($command, base_path());
            $process->run();

            if (! $process->isSuccessful()) {
                return $fallback;
            }

            $output = rtrim($process->getOutput());

            return $transform === null ? $output : $transform($output);
        } catch (Throwable) {
            return $fallback;
        }
    }

    /**
     * @param  resource  $handle
     */
    private function writeAll($handle, string $contents): void
    {
        $offset = 0;
        $length = strlen($contents);

        while ($offset < $length) {
            $written = fwrite($handle, substr($contents, $offset));

            if ($written === false || $written === 0) {
                throw new RuntimeException('Unable to write the complete inventory payload.');
            }

            $offset += $written;
        }
    }
}
