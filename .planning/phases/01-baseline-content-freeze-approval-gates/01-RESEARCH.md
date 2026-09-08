# Phase 1: Baseline, Content Freeze & Approval Gates - Research

**Researched:** 2026-09-08
**Domain:** Release governance, content inventory, evidence gates, and baseline measurement
**Confidence:** HIGH for repository architecture and phase constraints; MEDIUM for the completeness of human-review evidence until stakeholders supply it

<user_constraints>
## User Constraints (from CONTEXT.md)

### Locked Decisions

### Complete release inventory
- **D-01 / GOV-01:** The repository must contain a complete inventory of every public page, conversion path, clinical claim, professional claim, patient image, testimonial, analytics integration, and structured-data output before later release work proceeds.
- The inventory must distinguish visible content from machine-readable content and record a dated accessibility, performance, and measurement baseline.

### Clinical claim governance
- **D-02 / GOV-03:** Every clinical claim intended for publication must have an identifiable source, content owner, last-reviewed date, and recorded approval from Dra. Emily.
- A claim without complete evidence must be excluded from the release set or explicitly quarantined; repository status must not imply clinical approval.

### Patient media governance
- **D-03 / GOV-04:** Every patient image or testimonial intended for publication must have off-repository provenance, written authorization, responsible-professional attribution, and a current decision confirming use is permitted in the exact publishing context.
- Unsupported or undecided patient media must remain blocked from release. The repository must not store sensitive consent evidence when a reference to the controlled off-repository record is sufficient.

### Professional and HOF wording
- **D-04 / GOV-05:** Scope- and specialty-sensitive HOF wording cannot be released until a dated CRO-MG or qualified legal review addresses the current August 2026 regulatory uncertainty.
- Unverified professional titles, specialties, qualifications, or scope-sensitive wording remain blocked; implementation must not infer the outcome of external review.

### Clinic operations
- **D-05 / GOV-06:** Clinic identity, address, contact details, opening hours, directions, accessibility information, WhatsApp operations, and follow-up promises must be verified against current real-world operations before release.
- Missing or stale operational facts must remain visibly unresolved in governance evidence and must not be converted into public promises.

### Analytics and LGPD
- **D-06 / MEAS-03:** Analytics remains disabled until a documented LGPD and consent decision records purpose, lawful basis, configuration, retention, access, and consent behavior and is approved for the production release.
- Phase 1 records the decision and baseline only; consent-gated WhatsApp event implementation belongs to Phase 4.

### Safety and release boundaries
- The site is a public acquisition experience for consultation, not diagnosis, candidacy assessment, informed consent, clinical intake, or a guarantee of treatment or outcome.
- No automated diagnosis, face scoring, selfie analysis, treatment recommendation, guaranteed result, risk-free claim, coercive urgency, price-led promotion, unsupported patient evidence, open-ended health intake, booking, CRM, chatbot, portal, or framework replacement enters this phase.
- Human approval gates are evidence requirements, not values that implementation may fabricate or auto-approve.

### the agent's Discretion
- Exact repository file names, schemas, scripts, test organization, and report layout used to make the baseline repeatable and easy to review.
- Choice of existing Laravel, Blade, PHP, shell, or package-provided mechanisms for deterministic inventory and verification, without changing dependencies or public application behavior.
- How unresolved items are represented so long as release state fails closed and the missing human decision is explicit.

### Deferred Ideas (OUT OF SCOPE)
- Canonical verified identity, shared trust components, safe WhatsApp prefills, and privacy-boundary UI are Phase 2.
- Consultation-first page redesign, procedure content, objection handling, accessibility implementation, and CTA placement are Phase 3.
- Consent-gated analytics instrumentation and debug validation are Phase 4.
- SEO, structured-data hardening, performance work, broad automated quality gates, and production release verification are Phase 5.
- Outcome reconciliation, minimum-evidence rules, and usability-session operations are Phase 6.
- Campaign landing pages, A/B tests, CRM, direct scheduling, private intake, patient portals, and messaging automation remain v2 or out of scope.
</user_constraints>

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|---|---|---|
| GOV-01 | Review a complete inventory of public pages, conversion paths, claims, patient media, analytics, and structured data before release. | Deterministic source inventory plus rendered-surface and baseline artifacts. |
| GOV-03 | Every published clinical claim has source, owner, review date, and Dra. Emily approval. | Claim register with evidence completeness and fail-closed release disposition. |
| GOV-04 | Every published patient image/testimonial has provenance, authorization, attribution, and context-specific decision. | Media register containing non-sensitive off-repository evidence references only. |
| GOV-05 | HOF wording remains blocked pending dated CRO-MG or qualified legal review. | Professional-wording register and explicit unresolved external gate. |
| GOV-06 | Clinic and contact operations are verified against reality before release. | Operational-facts register with verifier, observed date, evidence reference, and expiry/recheck status. |
| MEAS-03 | Analytics follows a documented, approved LGPD and consent decision. | Privacy decision record and current no-collection baseline; Phase 1 does not instrument events. |
</phase_requirements>

