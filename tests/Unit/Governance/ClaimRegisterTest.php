<?php

use App\Governance\ClaimRegister;

function claimRegisterInventory(array $items): array
{
    return ['schema_version' => 2, 'run' => ['revision' => str_repeat('a', 40)], 'items' => $items];
}

function claimRegisterItem(
    string $id = 'publication.claim-one',
    string $text = 'A resposta depende de avaliação individual.',
    string $route = '/procedimentos/exemplo',
    string $context = 'visible:p:1',
): array {
    return [
        'id' => $id,
        'category' => 'visible_text',
        'content' => $text,
        'content_hash' => hash('sha256', $text),
        'locale' => 'pt-BR',
        'route' => $route,
        'route_name' => 'procedure',
        'context' => $context,
        'visibility' => 'visible',
        'source' => 'config/procedures.php',
    ];
}

function claimRegisterRecord(array $item, array $overrides = []): array
{
    return array_replace([
        'stable_id' => $item['id'],
        'exact_text' => $item['content'],
        'content_hash' => $item['content_hash'],
        'locale' => $item['locale'],
        'route' => $item['route'],
        'context' => $item['context'],
        'source_locator' => $item['source'],
        'content_owner' => 'Dra. Emily Beatriz',
        'last_reviewed_on' => '2026-09-01',
        'dra_emily_evidence_reference' => 'clinical:claim-one',
        'reviewer' => 'Dra. Emily Beatriz',
        'decision_on' => '2026-09-01',
        'review_expires_on' => '2027-09-01',
        'classification' => 'clinical_claim',
        'classification_reason' => null,
        'decision' => 'approved',
        'disposition_inputs' => [
            'inventory_revision' => str_repeat('a', 40),
            'inventory_category' => $item['category'],
            'visibility' => $item['visibility'],
        ],
    ], $overrides);
}

function claimRegisterPayload(array $records, array $overrides = []): array
{
    return array_replace([
        'schema_version' => 1,
        'inventory_revision' => str_repeat('a', 40),
        'candidate_categories' => ClaimRegister::CANDIDATE_CATEGORIES,
        'excluded_media_item_ids' => ClaimRegister::MEDIA_GOVERNED_ITEM_IDS,
        'records' => $records,
        'no_claim_candidates' => null,
    ], $overrides);
}

it('fails closed when discovered claims have no register or no matching record', function () {
    $item = claimRegisterItem();
    $validator = new ClaimRegister;

    expect($validator->validateFiles(
        claimRegisterTemporaryJson(claimRegisterInventory([$item])),
        sys_get_temp_dir().'/missing-claim-register-'.bin2hex(random_bytes(4)).'.md',
        new DateTimeImmutable('2026-09-09'),
    ))->toContain(['stable_id' => '@claims', 'route' => '@register', 'context' => '@register', 'reason' => 'missing_claim_register'])
        ->and($validator->validate(
            claimRegisterInventory([$item]),
            claimRegisterPayload([]),
            new DateTimeImmutable('2026-09-09'),
        ))->toContain(['stable_id' => $item['id'], 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'unregistered_claim']);
});

