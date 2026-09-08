# Project Research Summary

**Project:** Dra. Emily Beatriz — Website Conversion Review  
**Domain:** Brazilian facial-harmonization patient-acquisition website with WhatsApp consultation conversion  
**Researched:** 2026-09-08  
**Confidence:** MEDIUM

## Executive Summary

This is an existing Laravel/Blade acquisition website for a Belo Horizonte cirurgiã-dentista, not an e-commerce treatment catalogue. Its job is to help cautious prospective patients understand their options, verify the professional and clinic, form realistic expectations, and start a private WhatsApp conversation about an individualized assessment. Research supports a broad positioning around natural-looking intent, preservation of identity, professional competence, balanced safety information, and continuity of care. It does not support selecting a narrow persona or flagship procedure from the site's current low traffic. “Natural results” should therefore be explained as a careful assessment and planning process, never promised as a guaranteed outcome.

The recommended implementation preserves Laravel 13, server-rendered Blade, Tailwind CSS, Vite, named routes, and configuration-backed content. The central architectural move is to turn clinic identity, procedure claims, FAQs, social proof, CTAs, and structured data into projections of the same reviewed content records. One reusable direct-to-WhatsApp component should provide truthful consultation language, generic privacy-safe prefill, accessible link text, and a closed analytics taxonomy. JavaScript should remain a small progressive enhancement for consent and measurement; the site and every WhatsApp link must work without it. Pest contracts, focused Playwright/axe coverage, manual WCAG 2.2 AA review, Lighthouse baselines, schema validation, and production smoke tests provide the technical release gates.

The largest risks are not styling defects: they are unverified specialty wording, overconfident clinical claims, patient media or testimonials without a defensible authorization chain, health-interest data leaking into analytics or WhatsApp URLs, and low-volume click data being mislabeled as consultations. Current CFO/CRO advertising obligations require accurate professional identification and support for advertised titles and media; exact applicability must be reviewed for this publisher and content. Separately, the August 2026 HOF dispute is unresolved for this project: the CFO reports that a TRF1 panel voted to annul Resolution CFO 198/2019, says it will challenge that decision, and says duties did not immediately change, while the judgment itself was not retrieved by the researchers. The roadmap must therefore begin with treating-professional, CRO-MG/qualified legal, patient-media, and privacy decisions tied to the exact content revision, and must re-check them immediately before publication rather than inferring a legal conclusion.

## Evidence and Decision Boundary

- **Established evidence:** Patient research and authoritative guidance support consultation-first decision-making, naturalness and safety as important concerns, expectation setting, follow-up, accessible mobile pages, accurate local identity, and data minimization. These findings justify the baseline journey but do not guarantee conversion lift for this clinic.
- **Implementation inference:** The proposed section order, CTA wording, “não sei qual procedimento” route, visit-confidence module, shared Blade components, and qualitative validation loop are evidence-informed product choices. Their effect in Belo Horizonte must be observed.
- **Required professional validation:** Clinical accuracy, claims and limitations, candidacy, risks, recovery, aftercare, qualifications, specialty wording, publisher identity, patient-media/testimonial use, privacy basis, retention, and WhatsApp operations cannot be settled by website research or tests. Unresolved items must fail closed or remain unpublished.

## Key Findings

### Recommended Stack

The [stack research](./STACK.md) found no reason for a framework migration, SPA, CMS, tag manager, application analytics database, or CRM. The current architecture is well matched to a small, public, content-led site and keeps crawlable content, metadata, schema, and tests close together.

**Core technologies:**

