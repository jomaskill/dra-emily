# Coding Conventions

**Analysis Date:** 2026-09-08

## Naming Patterns

**Files:**
- PHP classes use PascalCase names matching the class, such as `app/Http/Controllers/ProcedureController.php`, `app/Models/User.php`, and `app/Console/Commands/ConvertImagesToWebp.php`.
- Blade views and partials use lowercase kebab-case or descriptive lowercase names, for example `resources/views/components/site-layout.blade.php`, `resources/views/partials/procedure-schema.blade.php`, and `resources/views/procedures/full-face.blade.php`.
- Configuration files use lowercase snake_case, such as `config/faq.php`, `config/procedures.php`, and `config/clinic.php`.

**Functions:**
- PHP methods use camelCase and explicit return types, for example `ProcedureController::show(string $slug): View` in `app/Http/Controllers/ProcedureController.php` and `User::initials(): string` in `app/Models/User.php`.
- Test names are lowercase, human-readable sentences in `test('...')` or `it('...')` blocks, as shown in `tests/Feature/ExampleTest.php` and `tests/Feature/HomeSchemaTest.php`.

**Variables:**
- Local PHP variables use camelCase (`$procedure`, `$sourceBytes`, `$webpBytes`) in `app/Http/Controllers/ProcedureController.php` and `app/Console/Commands/ConvertImagesToWebp.php`.
- Configuration payload keys use snake_case when they represent content fields (`meta_description`, `card_desc`, `what_is_title`) in `config/procedures.php`.
- Blade component props use camelCase (`$ogTitle`, `$ogDescription`, `$navBase`) in `resources/views/components/site-layout.blade.php`.

