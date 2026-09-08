# Architecture Patterns

**Domain:** Local facial-aesthetics patient-acquisition website
**Project:** Dra. Emily Beatriz — Website Conversion Review
**Researched:** 2026-09-08
**Overall confidence:** MEDIUM — HIGH for the observed codebase and proposed integration boundaries; MEDIUM for analytics/privacy and search guidance; professional advertising and scope-sensitive decisions still require current CRO-MG or qualified legal approval.

## Recommended Architecture

Keep the current Laravel 13 request/controller/Blade/configuration architecture. Do not introduce a CMS, SPA, Livewire state, database-backed lead flow, CRM, or server-side analytics pipeline for this milestone. The site is small, public, and primarily informational; its strongest architectural property is that routes, visible content, metadata, structured data, and sitemap entries can share the same version-controlled sources.

The improvement should add four narrow seams to the existing structure:

1. **Approved content seam:** clinic identity, procedure copy, FAQs, and approved social proof remain PHP configuration, but clinical claims and publication rights carry explicit review metadata. Visible pages and JSON-LD must consume the same approved values.
2. **Journey composition seam:** `welcome.blade.php`, `procedure.blade.php`, and the specialized Full Face view remain page composers. Extract only sections that must behave identically across pages: WhatsApp CTA, professional trust block, review disclaimer/provenance, and consent notice.
3. **Measurement seam:** every WhatsApp link uses a reusable Blade component with a small, closed analytics taxonomy. A minimal module in `resources/js/app.js` sends an event only after the approved analytics/consent condition is satisfied. Navigation to WhatsApp never depends on tracking success.
4. **Release-gate seam:** automated tests verify rendering, parity, semantics, and event attributes; clinical, advertising, patient-media, and privacy approvals verify meaning and legality. Automation cannot substitute for those human approvals.

```text
 AUTHORING / APPROVAL FLOW

 Copy and media inventory
          │
          ├── clinical claims ──> treating-professional review ─┐
          ├── titles/advertising ──> compliance review ─────────┤
          ├── patient media ──> authorization verification ─────┤
          └── analytics/cookies ──> privacy basis approval ─────┘
                                                               │ release gate
                                                               ▼
 config/clinic.php + config/procedures.php + config/faq.php
 + small config-backed social-proof/review records if retained
                         │
             ┌───────────┴───────────┐
             ▼                       ▼
       Visible Blade pages      JSON-LD + sitemap
             └───────────┬───────────┘
                         ▼
                 parity contract tests


 PATIENT / CONVERSION FLOW

 Concern or uncertainty
          ▼
 Clear natural-results and individualized-assessment promise
          ▼
 Verified professional identity + location + what assessment involves
          ▼
 Concern-led guidance ──> procedure education ──> limits/risks/follow-up
          ▼
 Approved proof and realistic expectations
          ▼
 Descriptive WhatsApp consultation CTA
          ├────────────────────────────> wa.me (always works)
          └─ if analytics allowed ─────> GA4 whitelisted click event
```

### Patient Journey Structure

The homepage should stop behaving like a catalogue headed by a transformation promise and become an orientation page for a cautious prospective patient. Preserve the existing single page, anchors, and procedure routes, but order its sections as:

1. **Concern-aware hero:** naturalness, individualized assessment, and uncertainty about the right approach; primary CTA is a conversation, not purchase or guaranteed transformation.
2. **Immediate trust facts:** verified professional name/title, CRO identifier, Belo Horizonte location, and a concise explanation of the assessment. Do not publish an unverified specialty label.
3. **Concern-to-guidance bridge:** explain that different concerns may have different or no procedural indications. Link to procedure education without diagnosing the visitor.
4. **Professional approach and safety:** assessment, expectation setting, clinical decision-making, contraindication discussion, and follow-up. Content must be clinically reviewed.
5. **Procedure discovery:** neutral options from `config/procedures.php`; no featured/flagship treatment until traffic and lead-quality data justify it.
6. **Evidence/social proof:** before-and-after images and testimonials only when provenance, patient authorization, attribution, disclaimers, and advertising treatment have passed the release gate.
7. **Practical FAQ:** safety, discomfort, recovery, duration uncertainty, candidacy, consultation process, and location, using the same config that feeds eligible schema.
8. **Final consultation CTA:** state what happens after the click and that indication/outcomes are individualized.

