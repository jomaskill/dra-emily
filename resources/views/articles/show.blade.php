@php
    $domain    = config('clinic.domain');
    $siteUrl   = 'https://'.$domain;
    $canonical = $siteUrl.'/artigos/'.$slug;
    $cro       = config('clinic.cro');
    $wa        = 'https://wa.me/'.config('clinic.whatsapp');
    $waArtigo  = $wa.'?text='.rawurlencode('Olá! Li o artigo sobre '.$article['h1'].' e gostaria de agendar uma avaliação.');
    $related   = collect(config('procedures'))->only($article['related'] ?? []);
    $published = \Illuminate\Support\Carbon::parse($article['published']);
    $updated   = \Illuminate\Support\Carbon::parse($article['updated']);
@endphp

<x-site-layout
    :title="$article['title']"
    :description="$article['meta_description']"
    :canonical="$canonical"
    og-type="article"
    :nav-base="'/'">

    <x-slot:schema>
        @include('partials.article-schema')
    </x-slot:schema>

    <main>
        {{-- ======================================================
             HERO
        ====================================================== --}}
        <article>
            <header class="bg-cream pt-32 lg:pt-40 pb-14 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-[45vw] h-[45vw] max-w-xl rounded-full bg-blush/20 translate-x-1/3 -translate-y-1/4 pointer-events-none"></div>

                <div class="max-w-3xl mx-auto px-6 lg:px-8 relative z-10">
                    <nav aria-label="Você está em" class="mb-8">
                        <ol class="flex flex-wrap items-center gap-2 text-xs text-muted">
                            <li><a href="{{ route('home') }}" class="hover:text-rose transition-colors">Início</a></li>
                            <li aria-hidden="true">›</li>
                            <li><a href="{{ route('articles.index') }}" class="hover:text-rose transition-colors">Artigos</a></li>
                        </ol>
                    </nav>

                    <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-5">{{ $article['eyebrow'] }}</p>

                    <h1 class="font-display text-4xl lg:text-6xl italic text-charcoal leading-[1.08] mb-7">
                        {{ $article['h1'] }}
                    </h1>

                    <p class="text-muted text-sm">
                        Por Dra. Emily Beatriz &middot; CRO-{{ $cro }}
                        <span class="mx-1.5" aria-hidden="true">·</span>
                        <time datetime="{{ $article['published'] }}">{{ $published->translatedFormat('d \d\e F \d\e Y') }}</time>
                        @if ($article['updated'] !== $article['published'])
                            <span class="mx-1.5" aria-hidden="true">·</span>
                            Revisado em <time datetime="{{ $article['updated'] }}">{{ $updated->translatedFormat('d \d\e F \d\e Y') }}</time>
                        @endif
                    </p>
                </div>
            </header>

            {{-- ======================================================
                 DIRECT ANSWER — the passage engines extract
            ====================================================== --}}
            <section id="resposta" class="bg-white">
                <div class="max-w-3xl mx-auto px-6 lg:px-8 -mt-2 pt-14">
                    <div class="border-l-2 border-rose pl-6 lg:pl-8">
                        <p class="text-xs tracking-[0.2em] uppercase text-rose font-medium mb-4">Resposta rápida</p>
                        <p class="font-display text-2xl lg:text-[1.7rem] italic text-charcoal leading-snug">
                            {{ $article['answer'] }}
                        </p>
                    </div>
                </div>
            </section>

            {{-- ======================================================
                 BODY
            ====================================================== --}}
            <div class="bg-white">
                <div class="max-w-3xl mx-auto px-6 lg:px-8 py-16 lg:py-20">
                    @foreach ($article['sections'] as $section)
                        <section class="mb-14 last:mb-0">
                            <h2 class="font-display text-3xl lg:text-4xl italic text-charcoal leading-tight mb-6">
                                {{ $section['heading'] }}
                            </h2>
                            @foreach ($section['body'] as $paragraph)
                                <p class="text-muted leading-relaxed mb-5 last:mb-0">{{ $paragraph }}</p>
                            @endforeach
                        </section>
                    @endforeach
                </div>
            </div>

            {{-- ======================================================
                 TAKEAWAYS
            ====================================================== --}}
            @if (! empty($article['takeaways']))
                <section class="bg-cream border-y border-blush/30">
                    <div class="max-w-3xl mx-auto px-6 lg:px-8 py-14">
                        <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-6">Em resumo</p>
                        <ul class="space-y-4">
                            @foreach ($article['takeaways'] as $takeaway)
                                <li class="flex items-start gap-3.5">
                                    <span class="shrink-0 w-1.5 h-1.5 rounded-full bg-gold mt-2.5" aria-hidden="true"></span>
                                    <span class="text-charcoal leading-relaxed">{{ $takeaway }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            @endif

            {{-- ======================================================
                 FAQ
            ====================================================== --}}
            <section id="faq" class="bg-white">
                <div class="max-w-3xl mx-auto px-6 lg:px-8 py-16 lg:py-20">
                    <h2 class="font-display text-3xl lg:text-4xl italic text-charcoal leading-tight mb-9">
                        Perguntas frequentes
                    </h2>
                    <div class="space-y-3">
                        @foreach ($article['faq'] as $item)
                            <details class="group bg-cream border border-blush/30 rounded-2xl overflow-hidden hover:border-rose/30 transition-colors duration-300">
                                <summary class="flex items-center justify-between gap-4 px-7 py-5 cursor-pointer list-none select-none">
                                    <span class="font-display text-xl italic text-charcoal leading-snug group-open:text-rose transition-colors duration-300">
                                        {{ $item['q'] }}
                                    </span>
                                    <span class="shrink-0 w-7 h-7 rounded-full border border-blush/50 flex items-center justify-center text-rose group-open:bg-rose group-open:border-rose group-open:text-white transition-all duration-300">
                                        <svg class="w-3.5 h-3.5 transition-transform duration-300 group-open:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </span>
                                </summary>
                                <div class="px-7 pb-6 pt-1">
                                    <div class="w-full h-px bg-blush/30 mb-4"></div>
                                    <p class="text-muted leading-relaxed text-[0.96rem]">{{ $item['a'] }}</p>
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>
            </section>
        </article>

        {{-- ======================================================
             RELATED PROCEDURES
        ====================================================== --}}
        @if ($related->isNotEmpty())
            <section class="py-20 lg:py-24 bg-cream">
                <div class="max-w-5xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Tratamentos citados</p>
                        <h2 class="font-display text-3xl lg:text-4xl italic text-charcoal leading-tight">
                            Sobre o que falamos aqui
                        </h2>
                        <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach ($related as $relatedSlug => $procedure)
                            <a href="{{ route('procedure', $relatedSlug) }}"
                               class="group bg-white border border-blush/30 rounded-2xl p-7 hover:border-rose/30 hover:shadow-xl hover:shadow-rose/5 transition-all duration-500 hover:-translate-y-1.5">
                                <div class="w-8 h-px bg-gold mb-5"></div>
                                <h3 class="font-display text-xl italic text-charcoal mb-2 leading-tight">{{ $procedure['name'] }}</h3>
                                <p class="text-muted text-sm leading-relaxed">{{ $procedure['card_desc'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- ======================================================
             CTA
        ====================================================== --}}
        <section class="py-20 lg:py-28 bg-deep-rose relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-white/5 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            <div class="max-w-3xl mx-auto px-6 lg:px-8 text-center relative z-10">
                <h2 class="font-display text-4xl lg:text-5xl italic text-white leading-tight mb-7">
                    Ficou com alguma dúvida?
                </h2>
                <p class="text-white/65 text-lg mb-10 leading-relaxed max-w-xl mx-auto">
                    A avaliação é uma conversa. Traga suas perguntas e vamos entender juntas o que faz sentido para você.
                </p>
                <a href="{{ $waArtigo }}"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-3 bg-white text-deep-rose px-10 py-5 rounded-full font-semibold text-sm tracking-wide hover:bg-cream transition-all duration-300 shadow-2xl hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Agendar avaliação
                </a>
            </div>
        </section>

        @include('partials.medical-disclaimer', ['reviewed' => $article['updated']])
    </main>
</x-site-layout>
