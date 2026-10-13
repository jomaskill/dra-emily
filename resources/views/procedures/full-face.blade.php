@php
    $domain      = config('clinic.domain');
    $siteUrl     = 'https://' . $domain;
    $canonical   = $siteUrl . '/procedimentos/' . $slug;
    $cro         = config('clinic.cro');
    $waHero      = \App\Support\WhatsApp::url('Olá! Gostaria de saber mais sobre '.$procedure['name'].' com a Dra. Emily.');
    $waResultados = \App\Support\WhatsApp::url('Olá! Vi os antes e depois de '.$procedure['name'].' no site e gostaria de agendar minha avaliação.');
    $waFinal     = \App\Support\WhatsApp::url('Olá! Quero agendar uma avaliação de '.$procedure['name'].' com a Dra. Emily.');
    $includes    = collect(config('procedures'))->only($procedure['includes'] ?? []);
    // Full Face já detalha o que inclui, então os relacionados são os 4 seguintes
    // que não fazem parte dessa lista.
    $catalogue   = collect(config('procedures'));
    $excluded    = array_merge([$slug], $procedure['includes'] ?? []);
    $others      = $catalogue->keys()
        ->merge($catalogue->keys())
        ->slice($catalogue->keys()->search($slug) + 1)
        ->reject(fn (string $key): bool => in_array($key, $excluded, true))
        ->unique()
        ->take(4)
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
             HERO: o tratamento carro-chefe, em argila
        ====================================================== --}}
        <section class="bg-clay text-linen pt-18">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-12 lg:pt-20 pb-20 lg:pb-28">
                <nav aria-label="Breadcrumb" class="animate-fade-up flex flex-wrap items-center gap-2 text-sm text-linen mb-12 lg:mb-16">
                    <a href="/" class="hover:text-linen transition-colors">Início</a>
                    <span aria-hidden="true">/</span>
                    <a href="/#procedimentos" class="hover:text-linen transition-colors">Procedimentos</a>
                    <span aria-hidden="true">/</span>
                    <span class="text-linen">{{ $procedure['name'] }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-14 lg:gap-24 items-end">
                    <div>
                        <p class="animate-fade-up delay-100 text-sm text-linen mb-6">
                            Tratamento exclusivo · {{ $procedure['eyebrow'] }} · Belo Horizonte
                        </p>
                        <h1 class="animate-fade-up delay-100 font-display text-[clamp(3.2rem,8vw,7rem)] leading-[1.0]">
                            {{ $procedure['h1'] }}
                        </h1>
                        <p class="animate-fade-up delay-200 text-linen text-lg lg:text-xl leading-relaxed max-w-[54ch] mt-8 mb-10">
                            {{ $procedure['hero_lead'] }}
                        </p>
                        <div class="animate-fade-up delay-300">
                            <a href="{{ $waHero }}" target="_blank" rel="noopener noreferrer" class="btn btn-light">
                                <x-whatsapp-icon />
                                Agendar avaliação Full Face
                            </a>
                        </div>
                    </div>

                    <div class="animate-fade-up delay-300">
                        <x-thread class="w-44 h-auto mb-6 !text-linen" />
                        <dl class="border-t border-linen/35">
                            @foreach ($procedure['facts'] as $fact)
                                <div class="flex items-baseline justify-between gap-6 py-4 border-b border-linen/35">
                                    <dt class="text-sm text-linen">{{ $fact['label'] }}</dt>
                                    <dd class="font-display text-xl lg:text-2xl text-right">{{ $fact['value'] }}</dd>
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
        <section id="o-que-e" class="bg-linen">
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
             SIGNATURE: o rosto em três terços
        ====================================================== --}}
        <section class="bg-sand/45">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12 items-end mb-12 lg:mb-16">
                    <h2 class="font-display text-[clamp(2.4rem,4.6vw,4rem)] leading-[1.04] text-ink">
                        O rosto em <em class="text-clay">três terços</em>
                    </h2>
                    <p class="text-ink-soft leading-relaxed max-w-[48ch] lg:justify-self-end">
                        O segredo do Full Face é tratar o rosto como um conjunto. Cada terço é avaliado e equilibrado em relação aos demais, e é isso que cria um resultado natural e harmonioso.
                    </p>
                </div>
                <ol class="grid grid-cols-1 md:grid-cols-3 gap-x-10 border-t rule">
                    @foreach ($procedure['thirds'] as $i => $third)
                        <li class="pt-8 pb-8 md:pb-0 border-b md:border-b-0 rule">
                            <span class="font-display text-5xl leading-none text-ochre">0{{ $i + 1 }}</span>
                            <h3 class="font-display text-2xl text-ink mt-5 mb-3">{{ $third['label'] }}</h3>
                            <p class="text-ink-soft leading-relaxed">{{ $third['desc'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        {{-- ======================================================
             WHAT'S INCLUDED: links para os procedimentos combinados
        ====================================================== --}}
        @if ($includes->isNotEmpty())
            <section class="bg-linen">
                <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12 items-end mb-12">
                        <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] text-ink">O que pode estar incluído</h2>
                        <p class="text-ink-soft leading-relaxed max-w-[48ch] lg:justify-self-end">
                            O Full Face combina diferentes procedimentos, escolhidos sob medida para o seu rosto. Conheça os principais.
                        </p>
                    </div>
                    <ul class="border-t rule">
                        @foreach ($includes as $incSlug => $inc)
                            <li>
                                <a href="{{ route('procedure', $incSlug) }}"
                                   class="group grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)_2rem] gap-x-8 gap-y-2 items-baseline py-6 border-b rule transition-[padding] duration-500 ease-out-quint md:hover:pl-4">
                                    <span class="font-display text-2xl text-ink group-hover:text-clay transition-colors duration-300">{{ $inc['name'] }}</span>
                                    <span class="text-ink-soft leading-relaxed">{{ $inc['card_desc'] }}</span>
                                    <span class="hidden md:block justify-self-end text-clay transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif

        {{-- ======================================================
             BENEFITS
        ====================================================== --}}
        <section class="bg-sand/45">
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
        <section class="bg-clay-deep text-linen">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32">
                <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] mb-12 lg:mb-16">Como funciona</h2>
                <ol class="grid grid-cols-1 md:grid-cols-3 gap-x-10 border-t border-linen/30">
                    @foreach ($procedure['steps'] as $i => $step)
                        <li class="pt-8 pb-6 md:pb-0 border-b md:border-b-0 border-linen/30">
                            <span class="font-display text-5xl leading-none text-ochre">0{{ $i + 1 }}</span>
                            <h3 class="font-display text-2xl mt-5 mb-3">{{ $step['title'] }}</h3>
                            <p class="text-linen/85 leading-relaxed">{{ $step['desc'] }}</p>
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
                    Full Face: o que você <em class="text-clay">precisa saber</em>
                </h2>
                <x-faq-list :items="$procedure['faq']" />
            </div>
        </section>

        @include('partials.comparison-table')

        <x-closing-cta :url="$waFinal">
            <x-slot:heading>Pronta para um olhar <em>completo</em> sobre o seu rosto?</x-slot:heading>
            Agende uma avaliação Full Face sem compromisso com a Dra. Emily Beatriz em Belo Horizonte e descubra o plano ideal para o seu rosto. CRO-{{ $cro }}.
        </x-closing-cta>
        @include('partials.medical-disclaimer', ['reviewed' => $procedure['updated'] ?? null])

    </main>
</x-site-layout>