## Summary

Phase 1 should add a repository-owned governance layer beside the existing Laravel application, not refactor the application itself. The site currently derives public routes and much of its visible and machine-readable content from `routes/web.php`, `config/clinic.php`, `config/procedures.php`, `config/faq.php`, Blade pages/partials, and public assets. [VERIFIED: routes/web.php:6-16; config/clinic.php:5-31; config/procedures.php:29 onward] The research artifacts should freeze exactly what those sources and rendered pages publish on a dated revision, then overlay human evidence and explicit release dispositions.

Use two complementary mechanisms: deterministic inventory for facts the repository can prove, and review registers for decisions only humans can make. Automation may prove that an item is catalogued, that required fields are present, and that a blocked item cannot satisfy a release check. It must never populate `approved` on behalf of Dra. Emily, counsel/CRO-MG, a privacy decision-maker, or clinic operations staff. Missing, stale, ambiguous, or mismatched evidence resolves to `blocked`, never to implicit acceptance.

**Primary recommendation:** Create reviewable Markdown/JSON-or-PHP artifacts under the existing Phase 1 directory, backed by a read-only Artisan inventory command and focused Pest tests; leave dependencies and rendered public behavior unchanged.

## Architectural Responsibility Map

| Capability | Primary Tier | Secondary Tier | Rationale |
|---|---|---|---|
| Source and rendered-content inventory | Laravel application / CLI | Blade/config | Laravel can enumerate routes/config/assets and render pages deterministically. |
| Clinical and professional approvals | Governance evidence | Laravel release check | Humans own decisions; code only validates recorded evidence. |
| Patient-media authorization | Controlled off-repository system | Governance reference | Consent material may be sensitive; repository stores only reference and disposition. |
| Operational verification | Clinic operations | Governance evidence | Real-world observations cannot be inferred from config defaults. |
| LGPD/analytics decision | Privacy owner/legal reviewer | Configuration inventory | Phase records the decision and current analytics surface without enabling tracking. |
| Accessibility/performance/measurement baseline | Review evidence | Rendered public pages | Baselines describe the dated current state; remediation is deferred. |

## Recommended Artifacts

Keep all Phase 1 evidence under `.planning/phases/01-baseline-content-freeze-approval-gates/` so it is reviewable without creating a new application subsystem. Recommended files:

| Artifact | Purpose | Required contents |
|---|---|---|
| `01-INVENTORY.md` | Human-readable release inventory and dated freeze manifest | Git revision/date/environment; every route; visible and machine-readable source; conversion paths; claims; assets/testimonials; analytics; JSON-LD; sitemap; baseline links; omissions explicitly stated. |
| `01-INVENTORY.json` | Deterministic machine-readable output | Stable IDs, category, source file/line or rendered URL/selector, visibility (`visible`/`machine_readable`/`both`), content hash, and generated timestamp/revision. No approval fields generated by scanning. |
| `01-CLAIMS.md` | Clinical-claim review register | Stable claim ID, exact text, contexts, source, content owner, last-reviewed date, Dra. Emily approval evidence reference, decision, and release disposition. |
| `01-MEDIA.md` | Patient image/testimonial register | Asset/testimonial ID, public contexts, classification (`patient`/`professional`/`illustrative`/`unknown`), provenance reference, written-authorization reference, responsible professional, context-specific decision/date, and release disposition. Never embed consent documents. |
| `01-PROFESSIONAL-WORDING.md` | Identity, title, qualification, specialty, and HOF review | Exact wording and every visible/schema context, current CRO evidence reference, reviewer and date, scope-sensitive flag, decision, and blocked reason. |
| `01-OPERATIONS.md` | Clinic operations verification | Identity, address, phone/WhatsApp, hours, directions, accessibility, response/follow-up promises; configured value, observed value, verifier/date, evidence reference, status, and recheck date. |
| `01-PRIVACY-DECISION.md` | MEAS-03 decision record | Controller/processors, purposes, data/parameters, lawful basis, consent trigger and deny/revoke behavior, retention, access roles, transfers, production configuration, approver/date, decision, and unresolved questions. |
| `01-BASELINE.md` | Dated accessibility, performance, and measurement baseline | Pages/viewports/tools, raw observations, run date/environment, limitations; WhatsApp clicks explicitly distinguished from conversations, appointments, attendance, eligibility, patients, and revenue. |
| `01-RELEASE-GATE.md` | Single fail-closed readiness summary | Exact content revision, required registers, unresolved/expired/missing counts by gate, current human decisions, and `BLOCKED` unless every required external decision exists for that revision. |

