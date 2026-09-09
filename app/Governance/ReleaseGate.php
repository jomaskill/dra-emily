<?php

namespace App\Governance;

use DateTimeImmutable;
use JsonException;
use RuntimeException;

class ReleaseGate
{
    /** @var list<string> */
    private const REQUIRED_CATEGORIES = [
        'claims',
        'media',
        'professional_wording',
        'operations',
        'privacy',
    ];

    public function __construct(
        private readonly ClaimRegister $claims,
        private readonly MediaRegister $media,
        private readonly ProfessionalWordingRegister $professionalWording,
        private readonly OperationsRegister $operations,
        private readonly PrivacyDecision $privacy,
    ) {}

    /**
     * @return array{
     *     status: string,
     *     candidate: array{revision: string, dirty_tree: string, public_surface_digest: string},
     *     baseline: array{run_id: string, captured_at: string, environment: string, status: string},
     *     comparison: array{status: string, reason: string},
     *     categories: array<string, array{requirement: string, owner: string, status: string, findings: int}>,
     *     findings: list<array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string}>
     * }
     */
    public function evaluate(
        string $inventoryPath,
        string $evidenceDirectory,
        string $baselinePath,
        ?DateTimeImmutable $asOf = null,
    ): array {
        $asOf ??= new DateTimeImmutable('today');
        $inventory = $this->readJsonObject($inventoryPath);
        $revision = $this->requiredString($inventory['run']['revision'] ?? null, 'Inventory revision is missing.');

        if (preg_match('/^[a-f0-9]{40}$/D', $revision) !== 1) {
            throw new RuntimeException('Inventory revision is invalid.');
        }

        $dirtyTree = $this->safeValue(
            $this->requiredString($inventory['run']['dirty_tree'] ?? null, 'Inventory dirty-tree identity is missing.'),
            'unavailable',
        );
        $items = $this->objectList($inventory['items'] ?? null);

        if ($items === []) {
            throw new RuntimeException('Inventory has no required publication items.');
        }

        $publicSurfaceDigest = $this->inventoryDigest($items);
        $findings = $this->inventoryFindings($inventory, $items);
        [$baseline, $baselineFindings] = $this->baselineBinding($baselinePath, $revision, $publicSurfaceDigest);
        array_push($findings, ...$baselineFindings);

        if (! is_dir($evidenceDirectory) || is_link($evidenceDirectory)) {
            throw new RuntimeException('Evidence directory is unavailable.');
        }

        /** @var array<string, array{requirement: string, owner: string, file: string, research_fields: list<string>}> $categoryConfiguration */
        $categoryConfiguration = config('governance.release_categories', []);

        foreach (self::REQUIRED_CATEGORIES as $category) {
            if (! isset($categoryConfiguration[$category])) {
                $findings[] = $this->finding($category, 'GOV-01', '@category', '@release', '@configuration', 'release owner', 'missing_category');
            }
        }

        $validatorFindings = $this->validatorFindings(
            $inventoryPath,
            $evidenceDirectory,
            $revision,
            $categoryConfiguration,
            $asOf,
        );
        array_push($findings, ...$validatorFindings);
        $findings = $this->sortAndUniqueFindings($findings);
        $categories = [];

        foreach (self::REQUIRED_CATEGORIES as $category) {
            $definition = $categoryConfiguration[$category] ?? [
                'requirement' => 'GOV-01',
                'owner' => 'release owner',
            ];
            $categoryCount = count(array_filter($findings, static fn (array $finding): bool => $finding['category'] === $category));
            $categories[$category] = [
                'requirement' => (string) $definition['requirement'],
                'owner' => (string) $definition['owner'],
                'status' => $categoryCount === 0 ? 'READY' : 'BLOCKED',
                'findings' => $categoryCount,
            ];
        }

        return [
            'status' => $findings === [] ? 'READY' : 'BLOCKED',
            'candidate' => [
                'revision' => $revision,
                'dirty_tree' => $dirtyTree,
                'public_surface_digest' => $publicSurfaceDigest,
            ],
            'baseline' => $baseline,
            'comparison' => [
                'status' => 'PENDING_TASK_3',
                'reason' => 'The final nine-category before/after comparison follows the accountable-human checkpoint.',
            ],
            'categories' => $categories,
            'findings' => $findings,
        ];
    }

