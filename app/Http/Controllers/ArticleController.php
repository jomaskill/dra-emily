<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * List every published article, newest first.
     */
    public function index(): View
    {
        return view('articles.index', [
            'articles' => collect(config('articles'))
                ->sortByDesc('published'),
        ]);
    }

    /**
     * Display a single article.
     */
    public function show(string $slug): View
    {
        $article = config("articles.{$slug}");

        abort_if($article === null, 404);

        return view('articles.show', [
            'slug' => $slug,
            'article' => $article,
        ]);
    }
}
