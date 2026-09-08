# Codebase Concerns

**Analysis Date:** 2026-09-08

## Tech Debt

**Large, duplicated presentation templates:**
- Issue: Page content and layout are embedded in very large Blade templates instead of being composed from smaller reusable sections. `resources/views/welcome.blade.php` is 500 lines, `resources/views/procedure.blade.php` is 254 lines, and `resources/views/procedures/full-face.blade.php` is 290 lines. The WhatsApp SVG/CTA markup is repeated in several templates and the normal and Full Face procedure pages duplicate most of their section structure.
- Files: `resources/views/welcome.blade.php`, `resources/views/procedure.blade.php`, `resources/views/procedures/full-face.blade.php`, `resources/views/partials/nav.blade.php`, `resources/views/partials/footer.blade.php`
- Impact: Small copy or accessibility changes require editing multiple large files; duplicated markup can drift and increases the chance that one page misses a fix.
- Fix approach: Extract repeated CTA, icon, card, FAQ, and page-section components while preserving the existing Blade/Tailwind conventions; keep procedure-specific content in configuration or dedicated view models.

**Unvalidated procedure content schema:**
- Issue: `ProcedureController` reads arbitrary nested keys from `config('procedures')`, while the route constraint is generated from the same array. There is no validation that each procedure has the keys required by the generic or Full Face templates, or that `view` and `includes` references resolve.
- Files: `app/Http/Controllers/ProcedureController.php:11-19`, `routes/web.php:7-10`, `config/procedures.php:20-235`, `resources/views/procedure.blade.php:12-20`, `resources/views/procedures/full-face.blade.php:13-21`
- Impact: A typo or partial new entry can produce a production 500 at render time; adding a procedure requires remembering undocumented structural invariants.
- Fix approach: Define a typed content object or configuration validator tested against every procedure key, validate custom views/includes at boot or in CI, and fail with a clear configuration error before deployment.

**Configuration and URL construction are split across code and views:**
- Issue: Clinic data is centralized in `config/clinic.php`, but views repeatedly build URLs with hard-coded `https://`, hard-coded paths, and hard-coded WhatsApp message text. The layout ignores `APP_URL` and derives the canonical host from `CLINIC_DOMAIN`.
- Files: `config/clinic.php:3-31`, `resources/views/components/site-layout.blade.php:13-22`, `resources/views/welcome.blade.php:1-11`, `resources/views/procedure.blade.php:1-10`, `resources/views/procedures/full-face.blade.php:1-11`, `resources/views/sitemap.blade.php:5-29`
- Impact: Staging, alternate domains, local HTTPS, or a future URL change can emit incorrect canonical, Open Graph, JSON-LD, sitemap, and CTA links.
- Fix approach: Centralize the public site URL and link builders in configuration or a small presenter, use named routes for internal links, and test generated absolute URLs per environment.

## Known Bugs

**CLI path option can escape the public directory:**
- Symptoms: `images:webp --path=../some-directory` is documented as relative to `public/`, but `public_path(trim($path, '/'))` accepts traversal and can scan/write WebP files outside `public/`.
- Files: `app/Console/Commands/ConvertImagesToWebp.php:123-146`
- Trigger: Run the command with a path containing `..` or a symlinked directory.
- Workaround: Only run the command with trusted paths under `public/` until the resolved real path is checked against the real public root and symlinks are rejected or intentionally handled.

**Image conversion can leave a corrupt destination:**
- Symptoms: The command writes directly to the final `.webp` path, suppresses GD errors with `@`, and only checks that a file exists afterward. A failed/interrupted encode can leave a partial file that is treated as current by the mtime check.
- Files: `app/Console/Commands/ConvertImagesToWebp.php:168-211`
- Trigger: Disk-full, malformed image, process interruption, or GD failure during `imagewebp()`.
- Workaround: Re-run with `--force`; this is not safe for automated concurrent conversion.

## Security Considerations

**No application-level security headers:**
- Risk: The application does not configure a Content Security Policy, frame protection, MIME sniffing protection, referrer policy, or permissions policy. The middleware callback is empty.
- Files: `bootstrap/app.php:11-15`, `resources/views/components/site-layout.blade.php:24-80`
- Current mitigation: Blade escaping is used for ordinary visible values and external links use `rel="noopener noreferrer"`; Laravel's default web middleware still applies.
- Recommendations: Add environment-appropriate security headers at the web-server or Laravel middleware layer, then account for the inline analytics/JSON-LD and Bunny Fonts/Google Tag Manager sources in a deliberate CSP.

