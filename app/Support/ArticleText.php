<?php

namespace App\Support;

use Illuminate\Support\HtmlString;
use InvalidArgumentException;

class ArticleText
{
    /**
     * Escape a paragraph of an article and turn its internal links into anchors.
     *
     * Links are written as [text](procedure:slug) or [text](article:slug). A slug
     * that does not exist fails at render time instead of publishing a dead link.
     */
    public static function render(string $paragraph): HtmlString
    {
        return new HtmlString(preg_replace_callback(
            '/\[([^\]]+)\]\((procedure|article):([a-z0-9-]+)\)/',
            fn (array $link): string => self::anchor($link[1], $link[2], $link[3]),
            e($paragraph),
        ));
    }

    /**
     * The paragraph as readers see it, without the link syntax.
     */
    public static function plain(string $paragraph): string
    {
        return preg_replace('/\[([^\]]+)\]\((?:procedure|article):[a-z0-9-]+\)/', '$1', $paragraph);
    }

    private static function anchor(string $text, string $route, string $slug): string
    {
        $catalogue = $route === 'procedure' ? 'procedures' : 'articles';

        if (! config()->has("{$catalogue}.{$slug}")) {
            throw new InvalidArgumentException("Article link points at a page that does not exist: {$route}:{$slug}");
        }

        return '<a href="'.route($route, $slug).'">'.$text.'</a>';
    }
}
