# Technology Stack

**Project:** Dra. Emily Beatriz — Website Conversion Review  
**Researched:** 2026-09-08  
**Overall confidence:** MEDIUM — recommendations are cross-checked against current official documentation, but all web-fetched evidence is classified MEDIUM by the project research seam and Brazilian privacy implementation still requires legal review.

## Recommended Stack

### Core Framework

Retain the current server-rendered architecture. Nothing found in this review justifies a framework migration, SPA, CMS, or analytics tag manager.

| Technology | Version | Purpose | Why |
|------------|---------|---------|-----|
| PHP | 8.4 runtime; Composer constraint `^8.3` | Application runtime | Already compatible with Laravel 13; no runtime change is needed for the review. |
| Laravel | 13.11.x | Routing, configuration, Blade rendering, HTTP tests | Existing routes are small, crawlable, and fast. Laravel remains the right boundary for metadata, canonical URLs, sitemap output, and schema generation. |
| Blade | Laravel 13 bundled | Semantic HTML and reusable CTA/schema components | Server-rendered content is robust for local SEO and accessibility. Reusable components can enforce analytics attributes and avoid taxonomy drift. |
| Tailwind CSS | 4.3.x | Existing design system and responsive styling | Keep the established tokens and utility workflow; accessibility fixes do not require a new component library. |
| Vite | 8.0.x with `laravel-vite-plugin` 3.1.x | Production CSS/JS bundling and font optimization | Already configured. Use one small vanilla ES module for consent and instrumentation; do not add a frontend framework. |
| Laravel Vite font provider | Existing `laravel-vite-plugin/fonts` integration | Self-host the two fonts actually rendered | Configure it for Cormorant Garamond and Jost, then remove the remote CSS imports and unused Instrument Sans configuration. This reduces third-party requests, connection work, and consent/privacy ambiguity without adding a package. |

**Decision:** preserve progressive enhancement. Navigation, content, WhatsApp links, and contact information must work before JavaScript. JavaScript adds consent state and measurement only.

### Database

| Technology | Version | Purpose | Why |
|------------|---------|---------|-----|
| Existing Laravel database configuration | Existing project default | Framework/test support only | This public landing site does not need a new application database for analytics or attribution. Keep consent choice in the browser and measurements in the approved analytics destination. Do not create a shadow store of WhatsApp inquiries or health-adjacent browsing records. |

### Infrastructure

| Technology | Version | Purpose | Why |
|------------|---------|---------|-----|
| Laravel Herd | Existing local environment | Local browser, accessibility, and Lighthouse testing | Use the already-served local site; do not introduce a second development server or container solely for audits. Resolve the project URL through Laravel Boost during implementation. |
| Existing production hosting/CDN | Preserve; audit configuration | Delivery, TLS, compression, and cache policy | The milestone should measure HTTPS redirects, HTTP caching, Brotli/gzip, protocol, and asset delivery before recommending infrastructure changes. No evidence currently justifies a hosting migration. |
| Local audit artifacts | Project-ignored filesystem | Lighthouse reports, screenshots, and traces | Keep potentially revealing URLs and traces private. Do not upload Lighthouse results to the temporary public LHCI storage service. |

### Conversion Measurement and Consent

| Technology / pattern | Version | Purpose | Why |
|----------------------|---------|---------|-----|
| Google Analytics 4 `gtag.js` | Current hosted tag | Aggregate traffic and CTA analysis after consent | It is already integrated and sufficient for this milestone. Load only in production, only when a valid measurement ID is configured, and only after analytics consent. |
| Basic consent mode | Current Consent Mode API | Default-deny analytics behavior | With basic mode, no Google tag request or measurement is made before opt-in. Default `analytics_storage`, `ad_storage`, `ad_user_data`, and `ad_personalization` to denied; grant only `analytics_storage` after explicit acceptance. |
| First-party Blade consent panel + vanilla JS | Project code | Accept analytics, reject non-essential, and reopen preferences | This site has one analytics vendor and does not need a commercial CMP. Keep the preference locally; make rejection as prominent and revocation as easy as acceptance. Legal wording and lawful basis require Brazilian privacy review. |
| Declarative CTA data attributes | Project code | Consistent WhatsApp event taxonomy | A reusable Blade CTA component should emit controlled `data-page-type`, `data-procedure-slug`, and `data-cta-placement` values. One delegated listener sends the event without delaying or replacing navigation. |
| GA4 custom event `whatsapp_click` | Project taxonomy v1 | Measure an outbound WhatsApp intent proxy | A `wa.me` click proves only that the visitor activated the link. It does not prove WhatsApp opened successfully, a message was sent, or a lead was created. Mark this event as a GA4 key event only if the report label explicitly says “WhatsApp CTA click”. |

