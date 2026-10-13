<?php

/**
 * Every WhatsApp button carries a prefilled message saying where the visitor
 * came from, so the team knows the procedure, result or article behind each
 * conversation.
 */
dataset('procedures', array_keys(require __DIR__.'/../../config/procedures.php'));
dataset('articles', array_keys(require __DIR__.'/../../config/articles.php'));

/**
 * @return list<string>
 */
function whatsAppMessages(string $html): array
{
    preg_match_all('/href="(https:\/\/wa\.me\/[^"]*)"/', $html, $matches);

    return array_map(function (string $href): string {
        parse_str((string) parse_url(html_entity_decode($href), PHP_URL_QUERY), $query);

        return (string) ($query['text'] ?? '');
    }, $matches[1]);
}

it('prefills a distinct message on every home page button', function () {
    $messages = whatsAppMessages($this->get('/')->assertOk()->getContent());

    expect($messages)->not->toBeEmpty()->not->toContain('')
        ->and(array_unique($messages))->toHaveCount(count($messages))
        ->and($messages)->toContain('Olá! Vim pela página inicial do site e gostaria de agendar uma consulta com a Dra. Emily.');
});

it('names the procedure in every button on its page', function (string $slug) {
    $name = config("procedures.{$slug}.name");
    $messages = whatsAppMessages($this->get("/procedimentos/{$slug}")->assertOk()->getContent());

    expect($messages)->not->toBeEmpty();

    foreach ($messages as $message) {
        expect($message)->toContain($name);
    }
})->with('procedures');

it('names the article in the nav, footer and closing buttons', function (string $slug) {
    $title = config("articles.{$slug}.h1");
    $messages = whatsAppMessages($this->get("/artigos/{$slug}")->assertOk()->getContent());

    expect($messages)->not->toBeEmpty();

    foreach ($messages as $message) {
        expect($message)->toContain($title);
    }
})->with('articles');

it('names the procedure and case on each before and after card', function () {
    $case = collect(config('results'))->firstWhere('featured', true);
    $name = config("procedures.{$case['procedure']}.name");

    expect(whatsAppMessages($this->get('/')->getContent()))
        ->toContain("Olá! Vi no site o resultado de {$name} (\"{$case['title']}\") e quero saber se consigo algo parecido.");
});
