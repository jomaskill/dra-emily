<?php

namespace App\Http\Controllers;

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
            'moreArticles' => $articles->except($slug)->take(3),
        ]);
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
            ->merge(collect($article['sections'])->flatMap(fn (array $section): array => [$section['heading'], ...$section['body']]))
            ->merge($article['takeaways'] ?? [])
            ->merge(collect($article['faq'])->flatMap(fn (array $item): array => [$item['q'], $item['a']]))
            ->implode(' ');

        $words = count(preg_split('/\s+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY));

        return max(1, (int) ceil($words / self::WORDS_PER_MINUTE));
    }
}