#### Required event contract

Use one event name and a closed, low-cardinality vocabulary:

| Field | Allowed shape | Example | Rules |
|-------|---------------|---------|-------|
| Event name | Fixed | `whatsapp_click` | Do not use `generate_lead` for a browser click. Reserve that recommended event for a future confirmed-lead source. |
| `page_type` | Enum | `home`, `procedure` | Do not send page titles or arbitrary strings. GA already supplies the page path after consent. |
| `procedure_slug` | Route-backed enum | `general`, `botox`, `full-face` | Use `general` where no single procedure applies. Never derive this from user text. |
| `cta_placement` | Enum | `header`, `hero`, `results`, `footer`, `final` | Name the visual/business placement, not a DOM selector. Keep values stable across responsive layouts. |

Register only these event-scoped custom dimensions if reporting needs them. Do not register GA client/session identifiers, URLs, timestamps, or message text as custom dimensions; those create high cardinality and unnecessary privacy exposure.

Privacy boundary for WhatsApp attribution:

- Do not send the phone number, `wa.me` URL, prefilled message, name, email, free text, cookies, GA client ID, click IDs, or raw UTM values as event parameters.
- Keep WhatsApp prefilled messages static and generic. They may identify the public procedure and CTA placement with a short anonymous source code only if operations genuinely needs manual reconciliation; never embed a visitor identifier or inferred health detail.
- Send no event when analytics consent is absent. The link itself must still work.
- Audit GA4 Enhanced Measurement. Treat `whatsapp_click` as the canonical metric and prevent an automatic outbound-link event from becoming a duplicate conversion definition or exposing the full destination URL.
- A later “confirmed lead” metric needs an authorized CRM or WhatsApp Business workflow with documented consent, retention, access, and deduplication rules. Do not simulate that confirmation in browser code.

### Quality and Audit Tooling

| Technology | Version | Purpose | When to Use |
|------------|---------|---------|-------------|
| Pest | Existing 4.7.x | Server-rendered contracts | Continue feature tests for status codes, canonical/meta output, visible FAQ-to-schema parity, sitemap routes, and complete/valid CTA data attributes on every public page. |
| Playwright Test | 1.63.0, dev-only | Real-browser interaction and responsive checks | Add for a small Chromium project covering home and representative procedure pages at mobile and desktop sizes. Stub `gtag`/inspect `dataLayer` to prove exactly one consent-gated event per click while preserving navigation. |
| `@axe-core/playwright` | 4.13.0, dev-only | Automated WCAG regression scans | Run after initial render and after opening navigation, FAQ, consent, and other interactive states. Include WCAG 2.2 AA rule tags supported by the installed axe version. Automated scans are a floor, not a conformance claim. |
| Lighthouse CI (`@lhci/cli`) | 0.15.1, dev-only | Repeatable performance, accessibility, best-practice, and SEO lab audits | Run at least three times per representative URL and compare the median. Store artifacts locally; do not use temporary public report upload. Establish the current baseline before enforcing non-regression assertions. |
| PageSpeed Insights and Search Console Core Web Vitals | Current hosted tools | Field/lab diagnosis and 28-day production trends | Use PageSpeed Insights for per-page lab plus available CrUX field data, and Search Console for origin/URL-group field trends. Low traffic may mean no field result. |
| Manual WCAG 2.2 AA checklist | WCAG 2.2 | Human accessibility review | Required for keyboard order, visible/unobscured focus, skip navigation, headings/landmarks, link purpose, target size, contrast, reduced motion, 200%/400% zoom and reflow, and VoiceOver/NVDA spot checks. |
| `web-vitals` | 6.0.1, optional runtime | First-party field CWV when CrUX lacks data | Add only after baseline work shows a genuine field-data gap. Use the standard build, load after analytics consent, and report only metric name, rounded value, and rating. Omit metric IDs, DOM selectors, and attribution details. |