The planner may combine the machine-readable schema into PHP arrays if that better matches local conventions, but the generated inventory and human-authored approvals must remain separate. This prevents regenerating an inventory from overwriting or fabricating evidence.

## Exact Existing Files in Scope

| Surface | Existing files | Inventory responsibility |
|---|---|---|
| Public route set | `routes/web.php`, `app/Http/Controllers/ProcedureController.php` | `/`, each configured `/procedimentos/{slug}`, and `/sitemap.xml`; include invalid-slug behavior. |
| Clinic and analytics config | `config/clinic.php` | WhatsApp, CRO, Instagram, city/state/address/coordinates/domain, Google verification/business URL, and GA4 ID. These are configured assertions, not verified operations or approvals. |
| Procedure claims | `config/procedures.php` | All card, title, metadata, hero, facts, explanatory paragraphs, benefits, steps, FAQ, Full Face-specific fields, view selection, and image references. |
| Homepage FAQ | `config/faq.php` | Visible FAQ and corresponding schema claims. |
| Shared document metadata | `resources/views/components/site-layout.blade.php` | Titles, descriptions, canonical/Open Graph/Twitter metadata, verification tags, stylesheet/script inclusions, and schema slot. |
| Homepage visible content | `resources/views/welcome.blade.php` | Headings, clinician/clinic wording, CTAs, testimonials, before/after content, promises, disclosures, and configured procedure/FAQ use. |
| Generic procedure page | `resources/views/procedure.blade.php` | Visible procedure content, CTAs, FAQ, media, and schema inclusion. |
| Specialized procedure page | `resources/views/procedures/full-face.blade.php` | Additional Full Face visible claims, CTAs, and media contexts. |
| Shared navigation/contact | `resources/views/partials/nav.blade.php`, `resources/views/partials/footer.blade.php` | Contact paths, identity, location, social/map/WhatsApp links, and cross-page consistency. |
| Machine-readable output | `resources/views/partials/schema.blade.php`, `resources/views/partials/procedure-schema.blade.php`, `resources/views/sitemap.blade.php` | Every JSON-LD node/property/value and sitemap URL/image/title; map each claim back to visible content or mark machine-readable-only. |
| Public media | `public/*.jpg`, `public/*.webp`, `public/*.png`, `public/procedures/*` | Every source/derivative, all rendering contexts, role/classification, metadata check, and media decision. Treat filename as no proof of patient status or authorization. |
| Existing verification | `tests/Feature/HomeSchemaTest.php`, `tests/Feature/ExampleTest.php`, `tests/Pest.php`, `phpunit.xml`, `composer.json` | Extend Pest conventions; preserve existing FAQ/schema parity contract and application scripts. |
| Frontend baseline | `resources/css/app.css`, `resources/js/app.js`, `vite.config.js`, `package.json`, `public/build/manifest.json` | Asset/build inputs and current bundle state; no design or tracking change in Phase 1. |

The current route union is verbatim: `home`, `procedure`, and `sitemap`, with procedure slugs constrained by `array_keys(config('procedures'))`. [VERIFIED: routes/web.php:6-16] The inventory must enumerate the actual configured procedure keys rather than documenting only the route template.

## Fail-Closed Approval Model

Use a small, explicit decision vocabulary in human-maintained evidence: `pending`, `approved`, `rejected`, `quarantined`, and `expired`. [ASSUMED: recommended schema; planner must confirm exact enum before implementation] Derive release eligibility; never store a freely editable `release_ready: true` as the authority.

An item is releasable only when all predicates relevant to its category are true:

