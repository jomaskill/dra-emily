---
phase: 1
slug: baseline-content-freeze-approval-gates
status: draft
nyquist_compliant: false
wave_0_complete: false
created: 2026-09-08
---

# Phase 1 — Validation Strategy

> Per-phase validation contract for feedback sampling during execution.

---

## Test Infrastructure

| Property | Value |
|----------|-------|
| **Framework** | Pest 4 with Laravel 13 feature and unit tests |
| **Config file** | `phpunit.xml`, `tests/Pest.php` |
| **Quick run command** | `php artisan test --compact --filter=Governance` |
| **Full suite command** | `php artisan test --compact` |
| **Estimated runtime** | ~30 seconds |

---

## Sampling Rate

- **After every task commit:** Run `php artisan test --compact --filter=Governance`
- **After every plan wave:** Run `php artisan test --compact`
- **Before `/gsd:verify-work`:** Full suite must be green and all manual release-gate evidence must be reviewed
- **Max feedback latency:** 60 seconds for focused automated checks

---

## Per-Task Verification Map

| Task ID | Plan | Wave | Requirement | Threat Ref | Secure Behavior | Test Type | Automated Command | File Exists | Status |
|---------|------|------|-------------|------------|-----------------|-----------|-------------------|-------------|--------|
| 01-01-01 | 01 | 1 | GOV-01 | T-01-01 | Inventory scans explicit public roots and excludes secrets/runtime data | feature | `php artisan test --compact --filter=PublicSurfaceInventory` | ❌ W0 | ⬜ pending |
| 01-01-02 | 01 | 1 | GOV-03 | Claims cannot become releasable without exact-context evidence and human approval | unit | `php artisan test --compact --filter=ClaimRegister` | ❌ W0 | ⬜ pending |
| 01-01-03 | 01 | 1 | GOV-04 | Patient evidence remains an opaque reference and incomplete media records block | unit | `php artisan test --compact --filter=MediaRegister` | ❌ W0 | ⬜ pending |
| 01-02-01 | 02 | 2 | GOV-05 | Scope-sensitive wording fails closed without dated CRO-MG or legal review | feature | `php artisan test --compact --filter=ReleaseGate` | ❌ W0 | ⬜ pending |
| 01-02-02 | 02 | 2 | GOV-06 | Missing, stale, or mismatched clinic operations remain blocked | unit | `php artisan test --compact --filter=OperationsRegister` | ❌ W0 | ⬜ pending |
| 01-02-03 | 02 | 2 | MEAS-03 | Analytics remains disabled without a complete approved production privacy decision | unit | `php artisan test --compact --filter=PrivacyDecision` | ❌ W0 | ⬜ pending |
| 01-03-01 | 03 | 3 | GOV-01, GOV-03, GOV-04, GOV-05, GOV-06, MEAS-03 | Release readiness is derived; missing, conflicting, stale, or unapproved evidence exits non-zero | feature | `php artisan test --compact --filter=GovernanceReleaseGate` | ❌ W0 | ⬜ pending |

*Status: ⬜ pending · ✅ green · ❌ red · ⚠️ flaky*

---

## Wave 0 Requirements

- [ ] `tests/Feature/Governance/PublicSurfaceInventoryTest.php` — route, configured procedure, sitemap, JSON-LD, asset, and invalid-slug inventory coverage for GOV-01
- [ ] `tests/Feature/Governance/ReleaseGateTest.php` — fail-closed integration cases across all Phase 1 requirements
- [ ] `tests/Unit/Governance/ClaimRegisterTest.php` — exact claim source, owner, review date, context hash, and approval schema for GOV-03
- [ ] `tests/Unit/Governance/MediaRegisterTest.php` — media classification, off-repository reference, attribution, context, and decision schema for GOV-04
- [ ] `tests/Unit/Governance/OperationsRegisterTest.php` — operational-domain completeness and stale/mismatch behavior for GOV-06
- [ ] `tests/Unit/Governance/PrivacyDecisionTest.php` — purpose, lawful basis, consent behavior, retention, access, configuration, and approval checks for MEAS-03

Existing Pest infrastructure is sufficient; no package installation is required.

---

## Manual-Only Verifications

| Behavior | Requirement | Why Manual | Test Instructions |
|----------|-------------|------------|-------------------|
| Clinical claim source judgment and approval are valid for exact release text | GOV-03 | Only Dra. Emily can provide clinical approval | Compare every `01-CLAIMS.md` item to its rendered context and controlled evidence reference; record reviewer, date, decision, and exact revision. |
| Patient provenance and written authorization permit the exact publication context | GOV-04 | Consent and provenance evidence is controlled and may contain sensitive data | Authorized custodian reviews every patient/unknown item in `01-MEDIA.md` against the off-repository record and records the context-specific decision without copying evidence into Git. |
| Current professional title and HOF wording are permissible | GOV-05 | Current CRO-MG or qualified legal interpretation cannot be automated | Reviewer checks every scope-sensitive visible and machine-readable occurrence in `01-PROFESSIONAL-WORDING.md`, records dated evidence and an explicit decision, and leaves unresolved wording blocked. |
| Clinic operations match current reality | GOV-06 | Hours, accessibility, response practices, and follow-up capacity require real-world observation | Clinic representative compares configured values/promises to operations, records observation date, verifier, evidence reference, status, and recheck date in `01-OPERATIONS.md`. |
| LGPD and consent decision is approved for production configuration | MEAS-03 | Lawful basis, retention, access, transfers, and consent behavior require accountable human approval | Privacy owner completes `01-PRIVACY-DECISION.md`, verifies the production environment remains non-collecting until approval, and records decision/date. |
| Baseline accurately represents the rendered site | GOV-01 | Accessibility, performance, and measurement observations include manual and environment-specific evidence | Review homepage, generic procedure, Full Face, and sitemap on representative mobile and desktop contexts; record tool/version/environment, limitations, and unavailable measures in `01-BASELINE.md`. |

---

## Validation Sign-Off

- [ ] All tasks have `<automated>` verification or Wave 0 dependencies
- [ ] Sampling continuity: no 3 consecutive tasks without automated verification
- [ ] Wave 0 covers all missing test references
- [ ] No watch-mode flags
- [ ] Feedback latency < 60 seconds for focused tests
- [ ] Full suite passes after each wave
- [ ] Human evidence is tied to the exact release revision; tests are not treated as approval
- [ ] `nyquist_compliant: true` set in frontmatter after validation coverage is implemented

**Approval:** pending
