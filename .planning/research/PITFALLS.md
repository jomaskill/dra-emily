# Domain Pitfalls

**Domain:** Brazilian facial-aesthetics patient-acquisition website with WhatsApp as the primary conversion
**Project:** Dra. Emily Beatriz — Website Conversion Review
**Researched:** 2026-09-08
**Overall confidence:** MEDIUM — primary official sources were cross-checked, but the August 2026 appellate judgment itself was not retrievable and legal/ethical application depends on the professional's registration, the publisher's legal identity, and current CRO-MG interpretation.

## Critical Pitfalls — Safety and Compliance Blockers

These are release gates. Conversion gains do not justify publishing while any applicable blocker is unresolved.

### Pitfall 1: Advertising an unverified specialty title during the Resolution CFO 198/2019 uncertainty

**What goes wrong:** The visible site, metadata, alt text, or JSON-LD calls Dra. Emily a “Especialista em Harmonização Orofacial” without proving that the title is currently registered and permissible to advertise.

**Why it happens:** The title is treated as SEO copy rather than a regulated professional credential. The current code repeats it in structured data, where reviewers may miss it because it is not normally visible on the page.

**Consequences:** Ethical complaint, misleading professional representation, search markup inconsistency, loss of patient trust, and a potentially urgent site-wide rewrite.

**Warning signs:**

- `jobTitle`, descriptions, headings, image alt text, or social metadata contain “especialista” while no current CRO-MG registry evidence is attached to the content record.
- The site assumes that completion of a course is equivalent to a specialty registered with the CRO.
- A reviewer says Resolution 198/2019 is simply “valid” or “invalid” without addressing the 2026 litigation and procedural status.

**Prevention:** Treat the specialty title as blocked until the exact CRO-MG registration is verified and a current CRO-MG or qualified Brazilian health-law review approves the wording. Until then, use the verified base credential “cirurgiã-dentista” and describe only services that the professional has separately confirmed are within her current competence. Keep the approved title in one configuration field so visible copy, metadata, and schema cannot diverge.

**Verification:** Save dated evidence of the CRO registration and the written wording decision; search rendered HTML for every occurrence of `especialista`, `HOF`, and `Harmonização Orofacial`; compare visible copy, Open Graph, sitemap image titles, and JSON-LD; add a regression test for the approved credential string.

**Phase:** Phase 0 — compliance inventory and release gate; re-check immediately before launch and whenever the litigation or CFO/CRO rules change.

**August 2026 uncertainty:** On 20 August 2026 the CFO reported that the TRF1 8th Panel, by majority on 19 August, decided to annul Resolution CFO 198/2019. The CFO disagrees, says it will challenge the decision, and states that professional duties did not immediately change. Research could not retrieve the appellate judgment itself from the court. This document therefore does **not** conclude that the resolution is finally valid or invalid, that a specialty title may or may not be advertised, or that any particular procedure is lawful or unlawful. Those are current-case-specific questions for CRO-MG or qualified counsel.

### Pitfall 2: Letting persuasive copy become a clinical promise or an unsafe omission

**What goes wrong:** Copy turns variable outcomes into certainties, presents comfort or safety as guaranteed, states fixed duration/recovery/candidacy as universal, or discusses benefits without material limits and risks. A disclaimer at the bottom does not neutralize a categorical promise in the headline or FAQ.

**Why it happens:** SEO and conversion copy favors short, confident assertions. Procedure facts are duplicated across templates and configuration without a clinical evidence register or review date.

**Consequences:** Patients form unrealistic expectations; unsuitable people may self-select; the advertising can become binding or misleading under the Consumer Defense Code; the professional's ethical and clinical risk increases.

**Warning signs:**

- Phrases such as “100% resultados naturais,” “completamente natural,” “garante,” “não dói,” “seguro,” “não fica artificial,” “resultado definitivo,” or “melhor resultado possível.”
- Exact time ranges, session counts, indications, aftercare, or durability with no source, product qualification, uncertainty, or clinical review date.
- Calls to action that imply treatment is already suitable before assessment.
- Benefits dominate the page while common contraindications, limitations, alternatives, adverse effects, and escalation advice are absent or hidden.

**Prevention:** Create a claim register with the exact claim, source, applicable product/technique, limitations, reviewer, and review date. Have the treating professional approve every claim in visible copy and schema. Use calibrated language (“pode,” “em geral,” “varia”) only when clinically accurate, explain that assessment determines suitability, and give a balanced overview of material limitations and risks without turning the landing page into individualized advice. Remove a claim when its evidence or applicability cannot be demonstrated.

