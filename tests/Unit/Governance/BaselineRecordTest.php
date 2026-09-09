<?php

/**
 * @return array{schema_version: int, runs: list<array<string, mixed>>}
 */
function phaseOneBaselinePayload(): array
{
    $path = dirname(__DIR__, 3).'/.planning/phases/01-baseline-content-freeze-approval-gates/01-BASELINE.md';

    expect($path)->toBeFile();

    $contents = (string) file_get_contents($path);
    $begin = '<!-- governance-baseline:start -->';
    $end = '<!-- governance-baseline:end -->';

    expect(substr_count($contents, $begin))->toBe(1)
        ->and(substr_count($contents, $end))->toBe(1);

    $payload = str($contents)->between($begin, $end)->trim()->toString();

    return json_decode($payload, true, flags: JSON_THROW_ON_ERROR);
}

it('binds every append-only baseline run and record to exact provenance', function () {
    $baseline = phaseOneBaselinePayload();

    expect($baseline['schema_version'])->toBe(1)
        ->and($baseline['runs'])->not->toBeEmpty();

    $runIds = [];

    foreach ($baseline['runs'] as $run) {
        expect($run)->toHaveKeys([
            'id',
            'captured_at',
            'revision',
            'dirty_tree',
            'environment',
            'base_url',
            'browser',
            'os',
            'tool',
            'inventory_digest',
            'measurement_definitions',
            'records',
        ])
            ->and($run['captured_at'])->toMatch('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/')
            ->and($run['revision'])->toMatch('/^[a-f0-9]{40}$/')
            ->and($run['dirty_tree'])->not->toBeEmpty()
            ->and($run['inventory_digest'])->toMatch('/^[a-f0-9]{64}$/')
            ->and($run['records'])->not->toBeEmpty()
            ->and($runIds)->not->toContain($run['id']);

        $runIds[] = $run['id'];
    }

    $inventoryPath = dirname(__DIR__, 3).'/.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json';
    $inventory = json_decode((string) file_get_contents($inventoryPath), true, flags: JSON_THROW_ON_ERROR);
    $itemPayload = json_encode(
        $inventory['items'],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
    ).PHP_EOL;

    expect($baseline['runs'][0]['inventory_digest'])->toBe(hash('sha256', $itemPayload));
});

it('covers every UI matrix surface, viewport, and backstop state with evidence or an honest blocker', function () {
    $run = phaseOneBaselinePayload()['runs'][0];
    $records = collect($run['records']);

    foreach ([
        'homepage',
        'generic_procedure',
        'full_face',
        'public_route_union',
        'navigation',
        'footer',
        'cta_inventory',
        'faq_disclosures',
        'media',
        'json_ld',
        'sitemap',
        'analytics_measurement',
        'unavailable_error',
    ] as $surface) {
        expect($records->where('surface', $surface))->not->toBeEmpty("Missing baseline surface {$surface}");
    }

    foreach ([320, 768, 1440] as $width) {
        expect($records->where('viewport.width', $width))->not->toBeEmpty("Missing {$width}px baseline");
    }

    expect($records->where('viewport.zoom', 200))->not->toBeEmpty('Missing 200% zoom baseline')
        ->and($records->where('reduced_motion', 'reduce'))->not->toBeEmpty('Missing reduced-motion baseline');

    foreach ([
        'loaded',
        'throttled_or_in_flight',
        'failure',
        'overflow_and_long_text',
        'keyboard_focus',
        'faq_closed',
        'faq_open',
        'no_javascript',
    ] as $state) {
        expect($records->where('state', $state))->not->toBeEmpty("Missing baseline state {$state}");
    }

    foreach ($records as $record) {
        expect($record)->toHaveKeys([
            'id',
            'surface',
            'route',
            'state',
            'viewport',
            'color_scheme',
            'reduced_motion',
            'evidence_status',
            'evidence_reference',
            'observation',
            'limitation',
            'owner',
            'measured_at',
        ])
            ->and($record['evidence_status'])->toBeIn(['observed', 'not measured'])
            ->and($record['observation'])->not->toBeEmpty()
            ->and($record['owner'])->not->toBeEmpty()
            ->and($record['measured_at'])->toMatch('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/');

        if ($record['evidence_status'] === 'observed') {
            expect($record['evidence_reference'])->not->toBeEmpty();
        } else {
            expect($record['evidence_reference'])->toBe('not measured')
                ->and($record['limitation'])->not->toBeEmpty();
        }
    }
});

it('keeps configured analytics, observed collection, and downstream clinic outcomes distinct', function () {
    $run = phaseOneBaselinePayload()['runs'][0];
    $definitions = $run['measurement_definitions'];
    $analytics = collect($run['records'])->where('surface', 'analytics_measurement');

    expect($definitions)->toHaveKeys([
        'configured_analytics',
        'observed_collection',
        'whatsapp_link_activation',
        'downstream_outcomes',
    ])
        ->and($definitions['whatsapp_link_activation'])->toContain('browser click proxy only')
        ->and($definitions['downstream_outcomes'])->toContain('not measured by a link activation')
        ->and($analytics)->not->toBeEmpty();

    foreach ($analytics as $record) {
        expect($record['observation'])->not->toContain(
            'qualified lead confirmed',
            'appointment confirmed',
            'patient confirmed',
            'revenue confirmed',
        );
    }
});
