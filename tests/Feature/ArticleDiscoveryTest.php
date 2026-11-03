<?php

use App\Support\ArticleText;

/**
 * Guards the 2026-11-02 blog audit fixes: articles a search engine can read as
 * blog posts, an author page behind every byline, topic pages, and internal
 * links that reach the older articles too.
 */
$articleSlugs = fn (): array => array_keys(require __DIR__.'/../../config/articles.php');
$topicSlugs = fn (): array => array_keys(require __DIR__.'/../../config/topics.php');

/**
 * @return array<int, mixed>
 */
function discoveryNodes(string $html): array
{
    preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $schema);

    $nodes = json_decode($schema[1], true);

    expect(json_last_error())->toBe(JSON_ERROR_NONE, 'JSON-LD must parse');

    return array_is_list($nodes) ? $nodes : [$nodes];
}

/**
 * @return list<string>
 */
function bareReferences(mixed $node): array
{
    if (! is_array($node)) {
        return [];
    }

    $own = isset($node['@id']) && count($node) === 1 ? [$node['@id']] : [];

    return array_merge($own, ...array_map(bareReferences(...), array_values($node)));
}

it('marks up every article as a blog post with an author page and an image', function (string $slug) {
    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();
    $post = collect(discoveryNodes($html))->firstWhere('@type', 'BlogPosting');
    $canonical = 'https://'.config('clinic.domain')."/artigos/{$slug}";

    expect($post)->not->toBeNull()
        ->and($post['headline'])->toBe(config("articles.{$slug}.h1"))
        ->and(mb_strlen($post['headline']))->toBeLessThanOrEqual(110)
        ->and($post['mainEntityOfPage']['@id'])->toBe($canonical.'#webpage')
        ->and($post['author']['url'])->toEndWith('/dra-emily-beatriz')
        ->and($post['image'])->toStartWith('https://')
        ->and($post['datePublished'])->toBe(config("articles.{$slug}.published"))
        ->and($post['dateModified'])->toBe(config("articles.{$slug}.updated"))
        ->and($post['publisher']['name'])->not->toBeEmpty()
        ->and($post['keywords'])->not->toBeEmpty();
})->with($articleSlugs);

it('describes what an article is about instead of pointing at the clinic', function () {
    $html = $this->get('/artigos/rosto-de-ozempic')->assertOk()->getContent();
    $page = collect(discoveryNodes($html))->firstWhere('@type', 'MedicalWebPage');

    expect(array_column($page['about'], '@type'))->each->toBe('MedicalProcedure')
        ->and(array_column($page['about'], 'name'))->toContain(config('procedures.bioestimulador-de-colageno.name'));
});

it('leaves no reference to a clinic or website node missing from the page', function (string $path) {
    $references = bareReferences(discoveryNodes($this->get($path)->assertOk()->getContent()));

    foreach ($references as $id) {
        expect($id)->not->toEndWith('/#clinic')->not->toEndWith('/#website');
    }
})->with(['/artigos', '/artigos/tema/antes-de-agendar', '/artigos/como-se-preparar', '/dra-emily-beatriz']);

it('declares the publication dates to link previews', function () {
    $html = $this->get('/artigos/como-se-preparar')->assertOk()->getContent();

    expect($html)->toContain('<meta property="article:published_time" content="'.config('articles.como-se-preparar.published').'">')
        ->and($html)->toContain('<meta property="article:author" content="https://'.config('clinic.domain').'/dra-emily-beatriz">')
        ->and($html)->toContain('<meta property="article:tag" content="Antes de agendar">');
});

it('uses the photo of an article once it has one', function () {
    config()->set('articles.como-se-preparar.image', 'foto-emily.jpg');
    config()->set('articles.como-se-preparar.image_alt', 'Dra. Emily Beatriz orienta uma paciente');

    $html = $this->get('/artigos/como-se-preparar')->assertOk()->getContent();
    $siteUrl = 'https://'.config('clinic.domain');

    expect($html)->toContain('<figure')
        ->and($html)->toContain('alt="Dra. Emily Beatriz orienta uma paciente"')
        ->and($html)->toContain('<meta property="og:image" content="'.$siteUrl.'/foto-emily.jpg">');
});

