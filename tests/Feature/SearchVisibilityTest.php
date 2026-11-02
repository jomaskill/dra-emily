<?php

/**
 * Guards the 2026-11-02 search audit fixes: titles that fit the results page,
 * Pampulha in the homepage title, links from conversion pages to articles,
 * section shortcuts, directions to the clinic and a schema that names a person
 * rather than a physician.
 */
$publicPaths = fn (): array => array_merge(
    ['/', '/artigos'],
    array_map(fn (string $slug): string => "/procedimentos/{$slug}", array_keys(require __DIR__.'/../../config/procedures.php')),
    array_map(fn (string $slug): string => "/artigos/{$slug}", array_keys(require __DIR__.'/../../config/articles.php')),
);
$procedureSlugs = fn (): array => array_keys(require __DIR__.'/../../config/procedures.php');
$articleSlugs = fn (): array => array_keys(require __DIR__.'/../../config/articles.php');

it('keeps every title short enough for the results page', function (string $path) {
    preg_match('#<title>(.*?)</title>#s', $this->get($path)->assertOk()->getContent(), $title);

    expect(mb_strlen(html_entity_decode($title[1])))->toBeLessThanOrEqual(62);
})->with($publicPaths);

it('names the region in the homepage title and in the articles heading', function () {
    preg_match('#<title>(.*?)</title>#s', $this->get('/')->getContent(), $title);
    preg_match('#<h1[^>]*>(.*?)</h1>#s', $this->get('/artigos')->getContent(), $heading);

    expect($title[1])->toContain('Pampulha')
        ->and(strip_tags($heading[1]))->toContain('Harmonização facial');
});

it('links every procedure page to articles that exist', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    preg_match('#<section id="leituras".*?</section>#s', $html, $section);
    preg_match_all('#/artigos/([a-z0-9-]+)"#', $section[0], $links);

    expect($links[1])->not->toBeEmpty()->and(count($links[1]))->toBeLessThanOrEqual(3);

    foreach ($links[1] as $article) {
        expect(config('articles'))->toHaveKey($article);
    }
})->with($procedureSlugs);

it('prefers the articles that cite the procedure', function () {
    $html = $this->get('/procedimentos/bigode-chines')->assertOk()->getContent();

    preg_match('#<section id="leituras".*?</section>#s', $html, $section);
    preg_match_all('#/artigos/([a-z0-9-]+)"#', $section[0], $links);

    foreach ($links[1] as $article) {
        expect(config("articles.{$article}.related"))->toContain('bigode-chines');
    }
});

it('links the newest articles from the homepage', function () {
    $html = $this->get('/')->assertOk()->getContent();
    $newest = collect(config('articles'))->sortByDesc('published')->keys()->take(3);

    preg_match('#<section id="leituras".*?</section>#s', $html, $section);

    foreach ($newest as $slug) {
        expect($section[0])->toContain("/artigos/{$slug}\"");
    }
});

it('points every procedure shortcut at a section on the page', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    preg_match('#<nav aria-label="Nesta página".*?</nav>#s', $html, $shortcuts);
    preg_match_all('#href="\#([a-z-]+)"#', $shortcuts[0], $anchors);

    expect($anchors[1])->not->toBeEmpty();

    foreach ($anchors[1] as $anchor) {
        expect($html)->toContain("id=\"{$anchor}\"");
    }
})->with($procedureSlugs);

it('gives every article heading an anchor listed in the summary', function (string $slug) {
    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

    preg_match('#<nav aria-label="Neste artigo".*?</nav>#s', $html, $summary);
    preg_match_all('#href="\#([a-z0-9-]+)"#', $summary[0], $anchors);

    expect($anchors[1])->toHaveCount(count(config("articles.{$slug}.sections")));

    foreach ($anchors[1] as $anchor) {
        expect($html)->toContain("<h2 id=\"{$anchor}\">");
    }
})->with($articleSlugs);

it('leaves only the first frequently asked question open', function () {
    $html = $this->get('/procedimentos/toxina-botulinica')->assertOk()->getContent();

    preg_match('#<section id="faq".*?</section>#s', $html, $faq);

    expect(preg_match_all('#<details[^>]*\bopen\b#', $faq[0]))->toBe(1);
});

it('offers directions to the clinic on Google Maps and Waze', function () {
    $html = html_entity_decode($this->get('/')->assertOk()->getContent());
    $address = rawurlencode('R. Conselheiro Galvão, 64, Santa Rosa, Belo Horizonte, MG');

    expect($html)->toContain("https://www.google.com/maps/dir/?api=1&destination={$address}")
        ->and($html)->toContain("https://waze.com/ul?q={$address}&navigate=yes");
});

it('describes the professional as a person and keeps only real profiles in sameAs', function (string $path) {
    $html = $this->get($path)->assertOk()->getContent();

    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $schema);
    $clinic = collect(json_decode($schema[1], true))->firstWhere('@type', 'Dentist');

    expect($html)->not->toContain('"@type": "Physician"')
        ->and($html)->not->toContain('"@type":"Physician"');

    if ($clinic !== null) {
        expect(implode(' ', $clinic['sameAs']))->not->toContain('wa.me');
    }
})->with(['/', '/procedimentos/toxina-botulinica', '/artigos/rosto-de-ozempic']);

it('never cites a source with the word that blocks Google Ads', function () {
    expect(mb_strtolower(json_encode(array_column(config('articles'), 'sources'))))->not->toContain('botox');
});
