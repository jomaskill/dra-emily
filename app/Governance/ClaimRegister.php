<?php

namespace App\Governance;

use DateTimeImmutable;
use JsonException;
use RuntimeException;

class ClaimRegister
{
    /** @var list<string> */
    public const CANDIDATE_CATEGORIES = [
        'configured_assertion',
        'json_ld',
        'metadata',
        'visible_text',
    ];

    /**
     * Structurally identified testimonial quote/attribution observations. Their
     * exact text is governed by MediaRegister and must not be copied here.
     *
     * @var list<string>
     */
    public const MEDIA_GOVERNED_ITEM_IDS = [
        'publication.095374ad9d753afb4d1e6b58',
        'publication.28e09650f8f38f6124f80186',
        'publication.67843e865a51caa33caa78fa',
        'publication.8766fc353fe9868c7782ef70',
        'publication.aacdbf72dd54889b05baa0fb',
        'publication.ffe0e471ad180475c431ecd0',
    ];

    private const BEGIN_MARKER = '<!-- governance-claims:start -->';

    private const END_MARKER = '<!-- governance-claims:end -->';

    /** @var list<string> */
    private const DECISIONS = ['pending', 'approved', 'rejected', 'quarantined', 'expired'];

    /**
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    public function validateFiles(string $inventoryPath, string $registerPath, ?DateTimeImmutable $asOf = null): array
    {
        if (! is_file($registerPath) || is_link($registerPath)) {
            return [$this->finding('@claims', '@register', '@register', 'missing_claim_register')];
        }

        try {
            $inventory = $this->decodeJson($this->readSharedSnapshot($inventoryPath));
            $register = $this->decodeTaggedRegister($this->readSharedSnapshot($registerPath));
        } catch (RuntimeException) {
            return [$this->finding('@claims', '@register', '@register', 'invalid_claim_register')];
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
        $findings = [];
        $revision = $this->stringValue($inventory['run']['revision'] ?? null);

        if ($revision === null || $this->stringValue($register['inventory_revision'] ?? null) !== $revision) {
            $findings[] = $this->finding('@claims', '@inventory', '@inventory', 'stale_inventory_revision');
        }

        $excludedIds = $this->stringList($register['excluded_media_item_ids'] ?? []);

        if ($excludedIds !== self::MEDIA_GOVERNED_ITEM_IDS) {
            $findings[] = $this->finding('@claims', '@inventory', '@inventory', 'invalid_media_governance_bindings');
        }

        $candidates = $this->candidateItems($inventory, array_values(array_intersect($excludedIds, self::MEDIA_GOVERNED_ITEM_IDS)));
        $records = $this->objectList($register['records'] ?? []);

        if ($candidates === []) {
            if (! $this->validNoClaimDeclaration($register['no_claim_candidates'] ?? null, $revision)) {
                $findings[] = $this->finding('@no-claims', '@inventory', '@inventory', 'missing_no_claim_declaration');
            }

            return $this->sortFindings($findings);
        }

        $recordsByStableId = [];

        foreach ($records as $record) {
            $stableId = $this->stringValue($record['stable_id'] ?? null) ?? '@invalid-claim';
            $recordsByStableId[$stableId][] = $record;
        }

        foreach ($candidates as $candidate) {
            $sameIdRecords = $recordsByStableId[$candidate['id']] ?? [];

            if ($sameIdRecords === []) {
                $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'unregistered_claim');

                continue;
            }

            $exactContextRecords = array_values(array_filter(
                $sameIdRecords,
                fn (array $record): bool => $this->stringValue($record['route'] ?? null) === $candidate['route']
                    && $this->stringValue($record['context'] ?? null) === $candidate['context']
                    && $this->stringValue($record['locale'] ?? null) === $candidate['locale'],
            ));

            if ($exactContextRecords === []) {
                $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'context_mismatch');

                continue;
            }

            foreach ($exactContextRecords as $record) {
                if ($this->stringValue($record['content_hash'] ?? null) !== $candidate['content_hash']
                    || $this->stringValue($record['exact_text'] ?? null) !== $candidate['content']) {
                    $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'stale_hash');
                }

                array_push($findings, ...$this->validateRecord($record, $candidate, $revision, $asOf));
            }
        }

        array_push($findings, ...$this->duplicateFindings($recordsByStableId));

        return $this->sortFindings($findings);
    }

    /**
     * @param  array<string, mixed>  $inventory
     * @param  list<string>  $excludedIds
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, context: string, visibility: string, source: string}>
     */
    public function candidateItems(array $inventory, array $excludedIds = []): array
    {
        $excludedLookup = array_fill_keys($excludedIds, true);
        $candidates = [];

        foreach ($this->objectList($inventory['items'] ?? []) as $item) {
            $id = $this->stringValue($item['id'] ?? null);
            $category = $this->stringValue($item['category'] ?? null);

            if ($id === null || isset($excludedLookup[$id]) || ! in_array($category, self::CANDIDATE_CATEGORIES, true)) {
                continue;
            }

            $candidate = [
                'id' => $id,
                'category' => $category,
                'content' => $this->stringValue($item['content'] ?? null),
                'content_hash' => $this->stringValue($item['content_hash'] ?? null),
                'locale' => $this->stringValue($item['locale'] ?? null),
                'route' => $this->stringValue($item['route'] ?? null),
                'context' => $this->stringValue($item['context'] ?? null),
                'visibility' => $this->stringValue($item['visibility'] ?? null),
                'source' => $this->stringValue($item['source'] ?? null),
            ];

            if (in_array(null, $candidate, true)) {
                continue;
            }

            /** @var array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, context: string, visibility: string, source: string} $candidate */
            $candidates[] = $candidate;
        }

        usort($candidates, static fn (array $left, array $right): int => [
            $left['id'], $left['route'], $left['context'], $left['content_hash'],
        ] <=> [
            $right['id'], $right['route'], $right['context'], $right['content_hash'],
        ]);

        return $candidates;
    }

