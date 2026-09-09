# Requirements: Dra. Emily Beatriz Website Conversion Review

**Defined:** 2026-09-08
**Core Value:** Turn qualified local visitors into WhatsApp consultation conversations by making the website credible, reassuring, clinically responsible, and easy to act on.

## v1 Requirements

Requirements for the complete website review and conversion-improvement milestone. Each requirement maps to exactly one roadmap phase.

### Governance & Approval

- [x] **GOV-01**: The project team can review a complete inventory of every public page, conversion path, clinical claim, professional claim, patient image, testimonial, analytics integration, and structured-data output before changes are released
- [ ] **GOV-02**: A visitor sees Dra. Emily's verified full name, the designation “cirurgiã-dentista,” her current CRO-MG registration, and only qualifications or specialties confirmed by current registration evidence
- [ ] **GOV-03**: Every published clinical claim has an identifiable source, content owner, last-reviewed date, and recorded approval from Dra. Emily
- [ ] **GOV-04**: Every published patient image or testimonial has documented provenance, written authorization, responsible-professional attribution, and a current decision confirming that its use is permitted in this publishing context
- [ ] **GOV-05**: Scope- and specialty-sensitive HOF wording cannot be released until a dated CRO-MG or qualified legal review addresses the current August 2026 regulatory uncertainty
- [ ] **GOV-06**: The team can verify clinic identity, address, contact details, opening hours, directions, accessibility information, WhatsApp operations, and follow-up promises against current real-world operations before release

### Positioning & Clinical Content

- [ ] **CONT-01**: A visitor immediately understands that the site offers individualized facial-aesthetic assessment with Dra. Emily in Belo Horizonte and does not promise a predetermined procedure or result
- [ ] **CONT-02**: A visitor who does not know which procedure they need can follow a non-diagnostic concern-based path into a personalized WhatsApp consultation
- [ ] **CONT-03**: A visitor can understand what each procedure is intended to address, what it may not achieve, how the plan is individualized, and why another treatment or no treatment may be recommended
- [ ] **CONT-04**: A visitor can review clinician-approved, non-guaranteed ranges for onset, duration, recovery, discomfort, and expected temporary effects wherever those facts are relevant
- [ ] **CONT-05**: A visitor can review balanced, clinician-approved information about material risks, warning signs, aftercare, and the correct care channel without mistaking the page for diagnosis or informed consent
- [ ] **CONT-06**: A visitor is clearly told that candidacy depends on private assessment of goals, health history, medications, prior procedures, anatomy, and risk factors
- [ ] **CONT-07**: A visitor can find direct, bounded answers to the principal objections around artificial results, safety, pain or needles, recovery, durability, cost uncertainty, and not knowing which procedure is appropriate
- [ ] **CONT-08**: No visible or machine-readable content guarantees naturalness, safety, symmetry, duration, confidence, universal candidacy, or a repeatable result
- [ ] **CONT-09**: Brazilian Portuguese copy uses respectful, autonomy-preserving language and avoids shame, defect framing, aging panic, coercive urgency, or an idealized “perfect face”

### Trust & Patient Journey

- [ ] **TRUST-01**: A visitor can verify who will assess or treat them, where care occurs, and how Dra. Emily's qualifications relate to the services described
- [ ] **TRUST-02**: A visitor can understand the complete journey from initial WhatsApp contact through assessment, recommendation and estimate, consent, treatment when indicated, aftercare, and follow-up
- [ ] **TRUST-03**: A visitor can understand what happens after opening WhatsApp, including verified service hours or response expectations, without being promised immediate clinical evaluation
- [ ] **TRUST-04**: A visitor can distinguish authentic, authorized patient evidence from illustrative or educational imagery, and is reminded that individual results vary
- [ ] **TRUST-05**: A visitor can access consistent, verified clinic location information and a genuine Google Business Profile or directions path from every relevant page
- [ ] **TRUST-06**: A visitor can see who clinically reviewed health-related content and when that review occurred

### WhatsApp Conversion

- [ ] **WA-01**: A visitor can start the primary WhatsApp consultation from every relevant homepage and procedure-page decision point on mobile and desktop
- [ ] **WA-02**: Every primary CTA uses a consistent consultation-first label and remains visually distinguishable from secondary navigation or procedure-discovery links
- [ ] **WA-03**: The prefilled WhatsApp message identifies only a controlled page or procedure context and never contains a name, phone number, symptom, diagnosis, image request, message body, or other sensitive information
- [ ] **WA-04**: A visitor has a working direct-contact fallback if WhatsApp cannot be opened
- [ ] **WA-05**: A visitor can review a clear privacy notice at the conversion boundary and is not encouraged to place unnecessary sensitive health information in the initial message