- **PHP 8.4 and Laravel 13.11.x:** Preserve routing, configuration, rendering, canonical URLs, sitemap output, and HTTP tests.
- **Blade:** Keep the journey server rendered and use narrow shared components for CTA, trust, disclosures, schema, and media contracts.
- **Tailwind CSS 4.3.x:** Retain the existing design system; implement focus, contrast, target-size, reflow, and reduced-motion fixes without adding a UI framework.
- **Vite 8.0.x and `laravel-vite-plugin` 3.1.x:** Continue production bundling and self-host the two fonts actually rendered; remove redundant remote font work.
- **Small vanilla ES module:** Add consent and delegated WhatsApp-click measurement only. Navigation and content remain independent of JavaScript and tracking success.
- **GA4 `gtag.js`, conditionally loaded:** Use only after the approved consent condition, in production, with a configured ID and advertising signals disabled. No tag manager or browser-to-server lead simulation is needed.
- **Pest 4.7.x:** Extend server-rendered contract tests across every public route, content configuration, canonical/schema/sitemap output, and CTA attributes.
- **Playwright 1.63.0 plus `@axe-core/playwright` 4.13.0:** Add a small dev-only browser suite for consent, exactly-once event behavior, preserved navigation, responsive interactions, and automated accessibility regression checks.
- **Lighthouse CI 0.15.1:** Establish repeatable three-run medians on representative pages before setting non-regression gates. Keep artifacts private and use field data when available.
- **Optional `web-vitals` 6.0.1:** Defer unless Search Console/CrUX lacks usable field data and privacy review approves consented, minimized collection.

Dependency additions require approval. Do not add Livewire state, Vue/React, a commercial CMP, GTM, an SEO/schema package, or a database-backed tracking redirect for this milestone.

### Expected Features

The [feature research](./FEATURES.md) supports an information-rich but restrained acquisition journey. The website should sell access to individualized professional assessment, not a treatment outcome.

**Must have (table stakes):**

- **Consultation-first proposition:** Make “conversar sobre uma avaliação” the primary action and state that treatment suitability is determined in assessment.
- **Natural-results positioning with limits:** Explain naturalness through individualized goals, proportions, movement, conservative planning, and the possibility of less or no treatment; never guarantee it.
- **Verified professional and clinic identity:** Publish full name, “cirurgiã-dentista,” confirmed CRO-MG number, only supportable titles, accurate Belo Horizonte address, hours, phone, map, and profile facts.
- **Clinically reviewed procedure guidance:** For each treatment, cover what it is, what it may and may not do, assessment/candidacy boundaries, variable timing and duration, common effects, material risks, recovery, warning signs, aftercare, and follow-up.
- **Objection-focused information:** Address fear of artificial results, safety, discomfort/needles, recovery, cost process, and uncertainty about procedure choice in bounded, plain Brazilian Portuguese.
- **Truthful WhatsApp handoff:** Use a consistent direct link, generic context-aware prefill, next-step expectations, service-hour claims only when reliable, a phone/contact fallback, and a nearby privacy notice. The click starts a conversation; it is not a booking or clinical assessment.
- **Governed social proof:** Render only exact, current, traceable, authorized testimonials or patient media with required attribution and context after current advertising review; otherwise omit them.
- **Accessible, mobile-first, fast pages:** Treat the WhatsApp journey, consent UI, navigation, FAQ, disclosures, and safety content as one WCAG 2.2 AA-oriented path.
- **Consent-aware conversion measurement:** Record a literal WhatsApp click proxy with only controlled enums. Never send message text, full URLs, contact details, free text, symptoms, precise concerns, identifiers, or raw campaign data as custom event parameters.
- **Content provenance and release gates:** Associate clinical/professional claims with owner, source, review version/date, and applicable approvals, while keeping actual consent forms and sensitive evidence outside the repository.

**Should have (differentiators):**

- **“Não sei qual procedimento” path:** Let uncertain visitors reach the same assessment conversation without a quiz or automatic recommendation.
- **Naturalness-as-process explanation:** Demonstrate the reasoning and restraint behind the positioning instead of repeating a slogan.
- **Procedure decision cards:** Compare clinically approved purposes, timing, recovery profiles, and limitations without ranking treatments as products.
- **Operationally backed continuity of care:** Explain review, routine questions, and urgent escalation only to the level the clinic can consistently deliver.
- **Visible clinical reviewer labels:** Show who reviewed educational content and when, after an actual review tied to the published revision.
- **Belo Horizonte visit-confidence module:** Add only verified neighborhood, landmark, route, accessibility, parking, public-transport, and clinic-photo details that reduce real visit friction.
- **Privacy-preserving consultation-quality tally:** Compare aggregate clicks with legitimate conversations, consultations scheduled/attended, and eligibility using a governed clinic process separate from GA4 and named patient records.
- **Structured qualitative loop:** Use small mobile-first usability rounds with relevant local, first-time, and safety-conscious prospects before conventional experiments.

