<?php

use App\Governance\PrivacyDecision;

function privacyRecord(array $overrides = []): array
{
    $productionConfiguration = [
        'ga4_id' => 'G-EXAMPLE',
        'configured_tag_present' => true,
        'observed_collection' => false,
        'observed_tags' => ['gtag.js'],
        'consent_state' => 'denied_until_choice',
        'measurement_status' => 'measured',
        'measurement_owner' => 'Named privacy owner',
        'not_measured_reason' => 'none',
        'source_revision' => str_repeat('f', 40),
    ];

    return array_replace([
        'schema_version' => 1,
        'inventory_revision' => str_repeat('f', 40),
        'controller' => 'Named controller',
        'processors' => ['google-analytics'],
        'purposes' => ['measure-consultation-cta'],
        'data_parameters' => ['cta-placement', 'page-path', 'procedure-slug'],
        'lawful_bases' => ['consent'],
        'consent_trigger' => 'before_analytics_collection',
        'deny_behavior' => 'blocks_analytics_collection',
        'revoke_behavior' => 'stops_future_collection_and_clears_permitted_storage',
        'retention' => 'Named retention period',
        'access_roles' => ['named-marketing-analyst'],
        'transfers' => ['processor-region-pending-confirmation'],
        'production_configuration' => $productionConfiguration,
        'production_configuration_hash' => PrivacyDecision::productionConfigurationHash($productionConfiguration),
        'approver' => 'Named privacy owner',
        'decided_on' => '2026-09-01',
        'decision' => 'approved',
        'unresolved_questions' => ['none'],
        'evidence_references' => ['privacy:decision-2026-09'],
        'applicable_revision' => str_repeat('f', 40),
        'recheck_on' => '2027-03-01',
    ], $overrides);
}

it('blocks a missing or empty privacy decision and every blank required field', function (string $field) {
    $record = privacyRecord([$field => null]);
    $findings = (new PrivacyDecision)->validate($record, str_repeat('f', 40), new DateTimeImmutable('2026-09-09'));

    expect(array_column($findings, 'reason'))->toContain('missing_'.$field);
})->with([
    'controller', 'processors', 'purposes', 'data_parameters', 'lawful_bases', 'consent_trigger', 'deny_behavior',
    'revoke_behavior', 'retention', 'access_roles', 'transfers', 'production_configuration',
    'production_configuration_hash', 'approver', 'decided_on', 'decision', 'unresolved_questions',
    'evidence_references', 'applicable_revision', 'recheck_on',
]);

it('keeps a configured ga4 identifier separate from observed collection and approval', function () {
    $record = privacyRecord(['decision' => 'pending']);
    $record['production_configuration']['observed_collection'] = false;
    $record['production_configuration_hash'] = PrivacyDecision::productionConfigurationHash($record['production_configuration']);
    $findings = (new PrivacyDecision)->validate($record, str_repeat('f', 40), new DateTimeImmutable('2026-09-09'));

    expect($record['production_configuration']['ga4_id'])->not->toBeEmpty()
        ->and($record['production_configuration']['observed_collection'])->toBeFalse()
        ->and(array_column($findings, 'reason'))->toContain('pending_privacy_decision');
});

it('blocks unknown production tags and consent behavior as not measured with owner and reason', function (array $productionOverrides, string $reason) {
    $record = privacyRecord();
    $record['production_configuration'] = array_replace($record['production_configuration'], $productionOverrides);
    $record['production_configuration_hash'] = PrivacyDecision::productionConfigurationHash($record['production_configuration']);
    $findings = (new PrivacyDecision)->validate($record, str_repeat('f', 40), new DateTimeImmutable('2026-09-09'));

    expect(array_column($findings, 'reason'))->toContain($reason);
})->with([
    'not measured' => [['measurement_status' => 'not_measured'], 'production_analytics_not_measured'],
    'missing owner' => [['measurement_status' => 'not_measured', 'measurement_owner' => null], 'missing_measurement_owner'],
    'missing reason' => [['measurement_status' => 'not_measured', 'not_measured_reason' => null], 'missing_not_measured_reason'],
    'unknown consent' => [['consent_state' => 'unknown'], 'unknown_production_consent_state'],
]);

it('binds exact utf-8 production configuration bytes without sensitive payloads', function () {
    $record = privacyRecord();
    $record['production_configuration']['ga4_id'] = 'G-EXAMPLÉ';
    $findings = (new PrivacyDecision)->validate($record, str_repeat('f', 40), new DateTimeImmutable('2026-09-09'));

    expect(array_column($findings, 'reason'))->toContain('production_configuration_hash_mismatch')
        ->and(json_encode($record, JSON_THROW_ON_ERROR))->not->toContain('patient_name', 'message_content', 'health_data');
});