Procedure pages should use a consistent question sequence: “Could this address my concern?” → “What is it?” → “How is suitability assessed?” → “What can and cannot be expected?” → “What are the risks, recovery, and follow-up?” → “How does the consultation work?” → WhatsApp. Related procedures belong after the core safety/expectation content, not before it. `full-face.blade.php` may retain its specialized educational section, but it should conform to the same trust, CTA, review, and measurement contracts as the standard procedure view.

### Component Boundaries

| Component | Responsibility | Communicates With |
|-----------|----------------|-------------------|
| `routes/web.php` | Preserve named home, procedure, and sitemap routes; optionally add a simple named privacy/cookie notice route. Keep route logic thin. | `ProcedureController`, Blade views, route tests |
| `ProcedureController` | Resolve an allow-listed config slug, fail closed for unknown procedures, and select the standard or specialized view. | `config/procedures.php`, procedure views |
| Clinic/procedure/FAQ configuration | Canonical source for verified identity, locality, patient-facing copy, SEO fields, procedure relationships, WhatsApp message templates, and review metadata. | Page composers, CTA component, schema partials, sitemap, tests |
| Social-proof configuration, if proof is retained | Move inline testimonials/result records out of `welcome.blade.php`; expose only publication-approved entries with source label, disclaimer, and a non-sensitive authorization reference. Actual consent evidence stays outside the repository. | Homepage proof section, compliance tests |
| `x-site-layout` | Shared document shell, metadata, canonical link, Vite assets, skip link, navigation/footer, per-page schema slot, and consent-aware analytics bootstrap. It must not contain page-specific clinical claims. | All public pages, analytics loader, schema slot |
| `welcome.blade.php` | Compose the homepage patient journey from approved config and shared components. | Layout, procedures/FAQ/social proof config, trust and CTA components |
| `procedure.blade.php` | Compose the shared procedure journey and render the common procedure content shape. | Procedure config, layout, schema and CTA components |
| `procedures/full-face.blade.php` | Render Full Face-only educational structures while honoring all common procedure contracts. Avoid copying common CTA, FAQ, trust, and disclaimer behavior. | Procedure config and shared components |
| `x-whatsapp-cta` (new anonymous Blade component) | Generate the `wa.me` URL, consistent accessible label, external-link attributes, visual variants, and whitelisted analytics data attributes. | Clinic/procedure config, `resources/js/app.js`, all CTA placements |
| Trust/review components (small, optional extraction) | Render verified professional identity and approved proof/disclaimer markup consistently. Extract only when reused by multiple pages. | Clinic/social-proof config, page composers |
| `x-picture` | Continue owning image rendering, intrinsic dimensions, WebP selection, loading mode, fetch priority, and optional responsive sources. It does not decide whether patient media is approved. | Page components and public assets |
| Schema partials | Emit only claims and entities that are visible, applicable, and approved, using the same config values as the page. No separate specialty, review, payment, hours, or procedure assertions. | Clinic/procedure/FAQ config, layout schema slot, parity tests |
| Consent/analytics module | Store the visitor's analytics choice, load GA4 only under the approved policy, disable advertising signals, and delegate clicks from CTA data attributes into one whitelisted event. | Layout consent UI, `x-whatsapp-cta`, GA4 |
| Pest feature tests | Render the real routes and verify cross-layer contracts without mocking Blade/config. | Routes, config, views, schema, CTA markup |
| Human release checklist | Approve the exact content revision, title/scope wording, patient-media evidence, testimonials, privacy basis, and GA4 configuration. | Treating professional, compliance/legal reviewer, deployment decision |

Do not add a repository/service layer around the static arrays. If content editing later becomes frequent or multi-author, a CMS can be reconsidered; it is not justified for five procedures and one homepage.

### Content and Approval Boundary

Configuration should remain the canonical runtime content store. Extend its schema rather than scattering new strings through Blade. A proportional procedure record can add patient-journey and review fields without creating a new domain model:

```php
'botox' => [
    'name' => '...',
    'concerns' => ['...'],
    'what_is' => ['...'],
    'assessment' => ['...'],
    'expectations' => ['...'],
    'risks_and_recovery' => ['...'],
    'follow_up' => ['...'],
    'faq' => [...],
    'review' => [
        'content_version' => '2026-09-08-1',
        'clinical_approved_at' => null,
        'advertising_approved_at' => null,
    ],
];
```

