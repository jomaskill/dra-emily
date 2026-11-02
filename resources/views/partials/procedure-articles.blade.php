@php
    // Artigos que citam este procedimento (chave "related"). Páginas-filhas herdam
    // os da página-mãe, e quem não é citado cai nos guias que valem para qualquer
    // tratamento. Assim nenhuma página de procedimento fica sem link para artigos.
    $articles = collect(config('articles'))->sortByDesc('published');
    $citing = fn (?string $procedureSlug) => $articles->filter(
        fn (array $article): bool => in_array($procedureSlug, $article['related'] ?? [], true)
    );
    $links = $citing($slug);

    if ($links->isEmpty()) {
        $links = $citing($procedure['parent'] ?? null);
    }

    if ($links->isEmpty()) {
        $links = $articles->only(['tempo-de-recuperacao', 'como-se-preparar', 'quem-nao-pode-fazer']);
    }
@endphp

@include('partials.article-links', [
    'links' => $links->take(3),
    'heading' => 'Para ler <em class="text-clay">antes de decidir</em>',
])
