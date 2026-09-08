---
phase: 1
slug: baseline-content-freeze-approval-gates
status: approved
shadcn_initialized: false
preset: none
created: 2026-09-08
---

# Phase 1 — UI Design Contract

> Visual and interaction contract for the dated baseline. Phase 1 preserves the existing public UI exactly; it records evidence and approval state but does not redesign, remediate, enable analytics, or publish new claims.

---

## Design System

| Property | Value |
|----------|-------|
| Tool | Existing Tailwind CSS v4 CSS-first theme; no shadcn |
| Preset | Not applicable |
| Component library | Existing Blade components and partials; no third-party component library |
| Icon library | Existing inline SVGs only |
| Font | Cormorant Garamond for display; Jost for body/UI; Georgia, system sans-serif fallbacks |

**Preservation rule:** `resources/css/app.css`, existing Blade class lists, content order, responsive behavior, imagery, animation, and CTA destinations are evidence under observation, not implementation targets to improve in this phase. Capture the exact Git revision plus dirty-tree state. Any public-render difference introduced by Phase 1 is a failure.

## Spacing Scale

Declared observation scale (used to classify the existing UI; never normalize existing values during Phase 1):

| Token | Value | Usage |
|-------|-------|-------|
| xs | 4px | Inline and icon gaps |
| sm | 8px | Compact control spacing |
| md | 16px | Default element spacing |
| lg | 24px | Card and container spacing |
| xl | 32px | Layout gaps |
| 2xl | 48px | Large group separation |
| 3xl | 64px | Page-section separation |

Exceptions: record existing Tailwind-derived values outside this scale verbatim, including 10px, 12px, 14px, 20px, 28px, 40px, 56px, 80px, 96px, 112px, 128px, 144px, and 160px where rendered. Do not “fix” them. At each required viewport, evidence must show section boundaries, card padding, gaps, fixed-nav height, and whether any element clips, overlaps, or creates horizontal scrolling.

## Typography

These four tiers are the baseline comparison anchors; screenshots and computed-style evidence retain the exact rendered values when the current UI differs.

| Role | Size | Weight | Line Height |
|------|------|--------|-------------|
| Label | 12px | 500 | 1.5 |
| Body | 16px | 400 | 1.5 |
| Heading | 32px | 500 | 1.2 |
| Display | 48px | 500 | 1.05 |

Only two contract weights are used for evaluation: regular `400` and medium `500`. Existing instances of `300`, `600`, or `700`, italic text, tracking, and responsive type sizes are captured as baseline deviations and preserved during Phase 1. Evidence must include computed font family, size, weight, line height, wrapping, clipping, and fallback behavior on the representative surfaces.

## Color

| Role | Value | Usage |
|------|-------|-------|
| Dominant (60%) | Cream `#FAF6F2` and white `#FFFFFF` | Existing page backgrounds and primary surfaces |
| Secondary (30%) | Charcoal `#2A1F1F`, blush `#E8B4B8` | Existing dark sections, footer, cards, borders, and decorative surfaces |
| Accent — primary action/emphasis (within 10%) | Rose `#C2757F` | Observed as filled WhatsApp/evaluation CTAs; emphasized words and numeric facts; section eyebrows; icons; inline links; FAQ open-state text/control fills; result labels; and low-opacity borders, shadows, gradients, and decorative orbs |
| Accent — strong action/section (within 10%) | Deep rose `#8B3D4A` | Observed as the hover fill for rose CTAs, the solid background of closing conversion sections, and the foreground of white CTAs placed on those closing sections |
| Accent — premium/decorative marker (within 10%) | Gold `#C4956A` | Observed as thin section rules and dividers, Full Face/featured badges, step and feature markers, stars, image-comparison dividers, small dots, and low-opacity hover borders or background glows; it does not carry the primary CTA role |
| Destructive | None | Phase 1 has no public destructive action |

Accent reserved for the exact observed responsibilities assigned above. Rose carries primary action and repeated content emphasis; deep rose carries stronger conversion-section and CTA-hover contrast; gold carries premium/decorative markers and rules. Phase 1 adds no accent usage, swaps no roles, and makes no contrast adjustment. Capture computed foreground/background colors for text, controls, focus indicators, and meaningful overlays; log WCAG 2.2 AA failures as dated findings for later phases, never as silent passes.

## Observed Visual Attention Hierarchy

This hierarchy documents the current templates for comparison evidence; it does not approve their clinical meaning, prominence, copy, or future use.

