<?php

use App\Governance\ClaimRegister;
use App\Governance\OperationsRegister;
use App\Governance\PrivacyDecision;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

/** @return array{directory: string, inventory: string, baseline: string, report: string, revision: string, digest: string} */
function releaseGateFixture(): array
{
    $directory = sys_get_temp_dir().'/draemily-release-gate-'.Str::lower((string) Str::ulid());
    mkdir($directory, 0700, true);
    $revision = str_repeat('a', 40);
    $wording = 'Dra. Emily Beatriz';
    $assetPayload = json_encode(['path' => 'public/patient.webp', 'sha256' => str_repeat('b', 64)], JSON_THROW_ON_ERROR);
    $items = [
        [
            'id' => 'publication.claim-1', 'category' => 'configured_assertion', 'content' => $wording,
            'content_hash' => hash('sha256', $wording), 'locale' => 'pt-BR', 'route' => '/',
            'route_name' => 'home', 'context' => 'visible:main:h1', 'visibility' => 'both',
            'source' => 'config/clinic.php',
        ],
        [
            'id' => 'publication.media-1', 'category' => 'public_asset', 'content' => $assetPayload,
            'content_hash' => hash('sha256', $assetPayload), 'locale' => 'pt-BR', 'route' => '@asset',
            'route_name' => '@asset', 'context' => 'asset:public/patient.webp', 'visibility' => 'source_only',
            'source' => 'public/patient.webp',
        ],
    ];
    $digest = hash('sha256', json_encode($items, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR).PHP_EOL);
    $inventoryPath = $directory.'/inventory.json';
    file_put_contents($inventoryPath, json_encode([
        'schema_version' => 2,
        'decision' => 'no-change',
        'run' => [
            'generated_at' => '2026-09-09T12:00:00-03:00', 'revision' => $revision, 'dirty_tree' => 'clean',
            'command_version' => '2.0.0', 'target' => 'fixture/inventory.json',
        ],
        'summary' => [
            'discovered_items' => count($items), 'inventoried_items' => count($items),
            'categories' => ['configured_assertion' => 1, 'public_asset' => 1],
            'cardinality' => ['procedures' => 1, 'articles' => 1, 'faqs' => 1, 'media' => 1, 'ctas' => 1, 'json_ld' => 1, 'sitemap' => 1],
            'unresolved_routes' => [], 'errors' => [], 'omissions' => [],
        ],
        'items' => $items,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR).PHP_EOL);

    releaseGateWriteTagged($directory.'/01-CLAIMS.md', 'governance-claims', [
        'schema_version' => 1, 'inventory_revision' => $revision,
        'excluded_media_item_ids' => ClaimRegister::MEDIA_GOVERNED_ITEM_IDS,
        'records' => [[
            'stable_id' => 'publication.claim-1', 'exact_text' => $wording,
            'content_hash' => hash('sha256', $wording), 'locale' => 'pt-BR', 'route' => '/',
            'context' => 'visible:main:h1', 'source_locator' => 'config/clinic.php',
            'content_owner' => 'Dra. Emily', 'last_reviewed_on' => '2026-09-09',
            'dra_emily_evidence_reference' => 'clinical:review-1', 'reviewer' => 'Dra. Emily',
            'decision_on' => '2026-09-09', 'review_expires_on' => '2099-12-31',
            'classification' => 'clinical_claim', 'decision' => 'approved',
            'disposition_inputs' => ['inventory_revision' => $revision, 'inventory_category' => 'configured_assertion', 'visibility' => 'both'],
        ]],
    ]);
    releaseGateWriteTagged($directory.'/01-MEDIA.md', 'governance-media', [
        'schema_version' => 1, 'inventory_revision' => $revision,
        'testimonial_item_ids' => [], 'testimonial_attribution_item_ids' => [],
        'records' => [[
            'stable_id' => 'media.asset-1', 'path' => 'public/patient.webp', 'content_hash' => str_repeat('b', 64),
            'derivative_of' => null, 'classification' => 'patient', 'provenance_reference' => 'media:provenance-1',
            'authorization_reference' => 'media:authorization-1', 'responsible_professional' => 'Dra. Emily',
            'reviewer' => 'Media custodian', 'decision_on' => '2026-09-09', 'decision_expires_on' => '2099-12-31',
            'recheck_on' => '2099-12-31', 'decision' => 'approved',
            'disposition_inputs' => ['inventory_revision' => $revision],
            'contexts' => [[
                'inventory_id' => 'publication.media-1', 'route' => '@asset',
                'context' => 'asset:public/patient.webp', 'content_hash' => hash('sha256', $assetPayload),
            ]],
        ]],
    ]);
    releaseGateWriteTagged($directory.'/01-PROFESSIONAL-WORDING.md', 'governance-professional', [
        'schema_version' => 1, 'inventory_revision' => $revision,
        'records' => [[
            'stable_id' => 'publication.claim-1', 'exact_wording' => $wording,
            'content_hash' => hash('sha256', $wording), 'locale' => 'pt-BR', 'route' => '/',
            'context' => 'visible:main:h1', 'source_locator' => 'config/clinic.php', 'scope_sensitive' => true,
            'classification_reviewer' => 'Professional reviewer', 'current_registration_evidence_reference' => 'cro:registration-1',
            'external_reviewer_role' => 'qualified_counsel', 'external_reviewer_name' => 'External reviewer',
            'reviewed_on' => '2026-09-09', 'decision_reference' => 'legal:decision-1', 'decision' => 'approved',
            'applicable_revision' => $revision, 'applicable_until' => '2099-12-31', 'recheck_on' => '2099-12-31',
        ]],
    ]);
    releaseGateWriteTagged($directory.'/01-OPERATIONS.md', 'governance-operations', [
        'schema_version' => 1, 'inventory_revision' => $revision,
        'records' => array_map(static fn (string $domain): array => [
            'stable_id' => 'operations.'.$domain, 'domain' => $domain,
            'configured_value' => 'verified-'.$domain, 'observed_value' => 'verified-'.$domain,
            'verifier' => 'Clinic operations', 'verified_on' => '2026-09-09',
            'evidence_reference' => 'operations:'.$domain.'-1', 'status' => 'approved', 'recheck_on' => '2099-12-31',
            'contexts' => [['route' => '/', 'context' => $domain, 'source' => 'config/clinic.php']],
        ], OperationsRegister::REQUIRED_DOMAINS),
    ]);
    $productionConfiguration = ['measurement_status' => 'observed_no_collection', 'consent_state' => 'disabled', 'source_revision' => $revision];
    releaseGateWriteTagged($directory.'/01-PRIVACY-DECISION.md', 'governance-privacy', [
        'schema_version' => 1, 'inventory_revision' => $revision, 'controller' => 'Dra. Emily Beatriz',
        'processors' => ['none'], 'purposes' => ['website operation'], 'data_parameters' => ['none'],
        'lawful_bases' => ['not applicable while collection is disabled'], 'consent_trigger' => 'before_collection',
        'deny_behavior' => 'no_collection', 'revoke_behavior' => 'no_collection', 'retention' => 'none',
        'access_roles' => ['privacy owner'], 'transfers' => ['none'], 'production_configuration' => $productionConfiguration,
        'production_configuration_hash' => PrivacyDecision::productionConfigurationHash($productionConfiguration),
        'approver' => 'Privacy owner', 'decided_on' => '2026-09-09', 'decision' => 'approved',
        'unresolved_questions' => ['none'], 'evidence_references' => ['privacy:decision-1'],
        'applicable_revision' => $revision, 'recheck_on' => '2099-12-31',
    ]);
    $baselinePath = $directory.'/baseline.md';
    releaseGateWriteTagged($baselinePath, 'governance-baseline', [
        'schema_version' => 1,
        'runs' => [[
            'id' => 'baseline-fixture', 'captured_at' => '2026-09-09T12:00:00-03:00',
            'revision' => $revision, 'dirty_tree' => 'clean', 'environment' => 'test',
            'base_url' => 'https://example.test', 'browser' => 'fixture', 'os' => 'fixture', 'tool' => 'Pest',
            'inventory_digest' => $digest, 'measurement_definitions' => ['configured_analytics' => 'fixture'],
            'records' => [['id' => 'fixture', 'evidence_status' => 'observed']],
        ]],
    ]);

    return ['directory' => $directory, 'inventory' => $inventoryPath, 'baseline' => $baselinePath,
        'report' => $directory.'/release.md', 'revision' => $revision, 'digest' => $digest];
}

/** @param array<string, mixed> $payload */
function releaseGateWriteTagged(string $path, string $marker, array $payload): void
{
    file_put_contents($path, '# Fixture'.PHP_EOL.PHP_EOL.'<!-- '.$marker.':start -->'.PHP_EOL
        .json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR).PHP_EOL
        .'<!-- '.$marker.':end -->'.PHP_EOL);
}

