# Testing Patterns

**Analysis Date:** 2026-09-08

## Test Framework

**Runner:**
- Pest 4 (`pestphp/pest` `^4.7`) with the Laravel plugin (`pestphp/pest-plugin-laravel` `^4.1`) in `composer.json`.
- PHPUnit 12 is used underneath Pest; `phpunit.xml` defines the `Unit` and `Feature` suites and bootstraps `vendor/autoload.php`.
- Pest bootstrap/configuration lives in `tests/Pest.php`; the application base test case is `tests/TestCase.php`.

**Assertion Library:**
- Pest expectations (`expect(...)`) and Laravel/PHPUnit response assertions (`assertOk()`) are used. `tests/Feature/HomeSchemaTest.php` combines both styles.

**Run Commands:**
```bash
php artisan test --compact                 # Run all tests (observed: 6 tests, 28 assertions)
php artisan test --compact tests/Feature/HomeSchemaTest.php  # Run one file
php artisan test --compact --filter="name" # Run a focused test
composer test                               # Config clear, Pint check, then all tests
vendor/bin/pint --test --format agent       # Formatting check
```

No dedicated coverage threshold or coverage script is configured in `phpunit.xml` or `composer.json`. PHPUnit source inclusion is limited to `app/`.

## Test File Organization

**Location:**
- Feature tests live in `tests/Feature`, and are bound to the Laravel `Tests\\TestCase` plus `RefreshDatabase` through `tests/Pest.php`.
- Unit tests live in `tests/Unit`; no Laravel feature trait is applied to this directory by the current Pest bootstrap.
- Shared bootstrap/test base files are `tests/Pest.php` and `tests/TestCase.php`.
- Browser tests, integration-specific directories, datasets, fixtures, and factories dedicated to tests are not detected.

**Naming:**
- Use PascalCase filenames ending in `Test.php`, for example `tests/Feature/HomeSchemaTest.php` and `tests/Unit/ExampleTest.php`.
- Use `test('...')` for simple tests and `it('...')` for behavior-focused cases; match neighboring tests in the same directory.

**Structure:**
```
tests/
├── Pest.php                 # Pest global configuration and Feature bindings
├── TestCase.php             # Laravel base test case
├── Feature/
│   ├── ExampleTest.php
│   └── HomeSchemaTest.php
└── Unit/
    └── ExampleTest.php
```

## Test Structure

**Suite Organization:**
```php
it('renders FAQ schema questions that match the visible accordion exactly', function () {
    $html = $this->get('/')->assertOk()->getContent();

    $faq = schemaNode(homeJsonLd($html), 'FAQPage');
    $schemaQuestions = array_column($faq['mainEntity'], 'name');

    expect(visibleFaqQuestions($html))->toBe($schemaQuestions);
});
```

**Patterns:**
- Keep each test focused on one externally observable behavior. `tests/Feature/HomeSchemaTest.php` has separate tests for question parity, answer visibility, shared config sourcing, and prohibited review markup.
- Exercise HTTP behavior through `$this->get()` and assert the response before parsing its body.
- Extract repeated parsing/assertion setup into file-local helper functions such as `homeJsonLd()`, `schemaNode()`, and `visibleFaqQuestions()` in `tests/Feature/HomeSchemaTest.php`.
- Prefer strict Pest expectations (`toBe`, `toContain`, `toBeTrue`, `not->toHaveKey`) over loose comparisons.
- Test names describe the user-visible or contract-level behavior, not the implementation method.

## Mocking

**Framework:**
- No mocks, fakes, datasets, or Mockery usage is present in the current tests. Mockery is installed as a dev dependency through `composer.json` but is not used by the repository's tests.

**Patterns:**
```php
// No repository-specific mocking example is currently available.
// When an external boundary is introduced, use the relevant Laravel fake
// (for example Http::fake(), Event::fake(), or Notification::fake()) before
// exercising the boundary, while preserving factory setup first.
```

**What to Mock:**
- Fake external HTTP, events, notifications, mail, queues, or other side effects when a test needs to assert calls without performing them.
- Keep the current schema/HTML tests real: they render the route and inspect generated output rather than mocking the view layer.

**What NOT to Mock:**
- Do not mock the route, Blade rendering, or configuration that is the behavior under test; `tests/Feature/HomeSchemaTest.php` intentionally verifies the complete rendered homepage.
- Do not fake model events before factory creation when factories depend on those events; follow the project testing guidance and create factory data first.

## Fixtures and Factories

**Test Data:**
```php
// Current feature tests use the rendered application's configured data:
$configured = config('faq.home');

expect($configured)->not->toBeEmpty();
```

The application has a general-purpose `Database\\Factories\\UserFactory` in `database/factories/UserFactory.php` with an `unverified()` state, but no current test consumes it. There are no test fixture files or test-specific factory states detected.

**Location:**
- Shared application factory: `database/factories/UserFactory.php`.
- Seed data: `database/seeders/DatabaseSeeder.php` (not used as an explicit fixture in the current test files).
- Inline fixture/config source for schema tests: `config/faq.php` and rendered Blade output from `resources/views/partials/schema.blade.php`.

## Coverage

**Requirements:** None enforced. `phpunit.xml` includes `app/` as the source directory, but no minimum percentage or coverage report configuration is present.

**View Coverage:**
```bash
php artisan test --coverage
```

This command is available through Pest/PHPUnit tooling, but coverage output is not part of the configured Composer scripts or CI workflow.

## Test Types

**Unit Tests:**
- `tests/Unit/ExampleTest.php` demonstrates a pure expectation with no framework dependencies. Keep unit tests isolated from HTTP, database, and Blade rendering.

**Integration Tests:**
- `tests/Feature/HomeSchemaTest.php` is an HTTP/rendering integration test: it requests `/`, parses JSON-LD and visible FAQ markup, and verifies the shared content contract.
- `tests/Feature/ExampleTest.php` is a minimal route smoke test using `$this->get('/')->assertOk()`.
- Feature tests use an in-memory SQLite database configured by `phpunit.xml` and `RefreshDatabase` via `tests/Pest.php`, even though the current assertions do not query models.

**E2E Tests:**
- No `tests/Browser` suite or browser runner configuration is detected. Pest 4 browser testing is not currently used.

## Common Patterns

**Async Testing:**
```php
// No asynchronous jobs or async test cases are present.
// Use Laravel's queue fakes/assertions when queue behavior is introduced.
```

**Error Testing:**
```php
it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertOk();
});
```

The current suite mostly asserts successful responses and schema invariants. For new negative HTTP cases, use semantic Laravel assertions such as `assertNotFound()` or `assertForbidden()` rather than numeric status comparisons. For command failures, add Artisan command tests that assert the exit code and console output from the command contract in `app/Console/Commands/ConvertImagesToWebp.php`.

---

*Testing analysis: 2026-09-08*
