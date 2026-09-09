<?php

namespace App\Governance;

use DateTimeImmutable;
use JsonException;
use RuntimeException;

class PrivacyDecision
{
    private const BEGIN_MARKER = '<!-- governance-privacy:start -->';

    private const END_MARKER = '<!-- governance-privacy:end -->';

    /** @var list<string> */
    private const LIST_FIELDS = ['processors', 'purposes', 'data_parameters', 'lawful_bases', 'access_roles', 'transfers', 'unresolved_questions', 'evidence_references'];

    /** @var list<string> */
    private const REQUIRED_FIELDS = [
        'controller', 'processors', 'purposes', 'data_parameters', 'lawful_bases', 'consent_trigger',
        'deny_behavior', 'revoke_behavior', 'retention', 'access_roles', 'transfers',
        'production_configuration', 'production_configuration_hash', 'approver', 'decided_on',
        'decision', 'unresolved_questions', 'evidence_references', 'applicable_revision', 'recheck_on',
    ];

    /** @var list<string> */
    private const DECISIONS = ['pending', 'approved', 'rejected', 'quarantined', 'expired'];

    /** @return list<array{stable_id: string, route: string, context: string, reason: string}> */
    public function validateFile(string $path, string $inventoryRevision, ?DateTimeImmutable $asOf = null): array
    {
        if (! is_file($path) || is_link($path)) {
            return [$this->finding('@register', 'missing_privacy_register')];
        }

        try {
            $record = $this->decodeTaggedRecord($this->readSharedSnapshot($path));
        } catch (RuntimeException) {
            return [$this->finding('@register', 'invalid_privacy_register')];
        }

        return $this->validate($record, $inventoryRevision, $asOf);
    }

    /**
     * @param  array<string, mixed>  $record
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    public function validate(array $record, string $inventoryRevision, ?DateTimeImmutable $asOf = null): array
    {
        $asOf ??= new DateTimeImmutable('today');
        $findings = [];

        foreach (self::REQUIRED_FIELDS as $field) {
            if ($this->isBlank($record[$field] ?? null)) {
                $findings[] = $this->finding($field, 'missing_'.$field);
            }
        }

        if ($this->stringValue($record['inventory_revision'] ?? null) !== $inventoryRevision || $this->stringValue($record['applicable_revision'] ?? null) !== $inventoryRevision) {
            $findings[] = $this->finding('applicable_revision', 'stale_privacy_revision');
        }

        foreach (self::LIST_FIELDS as $field) {
            $values = $this->stringList($record[$field] ?? null);

            if (count($values) !== count(array_unique($values))) {
                $findings[] = $this->finding($field, 'duplicate_'.$field);
            }
        }

        $lawfulBases = array_values(array_unique($this->stringList($record['lawful_bases'] ?? null)));

        if (count($lawfulBases) > 1) {
            $findings[] = $this->finding('lawful_bases', 'conflicting_lawful_bases');
        }

        $decision = $record['decision'] ?? null;

        if (is_array($decision)) {
            $findings[] = $this->finding('decision', 'multiple_privacy_decisions');
        } elseif (! in_array($decision, self::DECISIONS, true)) {
            $findings[] = $this->finding('decision', 'invalid_privacy_decision');
        } elseif ($decision !== 'approved') {
            $findings[] = $this->finding('decision', $decision.'_privacy_decision');
        }

        if ($this->stringValue($record['consent_trigger'] ?? null) === 'after_collection'
            || $this->stringValue($record['deny_behavior'] ?? null) === 'continues_collection') {
            $findings[] = $this->finding('consent', 'contradictory_consent_behavior');
        }

        foreach (['decided_on', 'recheck_on'] as $dateField) {
            if (! $this->isDate($this->stringValue($record[$dateField] ?? null))) {
                $findings[] = $this->finding($dateField, 'invalid_'.$dateField);
            }
        }

        $recheckOn = $this->stringValue($record['recheck_on'] ?? null);

        if ($this->isDate($recheckOn) && $recheckOn < $asOf->format('Y-m-d')) {
            $findings[] = $this->finding('recheck_on', 'stale_privacy_decision');
        }

        $configuration = $record['production_configuration'] ?? null;

        if (is_array($configuration) && ! array_is_list($configuration)) {
            if ($this->stringValue($record['production_configuration_hash'] ?? null) !== self::productionConfigurationHash($configuration)) {
                $findings[] = $this->finding('production_configuration_hash', 'production_configuration_hash_mismatch');
            }

            $measurementStatus = $this->stringValue($configuration['measurement_status'] ?? null);

            if ($measurementStatus === 'not_measured') {
                $findings[] = $this->finding('production_configuration', 'production_analytics_not_measured');

                if ($this->stringValue($configuration['measurement_owner'] ?? null) === null) {
                    $findings[] = $this->finding('production_configuration', 'missing_measurement_owner');
                }

                if ($this->stringValue($configuration['not_measured_reason'] ?? null) === null) {
                    $findings[] = $this->finding('production_configuration', 'missing_not_measured_reason');
                }
            }

            if ($this->stringValue($configuration['consent_state'] ?? null) === 'unknown') {
                $findings[] = $this->finding('production_configuration', 'unknown_production_consent_state');
            }

            if ($this->stringValue($configuration['source_revision'] ?? null) !== $inventoryRevision) {
                $findings[] = $this->finding('production_configuration', 'stale_production_configuration');
            }
        }

        foreach ($this->stringList($record['evidence_references'] ?? null) as $reference) {
            if (preg_match('/^[a-z][a-z0-9_-]*:[a-z0-9][a-z0-9._-]*$/D', $reference) !== 1) {
                $findings[] = $this->finding('evidence_references', 'invalid_privacy_evidence_reference');
            }
        }

        if ($this->hasSensitiveField($record)) {
            $findings[] = $this->finding('@record', 'sensitive_privacy_field');
        }

        return $this->sortFindings($findings);
    }

    /** @param array<string, mixed> $configuration */
    public static function productionConfigurationHash(array $configuration): string
    {
        return hash('sha256', json_encode(self::canonicalize($configuration), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));
    }

