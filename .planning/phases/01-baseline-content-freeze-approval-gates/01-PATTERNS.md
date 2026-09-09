# Phase 1: Baseline, Content Freeze & Approval Gates - Pattern Map

**Mapped:** 2026-09-08
**Files analyzed:** 18 likely new files
**Analogs found:** 17 / 18

## Scope Notes

- Phase 1 adds a governance layer and must not change public routes, Blade, CSS, JavaScript, assets, structured data, sitemap behavior, or analytics behavior.
- Generated inventory and human decisions stay separate. A scanner may record observable facts and hashes; it must never generate an `approved` decision.
- All missing, malformed, stale, conflicting, unmeasured, or non-approved evidence fails closed.
- The live tree now includes article routes and content in addition to the older research snapshot. Inventory code must enumerate Laravel's actual route collection and current config rather than hard-code the three routes named in research.

## File Classification

| New/Modified File | Role | Data Flow | Closest Analog | Match Quality |
|---|---|---|---|---|
| `app/Console/Commands/GenerateGovernanceInventory.php` | command | batch + file-I/O + transform | `app/Console/Commands/ConvertImagesToWebp.php` | exact role/flow |
| `app/Console/Commands/CheckGovernanceRelease.php` | command | batch + file-I/O | `app/Console/Commands/ConvertImagesToWebp.php` | exact role/flow |
| `config/governance.php` | config/schema | transform | `config/clinic.php`, `config/faq.php` | exact role |
| `01-INVENTORY.json` | generated record | batch output | `public/build/manifest.json` | format-only |
| `01-INVENTORY.md` | generated report | batch output | `01-RESEARCH.md` | report-layout match |
| `01-CLAIMS.md` | review register | CRUD-by-review + validation | `config/faq.php` | content-record match |
| `01-MEDIA.md` | review register | CRUD-by-review + validation | `config/faq.php` | content-record match |
| `01-PROFESSIONAL-WORDING.md` | review register | CRUD-by-review + validation | `config/clinic.php` | domain-record match |
| `01-OPERATIONS.md` | review register | CRUD-by-review + validation | `config/clinic.php` | domain-record match |
| `01-PRIVACY-DECISION.md` | decision record | CRUD-by-review + validation | `config/clinic.php` | partial domain match |
| `01-BASELINE.md` | evidence report | batch + file-I/O | `01-UI-SPEC.md` capture matrix | specification match |
| `01-RELEASE-GATE.md` | generated report | batch + transform | command report in `ConvertImagesToWebp.php` | flow match |
| `tests/Feature/Governance/PublicSurfaceInventoryTest.php` | test | request-response + transform | `tests/Feature/SiteStructureTest.php` | exact flow |
| `tests/Feature/Governance/ReleaseGateTest.php` | test | command + file-I/O | `tests/Feature/ProcedurePageTest.php` | framework match |
| `tests/Unit/Governance/ClaimRegisterTest.php` | test | file-I/O + validation | `tests/Feature/HomeSchemaTest.php` | validation match |
| `tests/Unit/Governance/MediaRegisterTest.php` | test | file-I/O + validation | `tests/Feature/SiteStructureTest.php` | validation match |
| `tests/Unit/Governance/PrivacyDecisionTest.php` | test | file-I/O + validation | `tests/Feature/MedicalContentTest.php` | validation match |
| `tests/Unit/Governance/OperationsRegisterTest.php` | test | file-I/O + validation | `tests/Feature/MedicalContentTest.php` | validation match |

The file names above follow the research recommendations. If planning consolidates validators into an `app/Governance/` service, preserve the same separation of generated observations, human records, and derived gate status; no existing application service is a close analog for that new class.

## Pattern Assignments

### `app/Console/Commands/GenerateGovernanceInventory.php` (command, batch/file-I-O)

**Primary analog:** `app/Console/Commands/ConvertImagesToWebp.php`

