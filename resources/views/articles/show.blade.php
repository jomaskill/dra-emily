@php
    $domain    = config('clinic.domain');
    $siteUrl   = 'https://'.$domain;
    $canonical = $siteUrl.'/artigos/'.$slug;
    $cro       = config('clinic.cro');
    $waArtigo  = \App\Support\WhatsApp::url('Olá! Li o artigo “'.$article['h1'].'” e gostaria de agendar uma avaliação.');
    $related   = collect(config('procedures'))->only($article['related'] ?? []);
    $published = \Illuminate\Support\Carbon::parse($article['published']);
    $updated   = \Illuminate\Support\Carbon::parse($article['updated']);
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

    <main>
        {{-- ======================================================
             HERO
        ====================================================== --}}
        <article>
            <header class="bg-linen pt-18">
                <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-12 lg:pt-20 pb-14 lg:pb-16">
                    <nav aria-label="Você está em" class="mb-12 lg:mb-16">
                        <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                            <li><a href="{{ route('home') }}" class="hover:text-clay transition-colors">Início</a></li>
                            <li aria-hidden="true">/</li>
                            <li><a href="{{ route('articles.index') }}" class="hover:text-clay transition-colors">Artigos</a></li>
                        </ol>
                    </nav>

                    <div class="max-w-4xl">
                        <p class="text-sm text-ink-soft mb-6">{{ $article['eyebrow'] }}</p>

                        <h1 class="font-display text-[clamp(2.6rem,5.6vw,4.8rem)] leading-[1.04] text-ink mb-8">
                            {{ $article['h1'] }}
                        </h1>

                        <p class="text-ink-soft text-sm">
                            Por Dra. Emily Beatriz &middot; CRO-{{ $cro }}
                            <span class="mx-1.5" aria-hidden="true">·</span>
                            <time datetime="{{ $article['published'] }}">{{ $published->translatedFormat('d \d\e F \d\e Y') }}</time>
                            @if ($article['updated'] !== $article['published'])
                                <span class="mx-1.5" aria-hidden="true">·</span>
                                Revisado em <time datetime="{{ $article['updated'] }}">{{ $updated->translatedFormat('d \d\e F \d\e Y') }}</time>
                            @endif
                        </p>
                    </div>
                </div>
            </header>

            {{-- ======================================================
                 DIRECT ANSWER: the passage engines extract
            ====================================================== --}}
            <section id="resposta" class="bg-sand/45">
                <div class="max-w-7xl mx-auto px-5 lg:px-8 py-14 lg:py-20 grid grid-cols-1 lg:grid-cols-[14rem_1fr] gap-4 lg:gap-12">
                    <p class="text-sm text-clay font-semibold lg:pt-2">Resposta rápida</p>
                    <p class="font-display text-[clamp(1.6rem,2.8vw,2.3rem)] text-ink leading-[1.25] max-w-[36ch]">
                        {{ $article['answer'] }}
                    </p>
                </div>
            </section>

            {{-- ======================================================
                 BODY
            ====================================================== --}}
            <div class="bg-linen">
                <div class="max-w-7xl mx-auto px-5 lg:px-8 py-16 lg:py-24 lg:pl-[calc(14rem+5rem)]">
                    @foreach ($article['sections'] as $section)
                        <section class="mb-16 last:mb-0 max-w-[68ch]">
                            <h2 class="font-display text-[clamp(1.9rem,3vw,2.5rem)] text-ink leading-[1.12] mb-6">
                                {{ $section['heading'] }}
                            </h2>
                            @foreach ($section['body'] as $paragraph)
                                <p class="text-ink-soft text-[1.05rem] leading-relaxed mb-5 last:mb-0">{{ $paragraph }}</p>
                            @endforeach
                        </section>
                    @endforeach
                </div>
            </div>

            {{-- ======================================================
                 TAKEAWAYS
            ====================================================== --}}
            @if (! empty($article['takeaways']))
                <section class="bg-clay text-linen">
                    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-16 lg:py-20 grid grid-cols-1 lg:grid-cols-[14rem_1fr] gap-6 lg:gap-12">
                        <h2 class="font-display text-3xl">Em resumo</h2>
                        <ul class="border-t border-linen/35 max-w-[68ch]">
                            @foreach ($article['takeaways'] as $takeaway)
                                <li class="py-4 border-b border-linen/35 leading-relaxed">{{ $takeaway }}</li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            @endif

            {{-- ======================================================
                 FAQ
            ====================================================== --}}
            <section id="faq" class="bg-linen">
                <div class="max-w-7xl mx-auto px-5 lg:px-8 py-20 lg:py-28 grid grid-cols-1 lg:grid-cols-[1fr_1.6fr] gap-10 lg:gap-20 items-start">
                    <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] text-ink lg:sticky lg:top-32">
                        Perguntas <em class="text-clay">frequentes</em>
                    </h2>
                    <x-faq-list :items="$article['faq']" />
                </div>
            </section>
        </article>

        {{-- ======================================================
             RELATED PROCEDURES
        ====================================================== --}}
        @if ($related->isNotEmpty())
            <section class="bg-sand/45">
                <div class="max-w-7xl mx-auto px-5 lg:px-8 py-20 lg:py-28">
                    <h2 class="font-display text-[clamp(2rem,3.4vw,2.8rem)] leading-[1.08] text-ink mb-10">Tratamentos citados</h2>
                    <ul class="border-t rule">
                        @foreach ($related as $relatedSlug => $procedure)
                            <li>
                                <a href="{{ route('procedure', $relatedSlug) }}"
                                   class="group grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)_2rem] gap-x-8 gap-y-2 items-baseline py-6 border-b rule transition-[padding] duration-500 ease-out-quint md:hover:pl-4">
                                    <span class="font-display text-2xl text-ink group-hover:text-clay transition-colors duration-300">{{ $procedure['name'] }}</span>
                                    <span class="text-ink-soft leading-relaxed">{{ $procedure['card_desc'] }}</span>
                                    <span class="hidden md:block justify-self-end text-clay transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif

        <x-closing-cta :url="$waArtigo" label="Agendar avaliação">
            <x-slot:heading>Ficou com alguma <em>dúvida</em>?</x-slot:heading>
            A avaliação é uma conversa. Traga suas perguntas e vamos entender juntas o que faz sentido para você.
        </x-closing-cta>

        @include('partials.medical-disclaimer', ['reviewed' => $article['updated']])
    </main>
</x-site-layout>