    /**
     * @param  array<string, mixed>  $record
     * @param  array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, context: string, visibility: string, source: string}  $candidate
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    private function validateRecord(array $record, array $candidate, ?string $revision, DateTimeImmutable $asOf): array
    {
        $findings = [];
        $requiredFields = [
            'source_locator' => 'missing_source',
            'content_owner' => 'missing_owner',
            'last_reviewed_on' => 'missing_last_reviewed_on',
            'dra_emily_evidence_reference' => 'missing_dra_emily_evidence',
            'reviewer' => 'missing_reviewer',
            'decision_on' => 'missing_decision_on',
        ];

        foreach ($requiredFields as $field => $reason) {
            if ($this->stringValue($record[$field] ?? null) === null) {
                $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], $reason);
            }
        }

        $source = $this->stringValue($record['source_locator'] ?? null);

        if ($source !== null && (! $this->isRepositoryRelativePath($source) || $source !== $candidate['source'])) {
            $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'invalid_source');
        }

        $evidenceReference = $this->stringValue($record['dra_emily_evidence_reference'] ?? null);

        if ($evidenceReference !== null && ! $this->isOpaqueReference($evidenceReference)) {
            $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'invalid_evidence_reference');
        }

        foreach (['last_reviewed_on', 'decision_on', 'review_expires_on'] as $dateField) {
            $date = $this->stringValue($record[$dateField] ?? null);

            if ($date !== null && ! $this->isDate($date)) {
                $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'invalid_date');
            }
        }

        $classification = $this->stringValue($record['classification'] ?? null);

        if ($classification === 'not_clinical_claim') {
            if ($this->stringValue($record['classification_reason'] ?? null) === null
                || $this->stringValue($record['reviewer'] ?? null) === null
                || $this->stringValue($record['decision_on'] ?? null) === null) {
                $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'invalid_non_claim_classification');
            }

            return $findings;
        }

        if ($classification !== 'clinical_claim') {
            $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'invalid_claim_classification');
        }

        $decision = $this->stringValue($record['decision'] ?? null);

        if (! in_array($decision, self::DECISIONS, true)) {
            $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'invalid_claim_decision');
        } elseif ($decision !== 'approved') {
            $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], $decision.'_claim');
        }

        $expiresOn = $this->stringValue($record['review_expires_on'] ?? null);

        if ($expiresOn === null) {
            $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'missing_review_expiry');
        } elseif ($this->isDate($expiresOn) && $expiresOn < $asOf->format('Y-m-d')) {
            $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'expired_claim');
        }

        if ($this->stringValue($record['disposition_inputs']['inventory_revision'] ?? null) !== $revision
            || $this->stringValue($record['disposition_inputs']['inventory_category'] ?? null) !== $candidate['category']
            || $this->stringValue($record['disposition_inputs']['visibility'] ?? null) !== $candidate['visibility']) {
            $findings[] = $this->finding($candidate['id'], $candidate['route'], $candidate['context'], 'invalid_disposition_inputs');
        }

        return $findings;
    }

    /**
     * @param  array<string, list<array<string, mixed>>>  $recordsByStableId
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    private function duplicateFindings(array $recordsByStableId): array
    {
        $findings = [];

        foreach ($recordsByStableId as $stableId => $sameIdRecords) {
            $identities = [];

            foreach ($sameIdRecords as $record) {
                $route = $this->stringValue($record['route'] ?? null) ?? '@invalid';
                $context = $this->stringValue($record['context'] ?? null) ?? '@invalid';
                $identity = implode("\0", [
                    $stableId,
                    $this->stringValue($record['content_hash'] ?? null) ?? '',
                    $this->stringValue($record['locale'] ?? null) ?? '',
                    $route,
                    $context,
                ]);
                $identities[$identity][] = $record;
            }

            foreach ($identities as $duplicates) {
                if (count($duplicates) < 2) {
                    continue;
                }

                $route = $this->stringValue($duplicates[0]['route'] ?? null) ?? '@invalid';
                $context = $this->stringValue($duplicates[0]['context'] ?? null) ?? '@invalid';
                $findings[] = $this->finding($stableId, $route, $context, 'duplicate_claim_identity');
                $decisions = array_unique(array_map(
                    fn (array $record): string => $this->stringValue($record['decision'] ?? null) ?? '@missing',
                    $duplicates,
                ));

                if (count($decisions) > 1) {
                    $findings[] = $this->finding($stableId, $route, $context, 'conflicting_claim_decision');
                }
            }
        }

        return $findings;
    }

    private function validNoClaimDeclaration(mixed $declaration, ?string $revision): bool
    {
        return is_array($declaration)
            && ! array_is_list($declaration)
            && $this->stringValue($declaration['inventory_revision'] ?? null) === $revision
            && $this->stringValue($declaration['reviewer'] ?? null) !== null
            && $this->isDate($this->stringValue($declaration['decision_on'] ?? null))
            && $this->stringValue($declaration['reason'] ?? null) !== null;
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
            throw new RuntimeException('Claim register must contain one tagged payload.');
        }

        $begin = strpos($contents, self::BEGIN_MARKER);
        $end = strpos($contents, self::END_MARKER);

        if ($begin === false || $end === false || $end <= $begin) {
            throw new RuntimeException('Claim register markers are invalid.');
        }

        return $this->decodeJson(trim(substr($contents, $begin + strlen(self::BEGIN_MARKER), $end - $begin - strlen(self::BEGIN_MARKER))));
    }

    private function readSharedSnapshot(string $path): string
    {
        if (! is_file($path) || is_link($path)) {
            throw new RuntimeException('Governance input is unavailable.');
        }

        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('Governance input is unavailable.');
        }

        try {
            if (! flock($handle, LOCK_SH)) {
                throw new RuntimeException('Governance input could not be locked.');
            }

            $contents = stream_get_contents($handle);

            if ($contents === false) {
                throw new RuntimeException('Governance input could not be read.');
            }

            return $contents;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }

    private function isRepositoryRelativePath(string $path): bool
    {
        return ! str_starts_with($path, '/')
            && ! str_contains($path, '\\')
            && ! str_contains('/'.$path.'/', '/../')
            && preg_match('/^[A-Za-z0-9._\/-]+$/D', $path) === 1;
    }

    private function isOpaqueReference(string $reference): bool
    {
        return preg_match('/^[a-z][a-z0-9_-]{1,31}:[A-Za-z0-9][A-Za-z0-9._-]{2,127}$/D', $reference) === 1;
    }

    private function isDate(?string $date): bool
    {
        if ($date === null || preg_match('/^\d{4}-\d{2}-\d{2}$/D', $date) !== 1) {
            return false;
        }

        $parsed = DateTimeImmutable::createFromFormat('!Y-m-d', $date);

        return $parsed !== false && $parsed->format('Y-m-d') === $date;
    }

    private function stringValue(mixed $value): ?string
    {
        return is_string($value) && $value !== '' ? $value : null;
    }

    /** @return list<string> */
    private function stringList(mixed $value): array
    {
        if (! is_array($value) || ! array_is_list($value)) {
            return [];
        }

        return array_values(array_filter($value, is_string(...)));
    }

    /** @return list<array<string, mixed>> */
    private function objectList(mixed $value): array
    {
        if (! is_array($value) || ! array_is_list($value)) {
            return [];
        }

        return array_values(array_filter($value, static fn (mixed $item): bool => is_array($item) && ! array_is_list($item)));
    }

    /** @return array{stable_id: string, route: string, context: string, reason: string} */
    private function finding(string $stableId, string $route, string $context, string $reason): array
    {
        return [
            'stable_id' => $stableId,
            'route' => $route,
            'context' => $context,
            'reason' => $reason,
        ];
    }

    /**
     * @param  list<array{stable_id: string, route: string, context: string, reason: string}>  $findings
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    private function sortFindings(array $findings): array
    {
        $findings = array_values(array_unique($findings, SORT_REGULAR));
        usort($findings, static fn (array $left, array $right): int => [
            $left['stable_id'], $left['route'], $left['context'], $left['reason'],
        ] <=> [
            $right['stable_id'], $right['route'], $right['context'], $right['reason'],
        ]);

        return $findings;
    }
}