**Command declaration and explicit exit type** (`ConvertImagesToWebp.php:3-7,9-27,43-51`):

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:webp
        {--path=* : Directories to scan, relative to public/. Defaults to the whole public directory.}
        {--dry-run : Report what would be converted without writing any file.}';

    protected $description = 'Generate a .webp companion for every JPEG and PNG under public/';

    public function handle(): int
    {
        // validate options before scanning
        return self::FAILURE;
    }
}
```

Copy the multiline signature, `$description`, `handle(): int`, and `self::SUCCESS`/`self::FAILURE` convention. The inventory command should default to read-only inspection and only write the explicitly selected inventory/report outputs. Include an output-directory or output-file option so tests can target a temporary directory without touching canonical evidence.

**Constrained deterministic scan** (`ConvertImagesToWebp.php:118-163`):

```php
/** @return list<string> */
private function resolveDirectories(): array
{
    if ($paths === []) {
        return [public_path()];
    }

    // resolve only allowed roots; warn for missing paths
}

/** @return iterable<SplFileInfo> */
private function sourceFiles(array $directories): iterable
{
    return Finder::create()
        ->files()
        ->in($directories)
        ->exclude(self::EXCLUDED_DIRECTORIES)
        ->name('/\.(jpg|jpeg|png)$/i')
        ->sortByName();
}
```

Use explicit roots and deterministic sorting. For governance, exclude `.env`, `.git`, `vendor`, `node_modules`, `storage`, build/runtime secrets, and symlinks. Enumerate routes through Laravel's route collection, config through known keys, and rendered output through framework requests; do not make regex-only Blade scanning the sole authority.

**Report and failure accounting** (`ConvertImagesToWebp.php:70-75,98-115,227-264`):

```php
/** @var list<array{0: string, 1: int, 2: int}> $rows */
$rows = [];
$failed = 0;

if (! $this->encode($source, $target, $quality)) {
    $this->warn('Failed to convert '.$this->relative($source));
    $failed++;
    continue;
}

$this->table(['Image', 'Before', 'WebP', 'Saved'], $rows);

return $failed > 0 ? self::FAILURE : self::SUCCESS;
```

Use typed array-shape PHPDoc, collect actionable stable IDs/reasons, render a summary table, and return non-zero on any scan/output failure. Inventory completeness is not approval and must not be presented as release success.

### `app/Console/Commands/CheckGovernanceRelease.php` (command, validation/file-I-O)

**Analog:** `app/Console/Commands/ConvertImagesToWebp.php:43-65,113-115,227-243`

```php
if ($directories === []) {
    $this->error('None of the requested paths exist under public/.');

    return self::FAILURE;
}

$this->renderReport($rows, $sourceBytes, $webpBytes, $skipped, $failed, $dryRun);

return $failed > 0 ? self::FAILURE : self::SUCCESS;
```

Apply this fail-fast/error-output pattern to missing or malformed required files, then aggregate record-level problems so one run lists every actionable item ID. Exit non-zero for duplicate IDs, absent fields, stale hashes/revisions, unknown statuses, `pending`, `rejected`, `quarantined`, `expired`, unresolved conflicts, and discovered-but-unregistered surfaces. Never accept a stored `release_ready` boolean; derive eligibility from evidence predicates.

No auth pattern applies: these are local CLI commands and Phase 1 must not introduce a public approval UI or route.

### `config/governance.php` (config/schema, transform)

**Analogs:** `config/clinic.php` and `config/faq.php`

**Direct returned-array convention** (`config/clinic.php:1-19`):

```php
<?php

return [
    'whatsapp' => env('CLINIC_WHATSAPP', '...'),
    'cro' => env('CLINIC_CRO', '...'),
    'city' => env('CLINIC_CITY', 'Belo Horizonte'),
];
```

**Stable repeated-record convention** (`config/faq.php:22-28`):

```php
return [
    'home' => [
        [
            'q' => '...',
            'a' => '...',
        ],
    ],
];
```

Use a directly returned PHP array for schema constants such as allowed statuses, required register paths, required fields by category, and allowed scan roots. Prefer descriptive keys and list/array-shape PHPDoc. Do not place approval decisions in environment-backed config: canonical human records must remain reviewable, revision-bound artifacts.

### `01-INVENTORY.json` and `01-INVENTORY.md` (generated records/reports)

**Source-enumeration analogs:** `routes/web.php`, `ProcedureController.php`, schema and sitemap partials.

**Actual route derivation** (`routes/web.php:7-23`):

```php
Route::view('/', 'welcome')->name('home');

Route::get('/procedimentos/{slug}', [ProcedureController::class, 'show'])
    ->where('slug', implode('|', array_keys(config('procedures'))))
    ->name('procedure');

