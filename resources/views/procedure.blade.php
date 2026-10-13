@php
    $domain      = config('clinic.domain');
    $siteUrl     = 'https://' . $domain;
    $canonical   = $siteUrl . '/procedimentos/' . $slug;
    $cro         = config('clinic.cro');
    $waHero      = \App\Support\WhatsApp::url('Olá! Gostaria de saber mais sobre '.$procedure['name'].' com a Dra. Emily.');
    $waResultados = \App\Support\WhatsApp::url('Olá! Vi os antes e depois de '.$procedure['name'].' no site e gostaria de agendar minha avaliação.');
    $waFinal     = \App\Support\WhatsApp::url('Olá! Quero agendar uma avaliação de '.$procedure['name'].' com a Dra. Emily.');
    // Cada página aponta para os 4 procedimentos seguintes na ordem do config,
    // com volta ao início. Assim todos recebem o mesmo número de links internos,
    // em vez de cada página listar todos os irmãos.
    $catalogue   = collect(config('procedures'));
    $position    = $catalogue->keys()->search($slug);
    $others      = $catalogue->keys()
        ->merge($catalogue->keys())
        ->slice($position + 1, 4)
        ->mapWithKeys(fn (string $key): array => [$key => $catalogue[$key]]);

    // Share card por procedimento (1200x630) em public/procedures/{slug}-og.jpg.
    // Sem arquivo, o layout cai na imagem genérica.
    $ogCard      = 'procedures/' . $slug . '-og.jpg';
    $ogImage     = is_file(public_path($ogCard)) ? $siteUrl . '/' . $ogCard : null;
@endphp

