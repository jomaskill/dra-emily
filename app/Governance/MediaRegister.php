<?php

namespace App\Governance;

use DateTimeImmutable;
use JsonException;
use RuntimeException;

class MediaRegister
{
    private const BEGIN_MARKER = '<!-- governance-media:start -->';

    private const END_MARKER = '<!-- governance-media:end -->';

    /** @var list<string> */
    private const CLASSIFICATIONS = ['patient', 'clinician_or_professional', 'stock_or_illustrative', 'unknown'];

    /** @var list<string> */
    private const DECISIONS = ['pending', 'approved', 'rejected', 'quarantined', 'expired'];

    /**
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    public function validateFiles(string $inventoryPath, string $registerPath, ?DateTimeImmutable $asOf = null): array
    {
        if (! is_file($registerPath) || is_link($registerPath)) {
            return [$this->finding('@media', '@register', '@register', 'missing_media_register')];
        }

        try {
            $inventory = $this->decodeJson($this->readSharedSnapshot($inventoryPath));
            $register = $this->decodeTaggedRegister($this->readSharedSnapshot($registerPath));
        } catch (RuntimeException) {
            return [$this->finding('@media', '@register', '@register', 'invalid_media_register')];
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
            $findings[] = $this->finding('@media', '@inventory', '@inventory', 'stale_inventory_revision');
        }

        $records = $this->objectList($register['records'] ?? []);
        $contextsByInventoryId = [];
        $testimonialAttributionLookup = array_fill_keys($this->stringList($register['testimonial_attribution_item_ids'] ?? []), true);
        $recordsByStableId = [];

        foreach ($records as $record) {
            $stableId = $this->stringValue($record['stable_id'] ?? null) ?? '@invalid-media';
            $recordsByStableId[$stableId] = true;

            foreach ($this->objectList($record['contexts'] ?? []) as $context) {
                $inventoryId = $this->stringValue($context['inventory_id'] ?? null);

                if ($inventoryId !== null) {
                    $contextsByInventoryId[$inventoryId][] = ['record' => $record, 'context' => $context];
                }
            }

            if ($this->containsSensitiveKey($record)) {
                $findings[] = $this->finding($stableId, $this->firstRoute($record), $this->firstContext($record), 'sensitive_media_field');
            }

            if ($this->containsSensitiveValue($record)) {
                $findings[] = $this->finding($stableId, $this->firstRoute($record), $this->firstContext($record), 'sensitive_media_value');
            }
        }

        foreach ($records as $record) {
            $derivativeOf = $this->stringValue($record['derivative_of'] ?? null);

            if ($derivativeOf !== null && ! isset($recordsByStableId[$derivativeOf])) {
                $findings[] = $this->finding(
                    $this->stringValue($record['stable_id'] ?? null) ?? '@invalid-media',
                    $this->firstRoute($record),
                    $this->firstContext($record),
                    'invalid_derivative_source',
                );
            }
        }

        foreach ($this->mediaItems($inventory, $register) as $item) {
            $matches = array_values(array_filter(
                $contextsByInventoryId[$item['id']] ?? [],
                fn (array $match): bool => $this->stringValue($match['context']['route'] ?? null) === $item['route']
                    && $this->stringValue($match['context']['context'] ?? null) === $item['context']
                    && $this->stringValue($match['context']['content_hash'] ?? null) === $item['content_hash'],
            ));

            if ($matches === []) {
                $findings[] = $this->finding($item['id'], $item['route'], $item['context'], 'unregistered_media');

                continue;
            }

            foreach ($matches as $match) {
                $record = $match['record'];
                $stableId = $this->stringValue($record['stable_id'] ?? null) ?? $item['id'];
                $expectedHash = $this->expectedContentHash($item);

                if ($item['category'] !== 'media'
                    && ! isset($testimonialAttributionLookup[$item['id']])
                    && $this->stringValue($record['content_hash'] ?? null) !== $expectedHash) {
                    $findings[] = $this->finding($stableId, $item['route'], $item['context'], 'stale_media_hash');
                }

                array_push($findings, ...$this->validateRecord($record, $item, $revision, $asOf));
            }
        }

        array_push($findings, ...$this->duplicateFindings($records));

        return $this->sortFindings($findings);
    }

    /**
     * @param  array<string, mixed>  $inventory
     * @param  array<string, mixed>  $register
     * @return list<array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, context: string, source: string}>
     */
    public function mediaItems(array $inventory, array $register): array
    {
        $testimonialIds = array_fill_keys([
            ...$this->stringList($register['testimonial_item_ids'] ?? []),
            ...$this->stringList($register['testimonial_attribution_item_ids'] ?? []),
        ], true);
        $items = [];

        foreach ($this->objectList($inventory['items'] ?? []) as $item) {
            $id = $this->stringValue($item['id'] ?? null);
            $category = $this->stringValue($item['category'] ?? null);

            if ($id === null || (! in_array($category, ['media', 'public_asset'], true) && ! isset($testimonialIds[$id]))) {
                continue;
            }

            $mediaItem = [
                'id' => $id,
                'category' => $category,
                'content' => $this->stringValue($item['content'] ?? null),
                'content_hash' => $this->stringValue($item['content_hash'] ?? null),
                'locale' => $this->stringValue($item['locale'] ?? null),
                'route' => $this->stringValue($item['route'] ?? null),
                'context' => $this->stringValue($item['context'] ?? null),
                'source' => $this->stringValue($item['source'] ?? null),
            ];

            if (in_array(null, $mediaItem, true)) {
                continue;
            }

            /** @var array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, context: string, source: string} $mediaItem */
            $items[] = $mediaItem;
        }

        usort($items, static fn (array $left, array $right): int => [
            $left['id'], $left['route'], $left['context'],
        ] <=> [
            $right['id'], $right['route'], $right['context'],
        ]);

        return $items;
    }