Route::get('/artigos/{slug}', [ArticleController::class, 'show'])
    ->where('slug', implode('|', array_keys(config('articles'))))
    ->name('article');

Route::get('/sitemap.xml', function () {
    return response()->view('sitemap')->header('Content-Type', 'application/xml');
})->name('sitemap');
```

Inventory the current route union, expanding every config-backed slug and including invalid-slug behavior. Record route name, method, URL, status, content type, selected template, visibility class, source/context, timestamp, commit SHA, dirty-tree state, and stable content hash.

**Config-to-render flow** (`ProcedureController.php:12-21`):

```php
public function show(string $slug): View
{
    $procedure = config("procedures.{$slug}");

    abort_if($procedure === null, 404);

    return view($procedure['view'] ?? 'procedure', [
        'slug' => $slug,
        'procedure' => $procedure,
    ]);
}
```

This is the pattern the inventory must understand: config is the content source, while the rendered route/context is the publication surface. Store both rather than treating a source string as its only context.

**Machine-readable enumeration** (`resources/views/sitemap.blade.php:26-33,40-47`):

```blade
@foreach (config('procedures') as $slug => $proc)
    <url>
        <loc>https://{{ config('clinic.domain') }}/procedimentos/{{ $slug }}</loc>
        <lastmod>{{ $proc['updated'] ?? config('clinic.content_updated') }}</lastmod>
    </url>
@endforeach
```

Parse rendered XML and JSON-LD, preserve exact property/value/context, and distinguish `visible`, `machine_readable`, and `both`. The JSON file must use stable key ordering and deterministic item ordering. Timestamps and revision metadata belong in a run envelope, not in content hashes.

### Human review registers (`01-CLAIMS.md`, `01-MEDIA.md`, `01-PROFESSIONAL-WORDING.md`, `01-OPERATIONS.md`, `01-PRIVACY-DECISION.md`)

**Closest content-source analog:** `config/faq.php:16-28`; **closest operational-source analog:** `config/clinic.php:5-47`.

```php
// config/faq.php documents the repeated shape before returning records
// Structure of each item:
//   q => question
//   a => answer

return [
    'home' => [
        ['q' => '...', 'a' => '...'],
    ],
];
```

Mirror the project's single-source, repeated-record organization, but use Markdown tables/sections with one stable ID per record and explicit fields rather than prose-only approvals. Each entry binds to exact hash/revision, route/context, and locale.

- Claims: exact text, source, owner, last-reviewed date, Dra. Emily evidence reference, decision/date, disposition.
- Media/testimonials: asset/text ID, every context, classification, opaque provenance and authorization references, responsible professional, decision/date. Never store patient identity, health data, signatures, consent scans, or credentials.
- Professional wording: exact wording and visible/schema contexts, current registration reference, reviewer/date, scope-sensitive flag, CRO-MG/legal decision, blocked reason.
- Operations: configured value and observed value, verifier/date, opaque evidence reference, status, recheck date.
- Privacy: controller/processors, purpose, parameters/data, lawful basis, consent deny/revoke behavior, retention, access, transfers, production config, approver/date/decision.

Allowed status vocabulary is exactly `pending`, `approved`, `rejected`, `quarantined`, `expired`. Blank or unknown fields block. Use configured clinic values as assertions awaiting verification, not as evidence; for example `config/clinic.php:35-39` contains Google/GA4 settings, while `schema.blade.php:50-80` publishes hours and professional wording that must be separately reviewed.

### `01-BASELINE.md` (evidence report, batch/file-I-O)

**Analog/specification:** `01-UI-SPEC.md`, sections “Baseline Capture Matrix,” “Responsive Evidence Contract,” and “Interaction and Accessibility Evidence.”

Use a dated, append-only run section. For every capture record: offset-aware timestamp, commit SHA, dirty-tree description/diff reference, base URL/environment, browser/version, OS, viewport width/height, DPR, zoom, color scheme, reduced-motion preference, tool/version, route, state, evidence path, observation, limitation, reviewer/status.

Cover `/`, one generic procedure, Full Face, current public-route union, invalid slugs, navigation, footer, every conversion link, FAQ states, public media, JSON-LD, sitemap, and analytics/network/storage behavior at 320px, 768px, and 1440px. Record keyboard order, focus, 200% zoom, reduced motion, overflow, loaded/failure states, and unavailable measurements. Use `not measured` plus reason/owner where evidence cannot be captured; never infer a pass.

Measurement language must keep a literal WhatsApp link activation separate from conversation, appointment, attendance, clinical eligibility, patient, and revenue.

### `01-RELEASE-GATE.md` (generated report, transform)

**Analog:** console table/totals in `ConvertImagesToWebp.php:227-264`.

```php
if ($rows === []) {
    $this->info('Nothing to convert. '.$skipped.' image(s) already up to date.');
    return;
}