<x-site-layout
    :title="$procedure['title']"
    :description="$procedure['meta_description']"
    :canonical="$canonical"
    og-type="article"
    :og-image="$ogImage"
    :nav-base="'/'"
    :whatsapp-origin="'pela página de '.$procedure['name']">

    <x-slot:schema>
        @include('partials.procedure-schema')
    </x-slot:schema>

    <main>
        {{-- ======================================================
             HERO
        ====================================================== --}}
        <section class="bg-linen pt-18">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-12 lg:pt-20 pb-20 lg:pb-28">
                <nav aria-label="Breadcrumb" class="animate-fade-up flex flex-wrap items-center gap-2 text-sm text-ink-soft mb-12 lg:mb-16">
                    <a href="/" class="hover:text-clay transition-colors">Início</a>
                    <span aria-hidden="true">/</span>
                    <a href="/#procedimentos" class="hover:text-clay transition-colors">Procedimentos</a>
                    <span aria-hidden="true">/</span>
                    <span class="text-ink">{{ $procedure['name'] }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-14 lg:gap-24 items-end">
                    <div>
                        <p class="animate-fade-up delay-100 text-sm text-ink-soft mb-6">
                            {{ $procedure['eyebrow'] }} · Belo Horizonte, MG
                        </p>
                        <h1 class="animate-fade-up delay-100 font-display text-[clamp(2.8rem,6.4vw,5.6rem)] leading-[1.03] text-ink">
                            {{ $procedure['h1'] }}
                        </h1>
                        <p class="animate-fade-up delay-200 text-ink-soft text-lg leading-relaxed max-w-[56ch] mt-8 mb-10">
                            {{ $procedure['hero_lead'] }}
                        </p>
                        <div class="animate-fade-up delay-300">
                            <a href="{{ $waHero }}" target="_blank" rel="noopener noreferrer" class="btn">
                                <x-whatsapp-icon />
                                Agendar avaliação
                            </a>
                        </div>
                    </div>

                    {{-- Ficha do tratamento --}}
                    <div class="animate-fade-up delay-300">
                        <x-thread class="w-44 h-auto mb-6" />
                        <dl class="border-t rule">
                            @foreach ($procedure['facts'] as $fact)
                                <div class="flex items-baseline justify-between gap-6 py-4 border-b rule">
                                    <dt class="text-sm text-ink-soft">{{ $fact['label'] }}</dt>
                                    <dd class="font-display text-xl lg:text-2xl text-ink text-right">{{ $fact['value'] }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================
             RESULTS (antes e depois)
        ====================================================== --}}
        @if ($results->isNotEmpty())
            <x-results-gallery :cases="$results"
                               :cta-url="$waResultados"
                               heading="Antes e depois: <em>{{ e($procedure['name']) }}</em>"
                               lead="Casos reais atendidos pela Dra. Emily Beatriz."
                               :cta-label="'Agendar avaliação de '.$procedure['name']" />
        @endif

        {{-- ======================================================
             WHAT IS
        ====================================================== --}}
        <section id="o-que-e" class="bg-sand/45">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32 grid grid-cols-1 lg:grid-cols-[1fr_1.4fr] gap-10 lg:gap-20 items-start">
                <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] text-ink lg:sticky lg:top-32">
                    {{ $procedure['what_is_title'] }}
                </h2>
                <div class="space-y-5 text-ink-soft leading-relaxed text-[1.05rem] max-w-[64ch]">
                    @foreach ($procedure['what_is'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ======================================================
             BENEFITS
        ====================================================== --}}
        <section class="bg-linen">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32">
                <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] text-ink mb-12 lg:mb-16">
                    Os benefícios <em class="text-clay">para você</em>
                </h2>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-16 border-t rule">
                    @foreach ($procedure['benefits'] as $benefit)
                        <li class="grid grid-cols-[1.5rem_1fr] gap-x-4 py-7 border-b rule">
                            <span class="w-1.5 h-1.5 rounded-full bg-ochre mt-3" aria-hidden="true"></span>
                            <div>
                                <h3 class="font-display text-2xl text-ink mb-2">{{ $benefit['title'] }}</h3>
                                <p class="text-ink-soft leading-relaxed">{{ $benefit['desc'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- ======================================================
             HOW IT WORKS
        ====================================================== --}}
        <section class="bg-clay text-linen">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32">
                <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] mb-12 lg:mb-16">Como funciona</h2>
                <ol class="grid grid-cols-1 md:grid-cols-3 gap-x-10 border-t border-linen/35">
                    @foreach ($procedure['steps'] as $i => $step)
                        <li class="pt-8 pb-6 md:pb-0 border-b md:border-b-0 border-linen/35">
                            <span class="font-display text-5xl leading-none text-linen/55">0{{ $i + 1 }}</span>
                            <h3 class="font-display text-2xl mt-5 mb-3">{{ $step['title'] }}</h3>
                            <p class="text-linen leading-relaxed">{{ $step['desc'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        {{-- ======================================================
             FAQ
        ====================================================== --}}
        <section id="faq" class="bg-linen">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32 grid grid-cols-1 lg:grid-cols-[1fr_1.6fr] gap-12 lg:gap-20 items-start">
                <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] text-ink lg:sticky lg:top-32">
                    {{ $procedure['name'] }}: o que você <em class="text-clay">precisa saber</em>
                </h2>
                <x-faq-list :items="$procedure['faq']" />
            </div>
        </section>

        @include('partials.comparison-table')

        {{-- ======================================================
             RELATED PROCEDURES
        ====================================================== --}}
        <section class="bg-sand/45">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-28">
                <h2 class="font-display text-[clamp(2rem,3.4vw,2.8rem)] leading-[1.08] text-ink mb-10">Outros tratamentos</h2>
                <ul class="border-t rule">
                    @foreach ($others as $otherSlug => $other)
                        <li>
                            <a href="{{ route('procedure', $otherSlug) }}"
                               class="group grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)_2rem] gap-x-8 gap-y-2 items-baseline py-6 border-b rule transition-[padding] duration-500 ease-out-quint md:hover:pl-4">
                                <span class="font-display text-2xl text-ink group-hover:text-clay transition-colors duration-300">{{ $other['name'] }}</span>
                                <span class="text-ink-soft leading-relaxed">{{ $other['card_desc'] }}</span>
                                <span class="hidden md:block justify-self-end text-clay transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <x-closing-cta :url="$waFinal">
            <x-slot:heading>Vamos conversar sobre <em>{{ $procedure['name'] }}</em>?</x-slot:heading>
            Agende uma avaliação sem compromisso com a Dra. Emily Beatriz em Belo Horizonte e descubra o que esse tratamento pode fazer por você. CRO-{{ $cro }}.
        </x-closing-cta>
        @include('partials.medical-disclaimer', ['reviewed' => $procedure['updated'] ?? null])

    </main>
</x-site-layout>