    /**
     * @param  array<string, mixed>  $record
     * @param  array{id: string, category: string, content: string, content_hash: string, locale: string, route: string, context: string, source: string}  $item
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    private function validateRecord(array $record, array $item, ?string $revision, DateTimeImmutable $asOf): array
    {
        $stableId = $this->stringValue($record['stable_id'] ?? null) ?? $item['id'];
        $route = $item['route'];
        $context = $item['context'];
        $findings = [];
        $classification = $this->stringValue($record['classification'] ?? null);

        if (! in_array($classification, self::CLASSIFICATIONS, true)) {
            $findings[] = $this->finding($stableId, $route, $context, 'invalid_media_classification');
        } elseif ($classification === 'unknown') {
            $findings[] = $this->finding($stableId, $route, $context, 'unknown_media_classification');
        }

        if ($classification === 'patient' || $classification === 'unknown') {
            foreach ([
                'provenance_reference' => 'missing_provenance_reference',
                'authorization_reference' => 'missing_authorization_reference',
                'responsible_professional' => 'missing_responsible_professional',
            ] as $field => $reason) {
                if ($this->stringValue($record[$field] ?? null) === null) {
                    $findings[] = $this->finding($stableId, $route, $context, $reason);
                }
            }
        }

        foreach ([
            'provenance_reference' => 'invalid_provenance_reference',
            'authorization_reference' => 'invalid_authorization_reference',
        ] as $field => $reason) {
            $reference = $this->stringValue($record[$field] ?? null);

            if ($reference !== null && ! $this->isOpaqueReference($reference)) {
                $findings[] = $this->finding($stableId, $route, $context, $reason);
            }
        }

        $path = $this->stringValue($record['path'] ?? null);

        if ($path !== null && ! $this->isAllowedMediaPath($path)) {
            $findings[] = $this->finding($stableId, $route, $context, 'invalid_media_path');
        }

        if ($item['category'] === 'public_asset' && $path !== $item['source']) {
            $findings[] = $this->finding($stableId, $route, $context, 'media_path_mismatch');
        }

        if ($path !== null && preg_match('/-\d+w\.[A-Za-z0-9]+$/D', $path) === 1
            && $this->stringValue($record['derivative_of'] ?? null) === null) {
            $findings[] = $this->finding($stableId, $route, $context, 'missing_derivative_source');
        }

        $decision = $this->stringValue($record['decision'] ?? null);

        if (! in_array($decision, self::DECISIONS, true)) {
            $findings[] = $this->finding($stableId, $route, $context, 'invalid_media_decision');
        } elseif ($decision !== 'approved') {
            $findings[] = $this->finding($stableId, $route, $context, $decision.'_media');
        }

        foreach (['decision_on', 'decision_expires_on', 'recheck_on'] as $dateField) {
            $date = $this->stringValue($record[$dateField] ?? null);

            if ($date !== null && ! $this->isDate($date)) {
                $findings[] = $this->finding($stableId, $route, $context, 'invalid_media_date');
            }
        }

        if ($this->stringValue($record['reviewer'] ?? null) === null) {
            $findings[] = $this->finding($stableId, $route, $context, 'missing_media_reviewer');
        }

        if ($this->stringValue($record['decision_on'] ?? null) === null) {
            $findings[] = $this->finding($stableId, $route, $context, 'missing_media_decision_date');
        }

        $expiresOn = $this->stringValue($record['decision_expires_on'] ?? null);

        if ($expiresOn === null) {
            $findings[] = $this->finding($stableId, $route, $context, 'missing_media_expiry');
        } elseif ($this->isDate($expiresOn) && $expiresOn < $asOf->format('Y-m-d')) {
            $findings[] = $this->finding($stableId, $route, $context, 'expired_media');
        }

        if ($this->stringValue($record['disposition_inputs']['inventory_revision'] ?? null) !== $revision) {
            $findings[] = $this->finding($stableId, $route, $context, 'invalid_media_disposition_inputs');
        }

        return $findings;
    }

    /**
     * @param  list<array<string, mixed>>  $records
     * @return list<array{stable_id: string, route: string, context: string, reason: string}>
     */
    private function duplicateFindings(array $records): array
    {
        $identities = [];

        foreach ($records as $record) {
            $stableId = $this->stringValue($record['stable_id'] ?? null) ?? '@invalid-media';

            foreach ($this->objectList($record['contexts'] ?? []) as $context) {
                $route = $this->stringValue($context['route'] ?? null) ?? '@invalid';
                $name = $this->stringValue($context['context'] ?? null) ?? '@invalid';
                $identity = implode("\0", [$stableId, $route, $name]);
                $identities[$identity][] = ['record' => $record, 'route' => $route, 'context' => $name];
            }
        }

        $findings = [];

        foreach ($identities as $duplicates) {
            if (count($duplicates) < 2) {
                continue;
            }

            $stableId = $this->stringValue($duplicates[0]['record']['stable_id'] ?? null) ?? '@invalid-media';
            $route = $duplicates[0]['route'];
            $context = $duplicates[0]['context'];
            $findings[] = $this->finding($stableId, $route, $context, 'duplicate_media_identity');
            $classifications = array_unique(array_map(
                fn (array $item): string => $this->stringValue($item['record']['classification'] ?? null) ?? '@missing',
                $duplicates,
            ));
            $decisions = array_unique(array_map(
                fn (array $item): string => $this->stringValue($item['record']['decision'] ?? null) ?? '@missing',
                $duplicates,
            ));

            if (count($classifications) > 1) {
                $findings[] = $this->finding($stableId, $route, $context, 'conflicting_media_classification');
            }

            if (count($decisions) > 1) {
                $findings[] = $this->finding($stableId, $route, $context, 'conflicting_media_decision');
            }
        }

        return $findings;
    }