    /**
     * @param  array{
     *     status: string,
     *     candidate: array{revision: string, dirty_tree: string, public_surface_digest: string},
     *     baseline: array{run_id: string, captured_at: string, environment: string, status: string},
     *     comparison: array{status: string, reason: string},
     *     categories: array<string, array{requirement: string, owner: string, status: string, findings: int}>,
     *     findings: list<array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string}>
     * }  $result
     */
    public function render(array $result): string
    {
        $lines = [
            '# Phase 1 Governance Release Gate',
            '',
            'Status: '.$result['status'],
            '',
            'Revision: `'.$result['candidate']['revision'].'`',
            'Dirty tree: `'.$result['candidate']['dirty_tree'].'`',
            'Public surface digest: `'.$result['candidate']['public_surface_digest'].'`',
            'Baseline run: `'.$result['baseline']['run_id'].'`',
            'Baseline captured at: `'.$result['baseline']['captured_at'].'`',
            'Environment: `'.$result['baseline']['environment'].'`',
            'Baseline status: `'.$result['baseline']['status'].'`',
            'Comparison status: `'.$result['comparison']['status'].'`',
            '',
            'Readiness is derived from current evidence. This report cannot grant or upgrade a human decision.',
            '',
            '## Required Categories',
            '',
            '| Category | Requirement | Status | Findings | Accountable owner |',
            '|---|---|---|---:|---|',
        ];

        foreach ($result['categories'] as $category => $summary) {
            $lines[] = '| `'.$category.'` | `'.$summary['requirement'].'` | '.$summary['status'].' | '.$summary['findings'].' | '.$summary['owner'].' |';
        }

        $lines[] = '';
        $lines[] = '## Unresolved Research Fields';
        $lines[] = '';
        $lines[] = '| Question | Accountable role | Blocking field |';
        $lines[] = '|---|---|---|';
        $lines[] = '| OQ-1 | All five accountable roles | Named owner and controlled evidence system |';
        $lines[] = '| OQ-2 | All five accountable roles | Validity or recheck period |';
        $lines[] = '| OQ-3 | Authorized media custodian | Media/testimonial classification and exact-context authorization |';
        $lines[] = '| OQ-4 | Named privacy owner | Deployed analytics, tag, storage, and consent state |';
        $lines[] = '| OQ-5 | All five accountable roles | Exact rendered candidate revision, environment, and public-surface digest |';
        $lines[] = '';
        $lines[] = '## Sanitized Findings';
        $lines[] = '';

        if ($result['findings'] === []) {
            $lines[] = 'None.';
        } else {
            $lines[] = '| Requirement | Category | Stable ID | Route / context | Accountable owner | Reason |';
            $lines[] = '|---|---|---|---|---|---|';

            foreach ($result['findings'] as $finding) {
                $lines[] = '| `'.$finding['requirement'].'` | `'.$finding['category'].'` | `'.$finding['stable_id'].'` | `'.$finding['route'].'` / `'.$finding['context'].'` | '.$finding['owner'].' | `'.$finding['reason'].'` |';
            }
        }

        $lines[] = '';
        $lines[] = '## Final Comparison';
        $lines[] = '';
        $lines[] = $result['comparison']['reason'];

        return implode(PHP_EOL, $lines).PHP_EOL;
    }

