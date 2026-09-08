# Roadmap: Dra. Emily Beatriz Website Conversion Review

## Overview

This milestone moves the existing Laravel/Blade site from an unverified conversion baseline to a clinically reviewed, consultation-first patient journey with privacy-safe measurement and evidence-based optimization. Work proceeds through six dependency-driven phases: inventory and human approval decisions; canonical content and shared contracts; the accessible public journey; consent-gated WhatsApp click measurement; search, performance, and release verification; then launch observation. Laravel 13, Blade, Tailwind CSS, configuration-backed content, shared components, named routes, direct WhatsApp links, and Pest remain the implementation foundation. Clinical approval, professional-status and advertising review, patient-media authorization, privacy approval, and verified clinic operations are external release gates that implementation cannot infer or self-approve.

## Phases

- [ ] **Phase 1: Baseline, Content Freeze & Approval Gates** - Inventory the live experience, establish baselines, and record the human decisions that determine what may be published.
- [ ] **Phase 2: Canonical Content & Shared Trust Contracts** - Make verified identity, trust evidence, privacy boundaries, WhatsApp context, and machine-readable output consistent and fail closed.
- [ ] **Phase 3: Consultation-First Patient Journey** - Deliver a clinically bounded, accessible journey from patient concern to an individualized WhatsApp consultation.
- [ ] **Phase 4: Consent-Gated WhatsApp Measurement** - Measure controlled WhatsApp click intent without blocking contact or sending sensitive data to analytics.
- [ ] **Phase 5: Search, Performance & Release Quality** - Harden final pages for local discovery, speed, correctness, accessibility, and production release.
- [ ] **Phase 6: Launch Learning & Evidence-Based Optimization** - Reconcile clicks with privacy-safe downstream outcomes and use sufficient evidence before changing prominence.

## Phase Details

### Phase 1: Baseline, Content Freeze & Approval Gates
**Goal:** The owner knows exactly what the site publishes and has dated evidence for every clinical, professional, media, privacy, and operational decision required to release it safely.
**Mode:** mvp
**Depends on:** Nothing (first phase)
**Requirements:** GOV-01, GOV-03, GOV-04, GOV-05, GOV-06, MEAS-03
**Success Criteria** (what must be TRUE):
  1. The owner can review a complete inventory of every public page, conversion path, visible or machine-readable claim, patient asset, testimonial, analytics integration, and structured-data output alongside dated accessibility, performance, and measurement baselines.
  2. Every clinical claim intended for publication has a source, owner, last-reviewed date, and recorded approval from Dra. Emily; anything unresolved is removed from the release set or explicitly quarantined.
  3. Every patient image or testimonial intended for publication has off-repository provenance, written authorization, responsible-professional attribution, and a current publishing decision; unsupported material cannot be released.
  4. Dated evidence verifies clinic operations and establishes the permitted professional-title and HOF wording under current CRO-MG or qualified legal review; unverified or scope-sensitive wording remains blocked.
  5. A documented LGPD and consent decision defines analytics purpose, lawful basis, configuration, retention, access, and consent behavior before tracking can be enabled.
**Release gate:** Phase 1 cannot close until Dra. Emily's clinical approval, current professional-status/advertising review, patient-media decisions, privacy approval, and clinic operational facts are recorded for the exact release content; implementation must not invent missing facts or approvals.
**Plans:** TBD
**UI hint:** yes