**Verification:** Conduct a line-by-line clinical sign-off; run a prohibited-phrase scan across configuration, Blade, metadata, schema, sitemap, and image titles; compare every duration/session/recovery claim to the claim register; have an independent reviewer test whether the most prominent message remains accurate when read without the disclaimer.

**Phase:** Phase 0 for removal of guarantees and unsafe statements; Phase 2 for clinically reviewed content architecture; quarterly and product-change review thereafter.

### Pitfall 3: Publishing before/after images or testimonials without a defensible authorization chain

**What goes wrong:** The site publishes identifiable patient images, names, treatment history, or testimonial quotes based only on an on-page statement that authorization exists. It cannot prove provenance, exact permitted uses, who performed the case, whether the publisher is the individual professional or a legal entity, or how withdrawal/takedown is handled.

**Why it happens:** Media files are treated as ordinary marketing assets and committed under `public/`. Clinical consent, image authorization, privacy notice, testimonial permission, and advertising-rule compliance are collapsed into one informal approval.

**Consequences:** Privacy and image-rights complaints, ethical proceedings, patient distress, inability to honor withdrawal quickly, repository/history exposure, and a forced campaign takedown.

**Warning signs:**

- Patient media is in the public repository but no off-repository consent record maps to each asset.
- A named Google review is copied to the site without proof of quote fidelity and permission for this separate publication context.
- Images lack the responsible dentist's name and CRO number within the publication, show a case performed by another person, show instruments/tissue or procedure-in-progress, or appear under a clinic/legal-entity publisher.
- Consent has no version, date, scope, channel list, expiry/review date, withdrawal route, or evidence that refusal did not affect care.
- EXIF or other metadata was never stripped; filenames, captions, or alt text identify the patient or treatment unnecessarily.

**Prevention:** Inventory every patient asset and quote. Keep evidence outside the public repository and map each publication to a specific, prior, freely given authorization and the applicable CFO-required TCLE. Separate clinical-care consent from publication authorization and LGPD information. Confirm that the responsible dentist performed the case; determine whether this personally branded site legally counts as publication by the individual or by a clinic/legal entity before relying on Resolution 196/2019; prohibit procedure-in-progress media and third-party cases. Use truthful, standardized, unretouched comparisons with equivalent lighting, angle, expression, crop, and clearly stated timepoint. Strip metadata and implement a same-day takedown route.

**Verification:** No asset ships without a consent-register ID, hash, responsible professional, CRO, capture dates, publication scope, and reviewer. Inspect rendered pages at mobile and desktop sizes for required attribution. Scan production assets for metadata. Test the takedown runbook and verify removal from origin, CDN/cache, sitemap, Open Graph image, and repository deployment. Obtain current CRO-MG review of the individual-versus-legal-entity publication question.

**Phase:** Phase 0 — media freeze and consent audit before any redesign reuses the assets.

### Pitfall 4: Treating testimonials, ratings, and before/after panels as neutral proof

**What goes wrong:** Selected outcomes imply typicality, a hard-coded rating or review count becomes stale, quotes are edited or fabricated, and outcome-adjacent copy such as “Quero isso” converts one patient's result into an implied promise to the next visitor.

**Why it happens:** Social proof is optimized for persuasion without provenance, freshness, representativeness, or clinical context.

**Consequences:** Misleading advertising, patient disappointment, ethical risk, and a severe credibility loss if visitors compare the site with the live Google Business Profile.

**Warning signs:**

- Rating and count are constants rather than reviewed data with a timestamp and link to their source.
- Quotes include numerical outcome claims such as “90%” with no context.
- Only spectacular results are shown, images are retouched, or before/after capture conditions differ.
- Review markup is added to the clinic's own `LocalBusiness`/`Organization` schema to chase stars.

**Prevention:** Publish only verbatim, authorized, traceable testimonials; date and periodically re-verify rating/count claims or omit them. Do not imply that a result is typical or guaranteed. Use neutral actions such as “Conversar sobre uma avaliação,” not “Quero esse resultado.” Keep self-serving review markup out of `LocalBusiness`/`Organization` structured data; linking to the live Business Profile does not remove the need to validate visible claims.

**Verification:** Reconcile every quote and rating against the source record; diff copied text against the original; review the page without its disclaimer for net impression; validate JSON-LD and inspect Search Console manual actions. Set an expiry test that fails when a time-sensitive rating has not been re-reviewed.

**Phase:** Phase 0 for provenance/removal; Phase 2 for responsible social-proof design; recurring monthly freshness check if counts remain visible.

### Pitfall 5: Sending health-interest or identifying data to analytics and ad platforms

**What goes wrong:** GA4 loads on every page and collects page URLs/titles, procedure interest, CTA placement, campaign parameters, or custom event labels tied to an online identifier. Future ad integrations enable remarketing, customer lists, or enhanced conversions for a health-related service. Consent is assumed to make prohibited vendor data uses acceptable.

