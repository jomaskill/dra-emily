# Technology Stack

**Analysis Date:** 2026-09-08

## Languages

**Primary:**
- PHP 8.3+ (Composer constraint `^8.3`; application code, Laravel configuration, controllers, models, commands, and Blade templates) in `app/`, `config/`, `database/`, `resources/views/`, and `routes/`

**Secondary:**
- JavaScript (ES modules) for the Vite entry point in `resources/js/app.js` and build configuration in `vite.config.js`
- CSS with Tailwind directives and custom design tokens in `resources/css/app.css`
- SQLite for the checked-in local database file `database/database.sqlite`

## Runtime

**Environment:**
- PHP 8.3 or newer, with the Laravel application bootstrapped through `artisan` and `bootstrap/app.php`
- Browser runtime for server-rendered Blade HTML and compiled Vite assets

**Package Manager:**
- Composer for PHP dependencies (`composer.json`, `composer.lock`)
- npm for frontend dependencies (`package.json`, `package-lock.json`)
- Lockfiles: present (`composer.lock`, `package-lock.json`)

## Frameworks

**Core:**
- Laravel Framework 13.11.2 - HTTP routing, configuration, Eloquent, sessions, queues, cache, filesystem, and console commands (`bootstrap/app.php`, `routes/`, `app/`)
- Livewire 4.3.0 - installed as the Laravel starter-kit UI integration (`composer.json`); current application pages are Blade views rather than Livewire components
- Blade - server-rendered layouts and pages under `resources/views/`

**Testing:**
- Pest 4.7.0 with `pestphp/pest-plugin-laravel` 4.1.0 - configured by `tests/Pest.php` and `phpunit.xml`
- PHPUnit 12 (transitive Laravel test runner dependency) - test runtime behind `php artisan test`

**Build/Dev:**
- Vite 8.0.14 with `laravel-vite-plugin` 3.1.0 - asset bundling and Blade refresh (`vite.config.js`)
- Tailwind CSS 4.3.0 with `@tailwindcss/vite` 4.3.0 - utility CSS and theme tokens (`resources/css/app.css`, `vite.config.js`)
- Autoprefixer 10.5.0 - CSS post-processing (`package.json`)
- Laravel Pint 1.29.1 - PHP formatting via the Composer `lint` scripts (`composer.json`)
- Laravel Sail 1.60.0 - optional containerized development dependency (`composer.json`)
- Concurrently 9.2.1 - runs server, queue, logs, and Vite together in `composer.json`

## Key Dependencies

**Critical:**
- `laravel/framework` 13.11.2 - application framework and all core web/runtime services
- `livewire/livewire` 4.3.0 - installed UI framework integration
- `laravel/tinker` 3.0.2 - interactive Laravel debugging tooling
- `monolog/monolog` 3.10.0 - logging implementation used by `config/logging.php`

**Infrastructure:**
- `laravel/boost` 2.4.8 - Laravel development tooling
- `laravel/pail` 1.2.6 - live application log viewing in the `composer dev` workflow
- `laravel/pao` 1.0.6 - development tooling
- `fakerphp/faker` 1.24.1 - test/factory data generation (`database/factories/UserFactory.php`)
- Symfony Finder (transitive Laravel dependency) - image discovery in `app/Console/Commands/ConvertImagesToWebp.php`

## Configuration

**Environment:**
- Environment variables are loaded by Laravel from `.env`; `.env` exists and is ignored, so its contents are not part of this map. The safe variable contract is documented in `.env.example`.
- Application defaults and locale are defined in `config/app.php`; clinic/business settings are centralized in `config/clinic.php`, and procedure/FAQ content is config-backed in `config/procedures.php` and `config/faq.php`.
- Database, cache, queue, session, mail, filesystem, logging, and third-party service settings are defined in `config/database.php`, `config/cache.php`, `config/queue.php`, `config/session.php`, `config/mail.php`, `config/filesystems.php`, `config/logging.php`, and `config/services.php`.

**Build:**
- `vite.config.js` declares Laravel inputs (`resources/css/app.css`, `resources/js/app.js`), Tailwind, Bunny Fonts integration, and dev-server behavior.
- `resources/css/app.css` imports Tailwind and defines the application theme, fonts, base styles, and animation utilities.
- `composer.json` scripts define setup, development, linting, testing, and asset build workflows; `package.json` exposes `npm run dev` and `npm run build`.
- `pint.json` and `phpunit.xml` define formatter and test-suite configuration.

## Platform Requirements

**Development:**
- PHP 8.3+, Composer, Node.js/npm, SQLite PDO support, and GD WebP support for `php artisan images:webp` (`app/Console/Commands/ConvertImagesToWebp.php`)
- The standard local workflow is `composer run dev`, which starts Laravel's server, database queue listener, Pail, and Vite concurrently (`composer.json`).

**Production:**
- A PHP-capable Laravel deployment with writable Laravel storage/cache paths, configured application key, database, and web server entry point `public/index.php`.
- No repository-specific cloud hosting or container deployment manifest is detected.

---

*Stack analysis: 2026-09-08*
