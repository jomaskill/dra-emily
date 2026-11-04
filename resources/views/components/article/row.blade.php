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
            <h2 class="font-headline font-bold text-[1.25rem] md:text-[1.5rem] leading-[1.2] tracking-[-0.016em] text-ink mt-3 group-hover:text-clay transition-colors duration-300 text-balance">
                {{ $article['h1'] }}
            </h2>
            <p class="hidden sm:block font-headline text-ink-soft leading-[1.5] mt-2 line-clamp-2">{{ $article['excerpt'] }}</p>
            <p class="text-sm text-clay mt-3">{{ $article['eyebrow'] }}</p>
        </div>
        <div class="aspect-square sm:aspect-[4/3] rounded-sm overflow-hidden">
            <x-article.cover :article="$article" class="w-full h-full transition-transform duration-700 ease-out-quint group-hover:scale-[1.04]" />
        </div>
    </a>
</li>
