<?php

namespace App\Governance;

use JsonException;
use RuntimeException;

class GovernanceEvidence
{
    /**
     * @return list<array<string, mixed>>
     */
    public function loadDirectory(string $directory): array
    {
        if (! is_dir($directory) || is_link($directory)) {
            throw new RuntimeException('Evidence directory must be an existing non-symlink directory.');
        }

        $paths = glob(rtrim($directory, '/').'/*.md') ?: [];
        sort($paths, SORT_STRING);

        $records = [];
        $identities = [];

        foreach ($paths as $path) {
            if (is_link($path)) {
                throw new RuntimeException('Evidence registers cannot be symlinks.');
            }

            $contents = $this->readSharedSnapshot($path);
            $begin = (string) config('governance.evidence_markers.begin');
            $end = (string) config('governance.evidence_markers.end');
            $beginCount = substr_count($contents, $begin);
            $endCount = substr_count($contents, $end);

            if ($beginCount === 0 && $endCount === 0) {
                continue;
            }

            if ($beginCount !== 1 || $endCount !== 1) {
                throw new RuntimeException('Evidence register must contain exactly one tagged payload.');
            }

            $beginPosition = strpos($contents, $begin);
            $endPosition = strpos($contents, $end);

            if ($beginPosition === false || $endPosition === false || $endPosition <= $beginPosition) {
                throw new RuntimeException('Evidence register markers are invalid.');
            }

            $jsonStart = $beginPosition + strlen($begin);
            $payload = trim(substr($contents, $jsonStart, $endPosition - $jsonStart));
            $decoded = $this->decodePayload($payload);

            foreach ($decoded as $record) {
                $this->validateRecord($record);
                $identity = $this->identity($record);

                if (isset($identities[$identity])) {
                    throw new RuntimeException('Duplicate governance evidence identity detected.');
                }

                $identities[$identity] = true;
                $records[] = $record;
            }
        }

        usort($records, fn (array $left, array $right): int => strcmp(
            $this->identity($left),
            $this->identity($right),
        ));

        return $records;
    }

    /**
     * @param  array<string, mixed>  $record
     */
    public function identity(array $record): string
    {
        /** @var list<string> $keys */
        $keys = config('governance.identity_keys', []);

        return implode("\0", array_map(
            static fn (string $key): string => (string) $record[$key],
            $keys,
        ));
    }

    private function readSharedSnapshot(string $path): string
    {
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('Evidence register is unavailable.');
        }

        try {
            if (! flock($handle, LOCK_SH)) {
                throw new RuntimeException('Evidence register could not be locked for reading.');
            }

            $contents = stream_get_contents($handle);

            if ($contents === false) {
                throw new RuntimeException('Evidence register could not be read.');
            }

            return $contents;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function decodePayload(string $payload): array
    {
        try {
            $decoded = json_decode($payload, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Evidence payload is malformed JSON.', previous: $exception);
        }

        if (! is_array($decoded) || ! array_is_list($decoded)) {
            throw new RuntimeException('Evidence payload must be a JSON list.');
        }

        foreach ($decoded as $record) {
            if (! is_array($record) || array_is_list($record)) {
                throw new RuntimeException('Every evidence entry must be a JSON object.');
            }
        }

        return $decoded;
    }

    /**
     * @param  array<string, mixed>  $record
     */
    private function validateRecord(array $record): void
    {
        if (array_key_exists('release_ready', $record)) {
            throw new RuntimeException('Release readiness must be derived, never stored in evidence.');
        }

        /** @var list<string> $requiredFields */
        $requiredFields = config('governance.required_evidence_fields', []);

        foreach ($requiredFields as $field) {
            if (! array_key_exists($field, $record) || ! is_scalar($record[$field])) {
                throw new RuntimeException('Evidence record is missing a required scalar field.');
            }

            if (! is_string($record[$field]) || $record[$field] === '') {
                throw new RuntimeException('Evidence record has a blank required field.');
            }
        }

        if (! preg_match('/^[a-f0-9]{64}$/D', (string) $record['content_hash'])) {
            throw new RuntimeException('Evidence content hash must be an exact lowercase SHA-256 value.');
        }

        /** @var list<string> $allowedStatuses */
        $allowedStatuses = config('governance.allowed_statuses', []);

        if (! in_array($record['status'], $allowedStatuses, true)) {
            throw new RuntimeException('Evidence status is not in the allowed vocabulary.');
        }
    }
}