| Surface | Primary focal point | Observed attention sequence |
|---------|---------------------|-----------------------------|
| Homepage | Above-the-fold hero, led jointly by the oversized italic headline and Dra. Emily portrait | Location eyebrow → large three-line headline with rose final line → portrait and floating credential badge → rose `Agendar Consulta` CTA → secondary procedure anchor → numeric trust badges. Down-page attention shifts to the oversized section headings, dark featured-procedure card, high-contrast before/after imagery, testimonials/ratings, FAQ disclosures, then the deep-rose closing conversion section and white CTA |
| Generic procedure page | Procedure hero heading paired with the procedure image | Breadcrumb → rose eyebrow → large procedure H1 → muted lead → rose `Agendar avaliação` CTA → framed portrait-format procedure image → four-column facts strip. Subsequent sections repeat eyebrow/large-heading/gold-rule anchors, alternating light and charcoal surfaces, before FAQ, related procedures, and the deep-rose closing CTA section |
| Full Face page | Dark flagship hero, with the cream oversized H1 as the strongest element | Breadcrumb → gold `Tratamento Exclusivo` badge and blush eyebrow → extra-large cream H1 → muted cream lead → rose `Agendar avaliação Full Face` CTA → framed procedure image → dark facts strip. Down-page attention is sustained by gold rules/markers, a deep-rose feature section, alternating light/dark sections, FAQ disclosures, and the deep-rose closing section with white CTA |

At 320px, 768px, and 1440px, capture whether this observed order remains perceptually intact or changes because columns stack, navigation items hide, content wraps, imagery crops, or fixed elements compete for attention. Report the observation; do not correct it in Phase 1.

## Copywriting Contract

| Element | Copy |
|---------|------|
| Primary CTA | Capture each existing label and context verbatim, including `Agendar Consulta`, mobile `WhatsApp`, and `Agendar pelo WhatsApp`; do not select or introduce a canonical replacement in Phase 1 |
| Empty state heading | `Evidência indisponível` (governance report only; never public UI) |
| Empty state body | `Não foi possível registrar esta evidência. Motivo: {motivo}. O item permanece bloqueado até nova captura ou decisão humana registrada.` |
| Error state | `Falha na captura de {superfície}. Registre ambiente, data, erro e tentativa; não marque como aprovado.` |
| Destructive confirmation | None; baseline capture and review must not expose destructive public actions |

All public Portuguese copy is frozen as observed. Inventory text verbatim by route and context, including visible headings, CTAs, navigation, footer, FAQ/disclosure text, testimonials, image labels/alternatives, metadata, WhatsApp prefill, JSON-LD, and sitemap values. A captured phrase is not thereby clinically, legally, operationally, or privacy approved.

## Baseline Capture Matrix

Every evidence item records: UTC offset-aware timestamp, exact commit SHA, dirty-tree description or diff reference, environment/base URL, browser and version, OS, viewport CSS width/height, device pixel ratio, zoom, color scheme, reduced-motion preference, tool/version, route, interaction state, screenshot/raw-output path, observation, limitation, and reviewer/status. Never overwrite an earlier capture; recapture under a new dated run.

| Surface | Required route/output | Required states and evidence |
|---------|-----------------------|------------------------------|
| Homepage | `/` | Full-page and section captures; fixed navigation; hero; clinician/trust content; featured and regular procedure cards; before/after media; testimonials; FAQ closed and each disclosure open; closing CTA; footer; every internal/external/WhatsApp destination |
| Generic procedure | One configured slug rendered by `resources/views/procedure.blade.php` | Breadcrumb, hero/media, facts, explanatory content, benefits, steps, FAQ/disclosures, CTAs, shared navigation/footer, and all responsive states |
| Full Face | Configured Full Face slug rendered by `resources/views/procedures/full-face.blade.php` | Every specialized section, media context, facts, disclosures, CTAs, shared navigation/footer, and all responsive states; do not treat it as equivalent to the generic template |
| Public route union | `/`, every configured procedure slug, `/sitemap.xml`, and an invalid procedure slug | HTTP status, content type, canonical target, rendered template, redirect behavior, invalid-slug 404 evidence, and route name |
| Navigation | Shared nav on all representative HTML pages | Desktop links, mobile label variant, fixed/sticky position, anchor destinations, wrapping/overflow, keyboard sequence, hover, focus, visited where observable, and external-tab behavior |
| Footer | Shared footer on all representative HTML pages | Identity, CRO wording, location, phone, Instagram, navigation, map/contact paths, wrapping/overflow, link focus, and consistency with configured values; configured values remain unverified assertions |
| CTA inventory | Every WhatsApp and other conversion link | Visible label, placement, route/context, complete destination captured in restricted evidence, target/rel attributes, keyboard activation, pointer activation, no-JS behavior, unavailable-app behavior where testable, and direct-contact fallback presence/absence. Do not send real messages |
| FAQ/disclosures | Homepage and procedure implementations | Zero/one/many inventory result, closed/open screenshots, summary text, answer text, native semantics, keyboard activation, focus, long-answer reflow, and visible/schema parity where applicable |
| Media | Every public source and derivative in every rendered context | Classification (`patient`, `clinician`, `stock/illustrative`, or `unknown`), source/derivative identity, dimensions, crop/object position, alt text or decorative status, loading behavior, failure behavior, attribution/disclosure, and opaque authorization reference only |
| JSON-LD | Every JSON-LD block on representative and configured pages | Raw parseable output, node/type/property/value inventory, visible-content mapping or `machine-readable-only`, professional/clinical/operational assertions, FAQ parity, and absence/presence by route |
| Sitemap | `/sitemap.xml` | Raw XML, HTTP content type, every URL/image/title, canonical-route mapping, duplicates, omissions, and values not otherwise visible |
| Analytics/measurement | HTML source, loaded scripts, storage/cookies, network requests | Current presence/absence and actual collection behavior. Distinguish configured GA4 ID from observed collection. Never enable analytics. Mark unobservable production configuration `not measured` with reason |
| Unavailable/error | Failed image/font/script/network request, invalid route, missing external app/tool, or inaccessible environment | Capture the actual browser/server behavior and raw error. Never invent a friendly public fallback that does not currently exist; use governance-report error copy and keep the affected evidence/gate blocked |