The dates/versions are workflow signals, not proof by themselves. Sign-off should reference the exact Git commit or content version in a private review record. Deployment remains blocked when the public diff contains clinical or promotional copy that is not covered by that review.

For patient images/testimonials, keep only public copy plus an opaque internal authorization reference in configuration. Never commit consent forms, identity documents, clinical records, health details, private messages, or additional patient identifiers. Missing or false publication approval must fail closed by omitting the item.

### WhatsApp CTA Contract

All WhatsApp links should share one stable component contract. Page composers choose the message context and visual variant; the component owns link construction and measurement attributes.

```blade
<x-whatsapp-cta
    placement="hero"
    page-type="procedure"
    :procedure-slug="$slug"
    :message="$procedure['whatsapp_message']"
>
    Conversar sobre uma avaliação de {{ $procedure['name'] }}
</x-whatsapp-cta>
```

Use a closed, documented taxonomy:

| Field | Allowed examples | Rule |
|------|------------------|------|
| Event name | `whatsapp_consultation_click` | One event means a website click that opens WhatsApp; it does not mean a sent message, qualified lead, booked consultation, or patient. |
| `page_type` | `home`, `procedure`, `privacy` | Low-cardinality enum, not the full URL or title. |
| `procedure_slug` | configured slug or `none` | Derived from server config; never inferred from user text. |
| `cta_placement` | `nav`, `hero`, `mid_content`, `proof`, `final`, `footer` | Stable enum shared across templates. Do not encode arbitrary labels or DOM paths. |

Do not send prefilled message text, query strings, link URLs, patient concerns, names, phone numbers, email addresses, testimonial names, user/session IDs, exact location, or any free text. Because Google documents both PII restrictions and special sensitivity around health information, the final analytics taxonomy and legal basis must pass privacy review even though it is coarse.

The event handler should use delegated click handling so dynamically rearranged CTAs keep working, must not call `preventDefault()`, and must tolerate blocked scripts, denied consent, offline state, and ad blockers. Register the three parameters as event-scoped custom dimensions in GA4 and verify them in Realtime/DebugView. Mark the event as a GA4 key event only with a written definition that it measures an outbound consultation click, not a completed consultation.

### Measurement and Privacy Boundary

```text
Browser-rendered page
       │
       ├── click WhatsApp link ───────────────> WhatsApp/Meta boundary
       │          (prefilled generic context only; no site form data)
       │
       └── approved analytics condition?
                  ├── no  ──> no GA network load/event; link still opens
                  └── yes ──> GA4 event with three whitelisted enums

No site database, no server-side lead endpoint, no Measurement Protocol,
no CRM, and no capture of WhatsApp conversation content in this milestone.
```

The current layout loads GA4 unconditionally. The conservative recommendation for this health-adjacent acquisition site is to default analytics off and load the Google tag only after the visitor accepts analytics cookies, with an equally clear reject path and a revocable preference. Disable Google signals and advertising-personalization signals; do not enable remarketing, cross-service audience enrichment, or user-provided data. If counsel documents a different lawful basis for strictly aggregate audience measurement, preserve the same minimization/event contract and change only the loader policy.

Add a short privacy/cookie notice as a normal Blade page using the shared layout. It should describe controller identity, purposes, third parties, cookie categories, retention/configuration, rights/contact, and the effect of choosing or withdrawing analytics. Legal/compliance owns the wording. Do not use a heavyweight consent platform for one analytics category unless operational or legal requirements expand.

## Data Flow

### 1. Home Request and Concern-to-Consultation Flow

1. `Route::view('/', 'welcome')` remains the home entry point.
2. `welcome.blade.php` reads approved clinic, procedure, FAQ, and optional social-proof config.
3. The page composes sections in patient-decision order: concern → verified trust → individualized approach → procedure orientation → safety/expectations → approved proof → FAQ → consultation.
4. `x-site-layout` emits consistent metadata, navigation, footer, Vite assets, skip link, consent UI/bootstrap, and the page schema slot.
5. Each `x-whatsapp-cta` renders a functional `wa.me` link with descriptive copy and only the closed data attributes.
6. A click opens WhatsApp regardless of consent or analytics status. If analytics is allowed and loaded, `app.js` sends exactly one `whatsapp_consultation_click` event.