#### Performance gates

The product target is the official “good” Core Web Vitals band at the 75th percentile for mobile and desktop:

| Metric | Target | Measurement note |
|--------|--------|------------------|
| LCP | `<= 2.5 s` | Measure representative home and procedure templates; optimize the actual hero/LCP asset rather than every image indiscriminately. |
| INP | `<= 200 ms` | A field metric; Lighthouse lab runs cannot by themselves prove the 75th-percentile target. Keep consent/analytics handlers small and non-blocking. |
| CLS | `<= 0.1` | Retain explicit image dimensions and reserve layout space for the consent panel and font changes. |

For Lighthouse CI, first record a repeatable baseline on the same machine/network profile. Then fail on meaningful regression and work toward scores of at least 0.90 for Performance, Accessibility, Best Practices, and SEO. Score thresholds are diagnostic project gates, not substitutes for CWV field thresholds or WCAG conformance.

### Local SEO and Structured Data

| Technology / tool | Version | Purpose | Why |
|-------------------|---------|---------|-----|
| Laravel routes, config, and a small PHP schema graph builder | Project code | Canonicals, metadata, sitemap, and JSON-LD | Keep one typed/config-backed source for clinic identity, professional identity, procedures, breadcrumbs, and FAQs. Serialize with Laravel/PHP JSON helpers rather than hand-concatenating JSON. No schema package is warranted for this small, fixed vocabulary. |
| Schema.org vocabulary | 30.0 reference | Entity modeling | Model the clinic as the most specific accurate `Dentist` local-business type and the practitioner as a `Person` with only verified title/credentials. Use only properties valid for the selected types. |
| Google Rich Results Test | Current hosted tool | Google-supported eligibility and syntax check | Test deployed URLs and code after every schema change. A pass does not guarantee a rich result. |
| Schema Markup Validator | Current hosted tool | Generic Schema.org validation | Required for types such as `MedicalProcedure` that may not have a dedicated Google rich-result presentation. |
| Google Search Console URL Inspection + sitemap report | Current hosted tool | Indexing, canonical selection, enhancement errors, and post-release checks | Submit one root sitemap containing absolute canonical URLs; inspect representative templates after release. |
| Google Business Profile | Current hosted product | Local entity accuracy and discovery | Keep name, category, address/service area, phone, hours, website URL, and practitioner data complete and consistent with visible site facts. Local ranking is driven by relevance, distance, and prominence, not schema volume. |

Specific corrections to plan:

- Keep JSON-LD because Google recommends it, but generate a single `@graph` from shared data so visible content and structured data cannot drift.
- The current `MedicalProcedure.performer` relationship is invalid because Schema.org defines `performer` for `Event`, not `MedicalProcedure`. Remove it or express the practitioner relationship only through valid properties/types verified during implementation.
- `employee` expects a `Person`; do not model the practitioner as `Physician` merely to force a profession claim. Use `Person` plus verified `jobTitle` and professional registration facts. Do not publish specialty claims until the clinic confirms their legally supportable wording.
- Keep visible FAQ/schema parity, but do not roadmap around FAQ rich-result traffic: Google normally limits FAQ rich results to authoritative government and health sites.
- Continue excluding self-serving aggregate ratings/reviews from clinic structured data. Google does not display self-serving LocalBusiness/Organization review snippets.
- Add self-referential canonicals and an absolute root sitemap if absent. Internal links should use canonical route URLs.

### Supporting Libraries

| Library | Version | Purpose | When to Use |
|---------|---------|---------|-------------|
| `@playwright/test` | `1.63.0` | Browser test runner | Required for interaction, consent, event, keyboard, and responsive smoke tests. |
| `@axe-core/playwright` | `4.13.0` | Accessibility engine binding | Required within Playwright tests; complement with manual WCAG review. |
| `@lhci/cli` | `0.15.1` | Repeatable Lighthouse collection/assertions | Required for local audit scripts and a future CI gate. |
| `web-vitals` | `6.0.1` | Minimal field CWV collection | Optional only when Search Console/CrUX lacks usable field data and consent-safe collection is approved. |

Pin these tools in `package-lock.json`. The project currently has Pest 4; do not adopt `pestphp/pest-plugin-browser` 5.x merely for this milestone because it would force a Pest 5/PHP toolchain migration unrelated to conversion improvement. Direct Playwright stays isolated from the PHP test runner.

