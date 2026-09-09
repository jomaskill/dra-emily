<?php

use App\Governance\OperationsRegister;

function operationsRecord(string $domain = 'identity', array $overrides = []): array
{
    return array_replace([
        'stable_id' => 'operations.'.$domain,
        'domain' => $domain,
        'configured_value' => 'Valor configurado — UTF-8',
        'configured_source' => 'config/clinic.php',
        'observed_value' => 'Valor configurado — UTF-8',
        'verifier' => 'Named operations verifier',
        'verified_on' => '2026-09-01',
        'evidence_reference' => 'operations:'.$domain.'-2026-09',
        'status' => 'approved',
        'recheck_on' => '2027-03-01',
        'contexts' => [['route' => '/', 'context' => 'footer:'.$domain, 'source' => 'resources/views/partials/footer.blade.php']],
        'mismatch_notes' => 'none',
    ], $overrides);
}

function operationsPayload(array $records): array
{
    return ['schema_version' => 1, 'inventory_revision' => str_repeat('e', 40), 'records' => $records];
}

function completeOperationsRecords(): array
{
    return array_map(fn (string $domain): array => operationsRecord($domain), OperationsRegister::REQUIRED_DOMAINS);
}

it('requires every operational domain and never accepts an empty register', function (string $missingDomain) {
    $records = array_values(array_filter(completeOperationsRecords(), fn (array $record): bool => $record['domain'] !== $missingDomain));
    $findings = (new OperationsRegister)->validate(operationsPayload($records), str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(['stable_id' => 'operations.'.$missingDomain, 'domain' => $missingDomain, 'reason' => 'missing_domain']);
})->with(fn (): array => array_combine(OperationsRegister::REQUIRED_DOMAINS, OperationsRegister::REQUIRED_DOMAINS));

it('keeps configured and observed values separate even when textually equal', function () {
    $record = operationsRecord('identity', ['verifier' => null, 'evidence_reference' => null]);
    $findings = (new OperationsRegister)->validate(operationsPayload([$record]), str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(
        ['stable_id' => 'operations.identity', 'domain' => 'identity', 'reason' => 'missing_verifier'],
        ['stable_id' => 'operations.identity', 'domain' => 'identity', 'reason' => 'missing_operations_evidence'],
    );
});

it('retains every public reuse context without merging evidence', function () {
    $record = operationsRecord('hours', ['contexts' => [
        ['route' => '/', 'context' => 'footer:hours', 'source' => 'resources/views/partials/footer.blade.php'],
        ['route' => '/', 'context' => 'json-ld:openingHours', 'source' => 'resources/views/partials/schema.blade.php'],
    ]]);
    $findings = (new OperationsRegister)->validate(operationsPayload([$record]), str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));

    expect($findings)->not->toContain(['stable_id' => 'operations.hours', 'domain' => 'hours', 'reason' => 'missing_context']);
});

it('blocks exact utf-8 mismatches and lossy url normalization', function (string $configured, string $observed) {
    $record = operationsRecord('directions', ['configured_value' => $configured, 'observed_value' => $observed]);
    $findings = (new OperationsRegister)->validate(operationsPayload([$record]), str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(['stable_id' => 'operations.directions', 'domain' => 'directions', 'reason' => 'configured_observed_mismatch']);
})->with([
    'unicode bytes' => ['Clínica Santa Rosa', 'Clínica Santa Rosa'],
    'url normalization' => ['https://maps.example.test/path/', 'https://maps.example.test/path'],
]);

it('blocks missing blank stale and pending evidence fields', function (array $overrides, string $reason) {
    $record = operationsRecord('contact', $overrides);
    $findings = (new OperationsRegister)->validate(operationsPayload([$record]), str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(['stable_id' => 'operations.contact', 'domain' => 'contact', 'reason' => $reason]);
})->with([
    'missing configured' => [['configured_value' => null], 'missing_configured_value'],
    'missing observed' => [['observed_value' => null], 'missing_observed_value'],
    'invalid verification date' => [['verified_on' => '09/09/2026'], 'invalid_verified_on'],
    'stale recheck' => [['recheck_on' => '2026-09-08'], 'stale_operations_evidence'],
    'pending' => [['status' => 'pending'], 'pending_operations'],
    'rejected' => [['status' => 'rejected'], 'rejected_operations'],
]);

it('rejects duplicate domains identities and conflicting observations or statuses', function () {
    $first = operationsRecord('identity');
    $second = operationsRecord('identity', ['stable_id' => 'operations.identity.duplicate', 'observed_value' => 'Outro valor', 'status' => 'rejected']);
    $findings = (new OperationsRegister)->validate(operationsPayload([$second, $first]), str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));

    expect($findings)->toContain(
        ['stable_id' => 'operations.identity', 'domain' => 'identity', 'reason' => 'duplicate_domain'],
        ['stable_id' => 'operations.identity', 'domain' => 'identity', 'reason' => 'conflicting_observation'],
        ['stable_id' => 'operations.identity', 'domain' => 'identity', 'reason' => 'conflicting_operations_status'],
    );
});

it('uses canonical domain then stable-id finding order and is idempotent', function () {
    $records = array_reverse(completeOperationsRecords());
    $records[] = operationsRecord('other', ['stable_id' => 'operations.z-extra', 'status' => 'pending']);
    $validator = new OperationsRegister;
    $forward = $validator->validate(operationsPayload($records), str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));
    $reverse = $validator->validate(operationsPayload(array_reverse($records)), str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));

    expect($reverse)->toBe($forward)
        ->and(get_class_methods(OperationsRegister::class))->not->toContain('write', 'observe', 'approve', 'seed');
});

