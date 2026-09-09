<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/**
 * @return array{schema_version: int, decision: string, run: array<string, mixed>, summary: array<string, mixed>, items: list<array<string, mixed>>}
 */
function publicSurfaceInventoryGenerate(string $directory, string $name = 'inventory.json'): array
{
    $inventoryPath = $directory.'/'.$name;
    $reportPath = $directory.'/'.pathinfo($name, PATHINFO_FILENAME).'.md';

    expect(Artisan::call('governance:inventory', [
        '--output' => $inventoryPath,
        '--report' => $reportPath,
    ]))->toBe(0, Artisan::output());

    expect($inventoryPath)->toBeFile()
        ->and($reportPath)->toBeFile();

    return json_decode((string) file_get_contents($inventoryPath), true, flags: JSON_THROW_ON_ERROR);
}

function publicSurfaceInventoryTemporaryDirectory(): string
{
    $directory = sys_get_temp_dir().'/draemily-public-surface-'.Str::lower((string) Str::ulid());

    mkdir($directory, 0700, true);

    return $directory;
}

function publicSurfaceInventoryRemoveDirectory(string $directory): void
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

/** @return list<string> */
function expectedPublicSurfacePaths(): array
{
    return [
        '/',
        '/artigos',
        ...array_map(static fn (string $slug): string => '/artigos/'.$slug, array_keys(config('articles'))),
        ...array_map(static fn (string $slug): string => '/procedimentos/'.$slug, array_keys(config('procedures'))),
        '/sitemap.xml',
    ];
}

it('expands every current named public route and records invalid parameter behavior', function () {
    $directory = publicSurfaceInventoryTemporaryDirectory();

    try {
        $inventory = publicSurfaceInventoryGenerate($directory);
        $routeItems = collect($inventory['items'])->where('category', 'route');

        foreach (expectedPublicSurfacePaths() as $path) {
            expect($routeItems->where('route', $path)->where('content', '200')->count())
                ->toBe(1, "Missing successful route observation for {$path}");
        }

        expect($routeItems->where('route', '/procedimentos/nao-existe')->where('content', '404')->count())->toBe(1)
            ->and($routeItems->where('route', '/artigos/nao-existe')->where('content', '404')->count())->toBe(1)
            ->and($inventory['summary']['errors'])->toBe([])
            ->and($inventory['summary']['omissions'])->toBe([]);

        $this->get('/procedimentos/nao-existe')->assertNotFound();
        $this->get('/artigos/nao-existe')->assertNotFound();
    } finally {
        publicSurfaceInventoryRemoveDirectory($directory);
    }
});

it('inventories rendered publication categories and reconciles required cardinalities', function () {
    $directory = publicSurfaceInventoryTemporaryDirectory();

    try {
        $inventory = publicSurfaceInventoryGenerate($directory);
        $items = collect($inventory['items']);

        foreach ([
            'route',
            'configured_assertion',
            'visible_text',
            'metadata',
            'link',
            'conversion',
            'media',
            'json_ld',
            'sitemap',
            'analytics',
            'source',
            'public_asset',
        ] as $category) {
            expect($items->where('category', $category))->not->toBeEmpty("Missing {$category} observations");
        }

        foreach (['procedures', 'articles', 'faqs', 'media', 'ctas', 'json_ld', 'sitemap'] as $collection) {
            expect($inventory['summary']['cardinality'][$collection] ?? 0)
                ->toBeGreaterThan(0, "Required {$collection} cardinality cannot be zero");
        }

        expect($items->where('route', '/')->where('category', 'json_ld'))->not->toBeEmpty()
            ->and($items->where('route', '/procedimentos/full-face')->where('category', 'visible_text'))->not->toBeEmpty()
            ->and($items->where('route', '/sitemap.xml')->where('category', 'sitemap'))->not->toBeEmpty()
            ->and($items->where('route', '/artigos')->where('category', 'visible_text'))->not->toBeEmpty();
    } finally {
        publicSurfaceInventoryRemoveDirectory($directory);
    }
});

it('keeps inventory identities deterministic, bidirectionally complete, and free of sensitive roots', function () {
    $directory = publicSurfaceInventoryTemporaryDirectory();

    try {
        $first = publicSurfaceInventoryGenerate($directory, 'first.json');
        usleep(1000);
        $second = publicSurfaceInventoryGenerate($directory, 'second.json');

        expect($first['items'])->toBe($second['items'])
            ->and($first['run']['generated_at'])->not->toBe($second['run']['generated_at'])
            ->and($first['run'])->toHaveKeys([
                'generated_at',
                'revision',
                'dirty_tree',
                'command_version',
                'target',
            ]);

        $identities = [];

        foreach ($first['items'] as $item) {
            expect($item)->toHaveKeys([
                'id',
                'category',
                'content',
                'content_hash',
                'locale',
                'route',
                'route_name',
                'context',
                'visibility',
                'source',
            ])
                ->and($item['content_hash'])->toBe(hash('sha256', $item['content']))
                ->and($item['source'])->not->toStartWith('/')
                ->and($item['source'])->not->toContain('.env', 'vendor/', 'node_modules/', 'storage/', '.git/');

            $identity = implode("\0", [
                $item['id'],
                $item['content_hash'],
                $item['locale'],
                $item['route'],
                $item['context'],
            ]);

            expect($identities)->not->toHaveKey($identity);
            $identities[$identity] = true;
        }

        expect($first['summary']['discovered_items'])->toBe(count($first['items']))
            ->and($first['summary']['inventoried_items'])->toBe(count($first['items']))
            ->and($first['summary']['unresolved_routes'])->toBe([]);
    } finally {
        publicSurfaceInventoryRemoveDirectory($directory);
    }
});

it('writes a reviewable freeze manifest without changing approval evidence', function () {
    $directory = publicSurfaceInventoryTemporaryDirectory();

    try {
        $inventory = publicSurfaceInventoryGenerate($directory);
        $report = (string) file_get_contents($directory.'/inventory.md');

        expect($report)->toContain('# Phase 1 Public Surface Inventory')
            ->and($report)->toContain('Decision: no-change')
            ->and($report)->toContain($inventory['run']['revision'])
            ->and($report)->toContain($inventory['run']['dirty_tree'])
            ->and($report)->toContain('Human approval: not inferred')
            ->and($report)->not->toContain('Status: READY');
    } finally {
        publicSurfaceInventoryRemoveDirectory($directory);
    }
});