it('accepts a zero-candidate inventory only with an exact-revision human declaration', function () {
    $validator = new ClaimRegister;
    $inventory = claimRegisterInventory([]);
    $declaration = [
        'inventory_revision' => str_repeat('a', 40),
        'reviewer' => 'Dra. Emily Beatriz',
        'decision_on' => '2026-09-09',
        'reason' => 'The exact frozen inventory contains no claim candidates.',
    ];

    expect($validator->validate($inventory, claimRegisterPayload([]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => '@no-claims', 'route' => '@inventory', 'context' => '@inventory', 'reason' => 'missing_no_claim_declaration'])
        ->and($validator->validate(
            $inventory,
            claimRegisterPayload([], ['no_claim_candidates' => $declaration]),
            new DateTimeImmutable('2026-09-09'),
        ))->toBe([]);
});

it('binds approvals to exact bytes and each publication context', function () {
    $nfc = claimRegisterItem(text: 'Avaliação individual');
    $nfd = claimRegisterItem(id: 'publication.claim-two', text: 'Avaliação individual', context: 'json-ld:0:/description');
    $whitespace = claimRegisterItem(id: 'publication.claim-three', text: 'Avaliação  individual', context: 'metadata:description:1');
    $validator = new ClaimRegister;
    $register = claimRegisterPayload([
        claimRegisterRecord($nfc),
        claimRegisterRecord($nfd, ['content_hash' => $nfc['content_hash']]),
        claimRegisterRecord($whitespace, ['route' => '/']),
    ]);

    expect($nfc['content_hash'])->not->toBe($nfd['content_hash'])
        ->and($nfc['content_hash'])->not->toBe($whitespace['content_hash']);

    $findings = $validator->validate(claimRegisterInventory([$nfc, $nfd, $whitespace]), $register, new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(['stable_id' => $nfd['id'], 'route' => $nfd['route'], 'context' => $nfd['context'], 'reason' => 'stale_hash'])
        ->and($findings)->toContain(['stable_id' => $whitespace['id'], 'route' => $whitespace['route'], 'context' => $whitespace['context'], 'reason' => 'context_mismatch']);
});

it('requires distinct context bindings for identical text', function () {
    $visible = claimRegisterItem();
    $schema = claimRegisterItem(id: 'publication.claim-schema', context: 'json-ld:0:/description');

    $findings = (new ClaimRegister)->validate(
        claimRegisterInventory([$visible, $schema]),
        claimRegisterPayload([claimRegisterRecord($visible)]),
        new DateTimeImmutable('2026-09-09'),
    );

    expect($findings)->toContain(['stable_id' => $schema['id'], 'route' => $schema['route'], 'context' => $schema['context'], 'reason' => 'unregistered_claim']);
});

it('blocks non-current claim decisions with stable reason codes', function (string $decision, string $reason, array $overrides = []) {
    $item = claimRegisterItem();
    $record = claimRegisterRecord($item, array_replace(['decision' => $decision], $overrides));

    expect((new ClaimRegister)->validate(claimRegisterInventory([$item]), claimRegisterPayload([$record]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => $item['id'], 'route' => $item['route'], 'context' => $item['context'], 'reason' => $reason]);
})->with([
    'pending' => ['pending', 'pending_claim'],
    'rejected' => ['rejected', 'rejected_claim'],
    'quarantined' => ['quarantined', 'quarantined_claim'],
    'expired status' => ['expired', 'expired_claim'],
    'expired review' => ['approved', 'expired_claim', ['review_expires_on' => '2026-09-08']],
]);

it('blocks missing human evidence fields', function (string $field, string $reason) {
    $item = claimRegisterItem();
    $record = claimRegisterRecord($item, [$field => null]);

    expect((new ClaimRegister)->validate(claimRegisterInventory([$item]), claimRegisterPayload([$record]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => $item['id'], 'route' => $item['route'], 'context' => $item['context'], 'reason' => $reason]);
})->with([
    'source' => ['source_locator', 'missing_source'],
    'owner' => ['content_owner', 'missing_owner'],
    'review date' => ['last_reviewed_on', 'missing_last_reviewed_on'],
    'Dra. Emily evidence' => ['dra_emily_evidence_reference', 'missing_dra_emily_evidence'],
    'reviewer' => ['reviewer', 'missing_reviewer'],
    'decision date' => ['decision_on', 'missing_decision_on'],
]);

it('permits only an explicitly human-recorded non-claim classification', function () {
    $item = claimRegisterItem();
    $invalid = claimRegisterRecord($item, ['classification' => 'not_clinical_claim', 'classification_reason' => null]);
    $valid = array_replace($invalid, [
        'classification_reason' => 'Navigation label only; no clinical assertion.',
        'reviewer' => 'Named content owner',
        'decision_on' => '2026-09-09',
    ]);

    expect((new ClaimRegister)->validate(claimRegisterInventory([$item]), claimRegisterPayload([$invalid]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => $item['id'], 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'invalid_non_claim_classification'])
        ->and((new ClaimRegister)->validate(claimRegisterInventory([$item]), claimRegisterPayload([$valid]), new DateTimeImmutable('2026-09-09')))->toBe([]);
});

it('rejects duplicates and conflicting decisions', function () {
    $item = claimRegisterItem();
    $approved = claimRegisterRecord($item);
    $rejected = array_replace($approved, ['decision' => 'rejected']);
    $validator = new ClaimRegister;

    expect($validator->validate(claimRegisterInventory([$item]), claimRegisterPayload([$approved, $approved]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => $item['id'], 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'duplicate_claim_identity'])
        ->and($validator->validate(claimRegisterInventory([$item]), claimRegisterPayload([$approved, $rejected]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => $item['id'], 'route' => $item['route'], 'context' => $item['context'], 'reason' => 'conflicting_claim_decision']);
});

it('sorts findings deterministically regardless of input order', function () {
    $first = claimRegisterItem(id: 'publication.a', context: 'visible:p:2');
    $second = claimRegisterItem(id: 'publication.b', context: 'visible:p:1');
    $records = [claimRegisterRecord($second, ['decision' => 'pending']), claimRegisterRecord($first, ['decision' => 'rejected'])];
    $validator = new ClaimRegister;
    $inventory = claimRegisterInventory([$second, $first]);

    $forward = $validator->validate($inventory, claimRegisterPayload($records), new DateTimeImmutable('2026-09-09'));
    $reverse = $validator->validate(
        claimRegisterInventory(array_reverse($inventory['items'])),
        claimRegisterPayload(array_reverse($records)),
        new DateTimeImmutable('2026-09-09'),
    );

    expect($reverse)->toBe($forward)
        ->and(array_column($forward, 'stable_id'))->toBe(['publication.a', 'publication.b']);
});

it('reads shared snapshots idempotently without modifying the human register', function () {
    $item = claimRegisterItem();
    $inventoryPath = claimRegisterTemporaryJson(claimRegisterInventory([$item]));
    $registerPath = claimRegisterTemporaryMarkdown(claimRegisterPayload([claimRegisterRecord($item, ['decision' => 'pending'])]));
    $before = hash_file('sha256', $registerPath);
    $validator = new ClaimRegister;
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
        ->and(get_class_methods(ClaimRegister::class))->not->toContain('write', 'approve', 'seed');
});

it('covers the frozen inventory with truthful pending human records', function () {
    $root = dirname(__DIR__, 3);
    $inventoryPath = $root.'/.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json';
    $registerPath = $root.'/.planning/phases/01-baseline-content-freeze-approval-gates/01-CLAIMS.md';
    $contents = file_get_contents($registerPath);
    $payloadText = str($contents)->between('<!-- governance-claims:start -->', '<!-- governance-claims:end -->')->trim()->toString();
    $payload = json_decode($payloadText, true, flags: JSON_THROW_ON_ERROR);
    $findings = (new ClaimRegister)->validateFiles($inventoryPath, $registerPath, new DateTimeImmutable('2026-09-09'));
    $reasons = array_column($findings, 'reason');

    expect($payload['records'])->toHaveCount(2993)
        ->and(array_unique(array_column($payload['records'], 'decision')))->toBe(['pending'])
        ->and(array_unique(array_column($payload['records'], 'classification')))->toBe(['pending_human_classification'])
        ->and($reasons)->toContain('pending_claim')
        ->and($reasons)->not->toContain('unregistered_claim', 'stale_hash', 'context_mismatch');
});

function claimRegisterTemporaryJson(array $payload): string
{
    $path = sys_get_temp_dir().'/claim-inventory-'.bin2hex(random_bytes(6)).'.json';
    file_put_contents($path, json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));

    return $path;
}

function claimRegisterTemporaryMarkdown(array $payload): string
{
    $path = sys_get_temp_dir().'/claim-register-'.bin2hex(random_bytes(6)).'.md';
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    file_put_contents($path, "# Claims\n\n<!-- governance-claims:start -->\n{$json}\n<!-- governance-claims:end -->\n");

    return $path;
}