### 2. Procedure Request Flow

1. The configured route constraint and `ProcedureController` continue to reject unknown slugs.
2. The controller passes the slug and one configuration record to the standard or specialized view.
3. The view presents the same decision sequence for every treatment. Optional sections are conditional on present, approved config fields rather than view-specific hard-coding.
4. The procedure schema partial consumes the same approved identity, copy, FAQ, and canonical URL as visible markup.
5. CTA records use `page_type=procedure`, the configured slug, and a placement enum. No data comes from query strings or visitor input.

### 3. Social-Proof Flow

1. A reviewer verifies source, attribution, exact approved quote/image, publication authorization, required disclaimer, and current advertising treatment outside the public repository.
2. A version-controlled record references that approval with an opaque identifier and explicit publication status.
3. Blade renders only approved records. JSON-LD must not add review/rating claims merely because testimonials are visible; structured-data eligibility is independently checked.
4. Revocation or expiry changes the config record and removes the item everywhere on the next deployment.

### 4. Search/Structured-Data Flow

1. Verified clinic identity and procedure facts enter configuration once.
2. Visible pages, metadata, schema, and sitemap consume those values through existing shared layout/partials.
3. Feature tests compare visible copy with structured data and ensure professional identifiers/titles are identical.
4. Rich Results Test and URL Inspection validate the deployed output. Search presentation is not assumed or guaranteed.

## Patterns to Follow

### Pattern 1: Configuration as Approved Content Contract

**What:** Treat each config record as a typed content contract shared by pages, metadata, schema, sitemap, and tests. Add fields to the common shape before adding one-off Blade strings.

**When:** Any change to clinic identity, procedure claims, FAQ, CTA messages, locality, or social proof.

**Example:** A verified professional title is stored once in `config/clinic.php`; the trust block and JSON-LD both render it. The current hard-coded “Especialista em Harmonização Orofacial” strings in page metadata/schema must not survive unless current registration and compliance review explicitly authorize them.

### Pattern 2: Render-Time Parity

**What:** Visible content and machine-readable content are two projections of the same approved record.

**When:** Metadata, FAQPage, LocalBusiness/Dentist/Person, breadcrumb, and procedure schema.

**Example:** Extend the existing homepage FAQ parity test to every configured procedure and to professional name/title/CRO. Schema should never contain a claim, service, hour, price/payment fact, specialty, or location absent from the visible approved source.

### Pattern 3: One CTA, Many Placements

**What:** Use one reusable WhatsApp component with semantic link text, visual variants, a generic prefilled message, and whitelisted measurement attributes.

**When:** Navigation, hero, mid-content reassurance, proof section, final CTA, and footer.

**Example:** The page chooses `placement="final"`; the component produces a valid WhatsApp URL and `data-cta-placement="final"`. JavaScript reads only the three allowed enums.

### Pattern 4: Progressive Enhancement

**What:** All information, navigation, FAQ disclosure, and WhatsApp links work in server-rendered HTML. JavaScript enhances analytics and consent only.

**When:** Every public page.

**Example:** A blocked Google tag means only lost measurement. It must never block the click, hide content, change the WhatsApp target, or prevent the patient from reaching clinic contact details.

### Pattern 5: Shared Fixes at the Narrowest Common Boundary

**What:** Put cross-site behavior in the existing shared component, not in every page.

**When:** Skip link, focus visibility, fixed-navigation offsets, reduced motion, metadata, consent bootstrap, image behavior, and CTA tracking.

**Example:** Reduced-motion rules belong in `resources/css/app.css`; skip link and analytics bootstrap belong in `x-site-layout`; hero-image priority belongs in `x-picture` props at the page call site.

### Pattern 6: Evidence Before Optimization

**What:** Record a baseline, use a stable event definition, and optimize based on page/procedure/placement aggregates rather than intuition.

**When:** Deciding hero copy, CTA prominence, procedure ordering, audience narrowing, or a flagship treatment.

**Example:** Keep procedure ordering neutral until enough traffic and consultation-quality evidence exists. A click-rate difference alone cannot establish clinical suitability, lead quality, or revenue value.

