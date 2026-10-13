<?php

/**
 * Guards the 2026-10-13 search coverage work: pages for the complaints the
 * 30–60 audience actually types (bigode chinês, papada, olheiras, flacidez,
 * bruxismo), a page for men, concern pages that lead to their treatments, no
 * brand names that would get Google Ads landing pages rejected, and copy that
 * no longer assumes every patient is a woman.
 */
$catalogue = require __DIR__.'/../../config/procedures.php';
$concernSlugs = array_keys(array_filter($catalogue, fn (array $page): bool => ($page['kind'] ?? null) === 'concern'));

$publicPaths = fn (): array => array_merge(
    ['/', '/artigos', '/sitemap.xml'],
    array_map(fn ($slug) => "/procedimentos/{$slug}", array_keys(require __DIR__.'/../../config/procedures.php')),
    array_map(fn ($slug) => "/artigos/{$slug}", array_keys(require __DIR__.'/../../config/articles.php')),
);

it('covers the terms the audience searches for', function (string $term, string $path) {
    $text = mb_strtolower(strip_tags($this->get($path)->assertOk()->getContent()));

    expect($text)->toContain($term);
})->with([
    ['bigode chinês', '/procedimentos/bigode-chines'],
    ['sulco nasogeniano', '/procedimentos/bigode-chines'],
    ['papada', '/procedimentos/enzima-para-papada'],
    ['olheiras', '/procedimentos/preenchimento-de-olheiras'],
    ['bruxismo', '/procedimentos/toxina-botulinica-bruxismo'],
    ['flacidez facial', '/procedimentos/flacidez-facial'],
    ['menopausa', '/procedimentos/flacidez-facial'],
    ['harmonização facial masculina', '/procedimentos/harmonizacao-facial-masculina'],
    ['preenchimento facial', '/procedimentos/preenchimento-facial'],
]);

it('gives every concern page up to four treatments that exist', function (string $slug) use ($catalogue) {
    $treatments = $catalogue[$slug]['treatments'];

    expect($treatments)->not->toBeEmpty()->and(count($treatments))->toBeLessThanOrEqual(4);

    foreach ($treatments as $treatment) {
        expect($catalogue)->toHaveKey($treatment)
            ->and($catalogue[$treatment]['kind'] ?? null)->not->toBe('concern');
    }
})->with($concernSlugs);

it('links a concern page to its treatments and nothing else in the catalogue', function (string $slug) use ($catalogue) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    $linked = array_values(array_filter(
        array_keys($catalogue),
        fn (string $other): bool => $other !== $slug && str_contains($html, "/procedimentos/{$other}\"")
    ));

    expect($linked)->toEqualCanonicalizing($catalogue[$slug]['treatments']);
})->with($concernSlugs);

it('marks a concern page up as a condition with its possible treatments', function (string $slug) use ($catalogue) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
    $condition = collect(json_decode($m[1], true))->firstWhere('@type', 'MedicalCondition');

    expect($condition)->not->toBeNull()
        ->and(array_column($condition['possibleTreatment'], 'url'))->toHaveCount(count($catalogue[$slug]['treatments']));

    foreach ($catalogue[$slug]['treatments'] as $treatment) {
        expect(array_column($condition['possibleTreatment'], 'url'))
            ->toContain('https://'.config('clinic.domain').'/procedimentos/'.$treatment);
    }
})->with($concernSlugs);

it('lists every concern on the homepage, linked to its page', function () use ($catalogue) {
    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->toContain('id="queixas"');

    foreach ($catalogue as $slug => $page) {
        if (! isset($page['concern'])) {
            continue;
        }

        expect($html)->toContain(e($page['concern']['label']))
            ->and($html)->toContain("/procedimentos/{$slug}\"");
    }
});

it('never names a commercial product brand on a public page', function (string $path) {
    $html = mb_strtolower($this->get($path)->assertOk()->getContent());

    expect(preg_match('/sculptra|radiesse|ellans[eé]|restylane|juv[eé]derm|dysport|xeomin/u', $html))->toBe(0);
})->with($publicPaths);

it('does not assume every patient is a woman in procedure, FAQ and article copy', function () {
    $copy = json_encode([config('procedures'), config('faq'), config('articles')], JSON_UNESCAPED_UNICODE);

    expect(preg_match('/\bjuntas\b|\b(as|das|muitas) pacientes\b|\ba paciente\b/iu', $copy))->toBe(0);
});