## Responsive Evidence Contract

Capture the homepage, selected generic procedure, and Full Face page at all three widths with a documented viewport height. Full-page screenshots alone are insufficient: include focused crops for navigation, representative CTA, FAQ/disclosure, representative media, and footer.

| Class | Required width | Contract |
|-------|----------------|----------|
| Mobile minimum | 320px | No assumption of success. Record horizontal overflow, clipping, overlap, fixed-nav collisions, hidden content, tap target dimensions, wrapping, image crop, disclosure reflow, and CTA accessibility exactly as observed |
| Tablet | 768px | Record breakpoint-driven grid/nav/content changes and any intermediate-layout defect |
| Desktop | 1440px | Record maximum-content widths, fixed navigation, multi-column composition, hover states, focus states, media crop, and footer layout |

Also test browser zoom at 200% on one representative HTML page and text spacing/reflow where available. If a viewport, device, browser, or tool cannot be run, record `not measured`, the reason, and the blocking owner; never infer a pass from another width.

## Interaction and Accessibility Evidence

- Traverse each representative HTML page using keyboard only from the first focusable element through the footer. Record the ordered focus sequence, skipped/duplicate stops, keyboard traps, off-screen focus, and whether a visible focus indicator exists. Do not add focus styles in Phase 1.
- Exercise every navigation link, representative CTA placement, and every FAQ/disclosure with `Tab`, `Shift+Tab`, `Enter`, and `Space` where semantically applicable. Record native element/role, accessible name, expanded state, destination, and observed result.
- Capture landmarks and heading outline; record missing, duplicate, or illogical semantics as findings, not remediations.
- Inspect text/control/focus contrast, meaningful image alternatives, decorative SVG treatment, target size, 320px reflow, 200% zoom, and horizontal scrolling against WCAG 2.2 AA. Tool output never substitutes for manual keyboard and rendered-meaning review.
- Run the homepage and both procedure templates with `prefers-reduced-motion: reduce`. Record whether `fadeUp`, `fadeIn`, `scaleIn`, smooth scrolling, hover transforms, and disclosure rotation still animate or leave content hidden. Phase 1 must not add a reduced-motion override.
- Record hover, focus, open/closed, and loaded/failure states separately. Do not claim a state was evaluated when only static source inspection exists.

## Approval and Fail-Closed Presentation

Governance artifacts may present state in tables or reports, but are not public UI and must not be served from public routes. Use exactly: `pending`, `approved`, `rejected`, `quarantined`, and `expired`. Any missing, conflicting, stale, or unmeasured evidence resolves to blocked release eligibility.

| Evidence class | Minimum visible fields in review output | Gate rule |
|----------------|-----------------------------------------|-----------|
| Clinical claim | Stable ID, exact text/hash, route/context, source, owner, last-reviewed date, Dra. Emily decision/date | Anything except current exact-context `approved` is blocked |
| Professional/HOF wording | Stable ID, exact text/hash, route/context, current registration evidence reference, CRO-MG or qualified legal reviewer/date/decision where scope-sensitive | No inferred specialty, title, or legal conclusion; missing/currently uncertain evidence is blocked |
| Patient media/testimonial | Asset/text ID, exact contexts, classification, opaque provenance and authorization references, responsible-professional attribution, decision/date | Unknown classification or incomplete exact-context approval is blocked; sensitive evidence never enters Git/screenshots/logs |
| Clinic operations | Configured value, observed value, verifier/date, evidence reference, status, recheck date | Mismatch, staleness, or missing verification is blocked and never converted into public copy |
| Privacy/analytics | Controller/processors, purpose, data/parameters, lawful basis, consent deny/revoke behavior, retention, access, transfers, production config, approver/date/decision | Analytics remains disabled until the exact production decision is approved |