## Accessibility, Performance, and SEO Integration

These are cross-cutting contracts, not separate rewrites.

### Accessibility

- Add a skip link and preserve native `header`/`nav`/`main`/`footer` landmarks.
- Keep one descriptive `h1` and logical headings; CTA purpose should be understandable without relying on the WhatsApp icon.
- Provide visible focus styling and ensure the fixed navigation or any future sticky mobile CTA cannot fully obscure focused elements.
- Add scroll margin for anchored sections so fixed navigation does not hide their headings.
- Preserve native `<details>/<summary>` behavior; do not replace it with a custom accordion.
- Test color contrast, zoom/reflow, keyboard order, target sizes, and screen-reader names rather than inferring accessibility from Tailwind classes.
- Under `prefers-reduced-motion: reduce`, disable smooth scrolling and transform animations and force currently animated content to full opacity. The current animation utilities begin at `opacity: 0`, so the reduced-motion fallback must explicitly reveal content.

### Performance

- Preserve server rendering and keep client JavaScript small.
- The homepage hero already uses eager loading and high fetch priority. Apply the same treatment to above-the-fold procedure hero images, which currently use lazy loading.
- Continue explicit `width`/`height` to reserve aspect ratio. Add responsive `srcset`/`sizes` only when real appropriately sized variants exist; do not generate decorative complexity without measurement.
- Lazy-load below-the-fold patient/procedure media.
- Audit the two external font stylesheets and loaded weights; self-host or reduce weights if they materially delay text rendering. Preserve a usable system-font fallback.
- Load analytics only after the approved condition, reducing third-party work for visitors who decline.
- Measure home plus one standard procedure and Full Face. Use Lighthouse for lab diagnosis and field Core Web Vitals when traffic becomes sufficient; do not optimize toward a single synthetic score.

### SEO and Local Trust

- Preserve named routes, canonicals, and config-driven sitemap generation.
- Make clinic name, address, phone, professional title, CRO, and profile links consistent across visible content and structured data.
- Use only applicable structured-data types and properties. Re-audit `Physician`, `medicalSpecialty`, `jobTitle`, `knowsAbout`, hours, payment, and procedure claims before release; syntactic validity is not evidence that a claim is correct or eligible.
- Keep titles/descriptions descriptive and non-guaranteeing. The treating professional should be visibly identified as reviewer/author where appropriate.
- Keep FAQ schema only when visible parity and current eligibility guidelines are met; never promise a rich result.
- Validate representative pages with Rich Results Test, then use Search Console URL Inspection after deployment.

## Anti-Patterns to Avoid

### Anti-Pattern 1: A Redesign Before a Claim and Journey Audit

**What:** Rebuild page visuals while leaving duplicated guarantees, unverified specialty wording, inconsistent CTAs, or unsupported schema intact.

**Why bad:** It increases review surface and can amplify the highest-risk content without improving trust.

**Instead:** Inventory every claim and conversion point first, close the clinical/compliance gates, then restructure using approved sources.

### Anti-Pattern 2: Tracking WhatsApp Through a Redirect Endpoint

**What:** Route clicks through Laravel or a database to log them before redirecting to WhatsApp.

**Why bad:** It adds latency, availability risk, bot noise, privacy obligations, and a persistence subsystem while still not proving a message was sent.

**Instead:** Keep the direct `wa.me` link and send a consent-aware browser event independently.

### Anti-Pattern 3: Passing URLs, Messages, or User Text to Analytics

**What:** Send full `href`, prefilled message, page query string, arbitrary CTA text, contact details, or typed concern as event parameters.

**Why bad:** URLs/messages can contain PII or health-adjacent information and create high-cardinality, hard-to-govern data.

**Instead:** Emit only closed enums derived from server configuration.

### Anti-Pattern 4: Schema as a Second Marketing Channel

**What:** Put stronger titles, more services, guarantees, review claims, or specialty assertions in JSON-LD than are visible and approved on the page.

**Why bad:** It creates factual drift, compliance risk, and structured-data policy violations.

**Instead:** Project the same approved configuration into visible and machine-readable outputs and test parity.

### Anti-Pattern 5: Boolean Approval as the Only Evidence

