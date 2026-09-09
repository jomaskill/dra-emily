<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Governance\GovernanceEvidence;
use App\Governance\GovernanceInventory;
use Symfony\Component\Process\Process;

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
    governanceTracerWriteRegisterRaw(
        $directory,
        '<!-- governance-evidence:start -->'.PHP_EOL
        .json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR).PHP_EOL
        .'<!-- governance-evidence:end -->',
    );
}

function governanceTracerWriteRegisterRaw(string $directory, string $payload, string $name = 'release.md'): void
{
    file_put_contents($directory.'/'.$name, '# Human Governance Evidence'.PHP_EOL.PHP_EOL.$payload.PHP_EOL);
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

it('defines the shared governance vocabulary and filesystem boundaries in config', function () {
    expect(config('governance.allowed_statuses'))->toBe([
        'pending',
        'approved',
        'rejected',
        'quarantined',
        'expired',
    ])->and(config('governance.identity_keys'))->toBe([
        'id',
        'content_hash',
        'locale',
        'route',
        'context',
    ])->and(config('governance.locale'))->toBe('pt-BR')
        ->and(config('governance.scan_roots'))->toContain('routes', 'config', 'resources/views', 'public')
        ->and(config('governance.forbidden_roots'))->toContain('.env', '.git', 'vendor', 'node_modules', 'storage');
});

it('loads exactly one tagged human payload and preserves context-bound identities', function () {
    $directory = governanceTracerTemporaryDirectory();

    try {
        $inventory = governanceTracerGenerateInventory($directory);
        $first = $inventory['items'][0];
        $second = $first;
        $second['id'] = 'publication.adjacent-context';
        $second['context'] = 'machine_readable:json-ld:name';

        governanceTracerWriteEvidence($directory, [
            array_merge($first, ['status' => 'approved', 'evidence_reference' => 'CONTROLLED://review/1']),
            array_merge($second, ['status' => 'pending', 'evidence_reference' => 'CONTROLLED://review/2']),
        ]);

        $records = app(GovernanceEvidence::class)->loadDirectory($directory);

        expect($records)->toHaveCount(2)
            ->and($records[0]['context'])->not->toBe($records[1]['context'])
            ->and($records[0]['content_hash'])->toBe($records[1]['content_hash']);
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
});

it('rejects ambiguous or malformed human evidence', function (string $payload) {
    $directory = governanceTracerTemporaryDirectory();

    try {
        governanceTracerWriteRegisterRaw($directory, $payload);

        expect(fn () => app(GovernanceEvidence::class)->loadDirectory($directory))
            ->toThrow(RuntimeException::class);
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
})->with([
    'malformed json' => '<!-- governance-evidence:start -->'.PHP_EOL.'{not-json}'.PHP_EOL.'<!-- governance-evidence:end -->',
    'second tagged payload' => '<!-- governance-evidence:start -->'.PHP_EOL.'[]'.PHP_EOL.'<!-- governance-evidence:end -->'.PHP_EOL.'<!-- governance-evidence:start -->'.PHP_EOL.'[]'.PHP_EOL.'<!-- governance-evidence:end -->',
    'missing scalar field' => '<!-- governance-evidence:start -->'.PHP_EOL.'[{"id":"publication.one"}]'.PHP_EOL.'<!-- governance-evidence:end -->',
    'editable readiness boolean' => '<!-- governance-evidence:start -->'.PHP_EOL.'[{"id":"publication.one","content_hash":"'.str_repeat('a', 64).'","locale":"pt-BR","route":"/","context":"visible:main:h1","status":"approved","evidence_reference":"CONTROLLED://review/1","release_ready":true}]'.PHP_EOL.'<!-- governance-evidence:end -->',
    'unknown status' => '<!-- governance-evidence:start -->'.PHP_EOL.'[{"id":"publication.one","content_hash":"'.str_repeat('a', 64).'","locale":"pt-BR","route":"/","context":"visible:main:h1","status":"maybe","evidence_reference":"CONTROLLED://review/1"}]'.PHP_EOL.'<!-- governance-evidence:end -->',
    'blank status' => '<!-- governance-evidence:start -->'.PHP_EOL.'[{"id":"publication.one","content_hash":"'.str_repeat('a', 64).'","locale":"pt-BR","route":"/","context":"visible:main:h1","status":"","evidence_reference":"CONTROLLED://review/1"}]'.PHP_EOL.'<!-- governance-evidence:end -->',
]);

it('rejects duplicate full identities across human registers', function () {
    $directory = governanceTracerTemporaryDirectory();

    try {
        $record = [[
            'id' => 'publication.duplicate',
            'content_hash' => str_repeat('a', 64),
            'locale' => 'pt-BR',
            'route' => '/',
            'context' => 'visible:main:h1',
            'status' => 'pending',
            'evidence_reference' => 'CONTROLLED://review/duplicate',
        ]];
        $payload = '<!-- governance-evidence:start -->'.PHP_EOL
            .json_encode($record, JSON_THROW_ON_ERROR).PHP_EOL
            .'<!-- governance-evidence:end -->';

        governanceTracerWriteRegisterRaw($directory, $payload, 'first.md');
        governanceTracerWriteRegisterRaw($directory, $payload, 'second.md');

        expect(fn () => app(GovernanceEvidence::class)->loadDirectory($directory))
            ->toThrow(RuntimeException::class);
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
});

it('hashes exact UTF-8 bytes and binds stable ids to publication context', function () {
    $inventory = app(GovernanceInventory::class);
    $composed = $inventory->publicationItem('é  natural', '/', 'visible:main:p', 'resources/views/welcome.blade.php');
    $decomposed = $inventory->publicationItem("e\u{301} natural", '/', 'visible:main:p', 'resources/views/welcome.blade.php');
    $adjacent = $inventory->publicationItem('é  natural', '/', 'machine_readable:description', 'resources/views/welcome.blade.php');

    expect($composed['content'])->toBe('é  natural')
        ->and($composed['content_hash'])->toBe(hash('sha256', 'é  natural'))
        ->and($composed['content_hash'])->not->toBe($decomposed['content_hash'])
        ->and($composed['id'])->not->toBe($adjacent['id']);
});

it('sorts item identities byte-deterministically and rejects empty or duplicate collections', function () {
    $inventory = app(GovernanceInventory::class);
    $later = $inventory->publicationItem('B', '/', 'visible:main:p[2]', 'resources/views/welcome.blade.php');
    $earlier = $inventory->publicationItem('A', '/', 'visible:main:p[1]', 'resources/views/welcome.blade.php');

    $ordered = $inventory->canonicalizeItems([$later, $earlier]);

    expect(array_column($ordered, 'id'))->toBe(collect([$later['id'], $earlier['id']])->sort()->values()->all())
        ->and(fn () => $inventory->canonicalizeItems([]))->toThrow(RuntimeException::class)
        ->and(fn () => $inventory->canonicalizeItems([$earlier, $earlier]))->toThrow(RuntimeException::class);
});

it('rejects symlink evidence directories and unsafe publication sources', function () {
    $directory = governanceTracerTemporaryDirectory();
    $link = $directory.'-link';

    try {
        symlink($directory, $link);

        expect(fn () => app(GovernanceEvidence::class)->loadDirectory($link))
            ->toThrow(RuntimeException::class)
            ->and(fn () => app(GovernanceInventory::class)->publicationItem(
                'secret',
                '/',
                'visible:main:p',
                '../.env',
            ))->toThrow(RuntimeException::class);
    } finally {
        if (is_link($link)) {
            unlink($link);
        }

        governanceTracerRemoveDirectory($directory);
    }
});

it('publishes only complete JSON when concurrent writers share a target', function () {
    $directory = governanceTracerTemporaryDirectory();
    $target = $directory.'/concurrent.json';

    try {
        $commands = [
            new Process([PHP_BINARY, base_path('artisan'), 'governance:inventory', '--output='.$target], base_path()),
            new Process([PHP_BINARY, base_path('artisan'), 'governance:inventory', '--output='.$target], base_path()),
        ];

        foreach ($commands as $command) {
            $command->start();
        }

        foreach ($commands as $command) {
            expect($command->wait())->toBe(0);
        }

        $decoded = json_decode((string) file_get_contents($target), true, flags: JSON_THROW_ON_ERROR);

        expect($decoded['items'])->toHaveCount(1)
            ->and(glob($directory.'/.concurrent.json.tmp.*') ?: [])->toBe([]);
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
});

it('preserves the previous canonical artifact when encoding is interrupted', function () {
    $directory = governanceTracerTemporaryDirectory();
    $target = $directory.'/inventory.json';

    try {
        file_put_contents($target, "previous-complete-artifact\n");

        expect(fn () => app(GovernanceInventory::class)->write($target, ['invalid' => INF]))
            ->toThrow(JsonException::class)
            ->and(file_get_contents($target))->toBe("previous-complete-artifact\n")
            ->and(glob($directory.'/.inventory.json.tmp.*') ?: [])->toBe([]);
    } finally {
        governanceTracerRemoveDirectory($directory);
    }
});