$this->table(['Image', 'Before', 'WebP', 'Saved'], $rows);
$this->info(sprintf('Converted %d image(s)... %d failed.', count($rows), $failed));
```

Produce a concise gate table by requirement/category with exact revision, total, approved, pending, expired, missing, conflicting, and blocked counts, followed by actionable item IDs/reasons. The headline stays `BLOCKED` unless every exact-revision predicate is current and approved. An empty required collection is a completeness failure, not success.

### `tests/Feature/Governance/PublicSurfaceInventoryTest.php` (Pest feature, request-response/transform)

**Primary analog:** `tests/Feature/SiteStructureTest.php:8-16,24-35,37-46,79-83`

```php
$catalogue = require __DIR__.'/../../config/procedures.php';
$slugs = array_keys($catalogue);

it('lists every procedure in the sitemap', function () use ($slugs) {
    $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

    foreach ($slugs as $slug) {
        expect($xml)->toContain("/procedimentos/{$slug}</loc>");
    }
});

it('shows every procedure on the homepage', function (string $slug) {
    $html = $this->get('/')->assertOk()->getContent();
    expect($html)->toContain("/procedimentos/{$slug}");
})->with($slugs);
```

Generate datasets from config before application boot when necessary, issue Laravel test requests, expand all current procedures/articles, assert the inventory contains every named public surface, parse sitemap/JSON-LD, and assert an invalid procedure/article slug is 404. Add the reverse check: every inventory entry resolves to a live surface or is explicitly quarantined historical evidence.

**Rendered JSON parsing helper** (`HomeSchemaTest.php:17-30`):

```php
/** @return array<int, mixed> */
function homeJsonLd(string $html): array
{
    expect($html)->toContain('application/ld+json');
    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
    $decoded = json_decode($m[1], true);
    expect(json_last_error())->toBe(JSON_ERROR_NONE, 'Homepage JSON-LD must be valid JSON');

    return $decoded;
}
```

Copy the typed helper plus explicit parse assertion. Prefer names unique to the governance test suite because this repository currently defines global helper functions in test files.

### `tests/Feature/Governance/ReleaseGateTest.php` (Pest feature, command/file-I-O)

**Framework convention:** `tests/Pest.php:17-19` binds all Feature tests to `Tests\TestCase`; assertion chaining follows `HomeSchemaTest.php:80-95`.

```php
pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

expect($configured)->not->toBeEmpty()
    ->and(visibleFaqQuestions($html))->toBe(array_column($configured, 'q'));
```

Exercise the Artisan gate through Laravel's console-test API. Use isolated temporary fixture directories and assert exit code plus stable IDs/reasons for: complete fixture, missing file, malformed shape, duplicate ID, stale hash/revision, absent required field, each non-approved status, context mismatch, conflict, and unregistered discovered surface. Assert command output excludes sensitive fixture payloads.

### Unit governance tests (validation/file-I-O)

**Analogs:** `HomeSchemaTest.php:33-43,59-77`, `MedicalContentTest.php:23-30,34-43`, `SiteStructureTest.php:18-22`.

```php
/**
 * @param  array<int, mixed>  $nodes
 * @return array<string, mixed>|null
 */
function nodeOfType(array $nodes, string $type): ?array
{
    return collect($nodes)->firstWhere('@type', $type);
}

expect($page)->not->toBeNull()
    ->and($page['lastReviewed'])->toBe(config("procedures.{$slug}.updated"));
