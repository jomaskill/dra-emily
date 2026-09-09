<?php

namespace App\Governance;

use DateTimeImmutable;
use JsonException;
use RuntimeException;

class ProfessionalWordingRegister
{
    private const BEGIN_MARKER = '<!-- governance-professional:start -->';

    private const END_MARKER = '<!-- governance-professional:end -->';

    /** @var list<string> */
    private const DECISIONS = ['pending', 'approved', 'rejected', 'quarantined', 'expired'];

    /** @return list<array{stable_id: string, route: string, context: string, reason: string}> */
    public function validateFiles(string $inventoryPath, string $registerPath, ?DateTimeImmutable $asOf = null): array
    {
        if (! is_file($registerPath) || is_link($registerPath)) {
            return [$this->finding('@professional', '@register', '@register', 'missing_professional_register')];
        }

        try {
            $inventory = $this->decodeJson($this->readSharedSnapshot($inventoryPath));
            $register = $this->decodeTaggedRegister($this->readSharedSnapshot($registerPath));
        } catch (RuntimeException) {
            return [$this->finding('@professional', '@register', '@register', 'invalid_professional_register')];
        }

        return $this->validate($inventory, $register, $asOf);
    }

    /**
     * @param  array<string, mixed>  $inventory
     * @param  array<string, mixed>  $register
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    public function validate(array $inventory, array $register, ?DateTimeImmutable $asOf = null): array
    {
        $asOf ??= new DateTimeImmutable('today');
        $revision = $this->stringValue($inventory['run']['revision'] ?? null);
        $findings = [];

        if ($revision === null || $this->stringValue($register['inventory_revision'] ?? null) !== $revision) {
            $findings[] = $this->finding('@professional', '@inventory', '@inventory', 'stale_inventory_revision');
        }

        $candidates = $this->candidateItems($inventory);

        if ($candidates === []) {
            if ($this->stringValue($register['classification_completed_by'] ?? null) === null
                || ! $this->isDate($this->stringValue($register['classification_completed_on'] ?? null))) {
                $findings[] = $this->finding('@no-professional-wording', '@inventory', '@inventory', 'missing_professional_classification_declaration');
            }

            return $this->sortFindings($findings);
        }

        $registerRecords = $this->objectList($register['records'] ?? []);
        $recordsByIdentity = [];

        foreach ($registerRecords as $record) {
            $recordsByIdentity[$this->recordIdentity($record)][] = $record;
        }

        foreach ($candidates as $candidate) {
            $records = $recordsByIdentity[$this->candidateIdentity($candidate)] ?? [];

            if ($records === []) {
                $sameId = array_filter($registerRecords, fn (array $record): bool => $this->stringValue($record['stable_id'] ?? null) === $candidate['id']);
                $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], $sameId === [] ? 'unregistered_professional_wording' : 'context_mismatch');

                continue;
            }

            foreach ($records as $record) {
                array_push($findings, ...$this->validateRecord($record, $candidate, $revision, $asOf));
            }

            if (count($records) > 1) {
                $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'duplicate_professional_identity');

                if (count(array_unique(array_map(fn (array $record): string => $this->scalarFingerprint($record['scope_sensitive'] ?? null), $records))) > 1) {
                    $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'conflicting_scope_classification');
                }

                if (count(array_unique(array_map(fn (array $record): string => $this->scalarFingerprint($record['decision'] ?? null), $records))) > 1) {
                    $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'conflicting_professional_decision');
                }
            }
        }

        return $this->sortFindings($findings);
    }

    /**
     * @param  array<string, mixed>  $inventory
     * @return list<array{id: string, content: string, content_hash: string, locale: string, route: string, context: string, source: string}>
     */
    public function candidateItems(array $inventory): array
    {
        $candidates = [];

        foreach ($this->objectList($inventory['items'] ?? []) as $item) {
            $category = $this->stringValue($item['category'] ?? null);
            $content = $this->stringValue($item['content'] ?? null);

            if (! in_array($category, ['configured_assertion', 'json_ld', 'metadata', 'visible_text'], true)
                || $content === null
                || preg_match('/(?:Dra\.?\s+Emily\s+Beatriz|CRO[\s-]*MG|Cirurgiã[\s-]*Dentista|Especialista\s+em\s+Harmonização\s+Orofacial|Harmonização\s+Orofacial|anos?\s+de\s+experiência)/iu', $content) !== 1) {
                continue;
            }

            $candidate = [
                'id' => $this->stringValue($item['id'] ?? null),
                'content' => $content,
                'content_hash' => $this->stringValue($item['content_hash'] ?? null),
                'locale' => $this->stringValue($item['locale'] ?? null),
                'route' => $this->stringValue($item['route'] ?? null),
                'context' => $this->stringValue($item['context'] ?? null),
                'source' => $this->stringValue($item['source'] ?? null),
            ];

            if (! in_array(null, $candidate, true)) {
                /** @var array{id: string, content: string, content_hash: string, locale: string, route: string, context: string, source: string} $candidate */
                $candidates[] = $candidate;
            }
        }

        usort($candidates, fn (array $left, array $right): int => $this->candidateIdentity($left) <=> $this->candidateIdentity($right));

        return $candidates;
    }

