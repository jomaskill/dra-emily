---
phase: 1
slug: baseline-content-freeze-approval-gates
status: draft
nyquist_compliant: false
wave_0_complete: false
created: 2026-09-08
updated: 2026-09-08
---

# Phase 1 — Validation Strategy

> Per-task contract for the final five-plan dependency graph. This remains draft and non-Nyquist until the tests exist and the accountable-human gate is satisfied.

---

## Test Infrastructure

| Property | Value |
|----------|-------|
| **Framework** | Pest 4 with Laravel 13 feature and unit tests |
| **Config file** | `phpunit.xml`, `tests/Pest.php` |
| **Quick run command** | `php artisan test --compact --filter=Governance` |
| **Full suite command** | `php artisan test --compact` |
| **Formatter command** | `vendor/bin/pint --dirty --format agent` before the focused Pest command for every PHP-modifying task and before final integration tests |

---

## Dependency and Sampling Contract

`01-01 (Wave 1) → 01-02 (Wave 2) → 01-03 + 01-04 in parallel (Wave 3) → 01-05 (Wave 4)`

- **After every task commit:** Run the focused command in the map below; every PHP-modifying task runs Pint first so Pest executes against the final formatted bytes.
- **After every wave:** If the wave modified PHP, run `vendor/bin/pint --dirty --format agent` before `php artisan test --compact`; otherwise run the compact suite directly.
- **Before Phase 1 verification:** The actual canonical release command must return success and `01-RELEASE-GATE.md` must say `Status: READY`; a `BLOCKED` result stops execution and cannot be treated as phase completion.
- **External evidence rule:** Automated tests may prove fail-closed behavior but cannot supply clinical, media, legal, operations, or privacy approval.
- **Feedback target:** Focused checks should return within 60 seconds; no watch-mode commands are permitted.

---

## Per-Task Verification Map

| Task ID | Plan | Wave | Requirement | Threat Ref | Secure Behavior | Test Type | Automated Command | File Exists | Status |
|---------|------|------|-------------|------------|-----------------|-----------|-------------------|-------------|--------|
| 01-01-01 | 01 | 1 | GOV-01 | T-01-01, T-01-02, T-01-03 | One real homepage item traverses inventory→separate pending evidence→non-zero gate without content/evidence disclosure | feature tracer | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=GovernanceTracer && php artisan list \| rg 'governance:(inventory\|check-release)'` | ❌ W0 | ⬜ pending |
| 01-01-02 | 01 | 1 | GOV-01 | T-01-01, T-01-04, T-01-05 | Identity, parsing, status, ordering, atomic write, and generated-vs-human boundaries fail closed | feature | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=GovernanceTracer` | ❌ W0 | ⬜ pending |
| 01-02-01 | 02 | 2 | GOV-01 | T-01-06, T-01-07, T-01-10 | Live routes/config/rendered output/assets/analytics/schema/sitemap are complete in both directions and deterministic | feature | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=PublicSurfaceInventory && php artisan governance:inventory` | ❌ W0 | ⬜ pending |
| 01-02-02 | 02 | 2 | GOV-01, MEAS-03 | T-01-08, T-01-09, T-01-10 | Exact-revision UI/performance/measurement matrix has direct evidence or explicit blockers without metric inflation | unit + evidence | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=BaselineRecord && php artisan test --compact --filter=PublicSurfaceInventory` | ❌ W0 | ⬜ pending |
| 01-03-01 | 03 | 3 | GOV-03 | T-01-11, T-01-13, T-01-14 | Claim empty/adjacency/encoding/status/order/duplicate/conflict/idempotency/shared-reader cases bind approval to exact context | unit | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=ClaimRegister` | ❌ W0 | ⬜ pending |
| 01-03-02 | 03 | 3 | GOV-04 | T-01-12, T-01-13, T-01-14 | Media empty/adjacency/encoding/privacy/order/duplicate/conflict/idempotency/shared-reader cases protect exact-context consent evidence | unit | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=MediaRegister` | ❌ W0 | ⬜ pending |
| 01-04-01 | 04 | 3 | GOV-05 | T-01-15, T-01-18, T-01-19 | Professional wording empty/adjacency/encoding/order/conflict/idempotency/shared-reader cases require current external review | unit | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=ProfessionalWordingRegister` | ❌ W0 | ⬜ pending |
| 01-04-02 | 04 | 3 | GOV-06 | T-01-16, T-01-18, T-01-19 | Operations domains keep configured/observed values separate and cover empty/order/mismatch/conflict/idempotency/shared-reader cases | unit | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=OperationsRegister` | ❌ W0 | ⬜ pending |
| 01-04-03 | 04 | 3 | MEAS-03 | T-01-17, T-01-18, T-01-19 | Privacy schema covers empty/encoding/order/conflict/production-state/idempotency/shared-reader cases while analytics remains unchanged | unit | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=PrivacyDecision` | ❌ W0 | ⬜ pending |
| 01-05-01 | 05 | 4 | GOV-01, GOV-03, GOV-04, GOV-05, GOV-06, MEAS-03 | T-01-20 through T-01-25 | All five validators are mandatory, exact-revision, deterministic, sanitized, read-concurrent, and atomically reported | feature integration | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=ReleaseGate && ! php artisan governance:check-release --inventory=.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json --evidence-dir=.planning/phases/01-baseline-content-freeze-approval-gates --baseline=.planning/phases/01-baseline-content-freeze-approval-gates/01-BASELINE.md --report=.planning/phases/01-baseline-content-freeze-approval-gates/01-RELEASE-GATE.md && rg '^Status: BLOCKED$' .planning/phases/01-baseline-content-freeze-approval-gates/01-RELEASE-GATE.md` | ❌ W0 | ⬜ pending |
| 01-05-02 | 05 | 4 | GOV-03, GOV-04, GOV-05, GOV-06, MEAS-03 | T-01-20, T-01-23, T-01-25 | Blocking human checkpoint requires five accountable roles and resolves all research open questions for one candidate | automated precheck + human action | `php artisan test --compact --filter=ReleaseGate` | ❌ W0 | ⬜ pending |
| 01-05-03 | 05 | 4 | GOV-01, GOV-03, GOV-04, GOV-05, GOV-06, MEAS-03 | T-01-20 through T-01-26 | Nine-category before/after comparison plus current external evidence is required for actual `READY` status | feature integration + evidence | `vendor/bin/pint --dirty --format agent && php artisan test --compact --filter=ReleaseGate && php artisan governance:check-release --inventory=.planning/phases/01-baseline-content-freeze-approval-gates/01-INVENTORY.json --evidence-dir=.planning/phases/01-baseline-content-freeze-approval-gates --baseline=.planning/phases/01-baseline-content-freeze-approval-gates/01-BASELINE.md --report=.planning/phases/01-baseline-content-freeze-approval-gates/01-RELEASE-GATE.md && rg '^Status: READY$' .planning/phases/01-baseline-content-freeze-approval-gates/01-RELEASE-GATE.md && php artisan test --compact` | ❌ W0 | ⬜ pending |

