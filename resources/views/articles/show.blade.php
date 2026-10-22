@php
    $domain    = config('clinic.domain');
    $siteUrl   = 'https://'.$domain;
    $canonical = $siteUrl.'/artigos/'.$slug;
    $cro       = config('clinic.cro');
    $waArtigo  = \App\Support\WhatsApp::url('Olá! Li o artigo “'.$article['h1'].'” e gostaria de agendar uma avaliação.');
    $related   = collect(config('procedures'))->only($article['related'] ?? []);
    $updated   = \Illuminate\Support\Carbon::parse($article['updated']);
    // Compartilhar usa api.whatsapp.com para não receber a marcação de anúncio dos links wa.me.
    $shareUrl  = 'https://api.whatsapp.com/send?text='.rawurlencode($article['h1'].' — '.$canonical);
    $story     = [
        'slug' => $slug,
        'title' => $article['h1'],
        'eyebrow' => $article['eyebrow'],
        'excerpt' => $article['excerpt'],
        'number' => $article['number'],
        'tone' => $article['tone'],
        'url' => $canonical,
        'domain' => $domain,
    ];
@endphp

<x-site-layout
    :title="$article['title']"
    :description="$article['meta_description']"
    :canonical="$canonical"
    og-type="article"
    :nav-base="'/'"
    :whatsapp-origin="'pelo artigo “'.$article['h1'].'”'">

    <x-slot:schema>
        @include('partials.article-schema')
    </x-slot:schema>

    <div class="reading-progress fixed top-18 inset-x-0 z-40 h-0.5 bg-clay" aria-hidden="true"></div>

    <main class="pt-18">
        <article>
            {{-- ======================================================
                 HEADER
            ====================================================== --}}
            <header class="max-w-[42rem] mx-auto px-5 pt-12 lg:pt-20">
                <nav aria-label="Você está em" class="mb-10 lg:mb-14">
                    <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                        <li><a href="{{ route('home') }}" class="hover:text-clay transition-colors">Início</a></li>
                        <li aria-hidden="true">/</li>
                        <li><a href="{{ route('articles.index') }}" class="hover:text-clay transition-colors">Artigos</a></li>
                    </ol>
                </nav>

                <p class="text-sm font-medium text-clay mb-5">{{ $article['eyebrow'] }}</p>

                <h1 class="font-display text-[clamp(2.3rem,1.6rem+3.2vw,3.5rem)] leading-[1.08] text-ink text-balance">
                    {{ $article['h1'] }}
                </h1>

                <p class="font-serif text-[1.25rem] md:text-[1.4rem] leading-snug text-ink-soft mt-5 text-pretty">
                    {{ $article['excerpt'] }}
                </p>

                <x-article.byline :article="$article" class="mt-9" />

                <div class="flex items-center justify-between gap-4 mt-8 py-3 border-y rule text-sm text-ink-soft">
                    <p>
                        Revisado em <time datetime="{{ $article['updated'] }}">{{ $updated->translatedFormat('j \d\e F \d\e Y') }}</time>
                    </p>
                    <div class="flex items-center gap-1">
                        <a href="{{ $shareUrl }}" target="_blank" rel="noopener noreferrer"
                           class="grid place-items-center w-10 h-10 rounded-full hover:bg-sand/60 hover:text-clay transition-colors"
                           aria-label="Compartilhar no WhatsApp">
                            <x-whatsapp-icon class="w-[1.1rem] h-[1.1rem]" />
                        </a>
                        <button type="button" data-story="{{ json_encode($story, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}"
                                class="grid place-items-center w-10 h-10 rounded-full hover:bg-sand/60 hover:text-clay transition-colors cursor-pointer"
                                aria-label="Compartilhar no story do Instagram">
                            <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5"/>
                                <circle cx="12" cy="12" r="4.2"/>
                                <circle cx="17.3" cy="6.7" r="0.6" fill="currentColor" stroke="none"/>
                            </svg>
                        </button>
                        <button type="button" data-copy-link="{{ $canonical }}"
                                class="grid place-items-center w-10 h-10 rounded-full hover:bg-sand/60 hover:text-clay transition-colors cursor-pointer"
                                aria-label="Copiar link do artigo">
                            <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <div data-share-toast role="status" aria-live="polite"
                 class="pointer-events-none fixed bottom-6 left-1/2 z-50 -translate-x-1/2 w-max max-w-[calc(100vw-2.5rem)] rounded-sm bg-ink px-4 py-3 text-center text-sm text-linen opacity-0 shadow-lg transition-opacity duration-300"></div>

            {{-- ======================================================
                 BODY
            ====================================================== --}}
            <div class="max-w-[42rem] mx-auto px-5 pt-12 lg:pt-14 pb-20 lg:pb-24">

                {{-- Direct answer: the passage engines extract --}}
                <section id="resposta" class="border-l-[3px] border-clay pl-5 md:pl-7 mb-14">
                    <p class="text-xs font-semibold tracking-[0.14em] uppercase text-clay mb-3">Resposta rápida</p>
                    <p class="font-serif italic text-[1.2rem] md:text-[1.35rem] leading-[1.6] text-ink">
                        {{ $article['answer'] }}
                    </p>
                </section>

                <div class="article-prose">
                    @foreach ($article['sections'] as $section)
                        <section>
                            <h2>{{ $section['heading'] }}</h2>
                            @foreach ($section['body'] as $paragraph)
                                <p @class(['drop-cap' => $loop->parent->first && $loop->first])>{{ $paragraph }}</p>
                            @endforeach
                        </section>
                    @endforeach
                </div>

                {{-- Takeaways --}}
                @if (! empty($article['takeaways']))
                    <aside class="mt-16 rounded-sm bg-sand/50 px-6 md:px-9 py-8 md:py-10" aria-labelledby="em-resumo">
                        <h2 id="em-resumo" class="font-display text-[1.75rem] leading-tight text-ink mb-5">Em resumo</h2>
                        <ul class="space-y-3.5 font-serif text-[1.075rem] md:text-[1.15rem] leading-relaxed text-ink">
                            @foreach ($article['takeaways'] as $takeaway)
                                <li class="flex gap-4">
                                    <span class="w-1.5 h-1.5 mt-[0.7em] rounded-full bg-clay shrink-0" aria-hidden="true"></span>
                                    <span>{{ $takeaway }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </aside>
                @endif

                {{-- FAQ --}}
                <section id="faq" class="mt-20">
                    <h2 class="font-display text-[clamp(1.9rem,1.4rem+1.6vw,2.4rem)] leading-tight text-ink mb-6">
                        Perguntas <em class="text-clay">frequentes</em>
                    </h2>
                    <x-faq-list :items="$article['faq']" />
                </section>

                {{-- Sources --}}
                <section id="fontes" class="mt-16 pt-8 border-t rule" aria-labelledby="fontes-titulo">
                    <h2 id="fontes-titulo" class="text-xs font-semibold tracking-[0.14em] uppercase text-ink-soft mb-5">Fontes</h2>
                    <ol class="space-y-3 text-[0.95rem] leading-relaxed text-ink-soft list-decimal marker:text-clay pl-5">
                        @foreach ($article['sources'] as $source)
                            <li class="pl-1">
                                <span class="text-ink">{{ $source['publisher'] }}.</span>
                                <a href="{{ $source['url'] }}" target="_blank" rel="noopener noreferrer"
                                   class="underline decoration-ink/25 underline-offset-[3px] hover:text-clay hover:decoration-clay transition-colors">{{ $source['title'] }}</a>.
                                {{ $source['year'] }}.
                            </li>
                        @endforeach
                    </ol>
                </section>

                {{-- Related procedures, as topic tags --}}
                @if ($related->isNotEmpty())
                    <nav aria-label="Tratamentos citados" class="mt-14">
                        <p class="text-sm text-ink-soft mb-4">Tratamentos citados</p>
                        <ul class="flex flex-wrap gap-2">
                            @foreach ($related as $relatedSlug => $procedure)
                                <li>
                                    <a href="{{ route('procedure', $relatedSlug) }}"
                                       class="inline-flex items-center rounded-full bg-sand/70 px-4 py-2 text-[0.95rem] text-ink hover:bg-sand hover:text-clay-deep transition-colors duration-300">
                                        {{ $procedure['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endif

                {{-- Author --}}
                <footer class="mt-16 pt-10 border-t rule flex flex-col sm:flex-row gap-6 sm:items-start">
                    <x-article.avatar class="w-18 h-18" alt="Dra. Emily Beatriz" />
                    <div>
                        <p class="text-sm text-ink-soft">Escrito por</p>
                        <p class="font-display text-[1.6rem] leading-tight text-ink mt-0.5">Dra. Emily Beatriz</p>
                        <p class="text-sm text-ink-soft mt-1">Cirurgiã-dentista, harmonização orofacial · CRO-{{ $cro }}</p>
                        <p class="text-ink-soft leading-relaxed mt-4 max-w-[52ch]">
                            Atende em Belo Horizonte com um princípio simples: o resultado tem que parecer você.
                            Escreve aqui as respostas que costuma dar na primeira conversa.
                        </p>
                        <a href="{{ $waArtigo }}" target="_blank" rel="noopener noreferrer" class="thread-link text-ink mt-5">
                            Agendar uma avaliação
                        </a>
                    </div>
                </footer>
            </div>
        </article>

        {{-- ======================================================
             MORE ARTICLES
        ====================================================== --}}
        @if ($moreArticles->isNotEmpty())
            <section class="bg-sand/45" aria-labelledby="continue-lendo">
                <div class="max-w-6xl mx-auto px-5 lg:px-8 py-20 lg:py-24">
                    <div class="flex items-baseline justify-between gap-6 mb-10">
                        <h2 id="continue-lendo" class="font-display text-[clamp(1.9rem,1.4rem+1.6vw,2.4rem)] leading-tight text-ink">Continue lendo</h2>
                        <a href="{{ route('articles.index') }}" class="text-sm text-ink-soft hover:text-clay transition-colors shrink-0">Ver todos →</a>
                    </div>
                    <ul class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-12">
                        @foreach ($moreArticles as $moreSlug => $more)
                            <li>
                                <a href="{{ route('article', $moreSlug) }}" class="group flex flex-col h-full">
                                    <div class="aspect-[16/10] rounded-sm overflow-hidden">
                                        <x-article.cover :article="$more" class="w-full h-full transition-transform duration-700 ease-out-quint group-hover:scale-[1.03]" />
                                    </div>
                                    <h3 class="font-display text-[1.45rem] leading-[1.2] text-ink mt-5 group-hover:text-clay transition-colors duration-300 text-balance">
                                        {{ $more['h1'] }}
                                    </h3>
                                    <p class="font-serif text-ink-soft leading-relaxed mt-2 line-clamp-2">{{ $more['excerpt'] }}</p>
                                    <x-article.byline :article="$more" size="sm" class="mt-auto pt-4" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif

        <x-closing-cta :url="$waArtigo" label="Agendar avaliação">
            <x-slot:heading>Ficou com alguma <em>dúvida</em>?</x-slot:heading>
            A avaliação é uma conversa. Traga suas perguntas e vamos entender, junto com você, o que faz sentido para você.
        </x-closing-cta>

        @include('partials.medical-disclaimer', ['reviewed' => $article['updated']])
    </main>

    @include('partials.article-share-script')
</x-site-layout>