### Phase 2: Canonical Content & Shared Trust Contracts
**Goal:** Visitors and search systems receive the same verified professional, clinic, evidence, reviewer, privacy, and WhatsApp facts from reusable configuration-driven contracts.
**Mode:** mvp
**Depends on:** Phase 1
**Requirements:** GOV-02, TRUST-01, TRUST-04, TRUST-05, TRUST-06, WA-03, WA-05
**Success Criteria** (what must be TRUE):
  1. A visitor sees Dra. Emily's verified full name, “cirurgiã-dentista” designation, current CRO-MG registration, supported qualifications, treatment location, and genuine directions consistently across visible pages and machine-readable output.
  2. A visitor can distinguish approved patient evidence from illustrative or educational imagery, sees that individual results vary, and can identify who clinically reviewed health-related content and when.
  3. Every direct WhatsApp link works without JavaScript and uses only an allow-listed page or procedure context; its prefill contains no identity, contact, symptom, diagnosis, image request, free text, or other sensitive information.
  4. A visitor can read a clear privacy notice at the conversion boundary and is explicitly discouraged from placing unnecessary sensitive health information in the initial message.
  5. Every configured public page renders through named routes and shared Blade/configuration contracts, while missing approvals or required content fail closed instead of producing contradictory visible, schema, canonical, or sitemap output.
**Release gate:** Only facts and media approved in Phase 1 may enter the canonical records; repository flags or passing tests are not substitutes for external evidence.
**Plans:** TBD
**UI hint:** yes

### Phase 3: Consultation-First Patient Journey
**Goal:** Cautious visitors can understand realistic options, verify the care journey, and reach an individualized consultation without being diagnosed, pressured, or promised an outcome.
**Mode:** mvp
**Depends on:** Phase 2
**Requirements:** CONT-01, CONT-02, CONT-03, CONT-04, CONT-05, CONT-06, CONT-07, CONT-08, CONT-09, TRUST-02, TRUST-03, WA-01, WA-02, WA-04, UX-01, UX-02, UX-03, UX-04, UX-05
**Success Criteria** (what must be TRUE):
  1. A visitor immediately understands the individualized-assessment proposition in Belo Horizonte and can follow a non-diagnostic “não sei qual procedimento” path to consultation.
  2. On every procedure journey, a visitor can understand what treatment may and may not address, how recommendations are individualized, what candidacy assessment considers, and clinician-approved ranges for timing, discomfort, recovery, temporary effects, risks, warning signs, aftercare, and follow-up.
  3. Visible and machine-readable Portuguese content answers the main naturalness, safety, needle, recovery, durability, cost-process, and procedure-choice concerns without guarantees, shame, defect framing, aging panic, coercive urgency, or an idealized perfect result.
  4. A visitor can follow the full path from WhatsApp contact through assessment, recommendation and estimate, consent, indicated treatment, aftercare, and follow-up; every relevant decision point has a consistent primary consultation CTA, truthful service expectations, and a working direct-contact fallback.
  5. The homepage, standard procedure pages, Full Face page, navigation, footer, FAQs, disclosures, and conversion components remain consistent and operable at 320px through desktop, with logical semantics, keyboard order, visible focus, adequate contrast and targets, reflow/zoom support, meaningful alternatives, and reduced motion.
**Release gate:** Dra. Emily must approve the final rendered clinical meaning, and the professional/advertising reviewer must approve the final context. Operational promises must still match verified clinic capacity. The phase cannot pass on source copy or automated accessibility scores alone.
**Plans:** TBD
**UI hint:** yes

### Phase 4: Consent-Gated WhatsApp Measurement
**Goal:** The owner can validate privacy-safe WhatsApp consultation-click attribution while visitors retain an uninterrupted direct-contact path regardless of analytics consent or script availability.
**Mode:** mvp
**Depends on:** Phase 3
**Requirements:** MEAS-01, MEAS-02, MEAS-04
**Success Criteria** (what must be TRUE):
  1. A deliberate CTA activation emits at most one `whatsapp_consultation_click` event with only controlled `source_page`, `procedure`, and `cta_placement` values, and the metric dictionary states that this is a click—not a message, conversation, booking, attendance, eligibility decision, patient, or revenue event.
  2. The owner can use a test or debug environment to distinguish eligible page views from CTA clicks and verify allow-listed values across homepage, standard procedure, and Full Face placements.
  3. Network inspection confirms analytics receives no WhatsApp message text or full URL, name, phone number, symptom, diagnosis, health concern, photo, free text, or identifier linked to patient records.
  4. WhatsApp and the direct-contact fallback continue to work when consent is rejected or revoked, JavaScript fails, analytics is blocked, or the event request does not complete.
