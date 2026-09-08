# Phase 1: Baseline, Content Freeze & Approval Gates - Context

**Gathered:** 2026-09-08
**Status:** Ready for planning
**Source:** PRD Express Path (`.planning/REQUIREMENTS.md`)

<domain>
## Phase Boundary

Create an auditable, dated baseline of the existing public website and the human approval records that determine what may be published. This phase inventories pages, conversion paths, visible and machine-readable claims, patient media, testimonials, analytics, structured data, accessibility, performance, and measurement. It also establishes fail-closed evidence registers for clinical claims, professional and HOF wording, patient media, clinic operations, and LGPD/analytics decisions. It does not redesign the patient journey, enable tracking, or publish unverified claims.

</domain>

<decisions>
## Implementation Decisions

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

### Claude's Discretion
- Exact repository file names, schemas, scripts, test organization, and report layout used to make the baseline repeatable and easy to review.
- Choice of existing Laravel, Blade, PHP, shell, or package-provided mechanisms for deterministic inventory and verification, without changing dependencies or public application behavior.
- How unresolved items are represented so long as release state fails closed and the missing human decision is explicit.

</decisions>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

### Project scope and release policy
- `.planning/PROJECT.md` — Defines the product goal, consultation-first positioning, constraints, clinical and regulatory boundaries, and open evidence gates.
- `.planning/REQUIREMENTS.md` — Defines GOV-01, GOV-03, GOV-04, GOV-05, GOV-06, MEAS-03 and the milestone-wide exclusions and Definition of Done.
- `.planning/ROADMAP.md` — Defines the Phase 1 goal, success criteria, dependencies, phase boundary, and release gate.
- `.planning/STATE.md` — Records current milestone status, decisions, and workflow history.

### Brownfield codebase evidence
- `.planning/codebase/ARCHITECTURE.md` — Maps the current Laravel architecture and application boundaries.
- `.planning/codebase/STRUCTURE.md` — Maps repository layout and relevant implementation locations.
- `.planning/codebase/CONVENTIONS.md` — Records established project conventions to preserve.
- `.planning/codebase/TESTING.md` — Maps the current automated-test approach and coverage.
- `.planning/codebase/CONCERNS.md` — Records known risks and technical concerns relevant to the baseline.
- `.planning/codebase/STACK.md` — Records the installed technology stack and dependency constraints.
- `.planning/codebase/INTEGRATIONS.md` — Maps existing external and analytics-related integrations.

### Research
- `.planning/research/SUMMARY.md` — Synthesizes the website-conversion, facial-harmonization, regulatory, privacy, and sequencing research.
- `.planning/research/PITFALLS.md` — Defines domain-specific failure modes and fail-closed mitigations.
- `.planning/research/ARCHITECTURE.md` — Recommends governance artifacts and their relationship to later implementation phases.

</canonical_refs>

<specifics>
## Specific Ideas

- Prefer generated inventories backed by deterministic source scanning, supplemented by review registers for items that require human judgment.
- Keep sensitive patient authorization and legal evidence outside the public repository; store only non-sensitive references, dates, responsible roles, publishing decisions, and release status.
- Make the unresolved August 2026 HOF regulatory question explicit and dated rather than encoding a legal conclusion.
- Separate a literal WhatsApp click baseline from conversations, appointments, attendance, clinical eligibility, patients, or revenue.
- Record baselines before changing copy, procedure prominence, analytics, structured data, or page hierarchy so later improvements have a trustworthy comparison point.

</specifics>

<deferred>
## Deferred Ideas

- Canonical verified identity, shared trust components, safe WhatsApp prefills, and privacy-boundary UI are Phase 2.
- Consultation-first page redesign, procedure content, objection handling, accessibility implementation, and CTA placement are Phase 3.
- Consent-gated analytics instrumentation and debug validation are Phase 4.
- SEO, structured-data hardening, performance work, broad automated quality gates, and production release verification are Phase 5.
- Outcome reconciliation, minimum-evidence rules, and usability-session operations are Phase 6.
- Campaign landing pages, A/B tests, CRM, direct scheduling, private intake, patient portals, and messaging automation remain v2 or out of scope.

</deferred>

---

*Phase: 01-baseline-content-freeze-approval-gates*
*Context gathered: 2026-09-08 via PRD Express Path*
