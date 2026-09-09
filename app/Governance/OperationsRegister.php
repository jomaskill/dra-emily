<?php

namespace App\Governance;

use DateTimeImmutable;
use JsonException;
use RuntimeException;

class OperationsRegister
{
    /** @var list<string> */
    public const REQUIRED_DOMAINS = [
        'identity',
        'address',
        'contact',
        'hours',
        'directions',
        'accessibility',
        'whatsapp_operations',
        'escalation_response',
        'follow_up',
    ];

    private const BEGIN_MARKER = '<!-- governance-operations:start -->';

    private const END_MARKER = '<!-- governance-operations:end -->';

    /** @var list<string> */
    private const STATUSES = ['pending', 'approved', 'rejected', 'quarantined', 'expired'];

    /** @return list<array{stable_id: string, domain: string, reason: string}> */
    public function validateFile(string $registerPath, string $inventoryRevision, ?DateTimeImmutable $asOf = null): array
    {
        if (! is_file($registerPath) || is_link($registerPath)) {
            return [$this->finding('@operations', '@register', 'missing_operations_register')];
        }

        try {
            $register = $this->decodeTaggedRegister($this->readSharedSnapshot($registerPath));
        } catch (RuntimeException) {
            return [$this->finding('@operations', '@register', 'invalid_operations_register')];
        }

        return $this->validate($register, $inventoryRevision, $asOf);
    }

    /**
     * @param  array<string, mixed>  $register
     * @return list<array{stable_id: string, domain: string, reason: string}>
     */
    public function validate(array $register, string $inventoryRevision, ?DateTimeImmutable $asOf = null): array
    {
        $asOf ??= new DateTimeImmutable('today');
        $findings = [];

        if ($this->stringValue($register['inventory_revision'] ?? null) !== $inventoryRevision) {
            $findings[] = $this->finding('@operations', '@inventory', 'stale_inventory_revision');
        }

        $records = $this->objectList($register['records'] ?? []);
        $byDomain = [];
        $byIdentity = [];

        foreach ($records as $record) {
            $domain = $this->stringValue($record['domain'] ?? null) ?? '@invalid-domain';
            $stableId = $this->stringValue($record['stable_id'] ?? null) ?? '@invalid-operations';
            $byDomain[$domain][] = $record;
            $byIdentity[$stableId."\0".$domain][] = $record;
            array_push($findings, ...$this->validateRecord($record, $asOf));
        }

        foreach (self::REQUIRED_DOMAINS as $domain) {
            if (! isset($byDomain[$domain])) {
                $findings[] = $this->finding('operations.'.$domain, $domain, 'missing_domain');
            }
        }

        foreach ($byDomain as $domain => $domainRecords) {
            if (count($domainRecords) < 2) {
                continue;
            }

            usort($domainRecords, fn (array $left, array $right): int => (string) ($left['stable_id'] ?? '') <=> (string) ($right['stable_id'] ?? ''));
            $stableId = $this->stringValue($domainRecords[0]['stable_id'] ?? null) ?? '@invalid-operations';
            $findings[] = $this->finding($stableId, $domain, 'duplicate_domain');

            if (count(array_unique(array_map(fn (array $record): string => $this->scalarFingerprint($record['observed_value'] ?? null), $domainRecords))) > 1) {
                $findings[] = $this->finding($stableId, $domain, 'conflicting_observation');
            }

            if (count(array_unique(array_map(fn (array $record): string => $this->scalarFingerprint($record['status'] ?? null), $domainRecords))) > 1) {
                $findings[] = $this->finding($stableId, $domain, 'conflicting_operations_status');
            }
        }

        foreach ($byIdentity as $identityRecords) {
            if (count($identityRecords) > 1) {
                $findings[] = $this->finding(
                    $this->stringValue($identityRecords[0]['stable_id'] ?? null) ?? '@invalid-operations',
                    $this->stringValue($identityRecords[0]['domain'] ?? null) ?? '@invalid-domain',
                    'duplicate_operations_identity',
                );
            }
        }

        return $this->sortFindings($findings);
    }