it('keeps the typographic cover while an article has no photo', function () {
    $html = $this->get('/artigos/como-se-preparar')->assertOk()->getContent();

    expect($html)->not->toContain('<figure')
        ->and($html)->toContain('<meta property="og:image" content="https://'.config('clinic.domain').'/og-image.jpg">');
});

it('files every article under topics that exist', function (string $slug) {
    expect(config("articles.{$slug}.topics"))->not->toBeEmpty();

    foreach (config("articles.{$slug}.topics") as $topic) {
        expect(config('topics'))->toHaveKey($topic);
    }
})->with($articleSlugs);

it('links every article to its topic pages', function (string $slug) {
    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

    foreach (config("articles.{$slug}.topics") as $topic) {
        expect($html)->toContain('/artigos/tema/'.$topic.'"');
    }
})->with($articleSlugs);

it('never publishes a topic thin enough to have one article', function (string $topic) {
    $articles = collect(config('articles'))->filter(fn (array $article): bool => in_array($topic, $article['topics'], true));

    expect($articles->count())->toBeGreaterThanOrEqual(2);
})->with($topicSlugs);

it('lists only the articles of a topic, under its own title', function (string $topic) {
    $html = $this->get("/artigos/tema/{$topic}")->assertOk()->getContent();
    $canonical = 'https://'.config('clinic.domain')."/artigos/tema/{$topic}";

    preg_match('#<main.*</main>#s', $html, $main);

    foreach (config('articles') as $slug => $article) {
        $belongs = in_array($topic, $article['topics'], true);

        expect(str_contains($main[0], "/artigos/{$slug}\""))->toBe($belongs, "{$slug} in {$topic}");
    }

    expect($html)->toContain('<link rel="canonical" href="'.$canonical.'">')
        ->and($html)->toContain('<title>'.e(config("topics.{$topic}.title")).'</title>')
        ->and(mb_strlen(config("topics.{$topic}.title")))->toBeLessThanOrEqual(62)
        ->and(mb_strlen(config("topics.{$topic}.description")))->toBeLessThanOrEqual(160);
})->with($topicSlugs);

it('reaches every topic from the article index and the sitemap', function (string $topic) {
    expect($this->get('/artigos')->assertOk()->getContent())->toContain("/artigos/tema/{$topic}\"")
        ->and($this->get('/sitemap.xml')->assertOk()->getContent())->toContain("/artigos/tema/{$topic}</loc>");
})->with($topicSlugs);

it('returns 404 for a topic that does not exist', function () {
    $this->get('/artigos/tema/nao-existe')->assertNotFound();
});

it('sends a link from another article to every article, older ones included', function () use ($articleSlugs) {
    $inbound = array_fill_keys($articleSlugs(), 0);

    foreach ($articleSlugs() as $slug) {
        $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

        preg_match('#<section class="bg-sand/45" aria-labelledby="continue-lendo">.*?</section>#s', $html, $section);
        preg_match_all('#/artigos/([a-z0-9-]+)"#', $section[0], $links);

        expect(array_unique($links[1]))->toHaveCount(3)->not->toContain($slug);

        foreach (array_unique($links[1]) as $target) {
            if ($target !== 'artigos') {
                $inbound[$target]++;
            }
        }
    }

    expect(min($inbound))->toBeGreaterThan(0);
});

it('prefers articles on the same subject over the newest ones', function () {
    $html = $this->get('/artigos/quanto-custa-harmonizacao-facial')->assertOk()->getContent();

    preg_match('#aria-labelledby="continue-lendo">.*?</section>#s', $html, $section);

    foreach (['tempo-de-recuperacao', 'quem-nao-pode-fazer', 'como-se-preparar'] as $sibling) {
        expect($section[0])->toContain("/artigos/{$sibling}\"");
    }
});