*Status: ⬜ pending · ✅ green · ❌ red · ⚠️ flaky*

---

## Wave 0 Requirements

- [ ] `tests/Feature/Governance/GovernanceTracerTest.php` — one-path integration plus identity, strict parsing, deterministic ordering, empty-set, safe-write, and generated/human boundary coverage.
- [ ] `tests/Feature/Governance/PublicSurfaceInventoryTest.php` — live route, configured procedure/article, invalid-slug, Blade/config/assets, analytics, JSON-LD, and sitemap inventory coverage in both directions.
- [ ] `tests/Unit/Governance/BaselineRecordTest.php` — exact-revision UI matrix, viewport/state/evidence-or-blocker schema, append-only identity, and metric-language contract.
- [ ] `tests/Unit/Governance/ClaimRegisterTest.php` — every GOV-03 edge truth with explicit empty, adjacency, encoding, status, ordering, duplicate/conflict, idempotency, and shared-reader fixtures.
- [ ] `tests/Unit/Governance/MediaRegisterTest.php` — every GOV-04 edge truth plus sensitive-data rejection and non-disclosure assertions.
- [ ] `tests/Unit/Governance/ProfessionalWordingRegisterTest.php` — every GOV-05 edge truth and exact current external-review binding.
- [ ] `tests/Unit/Governance/OperationsRegisterTest.php` — every GOV-06 domain and empty, adjacency, encoding, ordering, mismatch, duplicate/conflict, idempotency, and shared-reader behavior.
- [ ] `tests/Unit/Governance/PrivacyDecisionTest.php` — every MEAS-03 field and empty, encoding, ordering, duplicate/conflict, deployed-state, idempotency, and shared-reader behavior.
- [ ] `tests/Feature/Governance/ReleaseGateTest.php` — all five validators, exact revision, fail-closed status matrix, deterministic ordering, duplicate/conflict, idempotency, concurrency, sanitization, report atomicity, nine-category comparison, and actual release-state integration.

Existing Laravel/Pest/Symfony tooling is sufficient. No package installation or dependency change is planned.

---

