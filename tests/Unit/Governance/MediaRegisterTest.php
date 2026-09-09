<?php

use App\Governance\MediaRegister;

function mediaRegisterInventory(array $items): array
{
    return ['schema_version' => 2, 'run' => ['revision' => str_repeat('b', 40)], 'items' => $items];
}

function mediaRegisterItem(
    string $id = 'publication.media-one',
    string $category = 'public_asset',
    string $content = '{"path":"public/example.webp","sha256":"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"}',
    string $route = '@asset',
    string $context = 'public-asset:file:public/example.webp',
): array {
    return [
        'id' => $id,
        'category' => $category,
        'content' => $content,
        'content_hash' => hash('sha256', $content),
        'locale' => 'pt-BR',
        'route' => $route,
        'route_name' => '@source',
        'context' => $context,
        'visibility' => $category === 'public_asset' ? 'source_only' : 'visible',
        'source' => $category === 'public_asset' ? 'public/example.webp' : 'resources/views/welcome.blade.php',
    ];
}

function mediaRegisterRecord(array $item, array $overrides = []): array
{
    $asset = json_decode($item['content'], true);
    $hash = $item['category'] === 'public_asset' && is_array($asset) ? $asset['sha256'] : $item['content_hash'];

    return array_replace([
        'stable_id' => 'media.example',
        'kind' => $item['category'] === 'public_asset' ? 'asset' : 'rendered_media',
        'content_hash' => $hash,
        'locale' => $item['locale'],
        'path' => $item['category'] === 'public_asset' ? $item['source'] : null,
        'source_asset_id' => null,
        'derivative_of' => null,
        'contexts' => [[
            'inventory_id' => $item['id'],
            'route' => $item['route'],
            'context' => $item['context'],
            'content_hash' => $item['content_hash'],
        ]],
        'classification' => 'stock_or_illustrative',
        'classification_reason' => 'Human classification for the exact revision.',
        'provenance_reference' => 'media:asset-one',
        'authorization_reference' => 'consent:asset-one',
        'responsible_professional' => 'Dra. Emily Beatriz',
        'reviewer' => 'Authorized media custodian',
        'decision_on' => '2026-09-01',
        'decision_expires_on' => '2027-09-01',
        'recheck_on' => '2027-08-01',
        'decision' => 'approved',
        'disposition_inputs' => ['inventory_revision' => str_repeat('b', 40)],
    ], $overrides);
}

function mediaRegisterPayload(array $records, array $overrides = []): array
{
    return array_replace([
        'schema_version' => 1,
        'inventory_revision' => str_repeat('b', 40),
        'testimonial_item_ids' => [],
        'testimonial_attribution_item_ids' => [],
        'records' => $records,
    ], $overrides);
}

