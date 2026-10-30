<?php

/**
 * Guards the phase-one fixes from the 2026-09-07 SEO/GEO/AEO audit:
 * per-procedure share images, honest sitemap dates, and the absence of the
 * empty JavaScript bundle that was preloaded on every page.
 */

use Illuminate\Support\Facades\File;

// Datasets are resolved before the application boots, so read the config file
// directly rather than through the container.
dataset('procedures', array_keys(require __DIR__.'/../../config/procedures.php'));

it('gives every procedure its own share image at the declared size', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    preg_match('/property="og:image" content="([^"]*)"/', $html, $image);
    preg_match('/property="og:image:width" content="([^"]*)"/', $html, $width);
    preg_match('/property="og:image:height" content="([^"]*)"/', $html, $height);

    expect($image[1])->toEndWith("procedures/{$slug}-og.jpg");

    $file = public_path("procedures/{$slug}-og.jpg");
    expect(File::exists($file))->toBeTrue("Missing share image for {$slug}");

    [$actualWidth, $actualHeight] = getimagesize($file);

    expect((int) $width[1])->toBe($actualWidth)
        ->and((int) $height[1])->toBe($actualHeight);
})->with('procedures');

it('declares a content date for every procedure', function (string $slug) {
    expect(config("procedures.{$slug}.updated"))
        ->toMatch('/^\d{4}-\d{2}-\d{2}$/');
})->with('procedures');

it('publishes sitemap dates from content, not from the clock', function () {
    $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

    preg_match_all('#<lastmod>([^<]+)</lastmod>#', $xml, $stamps);

    // Every date must come from the content itself. An article may be dated
    // ahead of its release, so a future date is fine when the content says so.
    $contentDates = array_merge(
        [config('clinic.content_updated')],
        array_column(config('procedures'), 'updated'),
        array_column(config('articles'), 'updated'),
    );

    expect($stamps[1])->not->toBeEmpty();

    foreach ($stamps[1] as $stamp) {
        expect($stamp)->toMatch('/^\d{4}-\d{2}-\d{2}$/')
            ->and($contentDates)->toContain($stamp);
    }

    expect($xml)->toContain(config('clinic.content_updated'));
});

it('ships no empty JavaScript bundle', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->not->toContain('app.js')
        ->and($html)->not->toMatch('#/build/assets/app-[^"]*\.js#');
});

it('points the brand wordmark at the homepage on every page', function () {
    foreach (['/', '/procedimentos/toxina-botulinica'] as $path) {
        $html = $this->get($path)->assertOk()->getContent();

        expect($html)->not->toContain('href="#"');
    }
});

it('keeps the homepage meta description inside the truncation limit', function () {
    $html = $this->get('/')->assertOk()->getContent();

    preg_match('/<meta name="description" content="([^"]*)"/', $html, $m);

    expect(mb_strlen($m[1]))->toBeLessThanOrEqual(160)->toBeGreaterThan(100);
});

it('redirects the retired botox URL to the toxina botulínica page', function () {
    $this->get('/procedimentos/botox')
        ->assertStatus(301)
        ->assertRedirect('/procedimentos/toxina-botulinica');
});

it('redirects the retired bichectomia URL to the harmonização facial page', function () {
    $this->get('/procedimentos/bichectomia')
        ->assertStatus(301)
        ->assertRedirect('/procedimentos/harmonizacao-facial');
});

it('never mentions bichectomia on a public page', function (string $path) {
    $html = withoutCitedSources($this->get($path)->assertOk()->getContent());

    expect(mb_strtolower($html))->not->toContain('bichectomia');
})->with(fn () => array_merge(
    ['/', '/artigos', '/sitemap.xml'],
    array_map(fn ($slug) => "/procedimentos/{$slug}", array_keys(require __DIR__.'/../../config/procedures.php')),
    array_map(fn ($slug) => "/artigos/{$slug}", array_keys(require __DIR__.'/../../config/articles.php')),
));

it('never mentions botox on a public page', function (string $path) {
    $html = withoutCitedSources($this->get($path)->assertOk()->getContent());

    expect(mb_strtolower($html))->not->toContain('botox');
})->with(fn () => array_merge(
    ['/', '/artigos', '/sitemap.xml'],
    array_map(fn ($slug) => "/procedimentos/{$slug}", array_keys(require __DIR__.'/../../config/procedures.php')),
    array_map(fn ($slug) => "/artigos/{$slug}", array_keys(require __DIR__.'/../../config/articles.php')),
));