## Alternatives Considered

| Category | Recommended | Alternative | Why Not |
|----------|-------------|-------------|---------|
| Frontend architecture | Blade + Tailwind + vanilla ES module | Livewire interactions, Alpine-heavy UI, Vue/React SPA | The current site is content-led and has simple interactions. A client framework adds JavaScript, hydration, test surface, and accessibility risk without improving measurement or SEO. |
| Analytics deployment | Existing GA4 `gtag.js`, consent-gated | Google Tag Manager | One destination and one custom event do not justify a container, extra governance surface, or ability to publish unreviewed tags. Reconsider only when multiple independently managed vendors are approved. |
| Consent management | First-party panel with basic consent mode | Commercial CMP | A CMP is disproportionate for one optional analytics vendor. Reconsider if advertising, remarketing, embedded media, or multiple jurisdictions materially expand the tracker inventory. |
| Conversion definition | `whatsapp_click` proxy | GA4 `generate_lead` on link click | A click is not a submitted WhatsApp message or qualified lead; calling it one inflates conversion reporting. |
| Accessibility automation | Playwright + axe + manual review | Lighthouse accessibility score alone | Lighthouse/axe cannot evaluate all WCAG success criteria or interaction quality. |
| Browser test integration | Direct Playwright | Laravel Dusk or Pest Browser Plugin 5 | Dusk duplicates browser infrastructure, while Pest Browser 5 would pull the project across a major test-runner boundary. |
| Performance monitoring | PSI/Search Console + LHCI; optional consented `web-vitals` | Always-on RUM/APM/SaaS | Traffic is likely too small to justify another data processor and runtime script before a baseline demonstrates the need. |
| Structured data | Small config-backed PHP graph builder | Schema package or SEO plugin | The vocabulary is small and fixed; a dependency does not validate business truth or Google eligibility. |
| Local SEO | Search Console + Business Profile + technical correctness | Paid rank tracker/SEO suite | Not required to fix crawlability, entity consistency, metadata, schema, or conversion attribution. Add only for an explicit ongoing local-rank operations program. |
| WhatsApp attribution | Anonymous, low-cardinality click context | User/session tokens, GA IDs, click IDs, or message-content capture | Health-adjacent browsing context plus persistent identifiers creates disproportionate privacy and compliance risk. |

## Installation

Dependency changes require project approval. If approved, install the audit tools as exact dev dependencies:

```bash
npm install --save-dev --save-exact @playwright/test@1.63.0 @axe-core/playwright@4.13.0 @lhci/cli@0.15.1
npx playwright install chromium
```

Only if the field-data decision gate is met:

```bash
npm install --save-exact web-vitals@6.0.1
```

Recommended scripts after configuration:

```json
{
  "scripts": {
    "audit:browser": "playwright test",
    "audit:lighthouse": "lhci autorun"
  }
}
```

Do not install GTM wrappers, consent packages, Laravel SEO/schema packages, image-processing services, a CRM SDK, or a JavaScript framework as part of the review milestone. Each can be reconsidered only after an audited requirement demonstrates that the existing stack cannot meet it.

## Implementation Order

1. Capture a no-change baseline: route inventory, Search Console/Business Profile state, PageSpeed/CrUX availability, three-run Lighthouse medians, manual WCAG pass, and current GA configuration.
2. Centralize CTA markup and the event vocabulary in Blade, then add Pest contract tests before changing analytics behavior.
3. Add the default-deny consent layer and production-only GA loader; verify refusal, acceptance, revocation, and no-network-before-consent behavior in Playwright.
4. Add `whatsapp_click`, validate it in GA4 DebugView, register only the three necessary custom dimensions, and document it explicitly as an intent proxy.
5. Correct fonts, LCP resources, motion/focus/semantic issues, and other findings against measured baselines. Add axe and Lighthouse regression checks.
6. Consolidate JSON-LD, correct entity/property relationships, add canonical/sitemap contracts, validate deployed URLs, and monitor Search Console after release.
7. Decide whether consented `web-vitals` field collection is necessary only after checking CrUX/Search Console coverage.

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Existing-stack compatibility | HIGH | Verified against the installed project configuration and Laravel 13/Vite official documentation. |
| Package versions | MEDIUM | Verified from current official package/release metadata on the research date; versions will continue to move. |
| GA4 event semantics and PII boundary | HIGH | Directly supported by current Google Analytics developer and policy documentation. |
| Consent implementation | MEDIUM | Google and ANPD technical guidance is clear; final legal basis, copy, retention, and controller obligations require Brazilian counsel. |
| Accessibility tooling | HIGH | WCAG, Playwright, and axe official documentation agree on WCAG 2.2 and the limits of automation. |
| Performance thresholds | HIGH | Current official Google Search/web.dev thresholds are explicit; achievable scores still depend on measured production conditions. |
| Local SEO and schema | HIGH | Based on current Google Search, Business Profile, and Schema.org primary sources; rich-result display is never guaranteed. |

