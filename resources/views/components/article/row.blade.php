@props([
    'slug',
    'article',
])

{{--
    Linha da lista de artigos: autoria, título, resumo e capa à direita.
--}}
<li>
    <a href="{{ route('article', $slug) }}"
       class="group grid grid-cols-[minmax(0,1fr)_5.5rem] sm:grid-cols-[minmax(0,1fr)_10rem] gap-5 sm:gap-10 items-center py-9 border-b rule">
        <div>
            <x-article.byline :article="$article" size="sm" />
            <h2 class="font-display text-[clamp(1.35rem,1.1rem+0.9vw,1.75rem)] leading-[1.18] text-ink mt-3 group-hover:text-clay transition-colors duration-300 text-balance">
                {{ $article['h1'] }}
            </h2>
            <p class="hidden sm:block font-serif text-ink-soft leading-relaxed mt-2 line-clamp-2">{{ $article['excerpt'] }}</p>
            <p class="text-sm text-clay mt-3">{{ $article['eyebrow'] }}</p>
        </div>
        <div class="aspect-square sm:aspect-[4/3] rounded-sm overflow-hidden">
            <x-article.cover :article="$article" class="w-full h-full transition-transform duration-700 ease-out-quint group-hover:scale-[1.04]" />
        </div>
    </a>
</li>
