# Codebase Structure

**Analysis Date:** 2026-09-08

## Directory Layout

```text
draemilybeatriz/
├── app/                         # Application PHP classes
│   ├── Console/Commands/        # Custom Artisan commands
│   ├── Http/Controllers/        # Web controllers
│   ├── Models/                  # Eloquent models
│   └── Providers/               # Service providers
├── bootstrap/                   # Laravel application/bootstrap wiring
├── config/                      # Framework and clinic/procedure configuration
├── database/                    # SQLite database, migrations, factories, seeders
├── public/                     # Web root and source/static image assets
├── resources/
│   ├── css/                     # Tailwind entry and theme
│   ├── js/                      # Vite JavaScript entry
│   └── views/                   # Blade pages, components, and partials
├── routes/                      # Web and console route definitions
├── storage/                     # Runtime logs, cache, sessions, and local files
├── tests/                       # Pest feature/unit tests
├── artisan, composer.json       # PHP/Artisan entry and dependency scripts
├── package.json, vite.config.js # Frontend build configuration
└── phpunit.xml, pint.json       # Test and formatter configuration
```

## Directory Purposes

**`app/`:**
- Purpose: Application-owned PHP behavior.
- Contains: Controllers, the starter `User` model, service provider, and image conversion command.
- Key files: `app/Http/Controllers/ProcedureController.php`, `app/Models/User.php`, `app/Providers/AppServiceProvider.php`, `app/Console/Commands/ConvertImagesToWebp.php`.

**`bootstrap/`:**
- Purpose: Configure and assemble the Laravel application before dispatch.
- Contains: `bootstrap/app.php`, provider list, and framework cache placeholders.
- Key files: `bootstrap/app.php`, `bootstrap/providers.php`.

**`config/`:**
- Purpose: Framework settings and the site’s content/configuration boundary.
- Contains: Standard Laravel config plus clinic-specific arrays.
- Key files: `config/clinic.php`, `config/procedures.php`, `config/faq.php`, `config/app.php`, `config/database.php`.

**`database/`:**
- Purpose: Persistence scaffolding and local SQLite database.
- Contains: `database/migrations`, `database/factories`, `database/seeders`, and `database/database.sqlite`.
- Key files: `database/migrations/0001_01_01_000000_create_users_table.php`, `database/migrations/0001_01_01_000001_create_cache_table.php`, `database/migrations/0001_01_01_000002_create_jobs_table.php`.

**`public/`:**
- Purpose: Public document root and directly served assets.
- Contains: `public/index.php`, favicon/logo/social images, procedure images, and Vite output under `public/build`.
- Key files: `public/index.php`, `public/procedures/`, `public/build/`.

**`resources/views/`:**
- Purpose: Server-rendered HTML/XML presentation.
- Contains: Page templates (`welcome.blade.php`, `procedure.blade.php`), specialized templates (`procedures/full-face.blade.php`), anonymous components (`components/`), and reusable partials (`partials/`).
- Key files: `resources/views/components/site-layout.blade.php`, `resources/views/components/picture.blade.php`, `resources/views/partials/nav.blade.php`, `resources/views/partials/footer.blade.php`, `resources/views/partials/schema.blade.php`, `resources/views/partials/procedure-schema.blade.php`, `resources/views/sitemap.blade.php`.

**`resources/css/` and `resources/js/`:**
- Purpose: Frontend source assets compiled by Vite.
- Contains: Tailwind v4 theme/base/utilities in `resources/css/app.css` and the currently empty JS entry in `resources/js/app.js`.

**`routes/`:**
- Purpose: URL and Artisan command registration.
- Contains: `routes/web.php` for public pages and `routes/console.php` for CLI commands.

**`tests/`:**
- Purpose: Pest tests for HTTP behavior and starter unit coverage.
- Contains: `tests/Feature`, `tests/Unit`, shared setup in `tests/Pest.php`, and base case in `tests/TestCase.php`.

**`storage/`:**
- Purpose: Runtime-generated logs, compiled views, cache, sessions, and local application files.
- Contains: Ignored framework/runtime directories and `storage/logs`.

## Key File Locations

**Entry Points:**
- `public/index.php`: HTTP front controller.
- `artisan`: CLI front controller.
- `bootstrap/app.php`: Application assembly and route registration.
- `routes/web.php`: Public URL map.