## Sources

All source-backed findings were fetched through the GSD research-plan seam, cross-checked against primary documentation, and classified **MEDIUM** by the `websearch --verified` confidence seam. Project-specific compatibility findings are additionally grounded in the installed repository.

### Framework and assets

- [Laravel 13 — Asset Bundling with Vite](https://laravel.com/docs/13.x/vite)
- [Vite — Building for Production](https://vite.dev/guide/build)
- [Laravel 13 — HTTP Tests](https://laravel.com/docs/13.x/http-tests)

### Analytics, consent, and privacy

- [Google Analytics — Recommended events](https://developers.google.com/analytics/devguides/collection/ga4/reference/events)
- [Google Analytics — Set up event parameters](https://developers.google.com/analytics/devguides/collection/ga4/event-parameters)
- [Google Analytics — Custom dimensions and metrics](https://support.google.com/analytics/answer/14240153)
- [Google Analytics — Avoid sending personally identifiable information](https://support.google.com/analytics/answer/6366371)
- [Google Tag Platform — Consent mode overview](https://developers.google.com/tag-platform/security/concepts/consent-mode)
- [Google Tag Platform — Set up consent mode](https://developers.google.com/tag-platform/security/guides/consent)
- [ANPD — Guia orientativo: Cookies e proteção de dados pessoais (PDF)](https://www.gov.br/anpd/pt-br/centrais-de-conteudo/materiais-educativos-e-publicacoes/guia-orientativo-cookies-e-protecao-de-dados-pessoais.pdf)
- [ANPD — Recommendations on cookie collection practices](https://www.gov.br/anpd/pt-br/assuntos/noticias/anpd-emite-recomendacoes-para-adequacao-da-pratica-de-coleta-de-cookies-do-portal-gov.br)

### Accessibility and performance

- [W3C WAI — WCAG standards overview](https://www.w3.org/WAI/standards-guidelines/wcag/)
- [Playwright — Accessibility testing](https://playwright.dev/docs/accessibility-testing)
- [Deque — axe-core](https://github.com/dequelabs/axe-core)
- [Google Search — Understanding Core Web Vitals](https://developers.google.com/search/docs/appearance/core-web-vitals)
- [web.dev — Web Vitals](https://web.dev/articles/vitals)
- [PageSpeed Insights — About PSI](https://developers.google.com/speed/docs/insights/v5/about)
- [GoogleChrome — Lighthouse CI releases](https://github.com/GoogleChrome/lighthouse-ci/releases)
- [GoogleChrome — web-vitals](https://github.com/GoogleChrome/web-vitals)

### Search and structured data

- [Google Search — Local business structured data](https://developers.google.com/search/docs/appearance/structured-data/local-business)
- [Google Search — General structured data guidelines](https://developers.google.com/search/docs/appearance/structured-data/sd-policies)
- [Google Search — Structured data tools](https://developers.google.com/search/docs/appearance/structured-data)
- [Google Search — Canonical URLs](https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls)
- [Google Search — Build and submit a sitemap](https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap)
- [Google Business Profile — Tips to improve local ranking](https://support.google.com/business/answer/7091)
- [Schema.org — Dentist](https://schema.org/Dentist)
- [Schema.org — Person](https://schema.org/Person)
- [Schema.org — performer](https://schema.org/performer)
- [Google Search — FAQ and HowTo rich result changes](https://developers.google.com/search/blog/2023/08/howto-faq-changes)
- [Google Search — Review snippet structured data](https://developers.google.com/search/docs/appearance/structured-data/review-snippet)
