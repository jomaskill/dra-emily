<?php

namespace App\Console\Commands;

use App\Governance\GovernanceInventory;
use Illuminate\Console\Command;
use Throwable;

class GenerateGovernanceInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'governance:inventory
        {--output= : Inventory JSON target. Defaults to the canonical Phase 1 artifact.}
        {--report= : Human-readable inventory target. Defaults beside a custom JSON output or to the canonical Phase 1 report.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate deterministic observations of the public website without changing human evidence';

    public function __construct(private readonly GovernanceInventory $inventory)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $output = $this->outputPath();
        $report = $this->reportPath($output);
        $isFullInventory = $this->option('output') === null || $this->option('report') !== null;

        try {
            $inventory = $isFullInventory
                ? $this->inventory->snapshot($output)
                : $this->inventory->tracerSnapshot($output);
            $this->inventory->write($output, $inventory);

            if ($isFullInventory) {
                $this->inventory->writeReport($report, $inventory);
            }
        } catch (Throwable $exception) {
            report($exception);
            $this->error('Governance inventory failed. No successful artifact was published.');

            return self::FAILURE;
        }

        if ($isFullInventory) {
            $this->table(
                ['Category', 'Observations'],
                collect($inventory['summary']['categories'])
                    ->map(static fn (int $count, string $category): array => [$category, $count])
                    ->values()
                    ->all(),
            );
        } else {
            $this->table(
                ['Item', 'Route', 'Context'],
                array_map(
                    static fn (array $item): array => [$item['id'], $item['route'], $item['context']],
                    $inventory['items'],
                ),
            );
        }
        $this->info(count($inventory['items']).' observation(s) recorded. Human approval status was not changed.');

        $problemCount = $isFullInventory
            ? count($inventory['summary']['errors'])
                + count($inventory['summary']['omissions'])
                + count($inventory['summary']['unresolved_routes'])
            : 0;

        if ($problemCount > 0) {
            $this->error($problemCount.' blocking inventory problem(s) recorded in the report.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function outputPath(): string
    {
        $selected = $this->option('output');

        if (is_string($selected) && $selected !== '') {
            return $selected;
        }

        return (string) config(
            'governance.artifacts.inventory',
            base_path('.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json'),
        );
    }

    private function reportPath(string $output): string
    {
        $selected = $this->option('report');

        if (is_string($selected) && $selected !== '') {
            return $selected;
        }

        if ($this->option('output') !== null) {
            return dirname($output).'/'.pathinfo($output, PATHINFO_FILENAME).'.md';
        }

        return (string) config(
            'governance.artifacts.inventory_report',
            base_path('.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.md'),
        );
    }
}
