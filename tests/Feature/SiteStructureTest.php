<?php

/**
 * Guards the phase-three work from the 2026-09-07 SEO/GEO/AEO audit: the
 * procedure catalogue and its assets, internal linking that stays sane as the
 * catalogue grows, and service areas that the page states as well as declares.
 */
$catalogue = require __DIR__.'/../../config/procedures.php';
$slugs = array_keys($catalogue);

it('serves a hero image, a WebP variant and a share card for every procedure', function (string $slug) {
    foreach (['.jpg', '.webp', '-og.jpg'] as $extension) {
        expect(file_exists(public_path("procedures/{$slug}{$extension}")))
            ->toBeTrue("Missing procedures/{$slug}{$extension}");
    }
})->with($slugs);

it('gives every procedure a decorative number of its own', function () use ($catalogue) {
    $numbers = array_column($catalogue, 'num');

    expect($numbers)->toHaveCount(count(array_unique($numbers)));
});

it('lists every procedure in the sitemap', function () use ($slugs) {
    $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

    foreach ($slugs as $slug) {
        expect($xml)->toContain("/procedimentos/{$slug}</loc>");
    }

    // Homepage, every procedure, the article index, and every article.
    $expected = 1 + count($slugs) + 1 + count(config('articles'));

    expect(substr_count($xml, '<loc>'))->toBe($expected);
});

it('links a handful of siblings rather than the whole catalogue', function (string $slug) use ($slugs) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    $linked = array_filter(
        $slugs,
        fn (string $other): bool => $other !== $slug && str_contains($html, "/procedimentos/{$other}\"")
    );

    expect(count($linked))->toBeLessThanOrEqual(4)->toBeGreaterThan(0);
})->with($slugs);

it('sends internal links to every procedure, including the newest', function () use ($slugs) {
    $inbound = array_fill_keys($slugs, 0);

    foreach ($slugs as $slug) {
        $html = $this->get("/procedimentos/{$slug}")->getContent();

        foreach ($slugs as $target) {
            if ($target !== $slug && str_contains($html, "/procedimentos/{$target}\"")) {
                $inbound[$target]++;
            }
        }
    }

    expect(min($inbound))->toBeGreaterThan(0);
});

it('states the service areas on the page as well as in the markup', function () {
    $html = $this->get('/')->assertOk()->getContent();

    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
    $clinic = collect(json_decode($m[1], true))->firstWhere('@type', 'Dentist');

    $declared = array_column($clinic['areaServed'], 'name');
    $text = preg_replace('/\s+/', ' ', strip_tags($html));

    foreach (config('clinic.areas_served') as $area) {
        expect($declared)->toContain($area)
            ->and($text)->toContain($area);
    }
});

it('shows every procedure on the homepage', function (string $slug) {
    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->toContain("/procedimentos/{$slug}");
})->with($slugs);