**What:** Treat `approved => true` in a public code record as sufficient clinical, legal, or consent evidence.

**Why bad:** Anyone editing code can change it, and it does not identify the reviewed revision or preserve underlying authorization.

**Instead:** Use runtime metadata to fail closed, but keep signed/private evidence and tie approval to the exact content version or commit.

### Anti-Pattern 6: Over-Componentization

**What:** Turn every visual section into a PHP class, service, repository, or generic page-builder block.

**Why bad:** Five procedure pages do not justify a page-builder abstraction, and generic schemas make clinical copy harder to review.

**Instead:** Extract only behavior with a real cross-page contract; leave page ordering and unique content in Blade composers.

### Anti-Pattern 7: Optimizing for Click Quantity Alone

**What:** Name a flagship procedure or make increasingly aggressive promises because one CTA placement has more clicks.

**Why bad:** A WhatsApp click is an intent signal, not qualification, suitability, booking, treatment, or revenue.

**Instead:** Combine aggregate site data with manually reviewed lead-quality/business outcomes before changing strategic prominence.

## Safe Build Order

| Order | Work | Dependencies | Gate to Exit |
|------|------|--------------|--------------|
| 1 | **Baseline and full audit:** inventory routes, sections, CTA placements, claims, schema fields, media, testimonials, current pageview/search data, accessibility defects, and representative performance. | Existing site | Audit covers home, every procedure template, mobile/desktop, and all public/machine-readable claims. No redesign yet. |
| 2 | **Clinical/compliance/privacy decisions:** claim matrix, verified CRO/title, scope-sensitive wording, social-proof authorization, advertising treatment, analytics legal basis, consent behavior, and privacy notice requirements. | Audit inventory | Treating-professional clinical approval and current compliance/legal approval are recorded for the exact revision. Patient-media evidence is verified. Unresolved items are removed or withheld. |
| 3 | **Content contract and shared seams:** centralize verified identity, move retained inline proof to config, define review metadata, create `x-whatsapp-cta`, and make schema consume the same config. | Approved decisions | Config-shape and parity tests pass; missing proof approval fails closed; all CTA URLs and enums render correctly. |
| 4 | **Patient-journey rewrite:** reorder homepage and common procedure flow around concern, trust, individualized assessment, expectations, safety, follow-up, and consultation. Bring Full Face under the same contracts. | Approved content contract and shared components | Clinical/compliance reviewer approves the final rendered copy, not only source text. Conversion UAT confirms correct WhatsApp context at each placement. |
| 5 | **Measurement and consent:** implement the minimal loader, preference controls, three-parameter event, custom definitions, and documented key-event meaning. | Stable CTA component; privacy approval | No GA request before the approved condition; accept/reject/withdraw work; one click yields at most one event; WhatsApp works with analytics blocked; DebugView shows only whitelisted parameters. |
| 6 | **Accessibility, performance, and SEO hardening:** shared focus/reduced-motion/anchor fixes, hero image priority, responsive media/font work, metadata/schema cleanup, and sitemap checks. | Stable page structure | WCAG-oriented manual/automated checks pass; representative Lighthouse regressions resolved; Rich Results Test and local rendered-schema tests pass. |
| 7 | **Launch validation and observation:** production smoke test, URL inspection, event verification, baseline annotation, and a defined review window. | All preceding gates | No unresolved critical clinical/compliance/privacy issue; route/build/test matrix passes; monitoring ownership and decision thresholds are documented. |

The gates intentionally allow technical scaffolding on a branch before approval but do not allow unreviewed clinical, specialty, social-proof, or tracking claims to reach production.

## Verification Gates

### Automated Repository Gate

Use the existing Pest style: real HTTP requests, rendered HTML parsing, strict expectations, and file-local helpers.

- Home, sitemap, every configured procedure, and unknown slug response tests.
- Dataset-driven test that each procedure record contains required journey/review fields and selects an existing approved view.
- Visible FAQ/schema parity for home and every procedure.
- Visible and schema professional name/title/CRO parity; no hard-coded contradictory specialty title.
- Every WhatsApp CTA has a valid direct `wa.me` URL, descriptive visible/accessibility text, `rel="noopener noreferrer"` when opening a new tab, and allowed `page_type`, `procedure_slug`, and `cta_placement` values.
- No review/rating JSON-LD unless a separately approved and policy-eligible implementation is introduced.
- Social proof and patient media render only from publication-approved records.
- Image contract tests for intrinsic dimensions and eager/high-priority treatment of representative hero media.
- `php artisan test --compact`; if PHP changes, `vendor/bin/pint --dirty --format agent`; compile production assets with `npm run build`.