```text
inventory item exists for exact content hash/revision
AND every required evidence reference is present
AND each required human decision is explicitly approved
AND approval applies to the exact wording/asset/context
AND review has not expired or been superseded
AND no conflicting or unresolved record exists
= eligible

otherwise = blocked
```

Category rules:

- Clinical claim: source + owner + last-reviewed date + explicit Dra. Emily approval for exact text/context.
- Patient image/testimonial: non-sensitive provenance reference + written-authorization reference + responsible-professional attribution + exact-context approval.
- Professional/HOF wording: current professional evidence plus dated CRO-MG or qualified legal review wherever scope-sensitive.
- Operational fact/promise: observed real-world value, responsible verifier, verification date, and evidence reference.
- Analytics: complete privacy decision and explicit approval for the production configuration; until then the gate remains blocked and Phase 1 must not enable collection.

The gate command should exit non-zero for missing files, malformed records, duplicate IDs, stale hashes, absent fields, pending/rejected/quarantined/expired status, or content present in a scan but absent from a register. It should print actionable item IDs and reasons while avoiding sensitive evidence content.

## Architecture Patterns

### Pattern 1: Deterministic scan, human adjudication

Implement a read-only Artisan command under `app/Console/Commands/` that enumerates Laravel routes, configured procedures/FAQ/clinic fields, Blade sources, public media, and rendered JSON-LD/sitemap surfaces. Store stable IDs and hashes. The command may generate inventory output but must not edit content registers or infer categories that require human judgment.

### Pattern 2: Bidirectional completeness checks

Check both directions: every discovered surface must be represented in the inventory, and every register entry must resolve to a currently discovered surface or an explicit quarantined historical record. This detects both undocumented publication and stale approvals.

### Pattern 3: Exact-context approval

Approval binds to content hash, route/context, locale, and asset identity—not merely a topic such as “Botox approved.” One source claim reused in visible copy, metadata, FAQ, and JSON-LD must list every context because meaning can change with surrounding wording.

### Pattern 4: Evidence references, not evidence payloads

Use opaque controlled-system references for patient consent, legal advice, and other sensitive documents. Repository records may contain responsible role, decision, date, context, and reference locator, but not patient identifiers, health data, signatures, consent scans, or legal correspondence.

## Standard Stack

No package installation is needed or permitted without approval. Use the existing Laravel 13 application, PHP 8.4 conventions, Artisan commands, Blade/config inspection, and Pest 4 feature/unit tests. [VERIFIED: AGENTS.md; composer.json] Keep the public site server-rendered and configuration-backed.

## Don't Hand-Roll

| Problem | Do not build | Use instead |
|---|---|---|
| Route discovery/rendering | A second URL manifest | Laravel route collection plus named-route rendering. |
| Content parsing | A fragile regex-only HTML/Blade parser as sole authority | Source enumeration plus rendered-response assertions and targeted extraction. |
| Approval workflow | A database CMS, authentication system, or automated approver | Reviewable repository registers with off-repository evidence references and named human decisions. |
| Cryptographic/security primitives | Custom signing or encryption | Content hashes from PHP standard functions; sensitive originals remain in controlled systems. |
| Accessibility/performance remediation | Phase 1 redesign or optimization | Record dated observations and defer fixes to assigned later phases. |

## Common Pitfalls

### Inventorying files but not publication surfaces

One config string may appear in page text, metadata, WhatsApp prefill, JSON-LD, sitemap, and images. Inventory rendered contexts as well as sources and explicitly label visible versus machine-readable output.

### Treating config defaults as verified truth

`config/clinic.php` currently contains defaults for contact, CRO, address, coordinates, map destination, and GA4 identifier. [VERIFIED: config/clinic.php:5-31] These values are candidates for operational/professional/privacy verification, not evidence that verification occurred.

### Conflating scan completeness with approval

A green inventory test means “catalogued,” not “clinically/legal/privacy approved.” Keep generated data and human decisions separate and report both statuses.

### Approving a source phrase while schema still differs

Structured-data partials contain professional titles, procedure descriptions, hours, payment methods, and clinical terms. Inventory exact rendered JSON-LD values independently and link them to approval records.

### Storing sensitive consent evidence in Git

Consent scans, patient identity, case details, signatures, and health information do not belong in these artifacts. Only record an opaque reference and the minimum governance metadata.

### Baseline contamination

Capture revision, timestamp, environment, viewport/tool settings, and raw result locations before any copy, structure, tracking, or asset change. If the working tree is dirty, record the exact tree state rather than claiming a clean Git revision represents the render.