**Why it happens:** “Track every WhatsApp click by page and procedure” is implemented literally without a data classification exercise. The repository currently supplies a production GA ID by default and initializes the tag before any visible consent choice.

**Consequences:** Potential LGPD noncompliance, violation of Google policies, exposure of sensitive inferences, account enforcement, unfulfillable deletion/access obligations, and loss of patient trust.

**Warning signs:**

- A production measurement ID is the fallback in source control or tags fire before a lawful configuration and user choice are established.
- Event parameters include phone number, name, free text, full WhatsApp URL, message text, exact concern, treatment requested, or unreviewed page title/URL.
- GA4 is linked to ads with signals, personalized advertising, User-ID, enhanced conversions, or advertiser-curated audiences enabled.
- “Anonymous” is claimed only because GA4 does not store raw IP addresses; cookies and other online identifiers remain unassessed.

**Prevention:** Complete a data map and necessity test before instrumentation. Treat procedure-level browsing and click behavior as capable of revealing health/aesthetic interest. Have privacy/legal review select the legal basis and platform configuration; do not assume consent or legitimate interest applies. Start tags disabled by default where consent is the selected basis; make reject and revoke as easy as accept; minimize retention and data sharing. Never send PII, free text, message content, or precise concerns to analytics. Disable ad personalization and avoid remarketing, customer lists, and enhanced conversions for this context. If procedure/page attribution cannot be made compliant with vendor policy, use site-owned, short-retention, aggregate counters without persistent identifiers, or reduce granularity.

**Verification:** Inspect the network before and after accept/reject/revoke; use GA DebugView and tag diagnostics with synthetic non-personal data; verify page URLs, referrers, titles, UTMs, event names/parameters, and consent state. Review GA property links, Google Signals, advertising personalization, data sharing, retention, and deletion controls. Attempt an access/deletion request end to end. Fail CI if known PII keys or unrestricted free-text parameters appear in the analytics schema.

**Phase:** Phase 1 — privacy and measurement foundation, before conversion events are released.

### Pitfall 6: Assuming a WhatsApp click is a privacy-safe appointment flow

**What goes wrong:** A prefilled link asks the visitor to disclose procedure, symptoms, images, or medical history; analytics records the full destination or message; clinic staff use personal devices, uncontrolled backups, or indefinite chat retention; users receive follow-up marketing they did not request.

**Why it happens:** Click-to-chat feels like a simple outbound link, so controller/processor roles, international processing, access control, records, retention, and user rights are ignored.

**Consequences:** Sensitive health data spills into an unmanaged channel, inappropriate clinical advice is given by chat, urgent symptoms are mishandled, and the business cannot demonstrate compliant access, retention, or deletion.

**Warning signs:**

- Prefill text names a procedure or invites health details before a privacy notice is available.
- The CTA promises “agendamento” even though the click only opens a conversation.
- There is no message explaining that WhatsApp is not an emergency channel and that suitability requires assessment.
- Shared account access, device loss, employee departure, exports, backups, and deletion are undocumented.
- Automated outbound messages begin without a valid opt-in or ignore stop requests.

**Prevention:** Keep prefilled text neutral and minimal; do not put health details or identifiers in URL parameters. Accurately label the action as starting a WhatsApp conversation. Give a concise just-in-time notice before handoff and link the full privacy notice. Ask only what is necessary for initial routing, avoid diagnosis in marketing chat, and define escalation for urgent issues. Use an approved business account with least-privilege access, staff training, device controls, retention/deletion rules, and documented processors/transfers. Honor opt-out immediately. WhatsApp's business terms change on 23 September 2026; re-review them before adding API, CRM, chatbot, or ad automation.

**Verification:** Decode every `wa.me` URL and ensure no sensitive or identifying values are present; confirm analytics never captures message text or full outbound query strings; test copy and routing on iOS, Android, desktop, and without the app; audit account access and backups quarterly; test stop, deletion, and urgent-message workflows.

**Phase:** Phase 1 — privacy and contact-channel governance; repeat vendor review before any messaging integration.

### Pitfall 7: Shipping an inaccessible primary journey

**What goes wrong:** A visitor cannot understand the treatments, open mobile navigation, read the comparison content, or reach WhatsApp using keyboard, screen reader, zoom, high contrast, reduced motion, or touch with limited dexterity.

**Why it happens:** Visual polish is reviewed only with a mouse on a large screen. Repeated SVG CTAs, hover-only effects, transformed cards, sticky/floating controls, and decorative low-contrast text are not tested as one journey.

**Consequences:** Exclusion of prospective patients, breach risk under article 63 of the Brazilian Inclusion Law, lost conversions, and inaccessible safety information.

