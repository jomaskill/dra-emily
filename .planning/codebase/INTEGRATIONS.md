# External Integrations

**Analysis Date:** 2026-09-08

## APIs & External Services

**Analytics and discovery:**
- Google Analytics 4 - browser tracking is loaded with the Google tag (`gtag.js`) in `resources/views/components/site-layout.blade.php`; identifier is configured by `GOOGLE_ANALYTICS_ID` through `config/clinic.php`.
- Google site verification and Google Business/Maps - optional verification metadata, business URL, and map/schema links are rendered by `resources/views/components/site-layout.blade.php`, `resources/views/partials/schema.blade.php`, and `config/clinic.php`.
- Schema.org - JSON-LD metadata for the clinic, procedures, FAQs, and navigation is emitted by `resources/views/partials/schema.blade.php` and `resources/views/partials/procedure-schema.blade.php`; this is markup integration, not a server API client.

**Social and contact links:**
- WhatsApp - public `wa.me` click-to-chat links are generated from `CLINIC_WHATSAPP` in `config/clinic.php` and rendered in `resources/views/welcome.blade.php`, `resources/views/procedure.blade.php`, `resources/views/procedures/full-face.blade.php`, and shared footer/layout views.
- Instagram - public profile links are generated from `CLINIC_INSTAGRAM` in `config/clinic.php` and rendered by `resources/views/components/site-layout.blade.php` and `resources/views/partials/footer.blade.php`.

**Fonts/assets:**
- Bunny Fonts - Cormorant Garamond and Jost are imported over HTTPS in `resources/css/app.css`; Instrument Sans is configured through `bunny()` in `vite.config.js`.

## Data Storage

**Databases:**
- SQLite is the default connection (`DB_CONNECTION=sqlite`) and the repository includes `database/database.sqlite`; migrations in `database/migrations/` create users, sessions, cache, jobs, batches, and failed-job storage.
- Laravel also ships configured connection definitions for MySQL, MariaDB, PostgreSQL, and SQL Server in `config/database.php`, but no application code selects those by default.
  - Connection: `DB_CONNECTION`, `DB_DATABASE`/`DB_URL`, and driver-specific `DB_*` variables
  - Client: Laravel Eloquent/DB facade and PDO through `laravel/framework`

**File Storage:**
- Local private/public disks are configured in `config/filesystems.php`, with public assets committed under `public/`.
- An optional Amazon S3-compatible disk is configured using `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, `AWS_URL`, and `AWS_ENDPOINT`; no application call site currently uses S3.

**Caching:**
- Database cache is the default (`CACHE_STORE=database`) using the cache migration and `config/cache.php`.
- Redis, Memcached, DynamoDB, file, array, Octane, and failover stores are available as framework configuration options in `config/cache.php`; no dedicated application cache integration is detected.

## Authentication & Identity

**Auth Provider:**
- Custom Laravel session authentication - the `web` guard uses the Eloquent `App\Models\User` provider in `config/auth.php`, with sessions stored in the database by default (`config/session.php`).
- No OAuth, social login, external identity provider, or authentication SDK is detected.

## Monitoring & Observability

**Error Tracking:**
- No external error tracking service is detected.

**Logs:**
- Laravel logging uses Monolog through `config/logging.php`, defaulting to a stack containing the local single-file channel at `storage/logs/laravel.log`.
- Optional Slack webhook and Papertrail syslog channels are configured by `LOG_SLACK_WEBHOOK_URL`, `PAPERTRAIL_URL`, and `PAPERTRAIL_PORT`; no application code explicitly selects them.
- Local development uses Laravel Pail through the `composer dev` script (`composer.json`).

## CI/CD & Deployment

**Hosting:**
- No hosting provider, CI workflow, Dockerfile, or deployment manifest is detected in the repository.

**CI Pipeline:**
- No `.github/workflows` or other CI configuration is detected.
- The Composer `ci:check` script runs the project test workflow, including Pint checks and `php artisan test` (`composer.json`).

## Environment Configuration

**Required env vars:**
- `APP_KEY` is required for Laravel encryption/session security; `APP_ENV`, `APP_DEBUG`, and `APP_URL` control runtime behavior (`config/app.php`).
- `DB_CONNECTION`/`DB_DATABASE` select the database; the default is local SQLite (`config/database.php`, `.env.example`).
- `SESSION_DRIVER`, `CACHE_STORE`, `QUEUE_CONNECTION`, and `FILESYSTEM_DISK` select state backends (`config/session.php`, `config/cache.php`, `config/queue.php`, `config/filesystems.php`).
- Clinic-facing configuration is supplied through `CLINIC_DOMAIN`, `CLINIC_WHATSAPP`, `CLINIC_INSTAGRAM`, address/coordinates, `GOOGLE_ANALYTICS_ID`, `GOOGLE_SITE_VERIFICATION`, and `GOOGLE_BUSINESS_URL` (`config/clinic.php`).
- Mail variables are needed only when switching from the default log mailer to SMTP, SES, Postmark, Resend, or another configured transport (`config/mail.php`, `config/services.php`).

**Secrets location:**
- Secrets belong in the ignored `.env` file or the deployment platform's secret manager. `.env.example` contains placeholders only; secret-bearing files are intentionally excluded from this audit.

## Webhooks & Callbacks

**Incoming:**
- None detected. `routes/web.php` defines public HTML pages and `/sitemap.xml`, with no webhook receiver route.

**Outgoing:**
- No server-side webhook client is detected. Browser links navigate to WhatsApp, Instagram, Google Maps, and analytics/font providers as described above.

---

*Integration audit: 2026-09-08*