**Defer (v2+ or until a decision gate is met):**

- Flagship-procedure promotion or narrow persona targeting until sufficient consultation-quality evidence exists.
- A/B or multivariate testing until the primary metric, baseline, minimum detectable effect, sample size, duration, and stopping rule are written.
- AI outcome simulation, face scoring, selfie diagnosis, procedure recommenders, and any diagnostic/emergency bot.
- Online scheduling, public health intake, CRM, patient portal, server-side lead tracking, or confirmed-lead integration.
- Price, discount, promotion, scarcity, giveaway, and countdown features.
- Expansion of before/after content until provenance, consent, publisher identity, applicable CFO/CRO-MG rules, and presentation standards are verified.
- Remarketing, customer lists, enhanced conversions, health-interest audiences, Google Signals, and advertising personalization.

### Current Advertising and Regulatory Boundary

The source documents establish a compliance baseline, not case-specific legal advice:

- Professional name and CRO identification must be accurate and consistent; a course completion must not be treated as proof of a registered specialty.
- Any specialty title, HOF wording, service-scope claim, testimonial, rating, or patient image needs current support for the exact professional, publisher, medium, and context.
- Patient media requires a defensible off-repository authorization/provenance chain, responsible-professional attribution, confirmation that the case was performed by that professional, privacy handling, and a takedown process. Procedure-in-progress or sensational publication is a documented CRO-MG concern.
- Current CFO/CRO materials, including Resolution 196/2019, the Code of Dental Ethics, later amendments, and local enforcement guidance, must be read together. A technically valid disclosure or on-page `approved` flag is not legal evidence.
- The August 2026 litigation concerning Resolution CFO 198/2019 does not support a yes/no conclusion in website copy. The safe interim public credential is the verified base title “cirurgiã-dentista”; current registration and exact specialty/scope wording must be revalidated with CRO-MG or qualified Brazilian health-law counsel before release.

### Architecture Approach

The [architecture research](./ARCHITECTURE.md) recommends four narrow seams within the existing application: an approved configuration-backed content contract; Blade page composers plus only genuinely shared journey components; a direct WhatsApp component and consent-aware measurement module; and automated plus human release gates. Visible pages, metadata, JSON-LD, and sitemap entries must consume the same verified identity and procedure data. Runtime approval metadata may hide unapproved content, but private sign-off must identify the exact revision or commit; repository booleans are not evidence.

**Major components:**

1. **Routes and `ProcedureController`:** Preserve named home, procedure, and sitemap routes; resolve only configured slugs and fail closed for unknown procedures.
2. **Clinic/procedure/FAQ/social-proof configuration:** Hold canonical visible facts, patient-facing copy, SEO fields, generic WhatsApp context, and review metadata. Keep sensitive authorization records outside Git.
3. **Blade page composers:** Reorder the homepage and procedure pages around concern, trust, assessment, limits/risks/follow-up, approved proof, and consultation while allowing Full Face-specific education.
4. **Shared site layout and components:** Own landmarks, skip link, metadata/canonical/schema slot, consent UI, `x-whatsapp-cta`, trust/disclosure rendering, and existing `x-picture` image behavior at the narrowest common boundary.
5. **Schema graph/partials:** Project only visible, verified facts into a small valid graph. Use accurate `Dentist` and `Person` modeling, remove invalid `MedicalProcedure.performer`, avoid self-serving review markup, and do not rely on FAQ rich results.
6. **Consent/analytics module:** Store and revoke the choice, load GA4 only under the approved policy, and emit one event from server-controlled enums without delaying the direct `wa.me` navigation.
7. **Automated and human gates:** Pest verifies rendering and parity; browser/manual checks verify real interaction; clinical, compliance, patient-media, and privacy reviewers approve meaning and legal use.

