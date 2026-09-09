<?php

use App\Governance\ProfessionalWordingRegister;

function professionalInventory(array $items): array
{
    return ['schema_version' => 2, 'run' => ['revision' => str_repeat('c', 40)], 'items' => $items];
}

function professionalItem(string $id = 'publication.professional-one', string $content = 'Cirurgiã-Dentista — Especialista em Harmonização Orofacial', string $route = '/', string $context = 'visible:p:1'): array
{
    return ['id' => $id, 'category' => 'visible_text', 'content' => $content, 'content_hash' => hash('sha256', $content), 'locale' => 'pt-BR', 'route' => $route, 'route_name' => 'home', 'context' => $context, 'visibility' => 'visible', 'source' => 'resources/views/welcome.blade.php'];
}

function professionalRecord(array $item, array $overrides = []): array
{
    return array_replace([
        'stable_id' => $item['id'], 'exact_wording' => $item['content'], 'content_hash' => $item['content_hash'], 'locale' => $item['locale'], 'route' => $item['route'], 'context' => $item['context'], 'source_locator' => $item['source'],
        'scope_sensitive' => true, 'classification_reviewer' => 'Named content reviewer', 'current_registration_evidence_reference' => 'registration:cro-mg-current', 'external_reviewer_role' => 'qualified_legal_counsel', 'external_reviewer_name' => 'Named reviewer', 'reviewed_on' => '2026-09-01',
        'decision_reference' => 'legal:hof-2026-09', 'decision' => 'approved', 'applicable_revision' => str_repeat('c', 40), 'applicable_until' => '2027-09-01', 'recheck_on' => '2027-08-01', 'blocked_reason' => 'none',
    ], $overrides);
}

function professionalPayload(array $records, array $overrides = []): array
{
    return array_replace(['schema_version' => 1, 'inventory_revision' => str_repeat('c', 40), 'classification_completed_by' => 'Named content reviewer', 'classification_completed_on' => '2026-09-01', 'records' => $records], $overrides);
}

it('fails closed for a missing or empty professional wording register', function () {
    $item = professionalItem();
    $validator = new ProfessionalWordingRegister;

    expect($validator->validateFiles(professionalTemporaryJson(professionalInventory([$item])), sys_get_temp_dir().'/missing-professional-'.bin2hex(random_bytes(4)).'.md', new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => '@professional', 'route' => '@register', 'context' => '@register', 'reason' => 'missing_professional_register'])
        ->and($validator->validate(professionalInventory([$item]), professionalPayload([]), new DateTimeImmutable('2026-09-09')))
        ->toContain(['stable_id' => $item['id'], 'route' => '/', 'context' => 'visible:p:1', 'reason' => 'unregistered_professional_wording']);
});