**Warning signs:**

- Focus is invisible, illogical, or hidden under sticky UI; mobile navigation has no correct name/state/focus handling.
- CTA purpose is unclear out of context, targets are too small/close, or repeated WhatsApp links all announce the same generic text.
- Text or essential icons fail contrast; 200% zoom or 320 CSS-pixel reflow causes clipping or horizontal scrolling.
- Before/after alt text is SEO-stuffed, misleading, or omits the comparison's purpose; decorative imagery is announced noisily.
- Motion ignores `prefers-reduced-motion`; content appears only on hover; heading order and landmark structure are broken.

**Prevention:** Make WCAG 2.2 AA the implementation target. Use semantic links/buttons, descriptive accessible names that include destination/purpose, keyboard-operable navigation and disclosure widgets, visible/unobscured focus, minimum target sizing/spacing, sufficient contrast, correct landmarks/headings, accurate alternatives, reduced-motion support, and reflow-safe layouts. Ensure the privacy choice does not trap or block assistive-technology users.

**Verification:** Automated axe/Lighthouse checks on every public route plus manual keyboard-only, VoiceOver or NVDA, 200%/400% zoom, 320px reflow, contrast, reduced-motion, and touch-target testing. Include WhatsApp handoff and consent/revocation in the tested journey. Automated scores alone do not pass the gate.

**Phase:** Phase 2 — accessible conversion journey; critical regressions enforced in CI and manual pre-release QA.

## Moderate Pitfalls — Trust, Effectiveness, and Technical Fragility

These usually do not justify keeping a known safety/compliance blocker live. Address them only after Phase 0 and Phase 1 gates are satisfied.

### Pitfall 8: Optimizing from low traffic as if noise were evidence

**What goes wrong:** A handful of clicks crowns a “winning” audience, procedure, headline, or CTA. Repeatedly slicing by page, procedure, device, source, and placement finds apparent winners by chance. CTA clicks are treated as consultations or revenue.

**Warning signs:** Weekly winner/loser language, percentages without raw denominators or intervals, many simultaneous variants, stopping when a desirable result appears, unbalanced allocation, internal/test traffic, and no lead-quality reconciliation.

**Prevention:** First validate data collection. Use a descriptive baseline with counts and uncertainty, predefine the decision and observation window, and track the funnel from eligible page view to WhatsApp click to genuine conversation to qualified consultation using the least sensitive compliant method. Prefer qualitative call/chat coding in coarse, de-identified categories and sequential improvements grounded in usability/clinical review over underpowered A/B tests. Do not narrow the audience or select a flagship procedure until the evidence threshold is written and met.

**Verification:** Reconcile clicks against real conversations with a documented sampling method; report numerator, denominator, period, consent coverage, bot/internal exclusions, and uncertainty; check sample-ratio mismatch before interpreting any experiment; record all variants and comparisons, including null results. GA4 thresholding or consent-mode modeling must not be mistaken for observed truth; its modeling volume requirements are far beyond a typical small local site.

**Phase:** Phase 4 — baseline observation and cautious optimization, after instrumentation has passed privacy and accuracy tests.

### Pitfall 9: Measuring the wrong conversion and overstating attribution

**What goes wrong:** `whatsapp_click` is called a booked consultation, duplicate taps inflate performance, page attribution overwrites campaign context, and a conversation started later or on another device is credited with false precision.

**Warning signs:** The dashboard reports “agendamentos” from link-click events; no distinction exists among CTA placement, outbound navigation, conversation, qualified lead, booking, and attended consultation; event totals exceed plausible sessions; staff cannot tie web leads to outcomes without copying personal chat data into analytics.

**Prevention:** Name events literally (`whatsapp_click`, not `appointment_booked`), deduplicate within an agreed window, and publish a small funnel dictionary. Keep on-site event data pseudonymous/minimized and reconcile downstream outcomes only in a governed clinic process. Report attribution as directional, state the window and coverage, and retain an unattributed bucket.

**Verification:** Test one synthetic visit per route/CTA and inspect exact event counts; compare analytics clicks with WhatsApp conversation starts and staff disposition totals; audit duplicate, bot, staff, preview, and consent-denied traffic; require dashboard metric definitions alongside every chart.

**Phase:** Phase 1 for event semantics; Phase 4 for outcome reconciliation and reporting.

### Pitfall 10: Conversion design that pressures, shames, or prescribes

**What goes wrong:** The journey exploits appearance anxiety, uses transformation promises, urgency, scarcity, or “fix your flaws” language, and pushes a named treatment before assessment. Multiple competing CTAs obscure the safer next step.