    /** @param array<string, mixed> $record
     * @return list<array{stable_id: string, domain: string, reason: string}>
     */
    private function validateRecord(array $record, DateTimeImmutable $asOf): array
    {
        $stableId = $this->stringValue($record['stable_id'] ?? null) ?? '@invalid-operations';
        $domain = $this->stringValue($record['domain'] ?? null) ?? '@invalid-domain';
        $findings = [];
        $finding = fn (string $reason): array => $this->finding($stableId, $domain, $reason);
        $configured = $this->stringValue($record['configured_value'] ?? null);
        $observed = $this->stringValue($record['observed_value'] ?? null);

        if ($configured === null) {
            $findings[] = $finding('missing_configured_value');
        }

        if ($observed === null) {
            $findings[] = $finding('missing_observed_value');
        } elseif ($configured !== null && ! hash_equals(hash('sha256', $configured), hash('sha256', $observed))) {
            $findings[] = $finding('configured_observed_mismatch');
        }

        if ($this->stringValue($record['verifier'] ?? null) === null) {
            $findings[] = $finding('missing_verifier');
        }

        $verifiedOn = $this->stringValue($record['verified_on'] ?? null);

        if (! $this->isDate($verifiedOn)) {
            $findings[] = $finding('invalid_verified_on');
        }

        if (! $this->isOpaqueReference($this->stringValue($record['evidence_reference'] ?? null))) {
            $findings[] = $finding('missing_operations_evidence');
        }

        if ($this->objectList($record['contexts'] ?? []) === []) {
            $findings[] = $finding('missing_context');
        }

        $status = $this->stringValue($record['status'] ?? null);

        if (! in_array($status, self::STATUSES, true)) {
            $findings[] = $finding('invalid_operations_status');
        } elseif ($status !== 'approved') {
            $findings[] = $finding($status.'_operations');
        }

        $recheckOn = $this->stringValue($record['recheck_on'] ?? null);

        if (! $this->isDate($recheckOn) || $recheckOn < $asOf->format('Y-m-d')) {
            $findings[] = $finding('stale_operations_evidence');
        }

        return $findings;
    }

    private function readSharedSnapshot(string $path): string
    {
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('Operations register is unavailable.');
        }

        try {
            if (! flock($handle, LOCK_SH)) {
                throw new RuntimeException('Operations register could not be locked.');
            }

            $contents = stream_get_contents($handle);

            if ($contents === false) {
                throw new RuntimeException('Operations register could not be read.');
            }

            return $contents;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }

    /** @return array<string, mixed> */
    private function decodeTaggedRegister(string $contents): array
    {
        if (substr_count($contents, self::BEGIN_MARKER) !== 1 || substr_count($contents, self::END_MARKER) !== 1) {
            throw new RuntimeException('Operations register markers are invalid.');
        }

        $startPosition = strpos($contents, self::BEGIN_MARKER);
        $end = strpos($contents, self::END_MARKER);

        if ($startPosition === false || $end === false || $end <= $startPosition) {
            throw new RuntimeException('Operations register markers are invalid.');
        }

        try {
            $decoded = json_decode(trim(substr($contents, $startPosition + strlen(self::BEGIN_MARKER), $end - ($startPosition + strlen(self::BEGIN_MARKER)))), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Operations register JSON is malformed.', previous: $exception);
        }

        if (! is_array($decoded) || array_is_list($decoded)) {
            throw new RuntimeException('Operations register must be a JSON object.');
        }

        return $decoded;
    }

    /** @return list<array<string, mixed>> */
    private function objectList(mixed $value): array
    {
        if (! is_array($value) || ! array_is_list($value)) {
            return [];
        }

        return array_values(array_filter($value, fn (mixed $item): bool => is_array($item) && ! array_is_list($item)));
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

    private function isOpaqueReference(?string $value): bool
    {
        return $value !== null && preg_match('/^[a-z][a-z0-9_-]*:[a-z0-9][a-z0-9._-]*$/D', $value) === 1;
    }

    private function scalarFingerprint(mixed $value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }

    /** @return array{stable_id: string, domain: string, reason: string} */
    private function finding(string $stableId, string $domain, string $reason): array
    {
        return ['stable_id' => $stableId, 'domain' => $domain, 'reason' => $reason];
    }

    /** @param list<array{stable_id: string, domain: string, reason: string}> $findings */
    private function sortFindings(array $findings): array
    {
        $domainOrder = array_flip(self::REQUIRED_DOMAINS);
        usort($findings, static fn (array $left, array $right): int => [
            $domainOrder[$left['domain']] ?? PHP_INT_MAX,
            $left['stable_id'],
            $left['reason'],
        ] <=> [
            $domainOrder[$right['domain']] ?? PHP_INT_MAX,
            $right['stable_id'],
            $right['reason'],
        ]);

        return array_values(array_unique($findings, SORT_REGULAR));
    }
}