    /**
     * @param  array<string, mixed>  $record
     * @param  array{id: string, content: string, content_hash: string, locale: string, route: string, context: string, source: string}  $candidate
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    private function validateRecord(array $record, array $candidate, ?string $revision, DateTimeImmutable $asOf): array
    {
        $findings = [];
        $finding = fn (string $reason): array => $this->finding($candidate['id'], $candidate['route'], $candidate['context'], $reason);

        if ($this->stringValue($record['exact_wording'] ?? null) !== $candidate['content'] || $this->stringValue($record['content_hash'] ?? null) !== $candidate['content_hash']) {
            $findings[] = $finding('stale_professional_hash');
        }

        if (! is_bool($record['scope_sensitive'] ?? null)) {
            $findings[] = $finding('missing_scope_classification');
        }

        if ($this->stringValue($record['classification_reviewer'] ?? null) === null) {
            $findings[] = $finding('missing_classification_reviewer');
        }

        if (! $this->isOpaqueReference($this->stringValue($record['current_registration_evidence_reference'] ?? null))) {
            $findings[] = $finding('missing_registration_evidence');
        }

        $scopeSensitive = ($record['scope_sensitive'] ?? null) === true;

        if ($scopeSensitive && ($this->stringValue($record['external_reviewer_role'] ?? null) === null || $this->stringValue($record['external_reviewer_name'] ?? null) === null)) {
            $findings[] = $finding('missing_external_reviewer');
        }

        if ($scopeSensitive && ! $this->isDate($this->stringValue($record['reviewed_on'] ?? null))) {
            $findings[] = $finding('missing_external_review_date');
        }

        if ($scopeSensitive && ! $this->isOpaqueReference($this->stringValue($record['decision_reference'] ?? null))) {
            $findings[] = $finding('missing_external_decision_reference');
        }

        $decision = $this->stringValue($record['decision'] ?? null);

        if (! in_array($decision, self::DECISIONS, true)) {
            $findings[] = $finding('invalid_professional_decision');
        } elseif ($decision !== 'approved') {
            $findings[] = $finding($decision.'_professional_wording');
        }

        if ($this->stringValue($record['applicable_revision'] ?? null) !== $revision) {
            $findings[] = $finding('stale_professional_revision');
        }

        $applicableUntil = $this->stringValue($record['applicable_until'] ?? null);

        if (! $this->isDate($applicableUntil) || $applicableUntil < $asOf->format('Y-m-d')) {
            $findings[] = $finding('stale_professional_decision');
        }

        if (! $this->isDate($this->stringValue($record['recheck_on'] ?? null))) {
            $findings[] = $finding('missing_professional_recheck');
        }

        return $findings;
    }

    private function readSharedSnapshot(string $path): string
    {
        if (! is_file($path) || is_link($path)) {
            throw new RuntimeException('Governance source is unavailable.');
        }

        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('Governance source is unavailable.');
        }

        try {
            if (! flock($handle, LOCK_SH)) {
                throw new RuntimeException('Governance source could not be locked.');
            }

            $contents = stream_get_contents($handle);

            if ($contents === false) {
                throw new RuntimeException('Governance source could not be read.');
            }

            return $contents;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }

    /** @return array<string, mixed> */
    private function decodeJson(string $contents): array
    {
        try {
            $decoded = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Governance JSON is malformed.', previous: $exception);
        }

        if (! is_array($decoded) || array_is_list($decoded)) {
            throw new RuntimeException('Governance JSON must be an object.');
        }

        return $decoded;
    }

    /** @return array<string, mixed> */
    private function decodeTaggedRegister(string $contents): array
    {
        if (substr_count($contents, self::BEGIN_MARKER) !== 1 || substr_count($contents, self::END_MARKER) !== 1) {
            throw new RuntimeException('Professional register markers are invalid.');
        }

        $startPosition = strpos($contents, self::BEGIN_MARKER);
        $end = strpos($contents, self::END_MARKER);

        if ($startPosition === false || $end === false || $end <= $startPosition) {
            throw new RuntimeException('Professional register markers are invalid.');
        }

        $start = $startPosition + strlen(self::BEGIN_MARKER);

        return $this->decodeJson(trim(substr($contents, $start, $end - $start)));
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

    /** @param array<string, mixed> $record */
    private function recordIdentity(array $record): string
    {
        return implode("\0", array_map(fn (string $field): string => (string) ($record[$field] ?? ''), ['stable_id', 'route', 'context', 'locale']));
    }

    /** @param array{id: string, content: string, content_hash: string, locale: string, route: string, context: string, source: string} $candidate */
    private function candidateIdentity(array $candidate): string
    {
        return implode("\0", [$candidate['id'], $candidate['route'], $candidate['context'], $candidate['locale']]);
    }

    private function scalarFingerprint(mixed $value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }

    /** @return array{stable_id: string, route: string, context: string, reason: string} */
    private function finding(string $stableId, string $route, string $context, string $reason): array
    {
        return ['stable_id' => $stableId, 'route' => $route, 'context' => $context, 'reason' => $reason];
    }

    /** @param list<array{stable_id: string, route: string, context: string, reason: string}> $findings */
    private function sortFindings(array $findings): array
    {
        usort($findings, static fn (array $left, array $right): int => [$left['stable_id'], $left['route'], $left['context'], $left['reason']] <=> [$right['stable_id'], $right['route'], $right['context'], $right['reason']]);

        return array_values(array_unique($findings, SORT_REGULAR));
    }
}