it('links the body of every article to the rest of the site', function (string $slug) {
    $html = $this->get("/artigos/{$slug}")->assertOk()->getContent();

    preg_match('#<div class="article-prose">.*?</div>#s', $html, $body);
    preg_match_all('#<a href="[^"]*/(?:procedimentos|artigos)/[a-z0-9-]+">#', $body[0], $links);

    expect(count($links[0]))->toBeGreaterThanOrEqual(2)
        ->and($body[0])->not->toContain('](procedure:')
        ->and($body[0])->not->toContain('](article:');
})->with($articleSlugs);

it('never lets the link syntax reach text outside the article body', function (string $slug) {
    $article = config("articles.{$slug}");

    expect(json_encode([$article['answer'], $article['faq'], $article['takeaways'] ?? [], $article['excerpt']]))
        ->not->toContain('](procedure:')
        ->not->toContain('](article:');
})->with($articleSlugs);

it('escapes article text while it builds internal links', function () {
    $html = (string) ArticleText::render('Um <b>teste</b> com [toxina](procedure:toxina-botulinica).');

    expect($html)->toContain('&lt;b&gt;teste&lt;/b&gt;')
        ->and($html)->toContain('<a href="'.route('procedure', 'toxina-botulinica').'">toxina</a>');
});

it('fails loudly on an internal link to a page that does not exist', function () {
    ArticleText::render('[quebrado](procedure:nao-existe)');
})->throws(InvalidArgumentException::class);

it('reads the link text and not its target when counting words', function () {
    expect(ArticleText::plain('Veja a [toxina botulínica](procedure:toxina-botulinica) hoje.'))
        ->toBe('Veja a toxina botulínica hoje.');
});

it('presents the author with her registration and every article', function () use ($articleSlugs) {
    $html = $this->get('/dra-emily-beatriz')->assertOk()->getContent();
    $profile = collect(discoveryNodes($html))->firstWhere('@type', 'ProfilePage');

    expect($profile['mainEntity']['@type'])->toBe('Person')
        ->and($profile['mainEntity']['identifier'])->toContain(config('clinic.cro'))
        ->and($profile['mainEntity']['sameAs'][0])->toContain(config('clinic.instagram'))
        ->and($html)->toContain('CRO-'.config('clinic.cro'));

    preg_match('#<h1[^>]*>(.*?)</h1>#s', $html, $heading);

    expect($heading[1])->toBe('Dra. Emily Beatriz');

    foreach ($articleSlugs() as $slug) {
        expect($html)->toContain("/artigos/{$slug}\"");
    }
});

it('reaches the author page from every kind of page', function (string $path) {
    expect($this->get($path)->assertOk()->getContent())->toContain('/dra-emily-beatriz"');
})->with(['/', '/artigos', '/artigos/como-se-preparar', '/procedimentos/toxina-botulinica']);

it('links the byline of an article, and only there, to the author page', function () {
    $article = $this->get('/artigos/como-se-preparar')->assertOk()->getContent();
    $index = $this->get('/artigos')->assertOk()->getContent();

    preg_match('#<header class="max-w-\[42rem\].*?</header>#s', $article, $header);
    preg_match('#<a href="[^"]*/artigos/[^"]+"\s+class="group grid.*?</a>#s', $index, $card);

    expect($header[0])->toContain('rel="author"')
        ->and($card[0])->not->toContain('rel="author"');
});

it('keeps the word that blocks Google Ads off the new pages', function (string $path) {
    expect(mb_strtolower($this->get($path)->assertOk()->getContent()))->not->toContain('botox');
})->with(['/dra-emily-beatriz', '/artigos/tema/toxina-botulinica']);