### Measurement & Learning

- [ ] **MEAS-01**: The owner can measure a named `whatsapp_consultation_click` event with controlled `source_page`, `procedure`, and `cta_placement` values
- [ ] **MEAS-02**: Analytics never receives WhatsApp message text, full WhatsApp URLs, names, phone numbers, health concerns, photos, free text, or identifiers joined to patient records
- [ ] **MEAS-03**: Analytics collection follows a documented LGPD and consent decision, with configuration, retention, access, and consent behavior verified before release
- [ ] **MEAS-04**: The owner can validate analytics events in a test or debug environment and distinguish eligible page views from CTA clicks
- [ ] **MEAS-05**: The clinic can maintain a privacy-preserving aggregate count of genuine conversations, consultations scheduled, consultations attended, and clinically eligible leads without exporting clinical detail to GA4
- [ ] **MEAS-06**: The owner receives a documented baseline and minimum-evidence rule before changing audience or procedure prominence, preventing low traffic from being interpreted as conclusive
- [ ] **MEAS-07**: The team can collect structured qualitative feedback through task-based usability sessions when traffic is insufficient for quantitative experimentation

### Accessibility & Experience

- [ ] **UX-01**: A visitor can understand and complete the primary journey at 320px mobile width and on representative tablet and desktop layouts without hidden, overlapping, or horizontally scrolling content
- [ ] **UX-02**: A keyboard or assistive-technology user can navigate the site, identify landmarks and headings, operate menus and disclosures, follow CTAs, and perceive visible focus in a logical order
- [ ] **UX-03**: Text, controls, focus indicators, and meaningful imagery meet the agreed WCAG 2.2 AA contrast, alternative-text, reflow, zoom, target-size, reduced-motion, and semantic requirements
- [ ] **UX-04**: Page hierarchy prioritizes patient concern, professional trust, individualized evaluation, realistic expectations, and consultation before decorative luxury cues or procedure merchandising
- [ ] **UX-05**: The visual experience remains consistent across the homepage, standard procedure pages, specialized Full Face page, navigation, footer, FAQs, and conversion components

### Search, Performance & Release Quality

- [ ] **QUAL-01**: Every indexable page has unique, accurate Portuguese titles, descriptions, canonical URLs, headings, internal links, and visible content aligned with its search intent
- [ ] **QUAL-02**: Local-business, professional, procedure, breadcrumb, and FAQ structured data uses only supported types and properties, matches visible verified content, and passes applicable validators
- [ ] **QUAL-03**: The sitemap contains every intended canonical public URL and excludes invalid or non-indexable routes
- [ ] **QUAL-04**: Homepage and procedure pages meet agreed Core Web Vitals lab targets, reserve media dimensions, load responsive formats, and avoid unnecessary JavaScript or render-blocking work
- [ ] **QUAL-05**: Automated tests cover the homepage, every configured procedure route, invalid procedure handling, WhatsApp CTA contracts, metadata, structured data, sitemap output, and privacy-safe analytics parameters
- [ ] **QUAL-06**: A production asset build, focused Laravel tests, full test suite, formatter, structured-data validation, accessibility checks, and representative mobile/desktop browser smoke tests pass before release
- [ ] **QUAL-07**: The release checklist blocks publication when clinical approval, professional-status evidence, patient-media authorization, privacy approval, operational facts, or required automated verification is missing

## v2 Requirements

Deferred capabilities that are not needed to complete the current website-wide conversion review.

### Acquisition Expansion

- **ACQ-01**: The owner can publish campaign-specific landing pages after the baseline conversion journey is validated
- **ACQ-02**: The owner can run controlled A/B tests after traffic reaches a documented minimum sample threshold
- **ACQ-03**: The owner can integrate qualified lead outcomes with a CRM using an approved privacy and consent model
- **ACQ-04**: A visitor can request an appointment through direct scheduling if clinic operations adopt a supported booking workflow

### Patient Services

- **SERV-01**: A patient can complete approved private intake outside the public marketing and analytics boundary
- **SERV-02**: A patient can access a secure portal for records, consent, follow-up, or clinical communication
- **SERV-03**: The clinic can use non-diagnostic messaging automation for identity, hours, and routing after separate compliance and operational approval

## Out of Scope

Explicit exclusions documented to prevent scope creep and unsafe conversion tactics.

