@php
    $domain    = config('clinic.domain');
    $siteUrl   = 'https://'.$domain;
    $canonical = $siteUrl.'/artigos';
    $cro       = config('clinic.cro');
@endphp

<x-site-layout
    title="Artigos | Dra. Emily Beatriz — Harmonização Facial em BH"
    description="Respostas às perguntas que vêm antes de agendar: investimento, recuperação, contraindicações e preparo. Escrito pela Dra. Emily Beatriz, em Belo Horizonte."
    :canonical="$canonical"
    :nav-base="'/'"
    whatsapp-origin="pela página de artigos do site">

    <x-slot:schema>
        @include('partials.article-collection-schema', ['name' => 'Artigos — Dra. Emily Beatriz'])
    </x-slot:schema>

    @php
        $featuredSlug = $articles->keys()->first();
        $featured = $articles->first();
        $feed = $articles->except($featuredSlug);
        $waIndex = \App\Support\WhatsApp::url('Olá! Vim pela página de artigos do site e gostaria de agendar uma avaliação.');
    @endphp

    <main class="pt-18">
        <header class="max-w-6xl mx-auto px-5 lg:px-8 pt-14 lg:pt-20 pb-10 lg:pb-14">
            <p class="text-sm font-medium text-clay mb-5">Artigos</p>
            <h1 class="font-display text-[clamp(2.6rem,1.8rem+3.6vw,4.4rem)] leading-[1.04] text-ink max-w-[22ch]">
                Harmonização facial: as perguntas que <em class="text-clay">vêm antes</em>
            </h1>
            <p class="font-serif text-ink-soft text-[1.2rem] md:text-[1.3rem] leading-snug max-w-[52ch] mt-6">
                Quanto custa, quanto tempo leva para se recuperar, quem não pode fazer e como se preparar.
                As dúvidas que aparecem antes da primeira conversa, respondidas com franqueza.
            </p>
            <x-article.topics :topics="config('topics')" class="mt-9" />
        </header>

        {{-- ======================================================
             FEATURED: the newest article
        ====================================================== --}}
        <section class="max-w-6xl mx-auto px-5 lg:px-8" aria-label="Artigo mais recente">
            <a href="{{ route('article', $featuredSlug) }}"
               class="group grid grid-cols-1 md:grid-cols-[1.15fr_1fr] gap-7 md:gap-12 items-center py-10 border-y rule">
                <div class="aspect-[16/10] rounded-sm overflow-hidden">
                    <x-article.cover :article="$featured" class="w-full h-full transition-transform duration-700 ease-out-quint group-hover:scale-[1.03]" />
                </div>
                <div>
                    <p class="flex items-center gap-3 text-sm text-clay">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-clay px-2.5 py-0.5 text-xs font-semibold tracking-[0.08em] uppercase text-linen">
                            <span class="w-1.5 h-1.5 rounded-full bg-ochre" aria-hidden="true"></span>
                            Novo
                        </span>
                        {{ $featured['eyebrow'] }}
                    </p>
                    <h2 class="font-display text-[clamp(1.9rem,1.3rem+2vw,2.8rem)] leading-[1.1] text-ink mt-3 group-hover:text-clay transition-colors duration-300 text-balance">
                        {{ $featured['h1'] }}
                    </h2>
                    <p class="font-serif text-ink-soft text-[1.1rem] leading-relaxed mt-4 max-w-[46ch]">{{ $featured['excerpt'] }}</p>
                    <x-article.byline :article="$featured" class="mt-7" />
                </div>
            </a>
        </section>

        {{-- ======================================================
             FEED + AUTHOR
        ====================================================== --}}
        <section class="max-w-6xl mx-auto px-5 lg:px-8 pt-4 pb-24 lg:pb-32 grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_17rem] gap-x-16 gap-y-14">
            <ul aria-label="Todos os artigos">
                @foreach ($feed as $slug => $article)
                    <x-article.row :slug="$slug" :article="$article" />
                @endforeach
            </ul>

            <aside class="lg:pt-9" aria-label="Sobre a autora">
                <div class="lg:sticky lg:top-28">
                    <x-article.avatar class="w-20 h-20" alt="Dra. Emily Beatriz" />
                    <p class="font-display text-[1.5rem] leading-tight text-ink mt-5">
                        <a href="{{ route('author') }}" rel="author" class="hover:text-clay transition-colors">Dra. Emily Beatriz</a>
                    </p>
                    <p class="text-sm text-ink-soft mt-1">Harmonização orofacial · CRO-{{ $cro }}</p>
                    <p class="text-ink-soft leading-relaxed mt-4">
                        Atende em Belo Horizonte com um princípio simples: o resultado tem que parecer você.
                        Aqui estão as respostas que ela costuma dar na primeira conversa.
                    </p>
                    <x-thread class="w-32 h-auto my-7" />
                    <a href="{{ $waIndex }}" target="_blank" rel="noopener noreferrer" class="btn">
                        <x-whatsapp-icon />
                        Agendar avaliação
                    </a>
                </div>
            </aside>
        </section>

        @include('partials.medical-disclaimer')
    </main>
</x-site-layout>