Do not add a JavaScript unit-test framework solely for the short delegated handler. Verify it with browser UAT and GA4 DebugView. Add frontend tests only if client behavior becomes materially more complex.

### Clinical and Compliance Gate

- Treating professional reviews benefits, mechanism, indications, candidacy, contraindications, risks, duration, recovery, aftercare, follow-up, and comparative statements.
- Compliance/legal reviewer verifies professional identification, exact CRO registration, permitted title/specialty wording, procedure scope, testimonials, result imagery, disclaimers, calls to action, and the current effect of the August 2026 HOF regulatory uncertainty.
- Patient-image/testimonial owner confirms provenance and valid written publication authorization for the exact asset/quote/context.
- Sign-off references the exact commit or content version. Any material copy, schema, attribution, or media change reopens the corresponding gate.

### Accessibility and Conversion UAT Gate

- Keyboard-only journey on narrow mobile, wide mobile, tablet, and desktop widths.
- Skip link, focus order/visibility, fixed-nav obstruction, anchor landing, FAQ operation, zoom/reflow, contrast, meaningful headings, link purpose, target sizing, and reduced-motion behavior.
- Each CTA placement opens the correct generic WhatsApp conversation on mobile and desktop. No CTA suggests that a click is a booking, treatment indication, or guaranteed result.
- Page remains readable and WhatsApp/contact details remain usable with JavaScript disabled or third-party scripts blocked.

### Measurement and Privacy Gate

- Confirm documented legal basis and consent/opt-out behavior with the privacy reviewer before enabling GA4.
- Inspect network traffic before acceptance, after acceptance, after rejection, and after withdrawal.
- In GA4 Realtime/DebugView, confirm one event per deliberate click and only `page_type`, `procedure_slug`, and `cta_placement` custom parameters.
- Confirm ads personalization, Google signals, user-provided data, remarketing, and cross-service enrichment are disabled unless separately reviewed and approved.
- Document retention, access roles, custom-dimension definitions, and the distinction between a click, a WhatsApp conversation, a qualified lead, and a booked consultation.

### Search and Performance Gate

- Validate home, one standard procedure, and Full Face structured data; compare it to visible identity and claims.
- Confirm canonical URLs, sitemap content type/URLs, indexability, Open Graph images, and post-deploy URL Inspection.
- Test cold mobile performance for the same representative pages. Confirm the hero/LCP asset is discovered in initial HTML, not lazy-loaded, and has intrinsic dimensions; confirm below-fold assets remain lazy.
- Track LCP, INP, and CLS field data when sample size becomes meaningful; use lab findings as diagnosis, not as the sole success claim.

## Scalability Considerations

| Concern | At 100 monthly visitors | At 10K monthly visitors | At 1M monthly visitors |
|---------|-------------------------|--------------------------|-------------------------|
| Content | PHP config and reviewed Git diff are ideal. | Same architecture; formalize review ownership and release cadence. | Consider a governed CMS only if authoring volume/roles require it; preserve approved-content projection into Blade/schema. |
| Rendering | Normal Laravel/Blade requests are sufficient. | Laravel route/config/view caching plus CDN/static-asset caching. | Full-page/CDN edge caching and deployment tuning; still no need for a SPA for public content. |
| Media | Local optimized images with `<x-picture>`. | More responsive variants and long-cache/CDN delivery if field data shows need. | Image CDN/asset pipeline with consent/provenance metadata, not ad hoc public uploads. |
| Analytics | GA4 event and manual lead-quality review. | Stable custom reports by page/procedure/placement; access/retention review. | A governed first-party measurement design may be justified, but requires a new privacy/security architecture and is not an extension to make casually. |
| Leads | Direct WhatsApp only. | Direct WhatsApp remains valid; reconcile aggregate qualified-lead outcomes manually. | CRM/booking integration becomes a separate scoped project with consent, retention, access control, deletion, and clinical-data boundaries. |
| Testing | HTTP contracts plus manual browser/a11y/analytics validation. | Add scheduled production checks and field-performance monitoring. | Dedicated synthetic monitoring and release automation; preserve human clinical/compliance gates. |