| Feature | Reason |
|---------|--------|
| Automated diagnosis, face scoring, selfie analysis, candidacy decisions, or treatment recommendations | A public marketing experience cannot safely assess clinical suitability or anatomy |
| AI or edited simulations presented as expected outcomes | They may create unrealistic expectations and imply guaranteed results |
| Guaranteed results, risk-free language, or universal duration claims | Clinical outcomes and adverse effects vary by patient, product, technique, and follow-up |
| Price-led acquisition, discounts, giveaways, countdowns, or scarcity pressure | The milestone prioritizes reflective consultation and avoids unapproved mercantilist or coercive tactics |
| Indiscriminate before-and-after galleries or unattributed testimonials | Patient media requires provenance, written authorization, professional attribution, and current publishing approval |
| Procedure-in-progress or sensational injection media | It can trivialize risk and conflicts with professional advertising guidance |
| Open-ended health intake inside the public website or analytics pipeline | It would expand sensitive-data, security, retention, and incident-response obligations beyond this milestone |
| Online booking, CRM, chatbot, authentication, patient portal, or clinical-record features | WhatsApp consultation remains the v1 conversion and the site remains a public acquisition experience |
| Framework replacement or database-backed content management | Laravel, Blade, Tailwind, and configuration-backed content already fit the small public site |
| Selecting a flagship procedure from intuition or low-volume data | Procedure prominence requires qualified lead and consultation evidence |

## Traceability

Which phases cover which requirements. Every v1 requirement maps to exactly one phase.

| Requirement | Phase | Status |
|-------------|-------|--------|
| GOV-01 | Phase 1 | Complete |
| GOV-02 | Phase 2 | Pending |
| GOV-03 | Phase 1 | Pending |
| GOV-04 | Phase 1 | Pending |
| GOV-05 | Phase 1 | Pending |
| GOV-06 | Phase 1 | Pending |
| CONT-01 | Phase 3 | Pending |
| CONT-02 | Phase 3 | Pending |
| CONT-03 | Phase 3 | Pending |
| CONT-04 | Phase 3 | Pending |
| CONT-05 | Phase 3 | Pending |
| CONT-06 | Phase 3 | Pending |
| CONT-07 | Phase 3 | Pending |
| CONT-08 | Phase 3 | Pending |
| CONT-09 | Phase 3 | Pending |
| TRUST-01 | Phase 2 | Pending |
| TRUST-02 | Phase 3 | Pending |
| TRUST-03 | Phase 3 | Pending |
| TRUST-04 | Phase 2 | Pending |
| TRUST-05 | Phase 2 | Pending |
| TRUST-06 | Phase 2 | Pending |
| WA-01 | Phase 3 | Pending |
| WA-02 | Phase 3 | Pending |
| WA-03 | Phase 2 | Pending |
| WA-04 | Phase 3 | Pending |
| WA-05 | Phase 2 | Pending |
| MEAS-01 | Phase 4 | Pending |
| MEAS-02 | Phase 4 | Pending |
| MEAS-03 | Phase 1 | Pending |
| MEAS-04 | Phase 4 | Pending |
| MEAS-05 | Phase 6 | Pending |
| MEAS-06 | Phase 6 | Pending |
| MEAS-07 | Phase 6 | Pending |
| UX-01 | Phase 3 | Pending |
| UX-02 | Phase 3 | Pending |
| UX-03 | Phase 3 | Pending |
| UX-04 | Phase 3 | Pending |
| UX-05 | Phase 3 | Pending |
| QUAL-01 | Phase 5 | Pending |
| QUAL-02 | Phase 5 | Pending |
| QUAL-03 | Phase 5 | Pending |
| QUAL-04 | Phase 5 | Pending |
| QUAL-05 | Phase 5 | Pending |
| QUAL-06 | Phase 5 | Pending |
| QUAL-07 | Phase 5 | Pending |

**Coverage:**

- v1 requirements: 45 total
- Mapped to phases: 45
- Unmapped: 0 ✓

## Definition of Done

- All 45 v1 requirements are mapped to exactly one roadmap phase and verified against observable evidence
- Every public page and conversion path has been reviewed on representative mobile and desktop viewports
- Dra. Emily has approved clinical claims, procedure facts, expectations, aftercare, and warning-sign language
- Current professional-status, advertising, patient-media, and privacy decisions are documented before release
- WhatsApp conversion events are privacy-safe and verified without transferring health or identifying information to GA4
- Automated tests, production build, formatting, accessibility checks, structured-data validation, and browser smoke tests pass
- A baseline report defines how future audience and procedure-priority decisions will be made without overreading low traffic

---
*Requirements defined: 2026-09-08*
*Last updated: 2026-09-08 after roadmap creation*