### Measurement Strategy for Low Traffic

The research files use two candidate event names (`whatsapp_click` and `whatsapp_consultation_click`) and slightly different parameter labels. Requirements must choose one contract before implementation. Prefer the shorter literal **`whatsapp_click`**, because it most clearly states what the browser observed, with exactly three low-cardinality parameters: `page_type`, `procedure_slug`, and `cta_placement`. Document that the event is neither a sent message nor a lead, booking, attended consultation, patient, or revenue event.

Start with data-quality validation and a dated descriptive baseline. Report raw numerator/denominator, observation period, consent coverage, bot/internal exclusions, and uncertainty. Separately maintain a privacy-preserving, coarse monthly operational tally of legitimate conversations, consultations scheduled, attended consultations, and clinical eligibility; do not join GA identifiers to named patients or move chat content into analytics. Use qualitative usability sessions and sequential releases to fix clear comprehension and access problems. Only run controlled experiments after a written power/sample-size plan and stopping rule exist, and never use a small click difference alone to choose a flagship procedure or claim causality.

### Critical Pitfalls

The [pitfalls research](./PITFALLS.md) makes these release-critical:

1. **Unverified specialty and scope language:** Centralize the approved credential, default to “cirurgiã-dentista,” remove unsupported HOF/title claims from visible and hidden outputs, and re-check the August 2026 dispute immediately before launch.
2. **Clinical promises or unsafe omissions:** Inventory every claim across Blade, config, metadata, JSON-LD, sitemap/image text, and CTA context; remove guarantees and obtain line-by-line clinical review with scope, limitations, and date.
3. **Unauthorized or misleading social proof:** Freeze patient media/testimonials until provenance, exact authorization, publisher applicability, attribution, standardized presentation, disclaimer, freshness, and takedown are verified. Do not add self-serving review schema.
4. **Health-interest data leakage:** Approve a data map and legal basis before GA4; default non-essential analytics off where consent is the basis; expose equal accept/reject/revoke controls; keep WhatsApp URLs generic; disable ad features; and prohibit identifiers, free text, message content, or full URLs from events.
5. **Inaccessible, slow, or weakly tested primary journey:** Test the actual mobile and desktop path—including consent and WhatsApp—with keyboard, assistive technology, zoom/reflow, reduced motion, throttled performance, production assets, valid schema, and post-deploy smoke checks.
6. **Overinterpreting sparse clicks:** Use literal metric names, counts with uncertainty, an unattributed bucket, downstream aggregate reconciliation, and predeclared decision thresholds; postpone flagship and A/B decisions.

## Implications for Roadmap

Based on combined research, use six phases. Clinical, advertising, privacy, and patient-media work are gates across phases, not technical tasks that engineering can self-approve.

### Phase 1: Baseline, Content Freeze, and Approval Decisions

**Rationale:** A visual rewrite would amplify the highest-risk defects if claims, credentials, schema, testimonials, patient images, or current tracking behavior are not first inventoried. Low traffic also requires a no-change baseline before attribution or performance changes.  
**Delivers:** Route/page/CTA/claim/schema/media inventory; GA4 and Google Business Profile audit; accessibility and three-run Lighthouse baselines; verified clinic facts; claim register; current CRO/title/HOF decision; social-proof provenance decision; analytics data map/legal-basis decision; WhatsApp governance requirements.  
**Addresses:** Verifiable professional identity, content provenance, governed social proof, privacy notice requirements, realistic baseline measurement.  
**Avoids:** Unverified specialty advertising, unsafe claims, unauthorized patient media, redesign-before-audit, and false baseline conclusions.  
**Exit gate:** Every public claim and asset has a disposition. Exact clinical, advertising, patient-media, and privacy decisions are recorded against a content version; unresolved material is removed or quarantined.

### Phase 2: Canonical Content, Identity, and Shared Technical Contracts