**Configuration:**
- `config/clinic.php`: Clinic contact, location, domain, analytics, and verification settings.
- `config/procedures.php`: Slug-keyed procedure content and per-template metadata.
- `config/faq.php`: Homepage FAQ content used by both visible markup and schema.
- `vite.config.js`: CSS/JS entry points, Laravel refresh integration, fonts, and Tailwind plugin.
- `composer.json`: PHP dependencies, scripts, PSR-4 autoloading, and test/lint commands.

**Core Logic:**
- `app/Http/Controllers/ProcedureController.php`: Procedure configuration lookup and template dispatch.
- `resources/views/components/site-layout.blade.php`: Shared document/page shell.
- `resources/views/welcome.blade.php`: Homepage composition.
- `resources/views/procedure.blade.php`: Reusable procedure detail composition.
- `resources/views/procedures/full-face.blade.php`: Specialized procedure composition.

**Testing:**
- `tests/Feature/HomeSchemaTest.php`: Homepage JSON-LD and visible FAQ consistency contract.
- `tests/Feature/ExampleTest.php`: Basic homepage response smoke test.
- `tests/Unit/ExampleTest.php`: Unit test placeholder.
- `tests/Pest.php`: Pest extension, `RefreshDatabase` for Feature tests, and shared expectation setup.

## Naming Conventions

**Files:**
- PHP classes use PascalCase names matching their class, such as `ProcedureController.php`, `User.php`, and `AppServiceProvider.php`.
- Blade page/component names use kebab-case for anonymous components (`site-layout.blade.php`, `picture.blade.php`) and descriptive lowercase names for pages/partials (`welcome.blade.php`, `procedure-schema.blade.php`).
- Config files use lowercase domain names (`procedures.php`, `clinic.php`, `faq.php`).
- Tests use PascalCase with a `Test.php` suffix (`HomeSchemaTest.php`, `ExampleTest.php`).

**Directories:**
- Laravel conventions are used: `app/Http/Controllers`, `app/Models`, `app/Providers`, `database/migrations`, `resources/views/components`, and `resources/views/partials`.
- Procedure-specific templates live under `resources/views/procedures/` and use a slug-oriented filename.

## Where to Add New Code

**New Feature:**
- Public URL: add a named route to `routes/web.php`; keep the route thin and put nontrivial request behavior in `app/Http/Controllers`.
- Config/content: add clinic-wide settings to an appropriate `config/*.php` file; add procedure fields to `config/procedures.php` while preserving the common array shape.
- Page: add a Blade page under `resources/views/`, normally composing `resources/views/components/site-layout.blade.php` and existing partials.
- Tests: add HTTP behavior to `tests/Feature/` and isolated PHP behavior to `tests/Unit/`; extend the Pest conventions from `tests/Pest.php`.

**New Component/Module:**
- Shared Blade UI: add an anonymous component under `resources/views/components/` and invoke it with `<x-name>`.
- Shared markup fragment or schema: add a partial under `resources/views/partials/` and include it from the relevant page/layout.
- Reusable PHP application behavior: add a class under the nearest existing `app/` namespace (`app/Http/Controllers`, `app/Models`, `app/Providers`, or a new namespace only when the feature warrants it).

**Utilities:**
- Shared frontend styles/utilities: update `resources/css/app.css` and its Tailwind `@theme`/layers.
- Image processing: extend or add an Artisan command under `app/Console/Commands`; generated/public assets belong in `public/`.
- Shared image rendering: reuse `resources/views/components/picture.blade.php` rather than duplicating WebP detection.

## Special Directories

**`public/build/`:**
- Purpose: Vite-generated CSS/JS bundles and manifests.
- Generated: Yes, by `npm run build`.
- Committed: Present in the repository; treat source files under `resources/` as authoritative when changing assets.

**`storage/framework/` and `storage/logs/`:**
- Purpose: Laravel runtime cache, compiled views, sessions, and logs.
- Generated: Yes.
- Committed: Directory placeholders/ignore files only; do not place source code here.

**`vendor/` and `node_modules/`:**
- Purpose: Installed Composer and npm dependencies.
- Generated: Yes, by Composer/npm installation.
- Committed: Dependency trees are present locally but should not be used as application source locations.

**`.planning/codebase/`:**
- Purpose: GSD-generated architecture, structure, quality, integration, stack, and concern maps.
- Generated: Yes, by mapping workflows.
- Committed: The mapping documents are intended as project planning artifacts.

---

*Structure analysis: 2026-09-08*
