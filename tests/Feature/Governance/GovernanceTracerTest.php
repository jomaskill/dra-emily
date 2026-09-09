<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/**
 * @return array{schema_version: int, decision: string, run: array<string, mixed>, items: list<array<string, mixed>>}
 */
function governanceTracerGenerateInventory(string $directory, string $name = 'inventory.json'): array
{
    $output = $directory.'/'.$name;

    expect(Artisan::call('governance:inventory', ['--output' => $output]))->toBe(0);

    return json_decode((string) file_get_contents($output), true, flags: JSON_THROW_ON_ERROR);
}

/**
 * @param  list<array<string, mixed>>  $records
 */
function governanceTracerWriteEvidence(string $directory, array $records): void
{
    file_put_contents(
        $directory.'/release.json',
        json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR).PHP_EOL,
    );
}

function governanceTracerTemporaryDirectory(): string
{
    $directory = sys_get_temp_dir().'/draemily-governance-'.Str::lower((string) Str::ulid());

    mkdir($directory, 0700, true);

    return $directory;
}

function governanceTracerRemoveDirectory(string $directory): void
{
    if (! is_dir($directory)) {
        return;
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST,
    );

    foreach ($files as $file) {
        $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
    }

    rmdir($directory);
}

it('traces a real homepage publication item into deterministic inventory', function () {
    $directory = governanceTracerTemporaryDirectory();

    try {
        $inventory = governanceTracerGenerateInventory($directory);

        expect($inventory['schema_version'])->toBe(1)
            ->and($inventory['decision'])->toBe('no-change')
            ->and($inventory['run'])->toHaveKeys([
                'generated_at',
                'revision',
                'dirty_tree',
                'command_version',
                'target',
            ])
            ->and($inventory['items'])->toHaveCount(1);

        $item = $inventory['items'][0];

        expect($item)->toHaveKeys([
            'id',
            'content',
            'content_hash',
            'locale',
            'route',
            'route_name',
            'context',
            'visibility',
            'source',
        ])
            ->and($item['id'])->toStartWith('publication.')
            ->and($item['content'])->not->toBeEmpty()
            ->and($item['content_hash'])->toBe(hash('sha256', $item['content']))
            ->and($item['locale'])->toBe('pt-BR')
            ->and($item['route'])->toBe('/')
            ->and($item['route_name'])->toBe('home')
            ->and($item['context'])->toBe('visible:main:h1')
            ->and($item['visibility'])->toBe('visible')
            ->and($item['source'])->toBe('resources/views/welcome.blade.php');
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
});

it('blocks pending evidence without disclosing publication or evidence content', function () {
    $directory = governanceTracerTemporaryDirectory();

    try {
        $inventoryPath = $directory.'/inventory.json';
        $reportPath = $directory.'/report.md';
        $inventory = governanceTracerGenerateInventory($directory);
        $item = $inventory['items'][0];

        governanceTracerWriteEvidence($directory, [[
            'id' => $item['id'],
            'content_hash' => $item['content_hash'],
            'locale' => $item['locale'],
            'route' => $item['route'],
            'context' => $item['context'],
            'status' => 'pending',
            'evidence_reference' => 'CONTROLLED://clinical/review-123',
        ]]);

        $exitCode = Artisan::call('governance:check-release', [
            '--inventory' => $inventoryPath,
            '--evidence-dir' => $directory,
            '--report' => $reportPath,
        ]);
        $output = Artisan::output();

        expect($exitCode)->toBe(1)
            ->and($output)->toContain($item['id'])
            ->and($output)->toContain('pending human decision')
            ->and($output)->not->toContain($item['content'])
            ->and($output)->not->toContain('CONTROLLED://clinical/review-123')
            ->and(file_get_contents($reportPath))->toContain('Status: BLOCKED');
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
});

it('blocks stale evidence identity without exposing the claim', function (string $field, string $replacement) {
    $directory = governanceTracerTemporaryDirectory();

    try {
        $inventory = governanceTracerGenerateInventory($directory);
        $item = $inventory['items'][0];
        $record = [
            'id' => $item['id'],
            'content_hash' => $item['content_hash'],
            'locale' => $item['locale'],
            'route' => $item['route'],
            'context' => $item['context'],
            'status' => 'approved',
            'evidence_reference' => 'CONTROLLED://clinical/review-456',
        ];
        $record[$field] = $replacement;

        governanceTracerWriteEvidence($directory, [$record]);

        $exitCode = Artisan::call('governance:check-release', [
            '--inventory' => $directory.'/inventory.json',
            '--evidence-dir' => $directory,
            '--report' => $directory.'/report.md',
        ]);
        $output = Artisan::output();

        expect($exitCode)->toBe(1)
            ->and($output)->toContain($item['id'])
            ->and($output)->toContain('exact identity has no current evidence')
            ->and($output)->not->toContain($item['content'])
            ->and($output)->not->toContain('CONTROLLED://clinical/review-456');
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
})->with([
    'changed content hash' => ['content_hash', str_repeat('0', 64)],
    'changed publication context' => ['context', 'visible:footer:h1'],
]);

it('keeps item payloads byte-identical when only run metadata changes', function () {
    $directory = governanceTracerTemporaryDirectory();

    try {
        $first = governanceTracerGenerateInventory($directory, 'first.json');
        usleep(1000);
        $second = governanceTracerGenerateInventory($directory, 'second.json');

        expect($first['run']['generated_at'])->not->toBe($second['run']['generated_at'])
            ->and($first['run']['target'])->not->toBe($second['run']['target'])
            ->and($first['items'])->toBe($second['items']);
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
});