**Warning signs:** “Quero isso” beside a patient's result, “melhor versão,” “transformação,” countdowns, limited slots, fear-based aging language, or one treatment presented as universally right. The button says “Agendar avaliação” but merely opens WhatsApp, or important expectations appear after the CTA.

**Prevention:** Make the primary action a truthful invitation to discuss an individualized assessment. Lead with autonomy, naturalness, realistic expectations, qualifications, what happens before/during/after, and the possibility that no procedure is indicated. Use one dominant CTA pattern with context-aware but neutral copy. Address pain, recovery, cost process, safety, follow-up, and uncertainty without diagnosing the visitor or exploiting insecurity.

**Verification:** Run a content “net impression” review with the CTA and surrounding media together; test comprehension with safety-conscious first-time prospects; confirm button label, destination, prefilled message, and next-step promise match; search for pressure/scarcity/body-shaming language.

**Phase:** Phase 2 — content hierarchy and conversion design.

### Pitfall 11: Structured data becomes a hidden channel for unsupported claims

**What goes wrong:** JSON-LD advertises a specialty title, entity type, opening hours, payment methods, services, reviews, or clinical statements not verified in visible content. Technically valid markup is assumed to be policy-compliant.

**Warning signs:** `Physician` is used for a dentist without semantic justification; `MedicalProcedure.howPerformed` repeats promotional hero copy; hard-coded hours/payment details differ from the clinic or Google Business Profile; FAQ markup is maintained primarily to chase a rich result; self-serving reviews return to `LocalBusiness` schema.

**Prevention:** Build schema only from verified canonical fields and visible page content. Use the narrowest accurate entity type, remove properties that cannot be maintained, and keep clinical/credential claims under the same review workflow as visible copy. Do not expect regular FAQ rich results for an ordinary practice site, and never add self-serving local-business review markup merely for stars.

**Verification:** Parse every rendered JSON-LD block in automated tests for all procedure routes; run Google's Rich Results Test and Schema Markup Validator; compare against the visible page, Business Profile, CRO evidence, and canonical configuration; monitor Search Console enhancement and manual-action reports.

**Phase:** Phase 1 — canonical identity and content model; Phase 3 — search validation.

### Pitfall 12: Local SEO inconsistency or location spam erodes trust

**What goes wrong:** Name, address, phone, category, hours, practitioner identity, and service claims differ across the site, schema, sitemap, Google Business Profile, and real-world signage. Thin neighborhood pages or inflated `areaServed` lists are created to rank rather than serve patients.

**Warning signs:** Hard-coded `https://` hosts differ from `APP_URL`; staging emits production canonicals; practitioner and clinic profiles duplicate each other incorrectly; keywords are inserted into the Business Profile name; pages claim neighborhoods without unique useful content; the WhatsApp phone or map destination is stale.

**Prevention:** Establish one reviewed local-identity record for the real entity and individual practitioner. Keep NAP, hours, category, map, phone, canonical host, and specialty wording consistent. Use the fewest accurate Business Profile categories and the real-world business name. Create location content only when it gives genuinely distinct patient value; keep one canonical domain and named-route URL generation.

**Verification:** Quarterly NAP/profile audit; click every phone, map, social, and WhatsApp link; inspect production canonical/Open Graph/schema/sitemap output; use Search Console URL Inspection and sitemap status; check for duplicate Business Profiles and indexable staging hosts.

**Phase:** Phase 1 for canonical data; Phase 3 for local search implementation and monitoring.

### Pitfall 13: Image-heavy polish makes the mobile journey slow

**What goes wrong:** Mobile visitors download 1000–1400px portraits and duplicate original/WebP sets without `srcset`/`sizes`; external fonts and analytics contend with the hero; the CTA becomes usable only after a slow or unstable load.

**Warning signs:** The same hero source serves every viewport, more than one image has high fetch priority, below-fold assets load eagerly, no immutable cache contract exists, and field data is absent so a desktop Lighthouse run is treated as proof.

**Prevention:** Generate width variants and accurate `srcset`/`sizes`; keep the LCP image discoverable in initial server-rendered HTML, eager and high-priority only when it is actually the LCP candidate; lazy-load below-fold media; preserve intrinsic dimensions; subset/self-host fonts where appropriate; minimize third-party tags and set cache headers with versioned filenames. Do not compromise comparison fidelity when compressing clinical images.

**Verification:** Test each public template on a throttled mid-tier mobile profile; inspect the network waterfall and transferred bytes; measure LCP, INP, and CLS in lab and field data. Target the current “good” thresholds at the 75th percentile separately for mobile and desktop: LCP ≤2.5s, INP ≤200ms, CLS ≤0.1. Confirm the chosen responsive candidate at representative widths and device pixel ratios.

