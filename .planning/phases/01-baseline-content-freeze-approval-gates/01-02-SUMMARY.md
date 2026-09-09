---
phase: 01-baseline-content-freeze-approval-gates
plan: 02
subsystem: governance
tags: [laravel, artisan, pest, inventory, baseline, accessibility, analytics]

requires:
  - phase: 01-baseline-content-freeze-approval-gates
    plan: 01
    provides: Deterministic publication identity, strict evidence separation, and atomic inventory publishing
provides:
  - Complete deterministic inventory of repository-owned public routes and publication surfaces
  - Revision-bound accessibility, responsive, performance, and measurement baseline
  - Bidirectional inventory and baseline schema contracts
affects: [01-03-claims-media, 01-04-professional-operations-privacy, 01-05-release-gate, 05-release-quality]

actuals:
  tokens: 751014
  tasks: 2
  commits: 5

tech-stack:
  added: []
  patterns: [live route expansion, rendered-plus-source reconciliation, stable item payload digest, append-only evidence runs, honest unavailable-measurement blockers]

key-files:
  created:
    - .planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json
    - .planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.md
    - .planning/phases/01-baseline-content-freeze-approval-gates/01-BASELINE.md
    - tests/Feature/Governance/PublicSurfaceInventoryTest.php
    - tests/Unit/Governance/BaselineRecordTest.php
  modified:
    - app/Console/Commands/GenerateGovernanceInventory.php
    - app/Governance/GovernanceInventory.php

key-decisions:
  - "Repository-owned named GET routes and current procedure/article configuration keys are authoritative; Laravel vendor routes are excluded from the public publication inventory."
  - "The stable ordered item payload is digestible independently from mutable run metadata and append-only browser evidence."
  - "Unavailable browser, production, zoom, reduced-motion, keyboard, analytics, or downstream WhatsApp evidence remains explicitly not measured with date, reason, and owner."

patterns-established:
  - "Dual-source completeness: rendered responses are reconciled with route, configuration, Blade, and public-asset enumeration rather than replaced by source inspection."
  - "Stable reruns: same-tree generation preserves byte-equivalent ordered item data while run metadata records the exact revision and dirty-tree identity."
  - "Measurement precision: a configured analytics surface, observed collection, WhatsApp link activation, and downstream clinic outcomes are separate facts."

requirements-completed: [GOV-01, MEAS-03]

coverage:
  - id: D1
    description: "Every repository-owned public route, configured slug, rendered publication category, sitemap value, public asset, and configured assertion is represented bidirectionally in the canonical inventory."
    requirement: GOV-01
    verification:
      - kind: integration
        ref: "php artisan test --compact --filter=PublicSurfaceInventory"
        status: pass
      - kind: integration
        ref: "php artisan governance:inventory"
        status: pass
    human_judgment: false
  - id: D2
    description: "A dated, revision-bound baseline records representative public pages, responsive states, machine-readable output, measurement boundaries, direct observations, and explicit unavailable-evidence blockers."
    requirement: MEAS-03
    verification:
      - kind: unit
        ref: "php artisan test --compact --filter=BaselineRecord"
        status: pass
      - kind: manual_procedural
        ref: ".planning/phases/01-baseline-content-freeze-approval-gates/01-BASELINE.md#baseline-2026-09-09-local-herd-55be224"
        status: unknown
    human_judgment: true
    rationale: "The end-of-phase owner review must compare each opaque browser evidence locator and accept the explicitly blocked not-measured rows; automation validates the record contract but cannot grant that judgment."
  - id: D3
    description: "Inventory and baseline work leaves routes, observed content configs, views, CSS, JavaScript, and public assets unchanged."
    requirement: GOV-01
    verification:
      - kind: other
        ref: "git diff --name-only -- routes config/clinic.php config/procedures.php config/articles.php config/faq.php resources/views resources/css resources/js public"
        status: pass
      - kind: integration
        ref: "php artisan test --compact"
        status: pass
    human_judgment: false

duration: 4h37m
completed: 2026-09-09
status: complete
---

# Phase 01 Plan 02: Complete Public Inventory and Baseline Summary

**The current Laravel site now has a 3,589-observation public-surface inventory and an append-only, revision-bound baseline that preserves both direct browser findings and honest evidence gaps.**

## Performance

- **Duration:** 4h37m
- **Started:** 2026-09-09T12:09:22Z
- **Completed:** 2026-09-09T16:46:41Z
- **Tasks:** 2
- **Files modified:** 7

## Accomplishments

- Expanded the Plan 01-01 homepage tracer into a canonical scan of every repository-owned public route, all eight procedure slugs, all four article slugs, invalid-slug behavior, rendered HTML, JSON-LD, sitemap XML, conversions, media, analytics surfaces, configured assertions, source fingerprints, and public assets.
- Generated 3,589 deduplicated observations across 12 categories with 3,589 discovered and inventoried items, no scan errors, no omissions, and no unresolved parameterized routes.
- Captured the pre-change local Herd experience in an append-only baseline tied to revision `55be224238cbe07e2a79f3234284242315c1daef`, its exact dirty-tree identity, direct 320/768/1440 browser observations, and explicit blockers for unavailable evidence.
- Preserved measurement semantics: the report never equates a configured analytics surface or WhatsApp link activation with message delivery, conversation, appointment, attendance, clinical eligibility, qualified lead, patient, or revenue.
- Preserved the entire protected public application surface unchanged.

## Task Commits

