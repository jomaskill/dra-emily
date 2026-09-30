<?php

/**
 * Guards the before-and-after gallery: enough cases on the homepage to act as
 * visual proof, placeholders until real photos land in public/, and each
 * procedure page showing only its own cases.
 */
it('shows at least five before-and-after cases on the homepage', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect(substr_count($html, 'data-result-card='))->toBeGreaterThanOrEqual(5);
});

it('renders a placeholder while the photo is missing', function () {
    config(['results' => [[
        'id' => 'missing-photo',
        'procedure' => 'botox',
        'title' => 'Caso de teste',
        'type' => 'combined',
        'image' => 'resultados/nao-existe.jpg',
        'alt' => 'caso de teste',
        'featured' => true,
    ]]]);

    $this->get('/')
        ->assertOk()
        ->assertSee('data-placeholder="resultados/nao-existe.jpg"', false)
        ->assertDontSee('resultados/nao-existe.webp', false);
});

it('renders the real photo once the file exists', function () {
    config(['results' => [[
        'id' => 'existing-photo',
        'procedure' => 'botox',
        'title' => 'Caso de teste',
        'type' => 'split',
        'before' => 'antes-1.jpg',
        'after' => 'depois-1.jpg',
        'alt' => 'caso de teste',
        'featured' => true,
    ]]]);

    $this->get('/')
        ->assertOk()
        ->assertSee('antes-1-480w.webp', false)
        ->assertSee('depois-1-480w.webp', false)
        ->assertDontSee('data-placeholder=', false);
});

it('shows only the cases of the current procedure', function () {
    $html = $this->get('/procedimentos/botox')->assertOk()->getContent();

    $expected = collect(config('results'))->where('procedure', 'botox')->pluck('id');
    preg_match_all('/data-result-card="([^"]+)"/', $html, $cards);

    expect($cards[1])->toEqualCanonicalizing($expected->all());
});

it('omits the results section when a procedure has no cases', function () {
    $slug = collect(config('procedures'))->keys()
        ->diff(collect(config('results'))->pluck('procedure'))
        ->first();

    expect($slug)->not->toBeNull();

    $this->get("/procedimentos/{$slug}")
        ->assertOk()
        ->assertDontSee('id="resultados"', false);
});

it('points every case at a known procedure', function () {
    foreach (config('results') as $case) {
        expect(config('procedures'))->toHaveKey($case['procedure']);
    }
});

it('places the gallery right after the hero on the homepage', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect(strpos($html, 'id="antes-depois"'))->toBeLessThan(strpos($html, 'id="sobre"'));
});

it('places the gallery right after the hero on procedure pages', function (string $slug) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    expect(strpos($html, 'id="resultados"'))->toBeLessThan(strpos($html, 'id="o-que-e"'));
})->with(['botox', 'full-face']);

it('signs every case with the professional name and registration', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect(substr_count($html, 'CRO '.config('clinic.cro')))
        ->toBeGreaterThanOrEqual(substr_count($html, 'data-result-card='));
});
