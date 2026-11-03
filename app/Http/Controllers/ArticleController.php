<?php

namespace App\Http\Controllers;

use App\Support\ArticleText;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Average silent reading speed in Portuguese, in words per minute.
     */
    private const WORDS_PER_MINUTE = 200;

    /**
     * Cover tones cycled across the articles, in publication order.
     *
     * @var list<string>
     */
    private const COVER_TONES = ['clay', 'ink', 'sand', 'clay-deep', 'ochre'];

    /**
     * List every published article, newest first.
     */
    public function index(): View
    {
        return view('articles.index', [
            'articles' => $this->articles(),
        ]);
    }

    /**
     * Display a single article.
     */
    public function show(string $slug): View
    {
        $articles = $this->articles();

        abort_unless($articles->has($slug), 404);

        return view('articles.show', [
            'slug' => $slug,
            'article' => $articles->get($slug),
            'moreArticles' => $this->relatedTo($slug, $articles),
        ]);
    }

    /**
     * List the articles of a topic, newest first.
     */
    public function topic(string $slug): View
    {
        return view('articles.topic', [
            'slug' => $slug,
            'topic' => config("topics.{$slug}"),
            'articles' => $this->articles()->filter(
                fn (array $article): bool => in_array($slug, $article['topics'], true)
            ),
        ]);
    }

    /**
     * Display the author's page with everything she has published.
     */
    public function author(): View
    {
        return view('author', [
            'articles' => $this->articles(),
        ]);
    }

    /**
     * The three articles closest to the given one: a shared topic weighs more
     * than a shared procedure, and ties go to the newest. Ranking by subject
     * also sends links to older articles, which a newest-first list never does.
     *
     * @param  Collection<string, array<string, mixed>>  $articles
     * @return Collection<string, array<string, mixed>>
     */
    private function relatedTo(string $slug, Collection $articles): Collection
    {
        $article = $articles->get($slug);

        return $articles->except($slug)
            ->sortByDesc(fn (array $other): int => 3 * count(array_intersect($article['topics'], $other['topics']))
                + count(array_intersect($article['related'], $other['related'])))
            ->take(3);
    }

    /**
     * Every article keyed by slug, newest first, with its number, cover tone
     * and reading time resolved. Articles published on the same day keep
     * their order in the config.
     *
     * @return Collection<string, array<string, mixed>>
     */
    private function articles(): Collection
    {
        $articles = collect(config('articles'));

        $tones = $articles->keys()
            ->sortBy(fn (string $slug): string => $articles[$slug]['published'])
            ->values()
            ->mapWithKeys(fn (string $slug, int $position): array => [
                $slug => [
                    'number' => str_pad((string) ($position + 1), 2, '0', STR_PAD_LEFT),
                    'tone' => self::COVER_TONES[$position % count(self::COVER_TONES)],
                ],
            ]);

        return $articles
            ->map(fn (array $article, string $slug): array => $article + $tones[$slug] + [
                'reading_minutes' => $this->readingMinutes($article),
            ])
            ->sortByDesc('number');
    }

    /**
     * Estimate how many minutes the article takes to read.
     *
     * @param  array<string, mixed>  $article
     */
    private function readingMinutes(array $article): int
    {
        $text = collect([$article['answer']])
            ->merge(collect($article['sections'])->flatMap(fn (array $section): array => [
                $section['heading'],
                ...array_map(ArticleText::plain(...), $section['body']),
            ]))
            ->merge($article['takeaways'] ?? [])
            ->merge(collect($article['faq'])->flatMap(fn (array $item): array => [$item['q'], $item['a']]))
            ->implode(' ');

        $words = count(preg_split('/\s+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY));

        return max(1, (int) ceil($words / self::WORDS_PER_MINUTE));
    }
}
