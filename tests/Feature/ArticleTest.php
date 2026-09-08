<?php

/**
 * Guards the phase-four content layer from the 2026-09-07 SEO/GEO/AEO audit:
 * articles that carry an attributed author and real dates, a direct answer
 * positioned for extraction, and an index that stays in step with the config.
 */
$articles = require __DIR__.'/../../config/articles.php';
$articleSlugs = array_keys($articles);

/**
 * @return array<int, mixed>
 */
function articleNodes(string $html): array
{
    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);

    $decoded = json_decode($m[1], true);

    expect(json_last_error())->toBe(JSON_ERROR_NONE, 'Article JSON-LD must parse');

    return $decoded;
}

it('attributes every article to a named author with credentials and dates', function (string $slug) {
    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

    $page = collect(articleNodes($html))->firstWhere('@type', 'MedicalWebPage');

    expect($page)->not->toBeNull()
        ->and($page['author']['name'])->toBe('Dra. Emily Beatriz')
        ->and($page['author']['identifier'])->toContain(config('clinic.cro'))
        ->and($page['datePublished'])->toBe(config("articles.{$slug}.published"))
        ->and($page['dateModified'])->toBe(config("articles.{$slug}.updated"));
})->with($articleSlugs);

it('shows the author and publication date to readers, not only to crawlers', function (string $slug) {
    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

    expect($html)->toContain('Dra. Emily Beatriz')
        ->and($html)->toContain('datetime="'.config("articles.{$slug}.published").'"');
})->with($articleSlugs);

it('opens each article with a direct answer of snippet length', function (string $slug) use ($articles) {
    $answer = $articles[$slug]['answer'];
    $words = str_word_count(strip_tags($answer), 0, 'áàâãéêíóôõúçÁÀÂÃÉÊÍÓÔÕÚÇ');

    expect($words)->toBeGreaterThanOrEqual(35)->toBeLessThanOrEqual(75);

    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

    expect($html)->toContain($answer)
        ->and($html)->toContain('id="resposta"');
})->with($articleSlugs);

it('points article speakable selectors at anchors that exist', function (string $slug) {
    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

    $page = collect(articleNodes($html))->firstWhere('@type', 'MedicalWebPage');

    foreach ($page['speakable']['cssSelector'] as $selector) {
        expect($html)->toContain('id="'.ltrim($selector, '#').'"');
    }
})->with($articleSlugs);

it('marks up the article questions as a FAQ page', function (string $slug) {
    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

    $faq = collect(articleNodes($html))->firstWhere('@type', 'FAQPage');
    $questions = array_column($faq['mainEntity'], 'name');

    expect($questions)->toBe(array_column(config("articles.{$slug}.faq"), 'q'));
})->with($articleSlugs);

it('links each article to procedures that exist', function (string $slug) use ($articles) {
    $catalogue = array_keys(config('procedures'));

    foreach ($articles[$slug]['related'] ?? [] as $procedure) {
        expect($catalogue)->toContain($procedure);
    }
})->with($articleSlugs);

it('lists every article on the index and in the sitemap', function () use ($articleSlugs) {
    $index = $this->get('/artigos')->assertOk()->getContent();
    $sitemap = $this->get('/sitemap.xml')->assertOk()->getContent();

    foreach ($articleSlugs as $slug) {
        expect($index)->toContain("/artigos/{$slug}")
            ->and($sitemap)->toContain("/artigos/{$slug}</loc>");
    }

    expect($sitemap)->toContain('/artigos</loc>');
});

it('reaches the article index from every page', function () {
    foreach (['/', '/procedimentos/botox', '/artigos/como-se-preparar'] as $path) {
        expect($this->get($path)->getContent())->toContain('/artigos"');
    }
});

it('returns 404 for an article slug that does not exist', function () {
    $this->get('/artigos/nao-existe')->assertNotFound();
});