    /**
     * @return array{
     *     status: string,
     *     candidate: array{revision: string, dirty_tree: string, public_surface_digest: string},
     *     baseline: array{run_id: string, captured_at: string, environment: string, status: string},
     *     comparison: array{status: string, reason: string},
     *     categories: array<string, array{requirement: string, owner: string, status: string, findings: int}>,
     *     findings: list<array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string}>
     * }
     */
    public function blockedInputResult(): array
    {
        /** @var array<string, array{requirement: string, owner: string}> $configuration */
        $configuration = config('governance.release_categories', []);
        $categories = [];
        $findings = [];

        foreach (self::REQUIRED_CATEGORIES as $category) {
            $definition = $configuration[$category] ?? ['requirement' => 'GOV-01', 'owner' => 'release owner'];
            $categories[$category] = [
                'requirement' => (string) $definition['requirement'],
                'owner' => (string) $definition['owner'],
                'status' => 'BLOCKED',
                'findings' => 1,
            ];
            $findings[] = $this->finding(
                $category,
                (string) $definition['requirement'],
                '@category',
                '@input',
                '@validation',
                (string) $definition['owner'],
                'category_validation_not_run',
            );
        }

        $findings[] = $this->finding('release', 'GOV-01', '@release', '@input', '@input', 'release owner', 'invalid_or_unavailable_governance_data');

        return [
            'status' => 'BLOCKED',
            'candidate' => ['revision' => 'unavailable', 'dirty_tree' => 'unavailable', 'public_surface_digest' => 'unavailable'],
            'baseline' => ['run_id' => 'unavailable', 'captured_at' => 'unavailable', 'environment' => 'unavailable', 'status' => 'BLOCKED'],
            'comparison' => ['status' => 'BLOCKED', 'reason' => 'Input validation failed; no comparison may be inferred.'],
            'categories' => $categories,
            'findings' => $this->sortAndUniqueFindings($findings),
        ];
    }

    /**
     * @param  array<string, mixed>  $inventory
     * @param  list<array<string, mixed>>  $items
     * @return list<array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string}>
     */
    private function inventoryFindings(array $inventory, array $items): array
    {
        $findings = [];
        $summary = is_array($inventory['summary'] ?? null) ? $inventory['summary'] : [];
        $discovered = $summary['discovered_items'] ?? null;
        $inventoried = $summary['inventoried_items'] ?? null;

        if (! is_int($discovered) || ! is_int($inventoried) || $discovered !== count($items) || $inventoried !== count($items)) {
            $findings[] = $this->finding('inventory', 'GOV-01', '@inventory', '@inventory', '@count', 'release owner', 'inventory_incomplete');
        }

        foreach (['errors', 'omissions', 'unresolved_routes'] as $field) {
            if (! is_array($summary[$field] ?? null) || $summary[$field] !== []) {
                $findings[] = $this->finding('inventory', 'GOV-01', '@inventory', '@inventory', '@'.$field, 'release owner', 'inventory_incomplete');
            }
        }

        $cardinality = is_array($summary['cardinality'] ?? null) ? $summary['cardinality'] : [];

        /** @var list<string> $requiredCollections */
        $requiredCollections = config('governance.required_inventory_collections', []);

        foreach ($requiredCollections as $collection) {
            if (! is_int($cardinality[$collection] ?? null) || $cardinality[$collection] < 1) {
                $findings[] = $this->finding('inventory', 'GOV-01', '@inventory', '@inventory', '@'.$collection, 'release owner', 'inventory_incomplete');
            }
        }

        $identities = [];

        foreach ($items as $item) {
            $stableId = $this->requiredString($item['id'] ?? null, 'Inventory item ID is missing.');
            $content = $item['content'] ?? null;

            if (! is_string($content)) {
                throw new RuntimeException('Inventory item content is missing.');
            }

            $contentHash = $this->requiredString($item['content_hash'] ?? null, 'Inventory item hash is missing.');
            $identity = implode("\0", [
                $stableId,
                $this->requiredString($item['locale'] ?? null, 'Inventory item locale is missing.'),
                $this->requiredString($item['route'] ?? null, 'Inventory item route is missing.'),
                $this->requiredString($item['context'] ?? null, 'Inventory item context is missing.'),
            ]);

            if (! hash_equals(hash('sha256', $content), $contentHash)) {
                $findings[] = $this->finding('inventory', 'GOV-01', $stableId, '@inventory', '@hash', 'release owner', 'stale_hash');
            }

            if (isset($identities[$identity])) {
                $findings[] = $this->finding('inventory', 'GOV-01', $stableId, '@inventory', '@identity', 'release owner', 'duplicate_inventory_identity');
            }

            $identities[$identity] = true;
        }

        return $findings;
    }

