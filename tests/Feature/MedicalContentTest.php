<?php

/**
 * Guards the phase-two work from the 2026-09-07 SEO/GEO/AEO audit: the medical
 * page schema and its review date, speakable selectors that point at real
 * anchors, the visible disclaimer, and the comparison tables.
 */

/**
 * @return array<int, mixed>
 */
function schemaNodes(string $html): array
{
    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);

    $decoded = json_decode($m[1], true);

    expect(json_last_error())->toBe(JSON_ERROR_NONE, 'JSON-LD must parse');

    return $decoded;
}

/**
 * @param  array<int, mixed>  $nodes
 * @return array<string, mixed>|null
 */
function nodeOfType(array $nodes, string $type): ?array
{
    return collect($nodes)->firstWhere('@type', $type);
}

$slugs = array_keys(require __DIR__.'/../../config/procedures.php');

it('describes every procedure page as a reviewed medical page', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    $page = nodeOfType(schemaNodes($html), 'MedicalWebPage');

    expect($page)->not->toBeNull()
        ->and($page['lastReviewed'])->toBe(config("procedures.{$slug}.updated"))
        ->and($page['reviewedBy']['identifier'])->toContain(config('clinic.cro'))
        ->and($page['mainEntity']['@id'])->toEndWith('#procedure');
})->with($slugs);

it('points speakable selectors at anchors that exist on the page', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    $page = nodeOfType(schemaNodes($html), 'MedicalWebPage');

    expect($page['speakable']['cssSelector'])->not->toBeEmpty();

    // toContain() treats extra arguments as additional needles, not as a
    // failure message, so the assertion carries exactly one string.
    foreach ($page['speakable']['cssSelector'] as $selector) {
        $id = ltrim($selector, '#');
        expect($html)->toContain('id="'.$id.'"');
    }
})->with($slugs);

it('carries the treatment steps in the procedure markup', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    $procedure = nodeOfType(schemaNodes($html), 'MedicalProcedure');

    foreach (config("procedures.{$slug}.steps") as $step) {
        expect($procedure['howPerformed'])->toContain($step['title']);
    }
})->with($slugs);

it('shows the disclaimer and review date on every procedure page', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    expect($html)->toContain(config('clinic.medical_disclaimer'))
        ->and($html)->toContain('datetime="'.config("procedures.{$slug}.updated").'"');
})->with($slugs);

it('shows the disclaimer on the homepage too', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->toContain(config('clinic.medical_disclaimer'));

    $page = nodeOfType(schemaNodes($html), 'WebPage');

    expect($page['lastReviewed'])->toBe(config('clinic.content_updated'));
});

it('renders a comparison table only where one is configured', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    $comparison = config("procedures.{$slug}.comparison");

    if ($comparison === null) {
        expect($html)->not->toContain('<table');

        return;
    }

    expect($html)->toContain('<table')
        ->and($html)->toContain($comparison['title']);

    foreach ($comparison['rows'] as $row) {
        expect($html)->toContain($row['label']);
    }
})->with($slugs);

it('states the same years of experience everywhere it appears', function () {
    $html = $this->get('/')->assertOk()->getContent();

    $years = (string) config('clinic.years_experience');
    $text = preg_replace('/\s+/', ' ', strip_tags($html));

    expect($text)->toContain('+'.$years)
        ->and($text)->toContain('mais de '.$years.' anos')
        ->and($text)->not->toContain('Com anos de experiência');
});