**Phase:** Phase 3 — performance and delivery, with budgets in CI and field monitoring after launch.

### Pitfall 14: Duplicated templates and unvalidated content drift apart

**What goes wrong:** A claim, privacy behavior, CTA label, CRO attribution, accessibility fix, or disclaimer is corrected on the homepage but remains wrong on generic procedures or Full Face. A partial procedure configuration causes a production 500.

**Warning signs:** Repeated WhatsApp SVG/URL/message markup, separate generic and Full Face section structures, arbitrary nested array access, and no test that every configured procedure has all required keys/views/assets.

**Prevention:** Extract shared CTA, disclaimer, media, FAQ, and page-section components after content decisions stabilize. Introduce a typed procedure content object or boot/CI validator with required and optional fields, claim-review metadata, and view/include existence checks. Centralize link builders and canonical identity; avoid a broad framework or CMS rewrite during this milestone.

**Verification:** Render every procedure and the homepage in feature tests; fail on missing keys, views, includes, assets, or invalid JSON-LD; snapshot critical disclosures and CTA semantics across templates; search for duplicate hard-coded WhatsApp messages and regulated credential strings.

**Phase:** Phase 2 — safe component/content refactor; regression suite before Phase 3.

### Pitfall 15: A passing test suite hides production and browser failures

**What goes wrong:** PHP tests pass while the Vite manifest is missing, JSON-LD is malformed, images 404, external tags fail, mobile navigation breaks, or a page is not indexable. No monitoring catches the failure after deployment.

**Warning signs:** Production assets are ignored with no deployment build contract; CI does not run a production build, crawl routes, validate schema, or exercise a browser; no uptime/error tracking exists; sitemap and canonical URLs are untested.

**Prevention:** Define a production build/deploy contract, add route/content/schema/link smoke tests, verify every configured public page, and add minimal uptime/error monitoring. Use environment-safe absolute URL generation. Add post-deploy checks for the homepage, all procedure slugs, sitemap, Vite assets, canonical host, WhatsApp destination, privacy controls, and critical images.

**Verification:** Deploy to a staging environment with production settings; run a headless browser crawl at mobile and desktop widths; assert 200 responses, loaded assets, valid JSON-LD/XML, no console errors, no indexable staging URLs, and working consent/CTA behavior; repeat a compact smoke suite after production deployment.

**Phase:** Phase 1 for URL/deployment foundations; Phase 3 for complete browser and post-deploy gates.

### Pitfall 16: Security and asset tooling are treated as unrelated to trust

**What goes wrong:** Missing security headers leave pages frameable or permissive, a rushed CSP breaks analytics/fonts/schema, and the image converter can traverse outside `public/` or leave partial WebP files that production treats as valid.

**Warning signs:** No documented CSP, frame protection, MIME-sniffing protection, referrer policy, or permissions policy; inline scripts are added without a nonce/hash strategy; `images:webp --path=..` can escape the intended root; conversion writes directly to final files and suppresses errors.

**Prevention:** Add deliberate, environment-tested security headers and inventory every third-party origin before setting CSP. Keep referrer behavior privacy-conscious. Canonicalize and constrain image-conversion paths to the real public root, reject unintended symlinks/traversal, use bounded decoding, write temporary files, validate them, and rename atomically. Treat patient-media processing as a privacy-sensitive pipeline, not a generic utility.

**Verification:** Run header/CSP checks against rendered production pages and confirm no required resource is blocked; test framing and MIME behavior; add command tests for traversal, symlinks, malformed/oversized images, interruption, idempotency, and atomic output; hash and inspect published patient assets after conversion.

**Phase:** Phase 1 for security headers and data boundaries; Phase 3 for hardened asset pipeline.

## Minor Pitfalls

### Pitfall 17: The privacy or clinical disclaimer is technically present but practically invisible

**What goes wrong:** Small, low-contrast footer text is used as the sole remedy for prominent promises or tracking. Users reach WhatsApp before seeing material information.

**Warning signs:** Disclosures require scrolling past the final CTA, fail contrast/zoom, use legal jargon, or do not name the controller, purposes, channels, rights route, or last update.

**Prevention:** Put concise, plain-language context next to the relevant claim, patient image, analytics choice, or WhatsApp handoff, with a clear route to fuller information. Correct the main claim rather than relying on fine print.

**Verification:** Mobile comprehension test, contrast/zoom check, and a no-scroll review of what a visitor understands at each CTA.

**Phase:** Phase 2 — content and conversion design.

### Pitfall 18: SEO alt text undermines accessibility and clinical credibility

**What goes wrong:** Alternatives repeat keywords, declare a result or diagnosis the image cannot establish, or identify a patient unnecessarily.

