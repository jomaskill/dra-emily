<?php

/**
 * Guards the 2026-11-02 filler segmentation: six pages grouped by objective
 * under Preenchimento Facial, each naming the regions it treats, so the region
 * terms people search for have a page and the family links to itself.
 */
$catalogue = require __DIR__.'/../../config/procedures.php';

$segments = [
    'preenchimento-terco-medio' => ['Malar (maçãs do rosto)', 'Zigomático', 'Fossa canina', 'Olheiras', 'Têmporas'],
    'preenchimento-mandibula-e-queixo' => ['Mandíbula', 'Ângulo mandibular', 'Mento (queixo)', 'Região pré-jowl'],
    'preenchimento-terco-inferior' => ['Sulco nasogeniano (bigode chinês)', 'Linhas de marionete', 'Região pré-jowl', 'Mento', 'Contorno mandibular'],
    'harmonizacao-labial' => ['Preenchimento labial', 'Código de barras', 'Filtro labial', 'Projeção e definição do arco do cupido', 'Comissuras labiais'],
    'rejuvenescimento-com-preenchimento' => ['Têmporas', 'Malar', 'Zigomático', 'Olheiras', 'Fossa canina'],
    'rinomodelacao-e-refinamento-facial' => ['Rinomodelação', 'Mento', 'Ângulo mandibular', 'Ajustes de assimetrias e depressões faciais'],
];

it('lists the regions of each segment as headings on its page', function (string $slug) use ($segments) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    foreach ($segments[$slug] as $region) {
        expect($html)->toContain('text-ink">'.e($region).'</h3>');
    }
})->with(array_keys($segments));

it('keeps the six segments under Preenchimento Facial', function () use ($catalogue, $segments) {
    $children = array_keys(array_filter($catalogue, fn (array $page): bool => isset($page['parent'])));

    expect($children)->toEqualCanonicalizing(array_keys($segments));

    foreach ($children as $slug) {
        expect($catalogue[$slug]['parent'])->toBe('preenchimento-facial');
    }
});

it('links the parent page to every segment', function () use ($segments) {
    $html = $this->get('/procedimentos/preenchimento-facial')->assertOk()->getContent();

    expect($html)->toContain('id="regioes"');

    foreach (array_keys($segments) as $slug) {
        expect($html)->toContain("/procedimentos/{$slug}\"");
    }
});

it('puts the parent in the breadcrumb and its markup', function (string $slug) use ($catalogue) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
    $breadcrumb = collect(json_decode($m[1], true))->firstWhere('@type', 'BreadcrumbList');
    $items = $breadcrumb['itemListElement'];

    expect(array_column($items, 'position'))->toBe([1, 2, 3, 4])
        ->and($items[2]['item'])->toEndWith('/procedimentos/preenchimento-facial')
        ->and($items[3]['name'])->toBe($catalogue[$slug]['name'])
        ->and(preg_match('#aria-label="Breadcrumb".*?/procedimentos/preenchimento-facial"#s', $html))->toBe(1);
})->with(array_keys($segments));

it('declares the treated regions as the body location', function (string $slug) use ($segments) {
    $html = $this->get("/procedimentos/{$slug}")->assertOk()->getContent();

    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
    $procedure = collect(json_decode($m[1], true))->firstWhere('@type', 'MedicalProcedure');

    expect($procedure['bodyLocation'])->toBe(implode(', ', $segments[$slug]));
})->with(array_keys($segments));

it('gives each segment its own title, heading and description', function () use ($catalogue, $segments) {
    $pages = array_intersect_key($catalogue, $segments);

    foreach (['title', 'h1', 'meta_description', 'hero_lead'] as $field) {
        expect(array_unique(array_column($pages, $field)))->toHaveCount(count($segments));
    }
});

it('does not repeat copy between the two pages that share the same regions', function () use ($catalogue) {
    $support = $catalogue['preenchimento-terco-medio'];
    $volume = $catalogue['rejuvenescimento-com-preenchimento'];

    expect(array_intersect(array_column($support['regions'], 'desc'), array_column($volume['regions'], 'desc')))->toBeEmpty()
        ->and(array_intersect($support['what_is'], $volume['what_is']))->toBeEmpty()
        ->and(array_intersect(array_column($support['faq'], 'q'), array_column($volume['faq'], 'q')))->toBeEmpty();
});

it('gives each curated page up to four related pages that exist', function (string $slug) use ($catalogue) {
    $related = $catalogue[$slug]['related'];

    expect(count($related))->toBeLessThanOrEqual(4)
        ->and($related)->not->toContain($slug);

    foreach ($related as $target) {
        expect($catalogue)->toHaveKey($target);
    }
})->with(array_keys(array_filter($catalogue, fn (array $page): bool => isset($page['related']))));

it('groups the segments in their own block on the homepage', function () use ($segments) {
    $html = $this->get('/')->assertOk()->getContent();

    $block = substr($html, strpos($html, 'Preenchimento por objetivo'));

    foreach (array_keys($segments) as $slug) {
        expect($block)->toContain("/procedimentos/{$slug}\"");
    }
});
