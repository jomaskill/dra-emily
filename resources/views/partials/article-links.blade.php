{{-- ======================================================
     ARTICLE LINKS
     Leva leitores e buscadores das páginas de conversão para os artigos.
     Recebe $links (slug => artigo) e $heading (HTML confiável, sem dado externo).
====================================================== --}}
<section id="leituras" class="bg-linen">
    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-28">
        <div class="flex items-baseline justify-between gap-6 mb-10">
            <h2 class="font-display text-[clamp(2rem,3.4vw,2.8rem)] leading-[1.08] text-ink">{!! $heading !!}</h2>
            <a href="{{ route('articles.index') }}" class="text-sm text-ink-soft hover:text-clay transition-colors shrink-0">Ver todos →</a>
        </div>
        <ul class="border-t rule">
            @foreach ($links as $articleSlug => $linkedArticle)
                <li>
                    <a href="{{ route('article', $articleSlug) }}"
                       class="group grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)_2rem] gap-x-8 gap-y-2 items-baseline py-6 border-b rule transition-[padding] duration-500 ease-out-quint md:hover:pl-4">
                        <span class="font-display text-2xl text-ink group-hover:text-clay transition-colors duration-300">{{ $linkedArticle['h1'] }}</span>
                        <span class="text-ink-soft leading-relaxed">{{ $linkedArticle['excerpt'] }}</span>
                        <span class="hidden md:block justify-self-end text-clay transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>