```

- `ClaimRegisterTest.php`: stable unique IDs; exact hash/context/locale; source, owner, date, and explicit Dra. Emily decision; discovered-to-register and register-to-discovered completeness.
- `MediaRegisterTest.php`: every public asset/testimonial classified; unknown/patient records require opaque references and exact-context decisions; reject sensitive keys/content and paths outside allowed roots.
- `PrivacyDecisionTest.php`: every MEAS-03 field exists; analytics remains blocked unless exact production configuration is approved; configured GA4 ID does not equal observed collection or approval.
- `OperationsRegisterTest.php`: all required operational domains exist; dates/recheck validity; configured/observed mismatch, stale evidence, or absent verifier/reference blocks.

Keep pure shape/hash/date validation in Unit tests. Anything that boots Laravel config, renders pages, or calls Artisan belongs in Feature tests under the existing `tests/Pest.php` convention.

## Shared Patterns

### Fail-Closed Error Handling

**Source:** `app/Console/Commands/ConvertImagesToWebp.php:47-65,98-115`

Validate preconditions, emit a precise error/warning, accumulate record failures where useful, and return `Command::FAILURE`. Never catch and downgrade malformed evidence to a warning followed by success.

### Deterministic Ordering and Stable Sources

**Sources:** `ConvertImagesToWebp.php:155-163`, `routes/web.php:9-17`, `sitemap.blade.php:26-47`

Sort filesystem results, expand config-backed route keys, normalize paths, and use stable IDs/content hashes. Ensure the same tree/config produces byte-equivalent item content; isolate run timestamp/revision metadata from hashed payloads.

### Visible/Machine-Readable Parity

**Source:** `tests/Feature/HomeSchemaTest.php:59-87`

```php
$html = $this->get('/')->assertOk()->getContent();
$faq = schemaNode(homeJsonLd($html), 'FAQPage');
$schemaQuestions = array_column($faq['mainEntity'], 'name');

expect(visibleFaqQuestions($html))->toBe($schemaQuestions);
```

Apply the same rendered-surface comparison to FAQs, clinic/professional statements, procedures, articles, metadata, JSON-LD, and sitemap values. A machine-readable-only statement remains an inventory item requiring exact-context review.

### Security and Evidence Boundary

Scans use explicit repository roots and do not traverse symlinks. Never read or emit `.env`, credentials, runtime storage, patient identifiers, health information, signatures, consent scans, or legal correspondence. Human registers store opaque controlled-system references only. Governance artifacts remain outside `public/` and gain no public route.

### Public Behavior Freeze

Existing `routes/web.php`, `resources/views/**`, `resources/css/app.css`, `resources/js/app.js`, `public/**`, and analytics/network behavior are observation targets. Phase 1 command/config/test additions must not alter public DOM, copy, styles, assets, interactions, structured data, sitemap, or tracking. A before/after public-surface comparison is a required acceptance check.

### PHP and Pest Conventions

- PSR-4 `App\` namespace, Laravel-discovered command classes, explicit parameter/return types, constructor promotion for injected dependencies, curly braces, TitleCase enum keys, and PHPDoc array shapes.
- Pest closures use `$this->get(...)->assertOk()->getContent()`, `expect()` chains, and datasets for config-backed slugs.
- Create implementation files with Laravel `make:` commands and `--no-interaction`; run focused governance tests, the compact full suite, and `vendor/bin/pint --dirty --format agent` when PHP changes.

## No Analog Found

| File | Role | Data Flow | Reason |
|---|---|---|---|
| Dedicated governance validator/service, if introduced | service | file-I/O + transform | The application has controllers and a command but no existing service layer. Follow Laravel/PHP typing and command error conventions, while deriving the interface from the register schema. |

`01-INVENTORY.json` only has a format-level analog (`public/build/manifest.json`); do not copy that Vite-specific schema. Its governance envelope and item fields come from `01-RESEARCH.md` and the UI capture contract.

## Metadata

**Analog search scope:** `app/Console/Commands`, `app/Http/Controllers`, `config`, `routes`, `resources/views/partials`, `tests/Feature`, `tests/Pest.php`, `composer.json`

**Strong analogs read:** 12 files (command, routes, controller, two configs, schema/sitemap partials, four Pest suites, Pest bootstrap)

**Pattern extraction date:** 2026-09-08

**Implementation caveat:** The codebase changed after the upstream research snapshot (article routes/content/tests are present). The planner should treat the current route collection—not a frozen hand-written route list—as authoritative for the baseline.