**Warning signs:** Repeated “Botox BH” phrases, “resultado natural” asserted in alt text, identical text on distinct images, or decorative portraits announced as clinical evidence.

**Prevention:** Describe the image's function and relevant visible content concisely; use empty alt for truly decorative images; keep clinical interpretation in reviewed body text; never add personal identifiers for search value.

**Verification:** Screen-reader review of each image sequence and comparison against visible captions and consent scope.

**Phase:** Phase 2 — accessible content pass.

### Pitfall 19: A cookie banner becomes dark-pattern conversion UI

**What goes wrong:** “Accept” is prominent while reject/revoke is hidden, consent is bundled, the page blocks keyboard or screen-reader access, or denial disables the core informational/WhatsApp journey unnecessarily.

**Warning signs:** Pre-ticked options, unequal button prominence, no “reject non-essential” action, consent wall, repeated prompts after refusal, and no persistent preference control.

**Prevention:** Give equivalent accept/reject controls, granular purposes, no preselection, a persistent easy revocation route, and full access to essential site/WhatsApp navigation without non-essential tracking.

**Verification:** Fresh-browser tests for accept, reject, partial choice, revoke, and revisit; compare network traffic for each state; keyboard and screen-reader test the entire preference UI.

**Phase:** Phase 1 — privacy UX.

## Phase-Specific Warnings

| Phase Topic | Likely Pitfall | Mitigation / Exit Evidence |
|-------------|----------------|----------------------------|
| **Phase 0: Compliance inventory and content freeze** | Redesign amplifies an unverified specialty title, unsafe claim, or unauthorized patient asset | Dated CRO/credential decision; claim register with clinical sign-off; media/consent inventory; unresolved items removed or quarantined |
| **Phase 1: Privacy, identity, analytics, and technical foundations** | GA/WhatsApp implementation exposes health-interest data; canonical/schema identity conflicts; production deployment fails | Approved data map/legal-basis decision; deny-state network test; minimized event contract; WhatsApp governance; canonical identity fixture; production build/smoke proof |
| **Phase 2: Accessible content and conversion journey** | Persuasive copy becomes a promise; CTA pressures or mislabels the next step; fixes drift across templates | WCAG 2.2 AA journey audit; neutral and truthful CTA language; clinically reviewed content; shared components; all-route render tests |
| **Phase 3: Performance, local SEO, and release quality** | Large images and third parties hurt mobile conversion; schema/local profile become spammy or stale | Responsive-image verification; CWV budgets; NAP/Profile reconciliation; Rich Results/Schema validation; post-deploy crawl and monitoring |
| **Phase 4: Baseline and optimization** | Low counts are overinterpreted; clicks are called appointments; multiple comparisons manufacture winners | Predeclared metric dictionary and decision threshold; raw counts plus uncertainty; click-to-conversation reconciliation; experiment SRM/multiple-testing checks; no flagship decision without sufficient evidence |

## Pre-Launch Blocker Checklist

- [ ] Current professional name, CRO number, registration status, publisher identity, and any specialty title are documented and approved.
- [ ] The August 2026 Resolution 198/2019 issue has been re-checked with current CRO-MG/qualified counsel; no unsupported legal conclusion appears in copy or schema.
- [ ] Every clinical claim has source, scope, limitations, professional reviewer, and review date; guarantees and material omissions are removed.
- [ ] Every patient image/testimonial has a defensible authorization/provenance record and passes CFO publication conditions applicable to this publisher.
- [ ] No procedure-in-progress/third-party case or unstripped patient metadata is public.
- [ ] Privacy notice, cookie choice, controller/processor map, retention, transfer mechanism, rights route, and WhatsApp governance are implemented and tested.
- [ ] Analytics sends no PII, free text, message content, or unapproved health-interest parameters; ad personalization/remarketing/enhanced conversions remain off.
- [ ] The full mobile and desktop journey passes manual accessibility and browser checks.
- [ ] Rendered visible content, metadata, canonical, sitemap, structured data, and Google Business Profile agree.
- [ ] All public routes, production assets, WhatsApp links, and post-deploy monitoring pass.

## Sources

Confidence labels follow the GSD provider seam. Official sources retrieved through web search and cross-checked are **MEDIUM** confidence; live codebase observations are **HIGH** confidence. Legal sources establish issues to review, not case-specific legal advice.

### Professional ethics, advertising, and August 2026 uncertainty