**Types:**
- Application classes follow Laravel namespaces under `App\` and PSR-4 directories: controllers under `app/Http/Controllers`, models under `app/Models`, providers under `app/Providers`, and commands under `app/Console/Commands`.
- Laravel framework types are imported at the top of PHP files; migrations use anonymous `Migration` classes in `database/migrations`.
- Array shapes and generic collections are documented with PHPDoc where useful, for example the row shape in `app/Console/Commands/ConvertImagesToWebp.php` and factory return types in `database/factories/UserFactory.php`.

## Code Style

**Formatting:**
- Laravel Pint is the formatter, configured with the Laravel preset in `pint.json`.
- Run `vendor/bin/pint --format agent` (or the Composer `lint` script) after PHP changes; `vendor/bin/pint --test --format agent` is the non-mutating check used by CI-style validation.
- PHP uses four-space indentation, braces for all control structures, trailing commas in multiline arrays/calls, and one class per file. The observed PHP files consistently include `<?php` followed by a namespace/import block.
- Blade uses four-space indentation for markup and directives, with attributes split over lines for larger elements. Tailwind utility classes are grouped directly on the element in `resources/views/**/*.blade.php`.
- CSS in `resources/css/app.css` uses four-space indentation, lowercase kebab-case custom properties, and Tailwind v4 CSS-first configuration via `@import 'tailwindcss'` and `@theme`.

**Linting:**
- `pint.json` sets the Laravel preset; no ESLint, Prettier, or separate PHPStan/Psalm configuration is detected.
- The Composer `test` script clears config, runs `pint --parallel --test`, then invokes `php artisan test`; use `composer test` for the full project check.

## Import Organization

**Order:**
1. Namespace declaration.
2. Application and framework imports, generally alphabetized/grouped by the editor or formatter.
3. Class declaration or executable route/config code.

For example, `app/Providers/AppServiceProvider.php` imports Carbon first, then Laravel facades and service-provider types; `tests/Pest.php` imports the test trait and application test case before configuring Pest.

**Path Aliases:**
- PHP uses Composer PSR-4 mappings `App\\` → `app/`, `Database\\Factories\\` → `database/factories/`, `Database\\Seeders\\` → `database/seeders/`, and `Tests\\` → `tests/` as configured in `composer.json`.
- Frontend source is referenced by explicit Vite entry paths (`resources/css/app.css`, `resources/js/app.js`) in `vite.config.js`; no JavaScript import alias is detected.

## Error Handling

**Patterns:**
- Controllers fail early with Laravel helpers and return typed views. `app/Http/Controllers/ProcedureController.php` uses `abort_if($procedure === null, 404)` before rendering a configured view.
- Console commands validate options up front, print actionable errors/warnings, and return `self::FAILURE` or `self::SUCCESS`; see `app/Console/Commands/ConvertImagesToWebp.php`.
- Route closures return framework responses directly, such as the XML response in `routes/web.php`.
- No application-specific exception classes or custom exception rendering are detected; new code should follow the framework/bootstrap exception configuration in `bootstrap/app.php` unless a domain-specific need is established.

## Logging

**Framework:** Laravel's configured logging stack in `config/logging.php`; no direct application logger calls are detected in the scanned application code.

**Patterns:**
- User-facing command diagnostics use `$this->error()`, `$this->warn()`, `$this->info()`, and `$this->table()` in `app/Console/Commands/ConvertImagesToWebp.php`.
- Add structured Laravel logging only for operational events that should reach configured sinks; keep normal command progress in console output.

## Comments

**When to Comment:**
- Use PHPDoc for public methods, array shapes, framework extension points, and non-obvious contracts. Examples include `app/Console/Commands/ConvertImagesToWebp.php`, `app/Models/User.php`, and `database/factories/UserFactory.php`.
- Blade uses section divider comments for major page regions and short rationale comments for SEO/schema behavior, as in `resources/views/welcome.blade.php` and `resources/views/partials/schema.blade.php`.
- Configuration files contain explanatory block comments documenting the shape and single source of truth, especially `config/faq.php` and `config/procedures.php`.

**JSDoc/TSDoc:**
- No TypeScript or JSDoc convention is detected. `resources/js/app.js` is currently empty; JavaScript additions should use the project's ESM/Vite style from `package.json` and `vite.config.js`.

## Function Design

**Size:**
- Keep request/controller methods small and orchestration-focused; `ProcedureController::show()` resolves config, guards missing data, and renders.
- Extract repeated or multi-step command work into private methods. `app/Console/Commands/ConvertImagesToWebp.php` separates directory resolution, file discovery, encoding, reporting, and formatting.

**Parameters:**
- Type every parameter and return value in application PHP. Prefer scalar/domain types and nullable types where applicable (`string $slug`, `int $quality`, `?string`).
- Use PHP 8 constructor property promotion for new dependency-injected classes, consistent with project guidance; no injected constructor example exists in the current app.

**Return Values:**
- Return framework response/view types where known (`: View` in `app/Http/Controllers/ProcedureController.php`), `: int` for Artisan command handlers, and `: bool` for predicates such as `isUpToDate()`.
- Use arrays for configuration and structured view data, with PHPDoc shapes when the structure is non-trivial.

## Module Design

**Exports:**
- Laravel discovers classes through Composer PSR-4 and framework conventions; classes expose only the methods needed by the framework or their callers.
- Route and configuration files return their route definitions or arrays directly (`routes/web.php`, `config/faq.php`, `config/procedures.php`).

**Barrel Files:**
- No barrel/index modules are detected in PHP or frontend source.

## Blade and Frontend Patterns

- Prefer reusable Blade components and partials for shared shells and fragments: `resources/views/components/site-layout.blade.php`, `resources/views/components/picture.blade.php`, and `resources/views/partials/*.blade.php`.
- Pass component inputs through `@props` and render dynamic values with escaped `{{ }}`; use `{!! !!}` only for intentionally encoded JSON in `resources/views/partials/schema.blade.php` and `resources/views/partials/procedure-schema.blade.php`.
- Keep content/data in config arrays (`config/faq.php`, `config/procedures.php`) and render it through loops; do not duplicate procedure or FAQ content in templates.
- Use Tailwind utility classes and project theme tokens (`cream`, `blush`, `rose`, `charcoal`, etc.) defined in `resources/css/app.css`; use `gap-*` for sibling spacing and keep responsive variants alongside base utilities.

---

*Convention analysis: 2026-09-08*