it('fails closed for a missing or empty media register', function () {
    $item = mediaRegisterItem();
    $validator = new MediaRegister;

    expect($validator->validateFiles(
        mediaRegisterTemporaryJson(mediaRegisterInventory([$item])),
        sys_get_temp_dir().'/missing-media-register-'.bin2hex(random_bytes(4)).'.md',
        new DateTimeImmutable('2026-09-09'),
    ))->toContain(['stable_id' => '@media', 'route' => '@register', 'context' => '@register', 'reason' => 'missing_media_register'])
        ->and($validator->validate(mediaRegisterInventory([$item]), mediaRegisterPayload([]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => $item['id'], 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'unregistered_media']);
});

it('requires each reuse context without merging one approval into another', function () {
    $hero = mediaRegisterItem(category: 'media', content: '{"source":"/example.webp","alt":""}', route: '/', context: 'media:img:1');
    $schema = mediaRegisterItem(id: 'publication.media-two', category: 'media', content: '{"source":"/example.webp","alt":""}', route: '/', context: 'json-ld:0:/image');
    $record = mediaRegisterRecord($hero, ['stable_id' => 'media.shared']);

    $findings = (new MediaRegister)->validate(
        mediaRegisterInventory([$hero, $schema]),
        mediaRegisterPayload([$record]),
        new DateTimeImmutable('2026-09-09'),
    );

    expect($findings)->toContain(['stable_id' => $schema['id'], 'route' => $schema['route'], 'context' => $schema['context'], 'reason' => 'unregistered_media']);
});

it('binds assets and testimonials to exact bytes', function () {
    $asset = mediaRegisterItem();
    $testimonial = mediaRegisterItem(
        id: 'publication.testimonial-one',
        category: 'visible_text',
        content: 'Relato em UTF-8: avaliação.',
        route: '/',
        context: 'visible:p:62',
    );
    $assetRecord = mediaRegisterRecord($asset, ['content_hash' => str_repeat('f', 64)]);
    $testimonialRecord = mediaRegisterRecord($testimonial, [
        'stable_id' => 'testimonial.one',
        'kind' => 'testimonial',
        'content_hash' => hash('sha256', 'Relato em UTF-8: avaliação.'),
        'path' => null,
    ]);
    $payload = mediaRegisterPayload([$assetRecord, $testimonialRecord], [
        'testimonial_item_ids' => [$testimonial['id']],
    ]);

    $findings = (new MediaRegister)->validate(mediaRegisterInventory([$asset, $testimonial]), $payload, new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(['stable_id' => 'media.example', 'route' => $asset['route'], 'context' => $asset['context'], 'reason' => 'stale_media_hash'])
        ->and($findings)->toContain(['stable_id' => 'testimonial.one', 'route' => $testimonial['route'], 'context' => $testimonial['context'], 'reason' => 'stale_media_hash']);
});

it('blocks unknown and incomplete patient classifications', function () {
    $item = mediaRegisterItem();
    $unknown = mediaRegisterRecord($item, ['classification' => 'unknown']);
    $patient = mediaRegisterRecord($item, [
        'classification' => 'patient',
        'provenance_reference' => null,
        'authorization_reference' => null,
        'responsible_professional' => null,
    ]);
    $validator = new MediaRegister;

    expect($validator->validate(mediaRegisterInventory([$item]), mediaRegisterPayload([$unknown]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => 'media.example', 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'unknown_media_classification'])
        ->and($validator->validate(mediaRegisterInventory([$item]), mediaRegisterPayload([$patient]), new DateTimeImmutable('2026-09-09')))
        ->toContain(
            ['stable_id' => 'media.example', 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'missing_provenance_reference'],
            ['stable_id' => 'media.example', 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'missing_authorization_reference'],
            ['stable_id' => 'media.example', 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'missing_responsible_professional'],
        );
});

it('rejects sensitive metadata and non-opaque evidence without disclosing values', function (array $overrides, string $reason) {
    $item = mediaRegisterItem();
    $record = mediaRegisterRecord($item, $overrides);
    $findings = (new MediaRegister)->validate(mediaRegisterInventory([$item]), mediaRegisterPayload([$record]), new DateTimeImmutable('2026-09-09'));
    $encoded = json_encode($findings, JSON_THROW_ON_ERROR);

    expect($findings)->toContain(['stable_id' => 'media.example', 'route' => $item['route'], 'context' => $item['context'], 'reason' => $reason])
        ->and($encoded)->not->toContain('123.456.789-00', 'secret-value', 'patient@example.test', 'BEGIN CERTIFICATE', 'https://');
})->with([
    'sensitive key' => [['patient_name' => 'secret-value'], 'sensitive_media_field'],
    'patient-shaped identifier' => [['provenance_reference' => 'patient:123.456.789-00'], 'invalid_provenance_reference'],
    'credential locator' => [['authorization_reference' => 'https://user:secret-value@example.test/consent'], 'invalid_authorization_reference'],
    'email identifier' => [['provenance_reference' => 'patient@example.test'], 'invalid_provenance_reference'],
    'embedded evidence' => [['authorization_reference' => '-----BEGIN CERTIFICATE-----'], 'invalid_authorization_reference'],
    'sensitive free text' => [['classification_reason' => 'patient@example.test'], 'sensitive_media_value'],
    'absolute path' => [['path' => '/private/patient.webp'], 'invalid_media_path'],
    'parent path' => [['path' => 'public/../private/patient.webp'], 'invalid_media_path'],
    'backslash path' => [['path' => 'public\\patient.webp'], 'invalid_media_path'],
]);

it('rejects context mismatches, duplicates, and conflicting classifications or decisions', function () {
    $item = mediaRegisterItem();
    $base = mediaRegisterRecord($item);
    $mismatch = $base;
    $mismatch['contexts'][0]['route'] = '/other';
    $validator = new MediaRegister;

    expect($validator->validate(mediaRegisterInventory([$item]), mediaRegisterPayload([$mismatch]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => $item['id'], 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'unregistered_media'])
        ->and($validator->validate(mediaRegisterInventory([$item]), mediaRegisterPayload([$base, $base]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => 'media.example', 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'duplicate_media_identity'])
        ->and($validator->validate(
            mediaRegisterInventory([$item]),
            mediaRegisterPayload([$base, array_replace($base, ['classification' => 'patient', 'decision' => 'rejected'])]),
            new DateTimeImmutable('2026-09-09'),
        ))->toContain(
            ['stable_id' => 'media.example', 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'conflicting_media_classification'],
            ['stable_id' => 'media.example', 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'conflicting_media_decision'],
        );
});

it('sorts sanitized findings deterministically', function () {
    $first = mediaRegisterItem(id: 'publication.a', context: 'media:img:2');
    $second = mediaRegisterItem(id: 'publication.b', context: 'media:img:1');
    $records = [
        mediaRegisterRecord($second, ['stable_id' => 'media.b', 'decision' => 'pending']),
        mediaRegisterRecord($first, ['stable_id' => 'media.a', 'decision' => 'rejected']),
    ];
    $validator = new MediaRegister;
    $inventory = mediaRegisterInventory([$second, $first]);

    $forward = $validator->validate($inventory, mediaRegisterPayload($records), new DateTimeImmutable('2026-09-09'));
    $reverse = $validator->validate(mediaRegisterInventory(array_reverse($inventory['items'])), mediaRegisterPayload(array_reverse($records)), new DateTimeImmutable('2026-09-09'));

    expect($reverse)->toBe($forward)
        ->and(array_column($forward, 'stable_id'))->toBe(['media.a', 'media.b']);
});

it('reads shared snapshots idempotently without modifying the human register', function () {
    $item = mediaRegisterItem();
    $inventoryPath = mediaRegisterTemporaryJson(mediaRegisterInventory([$item]));
    $registerPath = mediaRegisterTemporaryMarkdown(mediaRegisterPayload([
        mediaRegisterRecord($item, ['classification' => 'unknown', 'decision' => 'pending']),
    ]));
    $before = hash_file('sha256', $registerPath);
    $validator = new MediaRegister;
    $firstHandle = fopen($registerPath, 'rb');
    $secondHandle = fopen($registerPath, 'rb');
    flock($firstHandle, LOCK_SH);
    flock($secondHandle, LOCK_SH);

    try {
        $first = $validator->validateFiles($inventoryPath, $registerPath, new DateTimeImmutable('2026-09-09'));
        $second = $validator->validateFiles($inventoryPath, $registerPath, new DateTimeImmutable('2026-09-09'));
    } finally {
        flock($firstHandle, LOCK_UN);
        flock($secondHandle, LOCK_UN);
        fclose($firstHandle);
        fclose($secondHandle);
    }

    expect($second)->toBe($first)
        ->and(hash_file('sha256', $registerPath))->toBe($before)
        ->and(get_class_methods(MediaRegister::class))->not->toContain('write', 'approve', 'seed');
});

it('covers every frozen media and testimonial observation with truthful pending records', function () {
    $root = dirname(__DIR__, 3);
    $inventoryPath = $root.'/.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json';
    $registerPath = $root.'/.planning/phases/01-baseline-content-freeze-approval-gates/01-MEDIA.md';
    $contents = file_get_contents($registerPath);
    $payloadText = str($contents)->between('<!-- governance-media:start -->', '<!-- governance-media:end -->')->trim()->toString();
    $payload = json_decode($payloadText, true, flags: JSON_THROW_ON_ERROR);
    $findings = (new MediaRegister)->validateFiles($inventoryPath, $registerPath, new DateTimeImmutable('2026-09-09'));
    $reasons = array_column($findings, 'reason');

    expect($payload['records'])->toHaveCount(92)
        ->and(array_unique(array_column($payload['records'], 'classification')))->toBe(['unknown'])
        ->and(array_unique(array_column($payload['records'], 'decision')))->toBe(['pending'])
        ->and($reasons)->toContain('unknown_media_classification', 'pending_media')
        ->and($reasons)->not->toContain(
            'unregistered_media',
            'stale_media_hash',
            'duplicate_media_identity',
            'conflicting_media_classification',
            'conflicting_media_decision',
        );
});

function mediaRegisterTemporaryJson(array $payload): string
{
    $path = sys_get_temp_dir().'/media-inventory-'.bin2hex(random_bytes(6)).'.json';
    file_put_contents($path, json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));

    return $path;
}

function mediaRegisterTemporaryMarkdown(array $payload): string
{
    $path = sys_get_temp_dir().'/media-register-'.bin2hex(random_bytes(6)).'.md';
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    file_put_contents($path, "# Media\n\n<!-- governance-media:start -->\n{$json}\n<!-- governance-media:end -->\n");

    return $path;
}