**Rationale:** Stable, approved source records and cross-page components must exist before journey rewriting or analytics instrumentation, otherwise fixes drift among the homepage, generic procedure view, Full Face, metadata, and JSON-LD.  
**Delivers:** Reviewed clinic/procedure/FAQ shapes; centralized local identity and professional credential; fail-closed social-proof records; shared `x-whatsapp-cta`; valid direct `wa.me` builder; trust/disclosure seams; schema graph sourced from visible config; base privacy route/UI; security and environment-safe URL foundations; Pest contract suite.  
**Addresses:** Consistent professional/local identity, generic WhatsApp prefill, provenance metadata, structured-data parity, privacy boundary.  
**Avoids:** Duplicated template drift, schema as hidden marketing, redirect-based tracking, missing config 500s, contradictory titles, and invalid canonical hosts.  
**Exit gate:** Every configured page renders; CTA URLs, accessible labels, and enums are valid; visible identity matches JSON-LD; missing approval fails closed; canonical/sitemap contracts pass.

### Phase 3: Consultation-First, Accessible Patient Journey

**Rationale:** Once the content contract is stable, the public journey can be rewritten without multiplying unreviewed claims. Trust, safety, accessibility, and conversion are the same patient journey, not separate design passes.  
**Delivers:** Concern-aware natural-results hero; immediate verified trust facts; individualized-assessment explanation; neutral procedure discovery; consistent what-it-may/may-not-do, candidacy, risk/recovery, aftercare/follow-up, and FAQ sections; truthful WhatsApp expectations; Full Face parity; “não sei qual procedimento” path if approved; WCAG-oriented shared styling and interaction fixes.  
**Addresses:** Consultation-first proposition, naturalness-as-process, balanced education, objection handling, continuity, local visit confidence, accessible primary CTA.  
**Avoids:** Shame/pressure, prescribed self-selection, guarantees, hidden disclosures, misleading “booking” labels, inaccessible sticky UI, SEO-stuffed alt text, and cross-template copy drift.  
**Exit gate:** Treating professional and compliance reviewer approve the final rendered copy. Mobile/desktop UAT confirms comprehension, correct generic handoff, keyboard/focus/zoom/reflow/reduced-motion operation, and full usefulness without JavaScript.

### Phase 4: Consent-Gated WhatsApp Measurement

**Rationale:** Measurement should be added only after the CTA contract is stable and privacy decisions are explicit. A click must never become a prerequisite for reaching WhatsApp or be reported as an appointment.  
**Delivers:** Equal accept/reject/reopen/revoke controls; production-only conditional GA4 loader; one canonical `whatsapp_click` event; three whitelisted enums; GA4 custom definitions and literal metric dictionary; ad-signal/settings audit; Playwright coverage for deny/accept/revoke and exactly-once events; documented operational outcome tally.  
**Addresses:** Named conversion events, source/procedure/placement attribution, WhatsApp expectations, consultation-quality measurement.  
**Avoids:** Pre-consent requests, dark-pattern consent, PII/health-interest leakage, duplicate outbound events, health remarketing, broken navigation, and clicks mislabeled as leads/bookings.  
**Exit gate:** Network inspection shows no GA request before the approved condition; WhatsApp always opens; DebugView shows one event with only allowed values; retention/access/ad settings and metric definitions are documented and privacy-approved.

### Phase 5: Performance, Local SEO, Structured Data, and Release Quality

**Rationale:** Optimize and validate the stable pages rather than tuning assets or schema that may still be restructured. This phase converts audit findings into measurable release gates.  
**Delivers:** Self-hosted/reduced fonts; correctly prioritized LCP hero media; lazy below-fold media; responsive variants where justified; intrinsic dimensions; focus/anchor/reduced-motion hardening; accurate `Dentist`/`Person` graph; invalid property cleanup; NAP/Business Profile reconciliation; canonical/sitemap/Open Graph verification; production build, browser crawl, security-header/CSP checks, and post-deploy smoke plan.  
**Addresses:** Fast mobile access, local visit trust, accurate search identity, structured data, complete test coverage.  
**Avoids:** Image-heavy mobile delay, local keyword/location spam, unsupported schema claims, stale NAP, missing Vite assets, indexable staging, and a PHP-only false sense of safety.  
**Exit gate:** Pest and production build pass; axe plus manual checks have no blocking journey defect; representative home/standard/Full Face Lighthouse medians do not regress and progress toward 0.90 project gates; LCP/INP/CLS targets remain ≤2.5s/≤200ms/≤0.1 at the 75th percentile when field data exists; deployed schema, canonical, sitemap, assets, headers, console, links, and indexability validate.