**Analytics and external assets load without consent or privacy controls:**
- Risk: Google Analytics is emitted on every page whenever the configured ID has a default value, and fonts are imported from Bunny Fonts while Google Tag Manager is loaded directly. There is no consent state, privacy notice, opt-out, or documented data-processing boundary.
- Files: `config/clinic.php:31`, `resources/views/components/site-layout.blade.php:27-34`, `resources/css/app.css:1-2`
- Current mitigation: The analytics ID is configurable through environment configuration.
- Recommendations: Make analytics opt-in where required, avoid shipping a production default tracking ID, add privacy/consent handling, and document third-party hosts and retention.

**Patient images and testimonials are public repository content:**
- Risk: Before/after photographs and named testimonial text are committed under `public/` and rendered publicly. The page asserts patient authorization in copy, but there is no consent record, takedown workflow, or access-control boundary in the codebase. Image metadata includes mobile-photo EXIF/GPS fields in at least the source assets.
- Files: `public/antes-1.jpg`, `public/depois-1.jpg`, `public/antes-e-depois.jpg`, `resources/views/welcome.blade.php:270-430`
- Current mitigation: The visible disclaimer at `resources/views/welcome.blade.php:361-363` says images are published with authorization.
- Recommendations: Track consent and expiry outside the public repository, strip EXIF before publishing, use an asset review/takedown process, and avoid identifying names or claims unless verified and authorized.

**CI workflow grants unnecessary write permission:**
- Risk: The linter workflow requests `permissions: contents: write` even though its commit step is commented out. A compromised action or dependency could receive write access to repository contents.
- Files: `.github/workflows/lint.yml:1-28`
- Current mitigation: The workflow does not currently commit its changes.
- Recommendations: Set the default to read-only or scope `contents: read`; pin third-party actions to trusted immutable references where operationally practical.

## Performance Bottlenecks

**Duplicate original and WebP image sets increase payload and storage:**
- Problem: The repository keeps both JPEG/PNG originals and WebP companions; raster assets total about 2.4 MB originals plus 912 KB WebP, and the templates rely on runtime `<picture>` selection rather than a single optimized asset pipeline.
- Files: `public/*.jpg`, `public/*.png`, `public/*.webp`, `public/procedures/*`, `resources/views/components/picture.blade.php:13-25`
- Cause: Every source asset is retained for fallback and each render checks `is_file(public_path($webp))`.
- Improvement path: Establish explicit responsive image sizes and a build/CDN policy, retain only required fallbacks, and add cache headers/immutable filenames for production assets.

**Hero images are large and only dimension-hinted:**
- Problem: Hero portraits are 1400×2100 JPEG/WebP files and procedure images are 1000×1250; the same source is served across viewports with CSS cropping. `loading="eager"` and `fetchpriority="high"` are used for the first portrait.
- Files: `public/foto-emily.jpg`, `public/foto-emily-2.jpg`, `resources/views/welcome.blade.php:100-106`, `resources/views/components/picture.blade.php:20-25`
- Cause: No `srcset`/`sizes` variants are generated by `x-picture`, so mobile clients can download desktop-sized images.
- Improvement path: Generate responsive variants and emit `srcset`/`sizes`; verify LCP and cumulative layout shift on representative mobile devices.

## Fragile Areas

**Single source of truth is not enforced across SEO/schema content:**
- Files: `config/faq.php`, `resources/views/welcome.blade.php:448-466`, `resources/views/partials/schema.blade.php:93-108`, `resources/views/partials/procedure-schema.blade.php:39-54`
- Why fragile: Homepage FAQ text is centralized and covered by `tests/Feature/HomeSchemaTest.php`, but procedure FAQ/content and clinic schema fields remain independently assembled. The schema partial interpolates many configured values directly into JSON strings rather than consistently using `json_encode`.
- Safe modification: Update configuration and add rendered JSON-LD assertions for each procedure; encode every dynamic JSON value as JSON rather than relying on Blade HTML escaping.
- Test coverage: `tests/Feature/HomeSchemaTest.php` covers only homepage FAQ and clinic review markup; there are no procedure schema validity tests.

**Marketing claims are hard-coded in templates:**
- Files: `resources/views/welcome.blade.php:381-407`, `resources/views/welcome.blade.php:273-279`, `resources/views/welcome.blade.php:389-392`
- Why fragile: Ratings, review counts, named quotes, “100% results,” years of experience, and before/after claims have no source, timestamp, or validation path. They can become stale or create advertising/compliance risk without causing a test failure.
- Safe modification: Store verifiable claims with provenance/last-reviewed metadata, or remove stale claims; add a content review checklist and smoke assertions for required disclosures.
- Test coverage: No test checks accuracy, freshness, attribution, or required medical/advertising disclaimers.

