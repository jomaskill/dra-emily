---
phase: 01-baseline-content-freeze-approval-gates
plan: 01
subsystem: governance
tags: [laravel, artisan, pest, governance, sha256, atomic-write]

requires:
  - phase: project-initialization
    provides: Phase 1 release-governance decisions and public-surface freeze
provides:
  - Deterministic homepage publication identity and inventory command
  - Strict separate human-evidence reader and fail-closed release command
  - Locked temporary-file plus atomic-rename artifact publishing
affects: [01-02-public-inventory, 01-03-claims-media, 01-04-professional-operations-privacy, 01-05-release-gate]

actuals:
  tokens: 11455
  tasks: 2
  commits: 5

tech-stack:
  added: []
  patterns: [context-bound publication identity, tagged Markdown JSON evidence, fail-closed CLI, atomic artifact write]

key-files:
  created:
    - app/Console/Commands/GenerateGovernanceInventory.php
    - app/Console/Commands/CheckGovernanceRelease.php
    - app/Governance/GovernanceInventory.php
    - app/Governance/GovernanceEvidence.php
    - config/governance.php
    - tests/Feature/Governance/GovernanceTracerTest.php
  modified: []

key-decisions:
  - "The primary release identity remains stable ID + exact UTF-8 SHA-256 + locale + route/context; generated inventory and human evidence stay separate (decision: no-change)."
  - "Run timestamp, revision, dirty-tree state, target, and command version remain outside deterministic item payloads."
  - "Human evidence uses exactly one tagged JSON list per Markdown register and readiness is always derived."

patterns-established:
  - "Exact-context identity: equal content in two publication contexts receives distinct stable IDs."
  - "Fail-closed evidence: missing, stale, malformed, duplicate, blank, unknown, or non-approved evidence blocks release."
  - "Safe generation: writers share a target-derived lock and publish through a sibling temporary file plus atomic rename."

requirements-completed: [GOV-01]

coverage:
  - id: D1
    description: "A real named homepage route produces one deterministic, context-bound publication item without changing public behavior."
    requirement: GOV-01
    verification:
      - kind: integration
        ref: "tests/Feature/Governance/GovernanceTracerTest.php#traces a real homepage publication item into deterministic inventory"
        status: pass
      - kind: integration
        ref: "php artisan list | rg 'governance:(inventory|check-release)'"
        status: pass
    human_judgment: false
  - id: D2
    description: "Separate human evidence is parsed strictly and pending or stale identity blocks with sanitized output."
    requirement: GOV-01
    verification:
      - kind: integration
        ref: "php artisan test --compact --filter=GovernanceTracer"
        status: pass
    human_judgment: false
  - id: D3
    description: "Concurrent and interrupted target writes cannot publish a partial successful inventory artifact."
    requirement: GOV-01
    verification:
      - kind: integration
        ref: "tests/Feature/Governance/GovernanceTracerTest.php#publishes only complete JSON when concurrent writers share a target"
        status: pass
    human_judgment: false

duration: 20min
completed: 2026-09-09
status: complete
---

# Phase 01 Plan 01: Governance Tracer Summary

**A real homepage observation now traverses deterministic identity, separate human evidence, and a sanitized fail-closed Artisan release decision.**

## Performance

- **Duration:** 20 min
- **Started:** 2026-09-09T11:21:37Z
- **Completed:** 2026-09-09T11:41:50Z
- **Tasks:** 2
- **Files modified:** 6

## Accomplishments

- Added `governance:inventory` to render the real named home route and record its main heading with a stable context-bound ID and exact UTF-8 SHA-256 hash.
- Added `governance:check-release` and a strict Markdown evidence reader so pending, stale, malformed, missing, duplicate, or unknown evidence fails closed without exposing claim text or controlled evidence locators.
- Made generated artifacts concurrency-safe with target-derived locks, sibling temporary files, durable flushes, and atomic rename while keeping approval data read-only.
- Preserved every protected route, config source, view, stylesheet, script, and public asset unchanged.

## Task Commits

Each TDD task was committed through RED then GREEN:

1. **Task 1 RED: homepage governance tracer contract** — `6656cca` (test)
2. **Task 1 GREEN: homepage observation-to-release tracer** — `17a6104` (feat)
3. **Task 2 RED: shared contract edge cases** — `151f027` (test)
4. **Task 2 GREEN: strict evidence and safe-write contracts** — `8f5eeb5` (feat)

## Files Created/Modified

- `app/Console/Commands/GenerateGovernanceInventory.php` — read-only deterministic inventory entry point.
- `app/Console/Commands/CheckGovernanceRelease.php` — fail-closed inventory/evidence join and sanitized report entry point.
- `app/Governance/GovernanceInventory.php` — publication identity, real homepage rendering, deterministic ordering, source boundaries, and atomic writing.
- `app/Governance/GovernanceEvidence.php` — shared-locked tagged Markdown reader with strict schema, status, and duplicate validation.
- `config/governance.php` — exact vocabulary, identity keys, scan/forbidden roots, evidence markers, and canonical artifact paths.
- `tests/Feature/Governance/GovernanceTracerTest.php` — 19 end-to-end and edge-case tests covering 90 assertions.

## Decisions Made

- Kept the planned `decision: no-change`: exact generated observations and human decisions remain separate representations joined by stable ID, hash, locale, route, and context.
- Derived stable IDs from locale, route, context, and repository-relative source so content edits change the content hash without losing item continuity.
- Kept approval and readiness out of config, environment variables, generated inventory, and editable evidence booleans.

## Deviations from Plan

None - plan executed exactly as written.

## Issues Encountered

- Laravel Boost `search-docs` was not exposed in this executor runtime. Per the required fallback, implementation used the installed Laravel 13.11.2/Pest 4 source and the repository's existing command/test conventions. No dependency was added.

## Verification

- `vendor/bin/pint --dirty --format agent` — passed.
- `php artisan test --compact --filter=GovernanceTracer` — 19 passed, 90 assertions.
- `php artisan test --compact` — 145 passed, 630 assertions.
- `php artisan list | rg 'governance:(inventory|check-release)'` — both commands registered.
- Protected public-surface diff (`routes`, observed configs, views, CSS, JavaScript, `public`) — empty.

## User Setup Required

None - no external service configuration required.

## Next Phase Readiness

Plan 01-02 can expand `GovernanceInventory` from the proven homepage tracer to all live routes, configured slugs, rendered/machine-readable content, media, analytics surfaces, sitemap values, and the dated baseline. Human approval remains intentionally unresolved and blocked.

## Self-Check: PASSED

All six implementation/test artifacts and this summary exist, and all four TDD task commits are present in Git history.

---
*Phase: 01-baseline-content-freeze-approval-gates*
*Completed: 2026-09-09*