**Release gate:** Tracking remains disabled until the Phase 1 privacy decision is implemented and re-approved against the production configuration, retention, access, consent behavior, and advertising-signal settings.
**Plans:** TBD
**UI hint:** yes

### Phase 5: Search, Performance & Release Quality
**Goal:** The final public journey is fast, indexable, semantically accurate, thoroughly tested, and blocked from production whenever a required human or automated release condition is missing.
**Mode:** mvp
**Depends on:** Phase 4
**Requirements:** QUAL-01, QUAL-02, QUAL-03, QUAL-04, QUAL-05, QUAL-06, QUAL-07
**Success Criteria** (what must be TRUE):
  1. Every indexable page has unique, accurate Portuguese metadata, headings, internal links, and canonical intent, while the sitemap includes every intended canonical public URL and excludes invalid or non-indexable routes.
  2. Local-business, professional, procedure, breadcrumb, and FAQ structured data uses supported types and properties, matches approved visible content, and passes applicable validators without unsupported review or outcome claims.
  3. Representative homepage, standard-procedure, and Full Face pages meet the agreed lab performance gates with reserved media dimensions, responsive formats, correct loading priority, and no unnecessary JavaScript or render-blocking work.
  4. Automated contracts cover the homepage, every configured procedure and specialized view, unknown procedures, direct WhatsApp links, privacy-safe analytics parameters, metadata, structured data, and sitemap output.
  5. Production assets, focused and full Laravel/Pest suites, Pint, structured-data validation, accessibility checks, security/header review, and representative mobile/desktop smoke tests pass, and the release checklist refuses publication when any automated check or required clinical, professional, media, privacy, or operational approval is absent.
**Release gate:** Publication requires the exact approved content revision, current external approvals, a successful production build, all required automated checks, manual accessibility/browser evidence, and a post-deploy validation path.
**Plans:** TBD
**UI hint:** yes

### Phase 6: Launch Learning & Evidence-Based Optimization
**Goal:** The owner can judge the consultation journey using privacy-preserving evidence that distinguishes browser clicks from real clinic outcomes and resists conclusions from sparse data.
**Mode:** mvp
**Depends on:** Phase 5
**Requirements:** MEAS-05, MEAS-06, MEAS-07
**Success Criteria** (what must be TRUE):
  1. The clinic can maintain coarse aggregate counts of genuine WhatsApp conversations, consultations scheduled, consultations attended, and clinically eligible leads without exporting clinical details to GA4 or joining analytics identifiers to named patient records.
  2. A dated baseline reports eligible views, consent coverage, controlled WhatsApp clicks, downstream aggregate outcomes, unattributed activity, observation period, exclusions, and uncertainty as distinct measures.
  3. The owner has a written minimum-evidence rule that prevents low traffic or click differences from being presented as proof of a winning audience, message, procedure, or CTA.
  4. Structured task-based usability sessions can capture qualitative feedback from relevant local, first-time, and safety-conscious participants when traffic is insufficient for quantitative experimentation.
**Release gate:** No flagship procedure, narrow audience, or causal conversion claim may be adopted unless the predeclared evidence threshold is met; clinical eligibility remains a clinician's private assessment, never an analytics inference.
**Plans:** TBD

## Progress

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. Baseline, Content Freeze & Approval Gates | 0/TBD | Not started | - |
| 2. Canonical Content & Shared Trust Contracts | 0/TBD | Not started | - |
| 3. Consultation-First Patient Journey | 0/TBD | Not started | - |
| 4. Consent-Gated WhatsApp Measurement | 0/TBD | Not started | - |
| 5. Search, Performance & Release Quality | 0/TBD | Not started | - |
| 6. Launch Learning & Evidence-Based Optimization | 0/TBD | Not started | - |