### Metric inflation

A literal WhatsApp link activation is not a conversation, appointment, attendance, clinical eligibility, patient, or revenue. The Phase 1 measurement baseline must keep these terms separate and report unavailable measures as unavailable.

## Validation Architecture

### Test Framework

| Property | Value |
|---|---|
| Framework | Pest 4 on Laravel's feature-test harness |
| Config | `phpunit.xml`, `tests/Pest.php` |
| Quick run | `php artisan test --compact --filter=Governance` |
| Full run | `php artisan test --compact` |
| Existing relevant contract | `tests/Feature/HomeSchemaTest.php` validates visible FAQ/schema consistency and absence of self-serving review markup. |

### Recommended Test Organization

- `tests/Feature/Governance/PublicSurfaceInventoryTest.php`: every named public route and configured procedure renders and is represented; invalid slugs remain 404; sitemap and JSON-LD are parsed.
- `tests/Feature/Governance/ReleaseGateTest.php`: complete fixture passes; missing/stale/pending/rejected/quarantined/expired/conflicting evidence fails with item IDs and reasons.
- `tests/Unit/Governance/ClaimRegisterTest.php`: stable IDs, exact hashes/contexts, required clinical metadata, and no unregistered discovered claims.
- `tests/Unit/Governance/MediaRegisterTest.php`: every published asset/testimonial is classified; patient evidence fields are references only; context mismatch blocks.
- `tests/Unit/Governance/PrivacyDecisionTest.php`: all MEAS-03 fields exist and analytics stays blocked absent an explicit production decision.
- `tests/Unit/Governance/OperationsRegisterTest.php`: required operational domains exist, dates/recheck status are valid, and configured/observed mismatches block.

### Requirements-to-Test Map

| Requirement | Automated proof | Human proof that automation cannot supply |
|---|---|---|
| GOV-01 | Route/config/Blade/assets/rendered-schema inventory is complete, parseable, deduplicated, and tied to revision/date. | Review that classifications and baseline observations are meaningful and complete. |
| GOV-03 | Every discovered clinical claim maps to a record with required fields; incomplete/non-approved records block. | Dra. Emily supplies the source judgment and approval. |
| GOV-04 | Every published patient/unknown media item and testimonial has the required reference fields and exact contexts; incomplete records block. | Authorized custodian verifies provenance, written authorization, attribution, and permitted use. |
| GOV-05 | Scope-sensitive wording is found across visible/schema contexts and blocked without dated review evidence. | CRO-MG or qualified counsel decides permitted wording. |
| GOV-06 | Every required operational category exists; stale/mismatched/pending values block. | Clinic representative verifies real-world operations. |
| MEAS-03 | Decision schema completeness and disabled-until-approved state are asserted. | Privacy/legal owner determines lawful basis, retention, access, consent, transfer, and production approval. |

### Baseline Checks

Record, do not remediate, representative homepage, generic procedure, Full Face, and sitemap results. Accessibility baseline should include 320px/mobile and desktop keyboard/semantic/manual observations plus whatever existing tooling is available; performance should record production-build context, payloads, and lab metrics without adding a dependency; measurement should inspect current script/network behavior and state precisely whether analytics collection occurred. A missing tool or unavailable field must be marked `not measured` with reason, not silently passed.

### Sampling and Phase Gate

- Per task: run the focused governance test file/filter relevant to the artifact.
- After inventory changes: regenerate into a temporary location and assert deterministic equivalence for the same tree/config.
- Before phase review: run `php artisan test --compact`; run `vendor/bin/pint --dirty --format agent` only if PHP files were changed.
- Phase completion: automated checks green **and** the exact release revision has all required human evidence. Tests alone cannot close the release gate.

### Wave 0 Gaps

- Add the governance fixtures/register schema and focused Pest tests before relying on a release-gate command.
- Add coverage for all configured procedure routes, procedure JSON-LD, sitemap contents, and invalid procedure handling; present coverage is limited chiefly to homepage/schema behavior.
- Define the baseline capture protocol and storage locations before any later phase changes public content.

## Security Domain