it('normalizes schema-defined list order but rejects duplicates and conflicting lawful bases', function () {
    $record = privacyRecord([
        'processors' => ['z-processor', 'a-processor'],
        'purposes' => ['z-purpose', 'a-purpose'],
        'access_roles' => ['z-role', 'a-role'],
        'transfers' => ['z-transfer', 'a-transfer'],
    ]);
    $shuffled = array_replace($record, [
        'processors' => array_reverse($record['processors']),
        'purposes' => array_reverse($record['purposes']),
        'access_roles' => array_reverse($record['access_roles']),
        'transfers' => array_reverse($record['transfers']),
    ]);
    $validator = new PrivacyDecision;

    expect($validator->validate($record, str_repeat('f', 40), new DateTimeImmutable('2026-09-09')))
        ->toBe($validator->validate($shuffled, str_repeat('f', 40), new DateTimeImmutable('2026-09-09')));

    $conflicting = privacyRecord(['processors' => ['google-analytics', 'google-analytics'], 'lawful_bases' => ['consent', 'legitimate_interest']]);
    expect(array_column($validator->validate($conflicting, str_repeat('f', 40), new DateTimeImmutable('2026-09-09')), 'reason'))
        ->toContain('duplicate_processors', 'conflicting_lawful_bases');
});

it('blocks contradictory consent behavior and multiple decisions for one revision', function () {
    $record = privacyRecord(['consent_trigger' => 'after_collection', 'deny_behavior' => 'continues_collection', 'decision' => ['approved', 'rejected']]);
    $reasons = array_column((new PrivacyDecision)->validate($record, str_repeat('f', 40), new DateTimeImmutable('2026-09-09')), 'reason');

    expect($reasons)->toContain('contradictory_consent_behavior', 'multiple_privacy_decisions');
});

it('is idempotent and shared-read validation cannot modify protected files', function () {
    $path = privacyTemporaryMarkdown(privacyRecord(['decision' => 'pending']));
    $root = dirname(__DIR__, 3);
    $protected = [$path, $root.'/resources/views/components/site-layout.blade.php', $root.'/config/clinic.php'];
    $before = array_map(fn (string $file): string => hash_file('sha256', $file), $protected);
    $validator = new PrivacyDecision;
    $firstHandle = fopen($path, 'rb');
    $secondHandle = fopen($path, 'rb');
    flock($firstHandle, LOCK_SH);
    flock($secondHandle, LOCK_SH);

    try {
        $first = $validator->validateFile($path, str_repeat('f', 40), new DateTimeImmutable('2026-09-09'));
        $second = $validator->validateFile($path, str_repeat('f', 40), new DateTimeImmutable('2026-09-09'));
    } finally {
        flock($firstHandle, LOCK_UN);
        flock($secondHandle, LOCK_UN);
        fclose($firstHandle);
        fclose($secondHandle);
    }

    expect($second)->toBe($first)
        ->and(array_map(fn (string $file): string => hash_file('sha256', $file), $protected))->toBe($before)
        ->and(get_class_methods(PrivacyDecision::class))->not->toContain('write', 'enable', 'approve', 'seed');
});

it('records exact configured analytics separately and keeps production privacy approval blocked', function () {
    $root = dirname(__DIR__, 3);
    $path = $root.'/.planning/phases/01-baseline-content-freeze-approval-gates/01-PRIVACY-DECISION.md';
    $contents = file_get_contents($path);
    $payload = json_decode(str($contents)->between('<!-- governance-privacy:start -->', '<!-- governance-privacy:end -->')->trim()->toString(), true, flags: JSON_THROW_ON_ERROR);
    $protected = [$path, $root.'/resources/views/components/site-layout.blade.php', $root.'/config/clinic.php'];
    $before = array_map(fn (string $file): string => hash_file('sha256', $file), $protected);
    $findings = (new PrivacyDecision)->validateFile($path, '55be224238cbe07e2a79f3234284242315c1daef', new DateTimeImmutable('2026-09-09'));
    $reasons = array_column($findings, 'reason');

    expect($payload['production_configuration']['ga4_id'])->toBe('G-FHD94M3R1T')
        ->and($payload['production_configuration']['observed_collection'])->toBeNull()
        ->and($payload['production_configuration']['measurement_status'])->toBe('not_measured')
        ->and($payload['decision'])->toBe('pending')
        ->and($reasons)->toContain('production_analytics_not_measured', 'pending_privacy_decision', 'missing_controller', 'missing_lawful_bases')
        ->and($reasons)->not->toContain('production_configuration_hash_mismatch')
        ->and(array_map(fn (string $file): string => hash_file('sha256', $file), $protected))->toBe($before);
});

function privacyTemporaryMarkdown(array $payload): string
{
    $path = sys_get_temp_dir().'/privacy-decision-'.bin2hex(random_bytes(6)).'.md';
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    file_put_contents($path, "# Privacy\n\n<!-- governance-privacy:start -->\n{$json}\n<!-- governance-privacy:end -->\n");

    return $path;
}