- **MEDIUM:** [CFO statement on the 19 August 2026 TRF1 decision concerning Resolution 198/2019](https://website.cfo.org.br/cfo-esclarece-decisao-judicial-sobre-a-harmonizacao-orofacial/)
- **MEDIUM:** [Resolution CFO 196/2019 — patient selfies and diagnosis/final-treatment imagery](https://website.cfo.org.br/wp-content/uploads/2019/01/Resolu%C3%A7%C3%A3o-CFO-196-2019.pdf)
- **MEDIUM:** [CFO guidance on ethical social-media publication and the individual-professional limitation](https://website.cfo.org.br/redes-sociais-na-odontologia-fique-atento-as-normas-eticas-e-acerte-na-publicacao-dos-conteudos/)
- **MEDIUM:** [CRO-MG 2026 warning against procedure-in-progress publication](https://cromg.org.br/noticias/cro-mg-alerta-e-vedada-a-divulgacao-de-transcurso-de-procedimento/)
- **MEDIUM:** [Code of Dental Ethics, Resolution CFO 118/2012](https://sistemas.cfo.org.br/visualizar/atos/RESOLU%C3%87%C3%83O/SEC/2012/118)
- **MEDIUM:** [Resolution CFO 271/2025 amendments after CADE decision](https://sistemas.cfo.org.br/visualizar/atos/RESOLU%25C3%2587%25C3%2583O/SEC/2025/271)
- **MEDIUM:** [Consumer Defense Code text and advertising duties](https://www.consumidor.gov.br/pages/conteudo/publico/102)

### Privacy, analytics, and WhatsApp

- **MEDIUM:** [Brazilian General Data Protection Law — LGPD](https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709compilado.htm)
- **MEDIUM:** [ANPD guide on cookies and personal-data protection](https://www.gov.br/anpd/pt-br/centrais-de-conteudo/materiais-educativos-e-publicacoes/anonimizado___guia_de_cookies.pdf)
- **MEDIUM:** [ANPD international-transfer rules and Resolution 19/2024](https://www.gov.br/anpd/pt-br/assuntos/assuntos-internacionais/transferencia-internacional-de-dados)
- **MEDIUM:** [Google Analytics practices to avoid sending PII](https://support.google.com/analytics/answer/6366371)
- **MEDIUM:** [Google Analytics statement on sensitive information and healthcare use](https://support.google.com/analytics/answer/13297105)
- **MEDIUM:** [Google Ads health category restrictions](https://support.google.com/adspolicy/answer/16701855)
- **MEDIUM:** [Google Ads customer-data restrictions for sensitive conversion categories](https://support.google.com/google-ads/answer/7475709)
- **MEDIUM:** [WhatsApp Business Terms of Service](https://www.whatsapp.com/legal/business-terms?lang=pt)
- **MEDIUM:** [WhatsApp Business Data Processing Terms](https://www.whatsapp.com/legal/business-data-processing-terms?lang=pt)
- **MEDIUM:** [WhatsApp legal resources and announced 23 September 2026 terms change](https://www.whatsapp.com/legal?lang=pt)

### Accessibility, search, performance, and inference

- **MEDIUM:** [Brazilian Inclusion Law, article 63 website-accessibility duty](https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2015/lei/l13146.htm)
- **MEDIUM:** [W3C WCAG 2.2 Recommendation](https://www.w3.org/TR/WCAG22/)
- **MEDIUM:** [Google structured-data general policies](https://developers.google.com/search/docs/appearance/structured-data/sd-policies)
- **MEDIUM:** [Google review-snippet rules, including self-serving local-business reviews](https://developers.google.com/search/docs/appearance/structured-data/review-snippet)
- **MEDIUM:** [Google FAQ rich-result limitation for authoritative health/government sites](https://developers.google.com/search/blog/2023/08/howto-faq-changes)
- **MEDIUM:** [Google Business Profile representation guidelines](https://support.google.com/business/answer/3038177)
- **MEDIUM:** [Google canonical URL guidance](https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls)
- **MEDIUM:** [Current Core Web Vitals thresholds](https://web.dev/articles/vitals)
- **MEDIUM:** [Responsive image loading and mobile waste](https://web.dev/articles/preload-responsive-images)
- **MEDIUM:** [GA4 data thresholds](https://support.google.com/analytics/answer/9383630)
- **MEDIUM:** [GA4 consent-mode behavioral-modeling eligibility](https://support.google.com/analytics/answer/11161109)
- **MEDIUM:** [Microsoft Research on online-metric interpretation and sample-ratio mismatch](https://www.microsoft.com/en-us/research/wp-content/uploads/2020/08/2017-08-KDDMetricInterpretationPitfalls.pdf)
- **MEDIUM:** [NIST guidance on multiple comparisons](https://itl.nist.gov/div898/handbook/toolaids/pff/prc.pdf)

---

*Research completed 2026-09-08. Re-check CFO/CRO-MG litigation guidance, professional registration, Google/WhatsApp policies, and ANPD rules immediately before publication because these areas are actively changing.*