| ASVS category | Applies | Phase 1 control |
|---|---|---|
| V2 Authentication | No public-auth change | Do not add an approval UI or identity system. Named human evidence remains externally controlled. |
| V3 Session Management | No | Public pages remain session-independent for this phase. |
| V4 Access Control | Yes, evidence boundary | Public application must not serve governance files or controlled evidence; references convey no access credentials. |
| V5 Validation | Yes | Strictly validate register shape, IDs, dates, statuses, hashes, paths, and cross-references; reject unknown/missing values. |
| V6 Cryptography | Limited | Use standard hashing only for change detection, never as proof of human approval or consent. |
| V8 Data Protection | Yes | Exclude patient identifiers, health data, consent scans, signatures, secrets, and legal correspondence from Git and command output. |
| V12 Files and Resources | Yes | Constrain scans to explicit repository roots; do not traverse symlinks or expose `.env`, storage, vendor, or runtime secrets. |
| V14 Configuration | Yes | Inventory analytics/config state and fail closed; do not enable tracking or mutate public production behavior. |

## Project Constraints (from AGENTS.md)

- Preserve PHP 8.4, Laravel 13, Blade/config-backed architecture, Livewire 4, Tailwind 4, Pest 4, and PHPUnit 12.
- Follow sibling-file structure/naming, use descriptive names, reuse existing components, and do not create new base folders without approval.
- Do not change dependencies without approval and do not replace verification covered by tests with ad hoc scripts/tinker.
- Use Artisan `make:` commands with `--no-interaction` for application classes/tests when implementation begins.
- Use explicit PHP parameter and return types, constructor property promotion where applicable, curly braces, TitleCase enum keys, PHPDoc rather than routine inline comments, and array-shape PHPDoc where useful.
- Create Pest tests via the project convention; most tests should be feature tests; do not delete tests without approval.
- If PHP is modified, run `vendor/bin/pint --dirty --format agent` before completion.
- Do not start a local server; Laravel Herd serves the application.
- Phase 1 is explicitly authorized to create its planning/governance documentation; avoid unrelated documentation.

## Assumptions Log

| # | Claim | Risk if wrong |
|---|---|---|
| A1 | The recommended decision vocabulary is `pending`, `approved`, `rejected`, `quarantined`, `expired`. | Planner must lock a different exact schema before tests/code use it. |
| A2 | Markdown plus JSON/PHP register artifacts are acceptable to all human reviewers. | Reviewers may require a controlled external workflow or export format. |
| A3 | Existing project tooling can capture sufficient baseline evidence without new dependencies. | Some accessibility/performance observations may need manual or externally provided evidence and must be recorded as unavailable until supplied. |

## Open Questions

1. Who is the named content owner and privacy approver, and what controlled systems hold CRO/legal and patient-authorization evidence?
2. What validity/recheck period applies to clinical review, legal/CRO review, operations verification, media authorization, and privacy approval?
3. Which public images/testimonials depict patients versus Dra. Emily, stock/illustrative subjects, or unknown subjects?
4. Is analytics currently collected in any deployed environment despite the configured GA4 ID, and what production tag/consent configuration exists outside this repository?
5. Which exact rendered revision/environment is the baseline and prospective release candidate?

These are evidence gaps, not implementation choices. Until answered and recorded by the authorized humans, the corresponding release gates remain blocked.

## Sources

### Repository and locked planning sources (HIGH confidence)

- `.planning/phases/01-baseline-content-freeze-approval-gates/01-CONTEXT.md`
- `.planning/REQUIREMENTS.md`
- `.planning/ROADMAP.md`
- `.planning/PROJECT.md`
- `.planning/research/SUMMARY.md`
- `.planning/research/ARCHITECTURE.md`
- `.planning/research/PITFALLS.md`
- `.planning/codebase/ARCHITECTURE.md`
- `.planning/codebase/STRUCTURE.md`
- `AGENTS.md`
- `routes/web.php`, `app/Http/Controllers/ProcedureController.php`
- `config/clinic.php`, `config/procedures.php`, `config/faq.php`
- `resources/views/**`, `public/**`, `tests/**`, `composer.json`, `package.json`

## Metadata

**Confidence breakdown:**
- Repository surface map: HIGH — derived from current routes, configuration, views, public assets, and tests.
- Governance architecture: HIGH — directly constrained by Phase 1 decisions and requirements.
- Human evidence status: MEDIUM — source documents identify required approvals but do not supply them.
- Legal/clinical/privacy outcomes: intentionally unresolved — implementation must not infer them.

**Research date:** 2026-09-08
**Valid until:** Re-run the deterministic inventory whenever the source tree, deployment configuration, or human evidence changes.