/** @return array<string, mixed> */
function releaseGateReadTagged(string $path, string $marker): array
{
    $contents = (string) file_get_contents($path);
    $payload = str($contents)->between('<!-- '.$marker.':start -->', '<!-- '.$marker.':end -->')->trim()->toString();

    return json_decode($payload, true, flags: JSON_THROW_ON_ERROR);
}

function releaseGateRun(array $fixture): int
{
    return Artisan::call('governance:check-release', [
        '--inventory' => $fixture['inventory'], '--evidence-dir' => $fixture['directory'],
        '--baseline' => $fixture['baseline'], '--report' => $fixture['report'],
    ]);
}

function releaseGateSetDecision(array $fixture, string $category, string $decision): void
{
    [$file, $marker, $field] = match ($category) {
        'claims' => ['01-CLAIMS.md', 'governance-claims', 'records'],
        'media' => ['01-MEDIA.md', 'governance-media', 'records'],
        'professional_wording' => ['01-PROFESSIONAL-WORDING.md', 'governance-professional', 'records'],
        'operations' => ['01-OPERATIONS.md', 'governance-operations', 'records'],
        'privacy' => ['01-PRIVACY-DECISION.md', 'governance-privacy', null],
    };
    $path = $fixture['directory'].'/'.$file;
    $payload = releaseGateReadTagged($path, $marker);

    if ($field === null) {
        $payload['decision'] = $decision;
    } else {
        $payload[$field][0][$category === 'operations' ? 'status' : 'decision'] = $decision;
    }

    releaseGateWriteTagged($path, $marker, $payload);
}