## Sources

### Project and Codebase Evidence — HIGH

- `.planning/PROJECT.md` — milestone goals, constraints, active requirements, and current regulatory uncertainty.
- `.planning/codebase/ARCHITECTURE.md` — existing Laravel/config/Blade request and content flow.
- `.planning/codebase/STRUCTURE.md` — current file responsibilities and extension points.
- `.planning/codebase/TESTING.md` — Pest conventions and present coverage.
- Direct inspection of `routes/web.php`, `ProcedureController`, clinic/procedure/FAQ config, shared layout, page templates, schema partials, `x-picture`, `app.js`, CSS, and feature tests on 2026-09-08.

### External Guidance — MEDIUM

Provider confidence was classified by the GSD confidence seam as MEDIUM for Brave search, even where the underlying result is an official primary source. Findings were cross-checked across the relevant official sources.

- [Google Analytics: Set up events](https://developers.google.com/analytics/devguides/collection/ga4/events) and [event parameters](https://developers.google.com/analytics/devguides/collection/ga4/event-parameters) — custom event/parameter implementation and DebugView/Realtime verification.
- [GA4 event-scoped custom dimensions](https://support.google.com/analytics/answer/14239696?hl=en) — reporting on low-cardinality custom parameters.
- [Google Analytics: avoid sending PII](https://support.google.com/analytics/answer/6366371?hl=en) and [health-data warning](https://support.google.com/analytics/answer/13297105?hl=en) — prohibition on PII and sensitive-information disclosure.
- [Google Tag privacy settings](https://developers.google.com/tag-platform/security/guides/privacy) — consent controls and disabling advertising signals.
- [LGPD, Lei 13.709/2018](https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709compilado.htm) — purpose, adequacy, necessity, transparency, security, accountability, and sensitive-data rules.
- [ANPD Cookies and Personal Data guide](https://www.gov.br/anpd/pt-br/centrais-de-conteudo/materiais-educativos-e-publicacoes/guia-orientativo-cookies-e-protecao-de-dados-pessoais.pdf) — analytics-cookie basis is contextual; minimization, aggregate use, transparency, choice, and revocation.
- [Google Search: helpful, reliable, people-first content](https://developers.google.com/search/docs/fundamentals/creating-helpful-content), [LocalBusiness structured data](https://developers.google.com/search/docs/appearance/structured-data/local-business), and [general structured-data guidelines](https://developers.google.com/search/docs/appearance/structured-data/sd-policies) — visible expertise, non-exaggerated content, applicable facts, validation, and policy parity.
- [WCAG 2.2](https://www.w3.org/TR/WCAG22/) and [Link Purpose understanding](https://www.w3.org/WAI/WCAG22/Understanding/link-purpose-in-context.html) — landmarks/bypass, headings, link purpose, focus, keyboard, target, and motion requirements.
- [web.dev: Optimize LCP](https://web.dev/articles/optimize-lcp), [Optimize CLS](https://web.dev/articles/optimize-cls), and [effective Core Web Vitals improvements](https://web.dev/articles/top-cwv) — SSR discovery, hero priority, intrinsic image sizing, minimal JavaScript, and field validation.

## Open Questions Requiring Phase-Specific Resolution

- What exact professional title and specialty wording are currently supported by Dra. Emily's CRO-MG registration and the current legal position? Architecture cannot decide this.
- Which existing photos/testimonials have valid authorization for the exact current and proposed context, and where is that evidence held?
- Which clinical claims survive professional review, and what procedure-specific risks/contraindications/follow-up information must be added?
- What lawful basis and consent/opt-out configuration will the privacy reviewer approve for GA4 on procedure pages?
- Does the GA4 property already have advertising signals, linked ad products, enhanced measurement, retention, and access settings that conflict with the minimized design?
- What traffic/lead-quality threshold will be considered sufficient before procedure prominence or audience positioning changes?

---

*Architecture research completed 2026-09-08. This document recommends integration boundaries and release gates; it does not replace clinical, regulatory, privacy, or legal review.*