it('requires every visible metadata and schema reuse context', function () {
    $visible = professionalItem();
    $schema = professionalItem(id: 'publication.professional-two', context: 'json-ld:0:/jobTitle');
    $metadata = professionalItem(id: 'publication.professional-three', context: 'metadata:author:4');

    $findings = (new ProfessionalWordingRegister)->validate(professionalInventory([$metadata, $schema, $visible]), professionalPayload([professionalRecord($visible), professionalRecord($schema)]), new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(['stable_id' => $metadata['id'], 'route' => '/', 'context' => 'metadata:author:4', 'reason' => 'unregistered_professional_wording']);
});

it('binds decisions to exact utf-8 bytes locale route context and revision', function () {
    $item = professionalItem(content: 'Cirurgiã-Dentista — CRO-MG 069427');
    $record = professionalRecord($item, ['exact_wording' => 'Cirurgiã-Dentista — CRO-MG 069427', 'content_hash' => hash('sha256', 'Cirurgiã-Dentista — CRO-MG 069427'), 'locale' => 'en-US', 'context' => 'visible:p:2', 'applicable_revision' => str_repeat('d', 40)]);

    $reasons = array_column((new ProfessionalWordingRegister)->validate(professionalInventory([$item]), professionalPayload([$record]), new DateTimeImmutable('2026-09-09')), 'reason');

    expect($reasons)->toContain('context_mismatch');
});

it('requires current professional and external scope evidence without interpreting it', function (array $overrides, string $reason) {
    $item = professionalItem();
    $findings = (new ProfessionalWordingRegister)->validate(professionalInventory([$item]), professionalPayload([professionalRecord($item, $overrides)]), new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(['stable_id' => $item['id'], 'route' => '/', 'context' => 'visible:p:1', 'reason' => $reason]);
})->with([
    'classification pending' => [['scope_sensitive' => null], 'missing_scope_classification'],
    'registration missing' => [['current_registration_evidence_reference' => null], 'missing_registration_evidence'],
    'external reviewer missing' => [['external_reviewer_name' => null], 'missing_external_reviewer'],
    'review date missing' => [['reviewed_on' => null], 'missing_external_review_date'],
    'decision locator missing' => [['decision_reference' => null], 'missing_external_decision_reference'],
    'pending' => [['decision' => 'pending'], 'pending_professional_wording'],
    'rejected' => [['decision' => 'rejected'], 'rejected_professional_wording'],
    'quarantined' => [['decision' => 'quarantined'], 'quarantined_professional_wording'],
    'expired status' => [['decision' => 'expired'], 'expired_professional_wording'],
    'stale applicability' => [['applicable_until' => '2026-09-08'], 'stale_professional_decision'],
]);

it('allows no sensitive wording only after exact-revision accountable classification', function () {
    $validator = new ProfessionalWordingRegister;
    $empty = professionalInventory([]);

    expect($validator->validate($empty, professionalPayload([], ['classification_completed_by' => null, 'classification_completed_on' => null]), new DateTimeImmutable('2026-09-09')))->toContain(['stable_id' => '@no-professional-wording', 'route' => '@inventory', 'context' => '@inventory', 'reason' => 'missing_professional_classification_declaration'])
        ->and($validator->validate($empty, professionalPayload([]), new DateTimeImmutable('2026-09-09')))->toBe([]);
});

it('rejects duplicate identities and conflicting classifications and decisions deterministically', function () {
    $item = professionalItem();
    $base = professionalRecord($item);
    $other = array_replace($base, ['scope_sensitive' => false, 'decision' => 'rejected']);
    $findings = (new ProfessionalWordingRegister)->validate(professionalInventory([$item]), professionalPayload([$other, $base]), new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(
        ['stable_id' => $item['id'], 'route' => '/', 'context' => 'visible:p:1', 'reason' => 'duplicate_professional_identity'],
        ['stable_id' => $item['id'], 'route' => '/', 'context' => 'visible:p:1', 'reason' => 'conflicting_scope_classification'],
        ['stable_id' => $item['id'], 'route' => '/', 'context' => 'visible:p:1', 'reason' => 'conflicting_professional_decision'],
    );
});

it('sorts findings and reads shared snapshots without mutation', function () {
    $a = professionalItem(id: 'publication.a', content: 'Dra. Emily Beatriz', context: 'visible:p:2');
    $b = professionalItem(id: 'publication.b', content: 'CRO-MG 069427', context: 'visible:p:1');
    $inventory = professionalInventory([$b, $a]);
    $payload = professionalPayload([professionalRecord($b, ['decision' => 'pending']), professionalRecord($a, ['decision' => 'rejected'])]);
    $inventoryPath = professionalTemporaryJson($inventory);
    $registerPath = professionalTemporaryMarkdown($payload);
    $before = hash_file('sha256', $registerPath);
    $validator = new ProfessionalWordingRegister;
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
        ->and(array_column($first, 'stable_id'))->toBe(['publication.a', 'publication.b'])
        ->and(hash_file('sha256', $registerPath))->toBe($before)
        ->and(get_class_methods(ProfessionalWordingRegister::class))->not->toContain('write', 'approve', 'seed');
});

it('covers the frozen inventory with truthful pending external-review records', function () {
    $root = dirname(__DIR__, 3);
    $inventoryPath = $root.'/.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json';
    $registerPath = $root.'/.planning/phases/01-baseline-content-freeze-approval-gates/01-PROFESSIONAL-WORDING.md';
    $contents = file_get_contents($registerPath);
    $payload = json_decode(str($contents)->between('<!-- governance-professional:start -->', '<!-- governance-professional:end -->')->trim()->toString(), true, flags: JSON_THROW_ON_ERROR);
    $validator = new ProfessionalWordingRegister;
    $inventory = json_decode(file_get_contents($inventoryPath), true, flags: JSON_THROW_ON_ERROR);
    $findings = $validator->validateFiles($inventoryPath, $registerPath, new DateTimeImmutable('2026-09-09'));
    $reasons = array_column($findings, 'reason');

    expect($payload['records'])->toHaveCount(count($validator->candidateItems($inventory)))
        ->and(array_unique(array_column($payload['records'], 'decision')))->toBe(['pending'])
        ->and(array_unique(array_column($payload['records'], 'scope_sensitive')))->toBe([null])
        ->and($reasons)->toContain('missing_scope_classification', 'missing_registration_evidence', 'pending_professional_wording')
        ->and($reasons)->not->toContain('unregistered_professional_wording', 'stale_professional_hash', 'context_mismatch');
});

function professionalTemporaryJson(array $payload): string
{
    $path = sys_get_temp_dir().'/professional-inventory-'.bin2hex(random_bytes(6)).'.json';
    file_put_contents($path, json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));

    return $path;
}

function professionalTemporaryMarkdown(array $payload): string
{
    $path = sys_get_temp_dir().'/professional-register-'.bin2hex(random_bytes(6)).'.md';
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    file_put_contents($path, "# Professional wording\n\n<!-- governance-professional:start -->\n{$json}\n<!-- governance-professional:end -->\n");

    return $path;
}