## Blocking Human Evidence Checkpoint

| Accountable role | Requirement | Required decision/evidence | Research question closed |
|------------------|-------------|----------------------------|--------------------------|
| Dra. Emily + named content owner | GOV-03 | Exact claim/context source, owner, reviewed date, validity, opaque evidence locator, approval/quarantine decision, exact candidate revision | OQ-1, OQ-2, OQ-5 |
| Authorized media custodian | GOV-04 | Classification of every image/testimonial, controlled provenance/authorization systems, responsible professional, context decision, validity | OQ-1, OQ-2, OQ-3, OQ-5 |
| CRO-MG or qualified counsel | GOV-05 | Current professional registration evidence plus dated August-2026-sensitive HOF/title decision, applicability, validity/recheck, opaque locator | OQ-1, OQ-2, OQ-5 |
| Clinic operations verifier | GOV-06 | Current observed identity/contact/hours/directions/accessibility/WhatsApp/response/follow-up facts, verifier, evidence, recheck | OQ-1, OQ-2, OQ-5 |
| Named privacy owner | MEAS-03 | Controller/processors, actual production tags/consent/collection state, purpose, data, lawful basis, retention, access, transfers, deny/revoke, decision, validity | OQ-1, OQ-2, OQ-4, OQ-5 |

The executor may seed pending records, implement validators, generate a `BLOCKED` report, and explain the requested fields. It must stop at 01-05-02 when any accountable evidence is unavailable. It must not invent facts, select decisions, change pending to approved, bypass the checkpoint, create a completion summary, or mark Phase 1 complete.

---

## Public-Freeze Comparison Contract

The final comparison must bind both sides to the same baseline run, inventory/public-surface digest, exact candidate revision and dirty-tree description, environment, browser/tool metadata, and evidence locators.

| Required category | Pass condition | Explicit failure conditions |
|-------------------|----------------|-----------------------------|
| Rendered DOM | Same route-specific structure and semantic output | Node/attribute addition, removal, mutation, missing route/state, or capture failure |
| Visible copy | Byte-equivalent rendered Portuguese copy per route/context | Added/removed/changed text, normalization hiding byte changes, missing context |
| Computed style | Same relevant typography/color/spacing/layout/visibility values at assigned viewports/states | Changed value, hidden content, missing viewport/state, unavailable capture |
| Assets | Same source/derivative identity, content hash, dimensions, and rendered context | Added/removed/changed asset, crop/loading context drift, missing evidence |
| Interactions | Same keyboard/pointer/no-JS navigation, CTA, disclosure, focus, and destination behavior | Changed target/state/order/activation, message send, missing interaction evidence |
| Network and storage | Same requests, scripts, cookies/local/session storage behavior under the same scenario | New/removed/changed request or storage mutation, sensitive URL capture, missing trace |
| Structured data and metadata | Byte/semantic-equivalent JSON-LD and document metadata for each route | Added/removed/changed property/value/node, parse failure, missing visible mapping |
| Sitemap | Same parseable URL/image/title set, order contract, and content type | Added/removed/changed value, duplicate/omission, parse/content-type failure |
| Analytics | Same configured-versus-observed collection state without enabling tracking | New collection/event/tag/identifier, changed consent behavior, or production state `not measured` |

Any addition, removal, mutation, missing category, baseline/candidate identity mismatch, raw capture failure, or required `not_measured` record is blocking. Source inspection and a different route, viewport, or environment cannot substitute for assigned rendered evidence.

---

## Validation Sign-Off

- [ ] Every final task ID/wave matches the five PLAN files.
- [ ] Every task has an `<automated>` command; checkpoint 01-05-02 also has accountable human verification.
- [ ] Sampling continuity has no three consecutive tasks without automated verification.
- [ ] All nine Wave 0 test files exist and every named RED fixture has been observed failing before implementation.
- [ ] Focused tests pass after their owning tasks; full suite passes after each wave.
- [ ] Pint runs before every focused Pest command for PHP-modifying tasks, before the post-wave full suite, and before final integration tests so all assertions exercise final formatted bytes.
- [ ] The five accountable roles supplied exact-revision evidence and all five research open questions are closed.
- [ ] The nine-category before/after comparison is complete and has no changed, missing, failed, unavailable, or mismatched result.
- [ ] Actual `governance:check-release` exits zero and `01-RELEASE-GATE.md` says `Status: READY` for the exact candidate.
- [ ] `nyquist_compliant: true`, `wave_0_complete: true`, and `status: complete` are set only after all preceding conditions are proven.

**Approval:** pending; external evidence checkpoint and implementation are not yet complete.