### Phase 6: Launch Observation and Evidence-Based Optimization

**Rationale:** The strategy question—what audience, message, procedure, or CTA deserves prominence—cannot be answered before clean instrumentation and real consultation-quality observations exist.  
**Delivers:** Launch annotation; Search Console and GA validation; raw-count baseline reporting; consent/data-quality coverage; coarse click-to-conversation-to-consultation reconciliation; local usability rounds; dated sequential improvements; written thresholds for future flagship or experiment decisions.  
**Addresses:** Structured qualitative research, consultation-quality measurement, evidence-based positioning and procedure ordering.  
**Avoids:** Weekly winner language, premature segmentation, false precision, multiple-comparison noise, click-as-revenue reporting, and underpowered A/B tests.  
**Exit gate:** Reports distinguish observed clicks from downstream outcomes, show counts and uncertainty, retain unattributed activity, and make no prominence/flagship claim unless the predeclared evidence threshold is met.

### Phase Ordering Rationale

- Evidence and approvals precede persuasion: credentials, claims, media, privacy basis, and the regulatory position determine what may safely be designed and measured.
- Canonical configuration and shared components precede page rewriting: this makes one approved fact flow into visible content, metadata, schema, sitemap, and all CTA placements.
- Stable content and CTAs precede analytics: otherwise the event taxonomy changes during implementation and consent tests cannot prove a durable contract.
- Stable pages precede performance/search hardening: assets, headings, canonicals, and schema can then be validated against the final journey.
- Observation follows data-quality validation: low-volume results are useful only after event semantics, consent coverage, and downstream distinctions are trustworthy.

### Requirements Implications

Roadmap requirements should be written as observable contracts:

- Every public page must render from an allow-listed, reviewable content record and expose the same verified identity in visible copy and machine-readable output.
- Any unresolved clinical claim, professional title, testimonial, rating, or patient image must be absent from publication, not hidden behind a generic disclaimer.
- Every WhatsApp CTA must remain a direct, functional link with truthful consultation language and generic prefill, even with JavaScript disabled, analytics denied, offline scripts, or blockers.
- No analytics network request may occur before the approved condition; one deliberate click may emit at most one literal click event with only the three controlled enums.
- Tests must cover the homepage, every configured procedure and specialized view, unknown slugs, FAQ/schema parity, credential/schema parity, CTA contracts, images, canonicals, sitemap, production assets, consent states, accessibility states, and post-deploy critical paths.
- Accessibility acceptance must include manual keyboard, assistive-technology spot checks, 200%/400% zoom, 320px reflow, contrast, target size, and reduced motion; automated scores alone are insufficient.
- Conversion reports must preserve the distinction among eligible page view, WhatsApp click, genuine conversation, consultation scheduled, attended consultation, and eligibility, without joining GA identifiers to patient records.
- A re-review date/trigger must exist for HOF/CFO/CRO-MG status, ratings, clinical content, privacy configuration, WhatsApp terms, Google policies, NAP, and patient-media authorization.

### Research Flags

Phases likely needing deeper research or current-source revalidation during planning:

- **Phase 1:** Re-check the live August 2026 HOF litigation posture, current CRO-MG registration, Code/Resolution interpretation, publisher identity, and exact media/testimonial/title rules. The present research deliberately reaches no case-specific legal conclusion.
- **Phase 4:** Revalidate the approved LGPD basis, GA4 property/policy settings, international-processing obligations, and WhatsApp terms—especially before any API, CRM, chatbot, or advertising automation and in light of the announced 23 September 2026 WhatsApp terms change.

Phases with well-documented implementation patterns that can usually skip a separate research phase:

- **Phase 2:** Laravel/Blade configuration contracts, reusable components, named routes, PHP JSON serialization, and Pest HTTP tests are established patterns in the existing codebase.
- **Phase 3:** Semantic HTML, native disclosure controls, progressive enhancement, and WCAG 2.2 implementation have strong standards guidance; the unknown is local user response, handled through UAT rather than more desk research.
- **Phase 5:** Responsive images, Core Web Vitals diagnostics, canonical/sitemap checks, Schema.org validation, production builds, and browser smoke tests are well documented. Re-check current Google eligibility rules during execution without reopening the architectural decision.
- **Phase 6:** Descriptive baselines, qualitative usability rounds, sequential releases, and experiment entry criteria are established methods; this phase needs site data, not speculative research.

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Stack | HIGH for compatibility; MEDIUM overall | Repository evidence strongly supports retaining Laravel/Blade/Tailwind/Vite. Exact package versions and privacy configuration can change and require approval. |
| Features | MEDIUM | Multiple patient, clinical, regulatory, and platform sources support the baseline needs, but much evidence is international and specific conversion tactics remain local hypotheses. |
| Architecture | HIGH for code boundaries; MEDIUM overall | Existing code inspection supports the proposed seams and build order. Human approval processes, GA policy, and legal/privacy details are external dependencies. |
| Pitfalls | MEDIUM | Official primary sources establish material risks, but current application depends on registration, publisher identity, consent records, operations, and an unresolved legal dispute whose judgment was not retrieved. |

**Overall confidence:** MEDIUM

### Gaps to Address

- **Professional status and HOF wording:** Obtain current CRO-MG evidence and a dated wording decision from CRO-MG or qualified counsel immediately before release.
- **Clinical content:** Dra. Emily must decide which claims, ranges, contraindications, risks, aftercare, warning signs, and follow-up statements are accurate for her actual products, techniques, and operations.
- **Patient media and testimonials:** Inventory actual assets, publisher identity, source fidelity, consent scope, responsible professional, privacy metadata, expiry, and takedown evidence outside the repository.
- **Clinic operations:** Verify address, hours, map, accessibility/parking/transit facts, response window, account access, urgent-message route, retention/deletion, and follow-up capacity before promising them.
- **Analytics governance:** Decide lawful basis and consent wording, audit GA links/signals/retention/access/enhanced measurement, and resolve the event-name/parameter vocabulary conflict before implementation.
- **Local audience and procedure priority:** No Brazil/Belo Horizonte evidence identifies a winning cohort or procedure. Require observed qualified-consultation data and local usability evidence.
- **Field performance:** Low traffic may prevent CrUX/Search Console field reporting. Use repeatable lab baselines first and add consented minimal RUM only if the documented decision gate is met.
- **Conversion truth:** A privacy-safe process for counting genuine conversations, scheduled/attended consultations, and eligibility is not yet operationally defined.

## Sources

### Project and Codebase Evidence (HIGH confidence)

- [PROJECT.md](../PROJECT.md) — product goal, existing scope, active requirements, constraints, and current legal uncertainty.
- [STACK.md](./STACK.md) — installed-stack compatibility, measurement contract, audit tooling, performance targets, and search implementation.
- [FEATURES.md](./FEATURES.md) — patient needs, table stakes, differentiators, anti-features, low-traffic validation, and research gaps.
- [ARCHITECTURE.md](./ARCHITECTURE.md) — current Laravel boundaries, target seams, data flows, build order, and release gates.
- [PITFALLS.md](./PITFALLS.md) — compliance blockers, privacy and accessibility hazards, technical failure modes, and pre-launch checklist.

### Official Regulatory, Privacy, and Accessibility Sources (MEDIUM under the project research confidence seam)