Approval styling, icons, or green checkmarks are secondary to explicit text status. Never render an empty cell, successful command, inventory completeness, content hash, checkbox, or repository flag as human approval. The release summary must state `BLOCKED` and list actionable item IDs/reasons until every predicate for the exact revision is current and approved.

## UI Considerations

Applicable state considerations resolved: 8 covered, 4 backstop, 0 unresolved.

| Category | Element(s) | Status | Resolution / Reason |
|----------|------------|--------|---------------------|
| empty | FAQ, procedure/media inventory, baseline evidence | ✅ covered | Record zero discovered items explicitly; a required surface or unavailable evidence uses the documented governance empty-state copy and remains blocked |
| loading | media, external fonts, navigation/CTA destination | 🧪 backstop | Capture loaded and throttled/in-flight behavior on each representative page; verify animation does not make core content permanently invisible |
| error | media, fonts, scripts, routes, external links, capture tools | ✅ covered | Capture actual failure behavior plus raw error; use the documented governance error copy and never infer approval or a public fallback |
| populated | page, claim, media, FAQ, CTA collections | ✅ covered | Inventory and capture the normal current render for homepage, generic procedure, Full Face, shared shell, JSON-LD, and sitemap |
| partial | evidence and approval registers | ✅ covered | Present known fields, mark each absent/stale/conflicting field, and keep the exact item and release gate blocked |
| overflow | nav, breadcrumbs, cards, footer, FAQ/static copy, tables | 🧪 backstop | At 320px, 768px, 1440px, and 200% zoom, capture wrapping, clipping, horizontal scroll, overlap, and truncation without remediation |
| zero-one-many | procedure, FAQ, media, CTA, JSON-LD and sitemap collections | ✅ covered | Evidence reports explicit counts and retains singular/plural meaning; zero required items is a completeness failure, not a pass |
| long-text | headings, CTA labels, nav, breadcrumbs, FAQ answers, footer, evidence tables | 🧪 backstop | Use longest current Portuguese values and record wrap/reflow/clip behavior at required viewports; do not shorten public copy |
| reduced motion | animations, smooth scroll, hover transforms, disclosures | 🧪 backstop | Capture the exact `reduce` behavior on all representative templates; continuing animation or hidden content is a dated finding |
| keyboard/focus | nav, CTA links, cards, FAQ summaries, footer links | ✅ covered | Record complete focus order and each control's activation, accessible name, focus visibility, and resulting state/destination |
| unavailable measurement | production analytics, external app, browser/tool capability | ✅ covered | State `not measured`, reason, date, and blocking owner; absence of evidence never becomes a pass |
| machine-readable parity | JSON-LD, FAQ schema, sitemap, metadata | ✅ covered | Parse raw output independently and map each value to visible content or label it machine-readable-only for exact-context review |

Backstop rows require explicit screenshots, browser traces, computed-style/accessibility output, or a recorded `not measured` blocker at verification; source inspection alone is insufficient.

## Registry Safety

| Registry | Blocks Used | Safety Gate |
|----------|-------------|-------------|
| shadcn official | None | Not applicable — project is Laravel Blade/Tailwind and Phase 1 adds no UI dependency |
| Third-party | None | No registry code permitted in this phase |

## Phase Acceptance Contract

- A dated baseline exists for every matrix row and required viewport, tied to an exact revision and environment.
- Before/after comparison shows no Phase 1-caused public DOM, copy, style, asset, interaction, network, structured-data, sitemap, or analytics behavior change.
- Visible and machine-readable claims are separately inventoried and cross-referenced; configured facts are not labelled verified without human evidence.
- Keyboard, focus, disclosure, reduced-motion, 320px, tablet, desktop, error/unavailable, JSON-LD, sitemap, and measurement observations contain evidence or an explicit blocking `not measured` record.
- Inventory completeness is reported separately from clinical, professional, patient-media, operational, and privacy approval.
- Release status remains `BLOCKED` until exact-revision human approvals exist. Automation cannot create, infer, or upgrade an approval.

## Checker Sign-Off

- [x] Dimension 1 Copywriting: PASS
- [x] Dimension 2 Visuals: PASS
- [x] Dimension 3 Color: PASS
- [x] Dimension 4 Typography: PASS
- [x] Dimension 5 Spacing: PASS
- [x] Dimension 6 Registry Safety: PASS

**Approval:** approved 2026-09-08 by GSD UI checker
