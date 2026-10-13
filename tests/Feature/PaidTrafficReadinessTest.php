<?php

use App\Support\WhatsApp;

/**
 * Guards the quick fixes from the 2026-10-13 audit done when Google Ads
 * traffic started: the homepage states its search term in the title and H1,
 * no page carries a meta description that Google truncates, analytics loads
 * once, and WhatsApp buttons can tell the team a conversation came from an ad.
 */
$pages = array_merge(
    ['/', '/artigos'],
    array_map(fn (string $slug): string => "/procedimentos/{$slug}", array_keys(require __DIR__.'/../../config/procedures.php')),
    array_map(fn (string $slug): string => "/artigos/{$slug}", array_keys(require __DIR__.'/../../config/articles.php')),
);

it('puts the main search term in the homepage title and H1', function () {
    $html = $this->get('/')->assertOk()->getContent();

    preg_match('#<title>(.*?)</title>#s', $html, $title);
    preg_match_all('#<h1[^>]*>(.*?)</h1>#s', $html, $headings);

    expect(mb_strlen(html_entity_decode($title[1])))->toBeLessThanOrEqual(60)
        ->and($title[1])->toContain('Harmonização Facial em BH')
        ->and($headings[1])->toHaveCount(1)
        ->and(strip_tags($headings[1][0]))->toContain('harmonização facial em Belo Horizonte');
});

it('keeps every meta description inside the truncation limit', function (string $path) {
    $html = $this->get($path)->assertOk()->getContent();

    preg_match('/<meta name="description" content="([^"]*)"/', $html, $m);

    expect(mb_strlen(html_entity_decode($m[1])))->toBeLessThanOrEqual(160);
})->with($pages);

it('loads gtag.js once and configures each analytics property once', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect(substr_count($html, 'googletagmanager.com/gtag/js'))->toBe(1)
        ->and(substr_count($html, "gtag('config', '".config('clinic.ga4_id')."')"))->toBe(1)
        ->and(substr_count($html, "gtag('config', '".config('clinic.ga4_secondary_id')."')"))->toBe(1);
});

it('skips the secondary analytics property when it is not configured', function () {
    config(['clinic.ga4_secondary_id' => '']);

    $html = $this->get('/')->assertOk()->getContent();

    expect(substr_count($html, "gtag('config'"))->toBe(1);
});

it('ships the script that tags WhatsApp messages from Google Ads visits', function (string $path) {
    $html = $this->get($path)->assertOk()->getContent();

    expect($html)->toContain("['gclid', 'gbraid', 'wbraid']")
        ->and($html)->toContain(WhatsApp::GOOGLE_ADS_MARKER);
})->with(['/', '/procedimentos/toxina-botulinica', '/artigos/como-se-preparar']);
