<?php

/**
 * Guards the responsive image work that came out of the phase-five measurement
 * baseline. The homepage hero was a 1400x2100 file rendered at 288x384: the
 * largest-contentful-paint element, downloaded at roughly six times the pixels
 * a phone needs.
 */
it('offers the hero at several widths with a sizes hint', function () {
    $html = $this->get('/')->assertOk()->getContent();

    preg_match('#<source type="image/webp"\s+srcset="([^"]+)"\s+sizes="([^"]+)"#', $html, $m);

    expect($m)->not->toBeEmpty('Hero should serve a width-based srcset');

    $candidates = explode(',', $m[1]);

    expect(count($candidates))->toBeGreaterThanOrEqual(3)
        ->and($m[1])->toContain('480w')
        ->and($m[1])->toContain('768w')
        ->and($m[2])->toContain('px');
});

it('ships every width variant the markup advertises', function () {
    foreach (['/', '/procedimentos/botox'] as $path) {
        $html = $this->get($path)->assertOk()->getContent();

        preg_match_all('#srcset="([^"]+)"#', $html, $sets);

        foreach ($sets[1] as $srcset) {
            foreach (explode(',', $srcset) as $candidate) {
                $file = parse_url(trim(explode(' ', trim($candidate))[0]), PHP_URL_PATH);

                expect(file_exists(public_path($file)))
                    ->toBeTrue("Advertised but missing: {$file}");
            }
        }
    }
});

it('keeps the largest candidate well under the original weight', function () {
    $original = filesize(public_path('foto-emily.webp'));
    $mobile = filesize(public_path('foto-emily-768w.webp'));

    expect($mobile)->toBeLessThan($original * 0.4);
});