    /**
     * @return array{0: array{run_id: string, captured_at: string, environment: string, status: string}, 1: list<array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string}>}
     */
    private function baselineBinding(string $path, string $revision, string $digest): array
    {
        $baseline = $this->readTaggedObject($path, 'governance-baseline');
        $runs = $this->objectList($baseline['runs'] ?? null);
        $matches = array_values(array_filter($runs, fn (array $run): bool => ($run['revision'] ?? null) === $revision && ($run['inventory_digest'] ?? null) === $digest));

        if (count($matches) !== 1) {
            return [[
                'run_id' => 'unavailable',
                'captured_at' => 'unavailable',
                'environment' => 'unavailable',
                'status' => 'BLOCKED',
            ], [$this->finding('baseline', 'GOV-01', '@baseline', '@baseline', '@binding', 'release reviewer', 'revision_mismatch')]];
        }

        $run = $matches[0];
        $findings = [];
        $records = $this->objectList($run['records'] ?? null);

        if ($records === []) {
            $findings[] = $this->finding('baseline', 'GOV-01', '@baseline', '@baseline', '@records', 'release reviewer', 'baseline_evidence_unavailable');
        }

        foreach ($records as $record) {
            if (($record['evidence_status'] ?? null) !== 'observed') {
                $findings[] = $this->finding(
                    'baseline',
                    'GOV-01',
                    $this->safeValue($record['id'] ?? null, '@baseline-record'),
                    '@baseline',
                    $this->safeValue($record['surface'] ?? null, '@evidence'),
                    'release reviewer',
                    'baseline_evidence_unavailable',
                );
            }
        }

        return [[
            'run_id' => $this->safeValue($run['id'] ?? null, '@baseline'),
            'captured_at' => $this->safeValue($run['captured_at'] ?? null, 'unavailable'),
            'environment' => $this->safeValue($run['environment'] ?? null, 'unavailable'),
            'status' => $findings === [] ? 'READY' : 'BLOCKED',
        ], $findings];
    }

    /**
     * @param  array<string, array{requirement: string, owner: string, file: string, research_fields: list<string>}>  $configuration
     * @return list<array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string}>
     */
    private function validatorFindings(
        string $inventoryPath,
        string $evidenceDirectory,
        string $revision,
        array $configuration,
        DateTimeImmutable $asOf,
    ): array {
        $paths = [];

        foreach (self::REQUIRED_CATEGORIES as $category) {
            $file = $configuration[$category]['file'] ?? '';
            $paths[$category] = rtrim($evidenceDirectory, '/').'/'.$file;
        }

        $rawFindings = [
            'claims' => $this->claims->validateFiles($inventoryPath, $paths['claims'], $asOf),
            'media' => $this->media->validateFiles($inventoryPath, $paths['media'], $asOf),
            'professional_wording' => $this->professionalWording->validateFiles($inventoryPath, $paths['professional_wording'], $asOf),
            'operations' => $this->operations->validateFile($paths['operations'], $revision, $asOf),
            'privacy' => $this->privacy->validateFile($paths['privacy'], $revision, $asOf),
        ];
        $findings = [];

        foreach (self::REQUIRED_CATEGORIES as $category) {
            $definition = $configuration[$category] ?? ['requirement' => 'GOV-01', 'owner' => 'release owner'];
            $missingCategory = false;

            foreach ($rawFindings[$category] as $rawFinding) {
                $reason = $this->safeValue($rawFinding['reason'] ?? null, 'invalid_category_result');
                $findings[] = $this->finding(
                    $category,
                    (string) $definition['requirement'],
                    $this->safeValue($rawFinding['stable_id'] ?? null, '@invalid'),
                    $this->safeValue($rawFinding['route'] ?? null, '@'.$category),
                    $this->safeValue($rawFinding['context'] ?? $rawFinding['domain'] ?? null, '@'.$category),
                    (string) $definition['owner'],
                    $reason,
                );

                if (str_starts_with($reason, 'missing_') && str_ends_with($reason, '_register')) {
                    $missingCategory = true;
                }

                if (str_contains($reason, 'revision') || str_contains($reason, 'disposition_inputs')) {
                    $findings[] = $this->finding(
                        $category,
                        (string) $definition['requirement'],
                        $this->safeValue($rawFinding['stable_id'] ?? null, '@invalid'),
                        $this->safeValue($rawFinding['route'] ?? null, '@'.$category),
                        $this->safeValue($rawFinding['context'] ?? $rawFinding['domain'] ?? null, '@'.$category),
                        (string) $definition['owner'],
                        'revision_mismatch',
                    );
                }
            }

            if ($missingCategory) {
                $findings[] = $this->finding(
                    $category,
                    (string) $definition['requirement'],
                    '@category',
                    '@register',
                    '@register',
                    (string) $definition['owner'],
                    'missing_category',
                );
            }
        }

        return $findings;
    }

