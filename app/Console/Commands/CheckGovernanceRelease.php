<?php

namespace App\Console\Commands;

use App\Governance\GovernanceEvidence;
use App\Governance\GovernanceInventory;
use Illuminate\Console\Command;
use JsonException;
use RuntimeException;
use Throwable;

class CheckGovernanceRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'governance:check-release
        {--inventory= : Generated inventory JSON path.}
        {--evidence-dir= : Directory containing separately maintained human evidence.}
        {--report= : Optional sanitized Markdown report target.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Derive a fail-closed release result from inventory observations and separate human evidence';

    public function __construct(
        private readonly GovernanceEvidence $evidence,
        private readonly GovernanceInventory $inventory,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $inventoryPath = $this->requiredOption('inventory');
            $evidenceDirectory = $this->requiredOption('evidence-dir');
            $items = $this->inventoryItems($inventoryPath);
            $records = $this->evidence->loadDirectory($evidenceDirectory);
            $problems = $this->releaseProblems($items, $records);
        } catch (Throwable $exception) {
            report($exception);
            $problems = [['governance-input', 'invalid or unavailable governance data']];
        }

        $status = $problems === [] ? 'READY' : 'BLOCKED';

        if ($problems !== []) {
            $this->table(['Item', 'Reason'], $problems);
        }

        $this->line('Release status: '.$status);

        if (is_string($this->option('report')) && $this->option('report') !== '') {
            try {
                $this->writeReport((string) $this->option('report'), $status, $problems);
            } catch (Throwable $exception) {
                report($exception);
                $this->error('Governance report failed. No successful report was published.');

                return self::FAILURE;
            }
        }

        return $problems === [] ? self::SUCCESS : self::FAILURE;
    }

    private function requiredOption(string $name): string
    {
        $value = $this->option($name);

        if (! is_string($value) || $value === '') {
            throw new RuntimeException('A required governance option is missing.');
        }

        return $value;
    }

    /**
     * @return list<array<string, scalar>>
     */
    private function inventoryItems(string $path): array
    {
        $decoded = $this->decodeJsonFile($path);
        $items = $decoded['items'] ?? null;

        if (! is_array($items) || $items === []) {
            throw new RuntimeException('Inventory has no required publication items.');
        }

        return array_values($items);
    }

    /**
     * @return array<string, mixed>
     */
    private function decodeJsonFile(string $path): array
    {
        if (! is_file($path) || is_link($path)) {
            throw new RuntimeException('Governance file is unavailable.');
        }

        try {
            $decoded = json_decode((string) file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Governance JSON is malformed.', previous: $exception);
        }

        if (! is_array($decoded)) {
            throw new RuntimeException('Governance JSON must decode to an object or list.');
        }

        return $decoded;
    }

    /**
     * @param  list<array<string, scalar>>  $items
     * @param  list<array<string, scalar>>  $records
     * @return list<array{0: string, 1: string}>
     */
    private function releaseProblems(array $items, array $records): array
    {
        $recordsByIdentity = [];

        foreach ($records as $record) {
            $identity = $this->identity($record);

            if ($identity !== null) {
                $recordsByIdentity[$identity] = $record;
            }
        }

        $problems = [];

        foreach ($items as $item) {
            $id = is_string($item['id'] ?? null) ? $item['id'] : 'invalid-item';
            $identity = $this->identity($item);
            $record = $identity === null ? null : ($recordsByIdentity[$identity] ?? null);

            if ($record === null) {
                $problems[] = [$id, 'exact identity has no current evidence'];

                continue;
            }

            $status = is_string($record['status'] ?? null) ? $record['status'] : '';

            if ($status !== 'approved') {
                $reason = $status === 'pending'
                    ? 'pending human decision'
                    : 'human decision is not approved';
                $problems[] = [$id, $reason];
            }
        }

        usort($problems, static fn (array $left, array $right): int => strcmp($left[0], $right[0]));

        return $problems;
    }

    /**
     * @param  array<string, scalar>  $record
     */
    private function identity(array $record): ?string
    {
        /** @var list<string> $keys */
        $keys = config('governance.identity_keys', []);

        foreach ($keys as $key) {
            if (! isset($record[$key]) || ! is_string($record[$key]) || $record[$key] === '') {
                return null;
            }
        }

        return $this->evidence->identity($record);
    }

    /**
     * @param  list<array{0: string, 1: string}>  $problems
     */
    private function writeReport(string $path, string $status, array $problems): void
    {
        $lines = ['# Governance Release Gate', '', 'Status: '.$status, ''];

        foreach ($problems as [$id, $reason]) {
            $lines[] = '- `'.$id.'`: '.$reason;
        }

        $this->inventory->writeAtomically($path, implode(PHP_EOL, $lines).PHP_EOL);
    }
}