- [CFO statement on the August 2026 TRF1 HOF decision](https://website.cfo.org.br/cfo-esclarece-decisao-judicial-sobre-a-harmonizacao-orofacial/) — CFO account of the panel decision, intended challenge, and stated immediate effect.
- [Resolution CFO 196/2019](https://website.cfo.org.br/wp-content/uploads/2019/01/Resolu%C3%A7%C3%A3o-CFO-196-2019.pdf) — dental patient-image publication baseline.
- [CFO guidance on ethical social-media publication](https://website.cfo.org.br/redes-sociais-na-odontologia-fique-atento-as-normas-eticas-e-acerte-na-publicacao-dos-conteudos/) — professional identification and publication constraints.
- [Code of Dental Ethics, Resolution CFO 118/2012](https://sistemas.cfo.org.br/visualizar/atos/RESOLU%C3%87%C3%83O/SEC/2012/118) and [Resolution CFO 271/2025](https://sistemas.cfo.org.br/visualizar/atos/RESOLU%25C3%2587%25C3%2583O/SEC/2025/271) — advertising/ethics baseline and later amendments.
- [CRO-MG warning on procedure-in-progress publication](https://cromg.org.br/noticias/cro-mg-alerta-e-vedada-a-divulgacao-de-transcurso-de-procedimento/) — current local enforcement guidance.
- [Brazilian General Data Protection Law](https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709compilado.htm) and [ANPD cookie guide](https://www.gov.br/anpd/pt-br/centrais-de-conteudo/materiais-educativos-e-publicacoes/guia-orientativo-cookies-e-protecao-de-dados-pessoais.pdf) — sensitive-data, necessity, transparency, choice, and cookie-governance baseline.
- [Brazilian Inclusion Law](https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2015/lei/l13146.htm) and [WCAG 2.2](https://www.w3.org/TR/WCAG22/) — website accessibility duty and implementation standard.

### Official Platform and Search Sources (MEDIUM under the project research confidence seam)

- [Google Analytics event parameters](https://developers.google.com/analytics/devguides/collection/ga4/event-parameters), [PII restriction](https://support.google.com/analytics/answer/6366371), and [health-data warning](https://support.google.com/analytics/answer/13297105) — minimized event design and prohibited data.
- [Google Consent Mode overview](https://developers.google.com/tag-platform/security/concepts/consent-mode) and [setup guidance](https://developers.google.com/tag-platform/security/guides/consent) — default-deny/basic-consent implementation.
- [WhatsApp click-to-chat guidance](https://faq.whatsapp.com/5913398998672934), [Business Messaging Policy](https://business.whatsapp.com/policy), and [Business Terms](https://www.whatsapp.com/legal/business-terms?lang=pt) — handoff behavior and business-channel governance.
- [Google LocalBusiness structured data](https://developers.google.com/search/docs/appearance/structured-data/local-business), [general structured-data policies](https://developers.google.com/search/docs/appearance/structured-data/sd-policies), and [review snippet rules](https://developers.google.com/search/docs/appearance/structured-data/review-snippet) — accurate visible/schema parity and self-serving review limits.
- [Google Business Profile local ranking guidance](https://support.google.com/business/answer/7091) and [representation guidelines](https://support.google.com/business/answer/3038177) — accurate local identity and completeness.
- [Google Core Web Vitals guidance](https://developers.google.com/search/docs/appearance/core-web-vitals) and [web.dev Web Vitals thresholds](https://web.dev/articles/vitals) — field targets and interpretation.

### Patient and Clinical Evidence (MEDIUM)

- [Global survey of facial-aesthetic priorities and concerns](https://pubmed.ncbi.nlm.nih.gov/34626170/) — cost, safety, pain/injection, and unnatural-result barriers.
- [Multinational surveys of beauty and aesthetic procedures](https://pubmed.ncbi.nlm.nih.gov/32153099/) — expectation management, need-based recommendations, communication, and aftercare.
- [The Patient Journey in Facial Aesthetics](https://pubmed.ncbi.nlm.nih.gov/38327550/) — screening, goals/history, education, access, and follow-up consensus.
- [FDA dermal filler patient guidance](https://www.fda.gov/medical-devices/aesthetic-cosmetic-devices/dermal-fillers-soft-tissue-fillers) and [systematic review of hyaluronic-acid filler adverse events](https://pubmed.ncbi.nlm.nih.gov/37563436/) — balanced safety and warning-sign information; Brazilian applicability requires clinician review.

---
*Research completed: 2026-09-08*  
*Ready for roadmap: yes*