function releaseGateRemoveDirectory(string $directory): void
{
    if (! is_dir($directory)) {
        return;
    }

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);

    foreach ($files as $file) {
        $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
    }

    rmdir($directory);
}

it('requires all five exact-revision validators exactly once before release is ready', function () {
    $fixture = releaseGateFixture();

    try {
        expect(releaseGateRun($fixture))->toBe(0);
        $report = (string) file_get_contents($fixture['report']);

        expect($report)->toContain('Status: READY')
            ->and($report)->toContain('Revision: `'.$fixture['revision'].'`')
            ->and($report)->toContain('Public surface digest: `'.$fixture['digest'].'`')
            ->and($report)->toContain('Baseline run: `baseline-fixture`');

        foreach (['claims', 'media', 'professional_wording', 'operations', 'privacy'] as $category) {
            expect(substr_count($report, '| `'.$category.'` |'))->toBe(1);
        }
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
});

it('fails closed when any required category register is missing', function (string $category, string $file) {
    $fixture = releaseGateFixture();

    try {
        unlink($fixture['directory'].'/'.$file);

        expect(releaseGateRun($fixture))->toBe(1)
            ->and(Artisan::output())->toContain($category, 'missing_category');
        expect(file_get_contents($fixture['report']))->toContain('Status: BLOCKED', 'missing_category');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
})->with([
    'claims' => ['claims', '01-CLAIMS.md'], 'media' => ['media', '01-MEDIA.md'],
    'professional wording' => ['professional_wording', '01-PROFESSIONAL-WORDING.md'],
    'operations' => ['operations', '01-OPERATIONS.md'], 'privacy' => ['privacy', '01-PRIVACY-DECISION.md'],
]);

it('propagates each accountable category pending decision as a sanitized blocker', function (string $category) {
    $fixture = releaseGateFixture();

    try {
        releaseGateSetDecision($fixture, $category, 'pending');

        expect(releaseGateRun($fixture))->toBe(1)
            ->and(Artisan::output())->toContain($category, 'pending');
        expect(file_get_contents($fixture['report']))->toContain('Status: BLOCKED');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
})->with(['claims', 'media', 'professional_wording', 'operations', 'privacy']);

it('never upgrades a non-approved clinical decision', function (string $decision) {
    $fixture = releaseGateFixture();

    try {
        releaseGateSetDecision($fixture, 'claims', $decision);

        expect(releaseGateRun($fixture))->toBe(1)
            ->and(Artisan::output())->toContain($decision.'_claim');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
})->with(['pending', 'rejected', 'quarantined', 'expired']);

it('blocks malformed category payloads without exposing their bytes', function (string $category, string $file, string $marker) {
    $fixture = releaseGateFixture();

    try {
        file_put_contents($fixture['directory'].'/'.$file, '# Fixture'.PHP_EOL.'<!-- '.$marker.':start -->'.PHP_EOL.'{"credential":"secret"'.PHP_EOL.'<!-- '.$marker.':end -->');

        expect(releaseGateRun($fixture))->toBe(1)
            ->and(Artisan::output())->toContain($category, 'invalid_')
            ->and(Artisan::output())->not->toContain('credential', 'secret');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
})->with([
    'claims' => ['claims', '01-CLAIMS.md', 'governance-claims'],
    'media' => ['media', '01-MEDIA.md', 'governance-media'],
    'professional wording' => ['professional_wording', '01-PROFESSIONAL-WORDING.md', 'governance-professional'],
    'operations' => ['operations', '01-OPERATIONS.md', 'governance-operations'],
    'privacy' => ['privacy', '01-PRIVACY-DECISION.md', 'governance-privacy'],
]);

it('normalizes every register binding failure to revision mismatch', function (string $file, string $marker) {
    $fixture = releaseGateFixture();

    try {
        $path = $fixture['directory'].'/'.$file;
        $payload = releaseGateReadTagged($path, $marker);
        $payload['inventory_revision'] = str_repeat('f', 40);
        releaseGateWriteTagged($path, $marker, $payload);

        expect(releaseGateRun($fixture))->toBe(1)
            ->and(Artisan::output())->toContain('revision_mismatch');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
})->with([
    'claims' => ['01-CLAIMS.md', 'governance-claims'],
    'media' => ['01-MEDIA.md', 'governance-media'],
    'professional wording' => ['01-PROFESSIONAL-WORDING.md', 'governance-professional'],
    'operations' => ['01-OPERATIONS.md', 'governance-operations'],
    'privacy' => ['01-PRIVACY-DECISION.md', 'governance-privacy'],
]);

it('blocks incomplete inventory summaries and baseline digest mismatches', function (string $target) {
    $fixture = releaseGateFixture();

    try {
        if ($target === 'inventory') {
            $inventory = json_decode((string) file_get_contents($fixture['inventory']), true, flags: JSON_THROW_ON_ERROR);
            $inventory['summary']['omissions'] = ['untrusted detail must not be emitted'];
            file_put_contents($fixture['inventory'], json_encode($inventory, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR).PHP_EOL);
        } else {
            $baseline = releaseGateReadTagged($fixture['baseline'], 'governance-baseline');
            $baseline['runs'][0]['inventory_digest'] = str_repeat('f', 64);
            releaseGateWriteTagged($fixture['baseline'], 'governance-baseline', $baseline);
        }

        expect(releaseGateRun($fixture))->toBe(1)
            ->and(Artisan::output())->toContain($target === 'inventory' ? 'inventory_incomplete' : 'revision_mismatch')
            ->and(Artisan::output())->not->toContain('untrusted detail');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
})->with(['inventory', 'baseline']);

it('binds inventory, baseline, and every approval to one exact revision and digest', function () {
    $fixture = releaseGateFixture();

    try {
        $baseline = releaseGateReadTagged($fixture['baseline'], 'governance-baseline');
        $baseline['runs'][0]['revision'] = str_repeat('f', 40);
        releaseGateWriteTagged($fixture['baseline'], 'governance-baseline', $baseline);

        expect(releaseGateRun($fixture))->toBe(1)
            ->and(Artisan::output())->toContain('revision_mismatch');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
});

it('orders findings deterministically and never discloses controlled evidence', function () {
    $fixture = releaseGateFixture();

    try {
        $claims = releaseGateReadTagged($fixture['directory'].'/01-CLAIMS.md', 'governance-claims');
        $claims['records'][0]['decision'] = 'pending';
        $claims['records'][0]['dra_emily_evidence_reference'] = 'https://user:secret@example.test/patient/123';
        releaseGateWriteTagged($fixture['directory'].'/01-CLAIMS.md', 'governance-claims', $claims);

        expect(releaseGateRun($fixture))->toBe(1);
        $first = (string) file_get_contents($fixture['report']);
        expect(releaseGateRun($fixture))->toBe(1);
        $second = (string) file_get_contents($fixture['report']);

        expect($second)->toBe($first)
            ->and($second)->not->toContain('user:secret', 'patient/123')
            ->and($second)->toContain('pending_claim', 'invalid_evidence_reference');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
});

it('blocks duplicate and conflicting evidence instead of selecting a decision', function () {
    $fixture = releaseGateFixture();

    try {
        $claims = releaseGateReadTagged($fixture['directory'].'/01-CLAIMS.md', 'governance-claims');
        $conflict = $claims['records'][0];
        $conflict['decision'] = 'rejected';
        $claims['records'][] = $conflict;
        releaseGateWriteTagged($fixture['directory'].'/01-CLAIMS.md', 'governance-claims', $claims);

        expect(releaseGateRun($fixture))->toBe(1)
            ->and(Artisan::output())->toContain('duplicate_claim_identity', 'conflicting_claim_decision');
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
});

it('keeps report ordering stable when register records are reversed', function () {
    $fixture = releaseGateFixture();

    try {
        releaseGateSetDecision($fixture, 'operations', 'pending');
        expect(releaseGateRun($fixture))->toBe(1);
        $first = (string) file_get_contents($fixture['report']);

        $operations = releaseGateReadTagged($fixture['directory'].'/01-OPERATIONS.md', 'governance-operations');
        $operations['records'] = array_reverse($operations['records']);
        releaseGateWriteTagged($fixture['directory'].'/01-OPERATIONS.md', 'governance-operations', $operations);

        expect(releaseGateRun($fixture))->toBe(1);

        expect(file_get_contents($fixture['report']))->toBe($first);
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
});

it('writes reports atomically during concurrent read-only checks without mutating registers', function () {
    $fixture = releaseGateFixture();
    $registers = ['01-CLAIMS.md', '01-MEDIA.md', '01-PROFESSIONAL-WORDING.md', '01-OPERATIONS.md', '01-PRIVACY-DECISION.md'];

    try {
        $before = collect($registers)->mapWithKeys(fn (string $name): array => [$name => hash_file('sha256', $fixture['directory'].'/'.$name)])->all();
        $arguments = [PHP_BINARY, base_path('artisan'), 'governance:check-release', '--inventory='.$fixture['inventory'],
            '--evidence-dir='.$fixture['directory'], '--baseline='.$fixture['baseline'], '--report='.$fixture['report']];
        $processes = [new Process($arguments, base_path()), new Process($arguments, base_path())];

        foreach ($processes as $process) {
            $process->start();
        }

        foreach ($processes as $process) {
            expect($process->wait())->toBe(0);
        }

        $after = collect($registers)->mapWithKeys(fn (string $name): array => [$name => hash_file('sha256', $fixture['directory'].'/'.$name)])->all();

        expect($after)->toBe($before)
            ->and(file_get_contents($fixture['report']))->toContain('Status: READY')
            ->and(glob($fixture['directory'].'/.release.md.tmp.*') ?: [])->toBe([]);
    } finally {
        releaseGateRemoveDirectory($fixture['directory']);
    }
});

it('defines the immutable validator order and accountable owners in configuration', function () {
    expect(array_keys(config('governance.release_categories')))->toBe([
        'claims', 'media', 'professional_wording', 'operations', 'privacy',
    ])->and(config('governance.release_categories.claims.requirement'))->toBe('GOV-03')
        ->and(config('governance.release_categories.privacy.requirement'))->toBe('MEAS-03');
});