1. **Task 1 RED:** `844bc6e` — `test(01-02): define complete public inventory contract`
2. **Task 1 GREEN:** `520afaf` — `feat(01-02): inventory complete public surface`
3. **Task 2 RED:** `b8a60fc` — `test(01-02): define baseline evidence contract`
4. **Task 2 GREEN:** `f7130e6` — `docs(01-02): record dated public baseline`
5. **Plan metadata:** committed with this summary, `STATE.md`, and `ROADMAP.md`.

## Files Created/Modified

- `app/Console/Commands/GenerateGovernanceInventory.php` — selects canonical full scans while retaining the Plan 01-01 isolated-output tracer contract and reports category totals.
- `app/Governance/GovernanceInventory.php` — expands live public routes, parses rendered and machine-readable content, fingerprints sources/assets, sanitizes destinations, and writes deterministic artifacts atomically.
- `.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json` — machine-readable 3,589-item canonical inventory envelope.
- `.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.md` — human-reviewable inventory and freeze manifest.
- `.planning/phases/01-baseline-content-freeze-approval-gates/01-BASELINE.md` — append-only dated browser, accessibility, responsive, performance, and measurement evidence/blocker register.
- `tests/Feature/Governance/PublicSurfaceInventoryTest.php` — complete-route, category, determinism, sanitization, and bidirectional coverage contract.
- `tests/Unit/Governance/BaselineRecordTest.php` — provenance, matrix completeness, evidence-or-blocker, digest, and metric-language contract.

## Decisions Made

- Excluded framework/vendor routes from the public publication union by requiring application-controller, route-file closure, or explicitly supported view-controller ownership.
- Kept the canonical full scan as the default command behavior while preserving the earlier one-item tracer only for isolated custom outputs that do not request a report.
- Bound the baseline to a digest of the stable ordered item array so mutable generation metadata cannot invalidate equivalent publication contents.
- Recorded unavailable 200% zoom, complete keyboard traversal, reduced-motion emulation, no-JavaScript WhatsApp, production analytics, and downstream clinic outcome evidence as blocked `not measured`, never as inferred passing results.

## Deviations from Plan

### Auto-fixed Issues

**1. [Rule 1 - Bug] Preserved the Plan 01-01 isolated-output tracer contract**

- **Found during:** Task 2 full-suite verification
- **Issue:** The expanded default command caused two existing `GovernanceTracer` tests to receive the full schema-2 inventory instead of their expected single schema-1 homepage observation when using a custom temporary output path.
- **Fix:** Added an explicit compatibility snapshot for isolated custom output without `--report`; the canonical default and explicit report paths continue to produce the complete inventory.
- **Files modified:** `app/Console/Commands/GenerateGovernanceInventory.php`, `app/Governance/GovernanceInventory.php`
- **Verification:** `php artisan test --compact --filter=GovernanceTracer` passed 19 tests/90 assertions, and the full suite passed.
- **Committed in:** `520afaf`

---

**Total deviations:** 1 auto-fixed (1 Rule 1 bug)
**Impact on plan:** The fix was required for backward compatibility and did not change the canonical inventory, public application surface, dependencies, or APIs.

## Issues Encountered

- Laravel Boost `search-docs` and `get-absolute-url` were not exposed in this executor runtime, and the Context7 CLI fallback was unavailable. The implementation therefore used installed Laravel 13.11.2/Pest 4 source, application configuration, and repository conventions; the base URL was resolved from the local Laravel/Herd configuration and verified in the browser. No dependency was added.
- The browser runtime did not expose reliable 200% zoom, complete keyboard traversal, reduced-motion emulation, no-JavaScript WhatsApp, or production analytics capture. Each gap is retained in the baseline as a dated, owned `not measured` blocker.
- Representative 768px/1440px initial captures sometimes observed fade/scale content while still transparent; this in-flight result is preserved as evidence and was not remediated during the freeze plan.

## Verification

- `vendor/bin/pint --dirty --format agent` — passed.
- `php artisan test --compact --filter=PublicSurfaceInventory` — 4 passed, 50,321 assertions.
- `php artisan test --compact --filter=BaselineRecord` — 3 passed, 485 assertions.
- `php artisan test --compact --filter=GovernanceTracer` — 19 passed, 90 assertions.
- `php artisan test --compact` — 152 passed, 51,436 assertions.
- `php artisan governance:inventory` — passed; 3,589/3,589 observations, 12 categories, zero errors, zero omissions, zero unresolved routes.
- `jq empty .planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json` — passed.
- Stable ordered item digest — `13e97d56a6281e3c198e3ceb6e38d9752020919911023e5ac080216f40609905`, matching the baseline record.
- Protected public-surface diff (`routes`, observed configs, views, CSS, JavaScript, `public`) — empty.
- Final browser console warning/error collection — empty.

## Known Stubs

None.

## Threat Flags

None. The plan added no network endpoint, authentication path, schema, dependency, public route, or public file-access behavior beyond the planned read-only governance scan and artifact writers.

## User Setup Required

None - no external service configuration required.

## Next Phase Readiness

Plan 01-03 can classify the exact claims and patient media represented by the frozen inventory. The external clinical, professional/advertising, patient-media, privacy, and clinic-operations approvals remain intentionally unresolved release blockers; this plan does not infer or grant them.

## Self-Check: PASSED

All seven implementation, test, inventory, and baseline artifacts plus this summary exist. The inventory parses, its stable payload digest matches the baseline, every focused and full test passes, no protected public-surface file changed, and the four implementation/test commits are present on the current branch.

---
*Phase: 01-baseline-content-freeze-approval-gates*
*Completed: 2026-09-09*