    private function readSharedSnapshot(string $path): string
    {
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('Privacy record is unavailable.');
        }

        try {
            if (! flock($handle, LOCK_SH)) {
                throw new RuntimeException('Privacy record could not be locked.');
            }

            $contents = stream_get_contents($handle);

            if ($contents === false) {
                throw new RuntimeException('Privacy record could not be read.');
            }

            return $contents;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }

    /** @return array<string, mixed> */
    private function decodeTaggedRecord(string $contents): array
    {
        if (substr_count($contents, self::BEGIN_MARKER) !== 1 || substr_count($contents, self::END_MARKER) !== 1) {
            throw new RuntimeException('Privacy record markers are invalid.');
        }

        $startPosition = strpos($contents, self::BEGIN_MARKER);
        $end = strpos($contents, self::END_MARKER);

        if ($startPosition === false || $end === false || $end <= $startPosition) {
            throw new RuntimeException('Privacy record markers are invalid.');
        }

        try {
            $decoded = json_decode(trim(substr($contents, $startPosition + strlen(self::BEGIN_MARKER), $end - ($startPosition + strlen(self::BEGIN_MARKER)))), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Privacy record JSON is malformed.', previous: $exception);
        }

        if (! is_array($decoded) || array_is_list($decoded)) {
            throw new RuntimeException('Privacy record must be a JSON object.');
        }

        return $decoded;
    }

    private function isBlank(mixed $value): bool
    {
        return $value === null || $value === '' || (is_array($value) && $value === []);
    }

    /** @return list<string> */
    private function stringList(mixed $value): array
    {
        if (! is_array($value) || ! array_is_list($value)) {
            return [];
        }

        return array_values(array_filter($value, fn (mixed $item): bool => is_string($item) && $item !== ''));
    }

    private function stringValue(mixed $value): ?string
    {
        return is_string($value) && $value !== '' ? $value : null;
    }

    private function isDate(?string $value): bool
    {
        if ($value === null) {
            return false;
        }

        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);

        return $date !== false && $date->format('Y-m-d') === $value;
    }

    /** @param array<string, mixed> $record */
    private function hasSensitiveField(array $record): bool
    {
        foreach ($record as $key => $value) {
            if (preg_match('/(?:patient|paciente|message_content|health_data|diagnosis|cpf|email|phone)/i', (string) $key) === 1) {
                return true;
            }

            if (is_array($value) && ! array_is_list($value) && $this->hasSensitiveField($value)) {
                return true;
            }
        }

        return false;
    }

    private static function canonicalize(mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        if (array_is_list($value)) {
            $normalized = array_map(self::canonicalize(...), $value);
            usort($normalized, static fn (mixed $left, mixed $right): int => json_encode($left, JSON_THROW_ON_ERROR) <=> json_encode($right, JSON_THROW_ON_ERROR));

            return $normalized;
        }

        ksort($value, SORT_STRING);

        foreach ($value as $key => $item) {
            $value[$key] = self::canonicalize($item);
        }

        return $value;
    }

    /** @return array{stable_id: string, route: string, context: string, reason: string} */
    private function finding(string $context, string $reason): array
    {
        return ['stable_id' => '@privacy', 'route' => '@production', 'context' => $context, 'reason' => $reason];
    }

    /** @param list<array{stable_id: string, route: string, context: string, reason: string}> $findings */
    private function sortFindings(array $findings): array
    {
        usort($findings, static fn (array $left, array $right): int => [$left['context'], $left['reason']] <=> [$right['context'], $right['reason']]);

        return array_values(array_unique($findings, SORT_REGULAR));
    }
}