    /** @param list<array<string, mixed>> $items */
    private function inventoryDigest(array $items): string
    {
        return hash('sha256', json_encode($items, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR).PHP_EOL);
    }

    /** @return array<string, mixed> */
    private function readJsonObject(string $path): array
    {
        return $this->decodeObject($this->readSharedSnapshot($path));
    }

    /** @return array<string, mixed> */
    private function readTaggedObject(string $path, string $marker): array
    {
        $contents = $this->readSharedSnapshot($path);
        $begin = '<!-- '.$marker.':start -->';
        $end = '<!-- '.$marker.':end -->';

        if (substr_count($contents, $begin) !== 1 || substr_count($contents, $end) !== 1) {
            throw new RuntimeException('Governance record markers are invalid.');
        }

        $start = strpos($contents, $begin);
        $finish = strpos($contents, $end);

        if ($start === false || $finish === false || $finish <= $start) {
            throw new RuntimeException('Governance record markers are invalid.');
        }

        return $this->decodeObject(trim(substr($contents, $start + strlen($begin), $finish - $start - strlen($begin))));
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

    /** @return array<string, mixed> */
    private function decodeObject(string $contents): array
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

    /** @return list<array<string, mixed>> */
    private function objectList(mixed $value): array
    {
        if (! is_array($value) || ! array_is_list($value)) {
            return [];
        }

        return array_values(array_filter($value, static fn (mixed $item): bool => is_array($item) && ! array_is_list($item)));
    }

    private function requiredString(mixed $value, string $message): string
    {
        if (! is_string($value) || $value === '') {
            throw new RuntimeException($message);
        }

        return $value;
    }

    private function safeValue(mixed $value, string $fallback): string
    {
        if (! is_string($value)
            || $value === ''
            || mb_strlen($value) > 256
            || preg_match('/[\r\n\x00-\x1F\x7F]/u', $value) === 1
            || preg_match('/(?:https?|data):\/\/|[A-Za-z0-9._%+-]+:[^\s@]+@|(?:password|secret|token|credential)=/iu', $value) === 1
            || str_contains($value, '?')) {
            return $fallback;
        }

        return str_replace(['|', '`'], ['/', "'"], $value);
    }

    /** @return array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string} */
    private function finding(string $category, string $requirement, string $stableId, string $route, string $context, string $owner, string $reason): array
    {
        return [
            'category' => $category,
            'requirement' => $requirement,
            'stable_id' => $stableId,
            'route' => $route,
            'context' => $context,
            'owner' => $owner,
            'reason' => $reason,
        ];
    }

    /**
     * @param  list<array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string}>  $findings
     * @return list<array{category: string, requirement: string, stable_id: string, route: string, context: string, owner: string, reason: string}>
     */
    private function sortAndUniqueFindings(array $findings): array
    {
        $categoryOrder = array_flip([...self::REQUIRED_CATEGORIES, 'inventory', 'baseline', 'release']);
        usort($findings, static fn (array $left, array $right): int => [
            $categoryOrder[$left['category']] ?? PHP_INT_MAX,
            $left['stable_id'],
            $left['route'],
            $left['context'],
            $left['reason'],
        ] <=> [
            $categoryOrder[$right['category']] ?? PHP_INT_MAX,
            $right['stable_id'],
            $right['route'],
            $right['context'],
            $right['reason'],
        ]);

        return array_values(array_unique($findings, SORT_REGULAR));
    }
}
