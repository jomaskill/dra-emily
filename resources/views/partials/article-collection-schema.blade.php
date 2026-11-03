{{--
    Listas de artigos (índice e temas). Recebe $canonical, $name e $articles.
    Com $breadcrumb (nome do item atual), acrescenta o caminho até a página.
--}}
@php
    $siteUrl = 'https://'.config('clinic.domain');
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => $canonical.'#webpage',
            'url' => $canonical,
            'name' => $name,
            'inLanguage' => 'pt-BR',
            'isPartOf' => \App\Support\SiteSchema::website(),
            'about' => \App\Support\SiteSchema::clinic(),
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => $articles->keys()->values()->map(fn (string $articleSlug, int $position): array => [
                    '@type' => 'ListItem',
                    'position' => $position + 1,
                    'url' => $siteUrl.'/artigos/'.$articleSlug,
                    'name' => $articles[$articleSlug]['h1'],
                ])->all(),
            ],
        ],
    ];

    if (isset($breadcrumb)) {
        $schema[] = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Início', 'item' => $siteUrl.'/'],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Artigos', 'item' => $siteUrl.'/artigos'],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $breadcrumb, 'item' => $canonical],
            ],
        ];
    }
@endphp
<script type="application/ld+json">
{!! \App\Support\SiteSchema::json($schema) !!}
</script>
