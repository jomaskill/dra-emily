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

    expect($stamps[1])->not->toBeEmpty()
        ->and($stamps[1])->not->toContain(now()->addDay()->toDateString());

    foreach ($stamps[1] as $stamp) {
        expect($stamp)->toMatch('/^\d{4}-\d{2}-\d{2}$/');
    }

    expect($xml)->toContain(config('clinic.content_updated'));
});

it('ships no empty JavaScript bundle', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->not->toContain('app.js')
        ->and($html)->not->toMatch('#/build/assets/app-[^"]*\.js#');
});

it('points the brand wordmark at the homepage on every page', function () {
    foreach (['/', '/procedimentos/botox'] as $path) {
        $html = $this->get($path)->assertOk()->getContent();

        expect($html)->not->toContain('href="#"');
    }
});

it('keeps the homepage meta description inside the truncation limit', function () {
    $html = $this->get('/')->assertOk()->getContent();

    preg_match('/<meta name="description" content="([^"]*)"/', $html, $m);

    expect(mb_strlen($m[1]))->toBeLessThanOrEqual(160)->toBeGreaterThan(100);
});