**Image converter is an operationally fragile command:**
- Files: `app/Console/Commands/ConvertImagesToWebp.php:77-115`, `app/Console/Commands/ConvertImagesToWebp.php:184-211`
- Why fragile: It processes all eligible files synchronously, loads each image fully into memory, suppresses conversion warnings, and has no locking, atomic replacement, retry policy, or per-file size limit.
- Safe modification: Validate and canonicalize paths, write to a temporary file then rename atomically, report structured failures, and process large collections in bounded batches.
- Test coverage: No command tests cover traversal, malformed images, GD failures, dry-run behavior, or idempotency.

## Scaling Limits

**Static configuration is the only content store:**
- Current capacity: Five procedure entries and homepage FAQ/content are represented in PHP arrays and Blade files.
- Limit: Content updates require code review, deployment, and cache/view invalidation; there is no CMS, admin workflow, localization model, or content versioning.
- Scaling path: If procedures, locations, or staff grow, move structured content to validated records or a content service while preserving stable slugs and cached read models.
- Files: `config/procedures.php:31-235`, `config/faq.php`, `resources/views/welcome.blade.php`

**No explicit production observability or failure path:**
- Current capacity: The repository has Laravel logging configuration but no application error tracking, uptime checks, alerting, or deployment health verification.
- Limit: Broken templates, missing Vite manifests, invalid JSON-LD, or external-link failures can reach production without notification.
- Scaling path: Add structured error tracking, health checks for all route slugs and assets, and post-deploy smoke/SEO checks.
- Files: `config/logging.php`, `bootstrap/app.php:16-18`, `.github/workflows/tests.yml:42-43`

## Dependencies at Risk

**Broad semver ranges without an automated update/security policy:**
- Risk: Runtime and frontend dependencies use caret ranges in `composer.json` and `package.json`; lockfiles pin current installs, but no Dependabot/Renovate or dependency audit workflow is present.
- Impact: Fresh installs can drift when lockfiles are regenerated, while known vulnerabilities or breaking framework/plugin changes may remain unnoticed.
- Migration plan: Add scheduled Composer/npm audit checks and controlled lockfile updates; test Laravel/PHP and Node upgrades before merging.
- Files: `composer.json:12-27`, `package.json:8-22`, `.github/workflows/tests.yml`, `.github/workflows/lint.yml`

## Missing Critical Features

**Production asset/deployment contract is undocumented:**
- Problem: `public/build` is ignored by `.gitignore`, while `@vite` requires a generated manifest in production. CI builds assets, but no deployment workflow or hosting configuration in the repository guarantees `npm run build` runs before serving.
- Blocks: A checkout-based deployment can fail every page with a Vite manifest exception even when PHP tests pass.
- Files: `.gitignore:3`, `resources/views/components/site-layout.blade.php:76`, `vite.config.js:1-23`, `.github/workflows/tests.yml:38-43`

**No privacy, contact, or consent workflow:**
- Problem: The site exposes WhatsApp, address, analytics, patient imagery, and testimonials but has no privacy policy route, cookie/analytics consent UI, contact capture audit trail, or documented data-retention process.
- Blocks: Compliance and user-data handling cannot be demonstrated as traffic and marketing integrations expand.
- Files: `routes/web.php:5-16`, `resources/views/components/site-layout.blade.php:27-34`, `config/clinic.php:11-31`, `resources/views/welcome.blade.php:327-362`

## Test Coverage Gaps

**Most routes and rendering paths are untested:**
- What's not tested: Procedure route success/404 behavior, all five procedure slugs, custom Full Face rendering, sitemap XML, canonical/OG metadata, image fallbacks, navigation links, and external CTA URL construction.
- Files: `routes/web.php:5-16`, `app/Http/Controllers/ProcedureController.php:11-19`, `resources/views/procedure.blade.php`, `resources/views/procedures/full-face.blade.php`, `resources/views/sitemap.blade.php`
- Risk: A missing config key, view, image, or malformed metadata can ship while the six current tests remain green.
- Priority: High

**No command, accessibility, browser, or performance tests:**
- What's not tested: `images:webp` safety/idempotency, keyboard/semantic navigation, responsive layout, JavaScript/console errors, image loading behavior, and Core Web Vitals.
- Files: `app/Console/Commands/ConvertImagesToWebp.php`, `resources/views/components/picture.blade.php`, `resources/views/partials/nav.blade.php`, `tests/Feature`, `tests/Unit`
- Risk: Regressions in the only custom command or public-facing UX are detected manually, if at all.
- Priority: Medium

**CI does not enforce a full production-like verification loop:**
- What's not tested: The lint workflow does not build frontend assets, and the test workflow runs Pest but does not exercise generated pages in a browser or validate deployed Vite output. No coverage threshold is configured.
- Files: `.github/workflows/lint.yml:19-25`, `.github/workflows/tests.yml:35-43`, `phpunit.xml:13-20`
- Risk: CI can pass despite deployment-only asset failures, browser regressions, stale links, or declining test coverage.
- Priority: High

---

*Concerns audit: 2026-09-08*
