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
        {--output= : Inventory JSON target. Defaults to the canonical Phase 1 artifact.}';

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

        try {
            $inventory = $this->inventory->snapshot($output);
            $this->inventory->write($output, $inventory);
        } catch (Throwable $exception) {
            report($exception);
            $this->error('Governance inventory failed. No successful artifact was published.');

            return self::FAILURE;
        }

        $this->table(
            ['Item', 'Route', 'Context'],
            array_map(
                static fn (array $item): array => [$item['id'], $item['route'], $item['context']],
                $inventory['items'],
            ),
        );
        $this->info(count($inventory['items']).' observation(s) recorded. Human approval status was not changed.');

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
}