    /** @param array<string, mixed> $item */
    private function expectedContentHash(array $item): string
    {
        if ($item['category'] !== 'public_asset') {
            return $item['content_hash'];
        }

        try {
            $asset = json_decode($item['content'], true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return $item['content_hash'];
        }

        return is_array($asset) && is_string($asset['sha256'] ?? null) ? $asset['sha256'] : $item['content_hash'];
    }

    /** @param array<string, mixed> $value */
    private function containsSensitiveKey(array $value): bool
    {
        foreach ($value as $key => $nested) {
            if (is_string($key) && preg_match('/(?:patient_(?:name|id)|health|diagnosis|signature|consent_document|credential|password|secret|token|cpf|email|phone)/i', $key) === 1) {
                return true;
            }

            if (is_array($nested) && $this->containsSensitiveKey($nested)) {
                return true;
            }
        }

        return false;
    }

    /** @param array<string, mixed> $value */
    private function containsSensitiveValue(array $value): bool
    {
        foreach ($value as $nested) {
            if (is_string($nested) && preg_match('/\d{3}\.\d{3}\.\d{3}-\d{2}|[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}|BEGIN\s+(?:CERTIFICATE|PRIVATE KEY)|data:[^;]+;base64,/iu', $nested) === 1) {
                return true;
            }

            if (is_array($nested) && $this->containsSensitiveValue($nested)) {
                return true;
            }
        }

        return false;
    }

    private function isOpaqueReference(string $reference): bool
    {
        if (preg_match('/\d{3}\.\d{3}\.\d{3}-\d{2}|@|(?:https?|data):|BEGIN\s/u', $reference) === 1) {
            return false;
        }

        return preg_match('/^[a-z][a-z0-9_-]{1,31}:[A-Za-z0-9][A-Za-z0-9._-]{2,127}$/D', $reference) === 1;
    }

    private function isAllowedMediaPath(string $path): bool
    {
        return str_starts_with($path, 'public/')
            && ! str_contains($path, '\\')
            && ! str_contains('/'.$path.'/', '/../')
            && preg_match('/^[A-Za-z0-9._\/-]+$/D', $path) === 1;
    }

    private function firstRoute(array $record): string
    {
        return $this->stringValue($record['contexts'][0]['route'] ?? null) ?? '@register';
    }

    private function firstContext(array $record): string
    {
        return $this->stringValue($record['contexts'][0]['context'] ?? null) ?? '@register';
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
            throw new RuntimeException('Media register must contain one tagged payload.');
        }

        $begin = strpos($contents, self::BEGIN_MARKER);
        $end = strpos($contents, self::END_MARKER);

        if ($begin === false || $end === false || $end <= $begin) {
            throw new RuntimeException('Media register markers are invalid.');
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
        return ['stable_id' => $stableId, 'route' => $route, 'context' => $context, 'reason' => $reason];
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