it('reads shared snapshots concurrently without modifying the operations register', function () {
    $path = operationsTemporaryMarkdown(operationsPayload([operationsRecord('identity', ['status' => 'pending'])]));
    $before = hash_file('sha256', $path);
    $validator = new OperationsRegister;
    $firstHandle = fopen($path, 'rb');
    $secondHandle = fopen($path, 'rb');
    flock($firstHandle, LOCK_SH);
    flock($secondHandle, LOCK_SH);

    try {
        $first = $validator->validateFile($path, str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));
        $second = $validator->validateFile($path, str_repeat('e', 40), new DateTimeImmutable('2026-09-09'));
    } finally {
        flock($firstHandle, LOCK_UN);
        flock($secondHandle, LOCK_UN);
        fclose($firstHandle);
        fclose($secondHandle);
    }

    expect($second)->toBe($first)->and(hash_file('sha256', $path))->toBe($before);
});

it('seeds every configured assertion as pending rather than verified operations', function () {
    $root = dirname(__DIR__, 3);
    $path = $root.'/.planning/phases/01-baseline-content-freeze-approval-gates/01-OPERATIONS.md';
    $contents = file_get_contents($path);
    $payload = json_decode(str($contents)->between('<!-- governance-operations:start -->', '<!-- governance-operations:end -->')->trim()->toString(), true, flags: JSON_THROW_ON_ERROR);
    $before = hash_file('sha256', $path);
    $findings = (new OperationsRegister)->validateFile($path, '55be224238cbe07e2a79f3234284242315c1daef', new DateTimeImmutable('2026-09-09'));

    expect(array_column($payload['records'], 'domain'))->toBe(OperationsRegister::REQUIRED_DOMAINS)
        ->and(array_unique(array_column($payload['records'], 'status')))->toBe(['pending'])
        ->and(array_unique(array_column($payload['records'], 'observed_value')))->toBe([null])
        ->and(array_column($findings, 'reason'))->toContain('missing_observed_value', 'missing_verifier', 'missing_operations_evidence', 'pending_operations')
        ->and(hash_file('sha256', $path))->toBe($before);
});

function operationsTemporaryMarkdown(array $payload): string
{
    $path = sys_get_temp_dir().'/operations-register-'.bin2hex(random_bytes(6)).'.md';
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    file_put_contents($path, "# Operations\n\n<!-- governance-operations:start -->\n{$json}\n<!-- governance-operations:end -->\n");

    return $path;
}
