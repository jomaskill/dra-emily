@php
    $domain      = config('clinic.domain');
    $siteUrl     = 'https://' . $domain;
    $canonical   = $siteUrl . '/procedimentos/' . $slug;
    $cro         = config('clinic.cro');
    $wa          = 'https://wa.me/' . config('clinic.whatsapp');
    $waText      = rawurlencode('Olá! Gostaria de saber mais sobre ' . $procedure['name'] . ' com a Dra. Emily.');
    $waProc      = $wa . '?text=' . $waText;
    $others      = collect(config('procedures'))->except($slug);
@endphp

<x-site-layout
    :title="$procedure['title']"
    :description="$procedure['meta_description']"
    :canonical="$canonical"
    og-type="article"
    :nav-base="'/'">

    <x-slot:schema>
        @include('partials.procedure-schema')
    </x-slot:schema>

    <main>
        {{-- ======================================================
             HERO
        ====================================================== --}}
        <section class="relative overflow-hidden bg-cream pt-32 lg:pt-40 pb-20 lg:pb-28">
            <div class="absolute right-0 top-0 w-[50vw] h-[50vw] max-w-2xl rounded-full bg-blush/20 translate-x-1/3 -translate-y-1/4 pointer-events-none"></div>
            <div class="absolute inset-0 pointer-events-none opacity-[0.015]"
                 style="background-image: repeating-linear-gradient(0deg, #2A1F1F 0px, transparent 1px, transparent 80px), repeating-linear-gradient(90deg, #2A1F1F 0px, transparent 1px, transparent 80px);"></div>

            <div class="max-w-4xl mx-auto px-6 lg:px-8 relative z-10">
                {{-- Breadcrumb --}}
                <nav aria-label="Breadcrumb" class="animate-fade-up flex items-center gap-2 text-xs text-muted mb-8">
                    <a href="/" class="hover:text-rose transition-colors">Início</a>
                    <span class="text-blush">/</span>
                    <a href="/#procedimentos" class="hover:text-rose transition-colors">Procedimentos</a>
                    <span class="text-blush">/</span>
                    <span class="text-charcoal">{{ $procedure['name'] }}</span>
                </nav>

                <p class="animate-fade-up delay-100 text-xs tracking-[0.25em] uppercase text-rose font-medium mb-5">
                    {{ $procedure['eyebrow'] }}&nbsp;&nbsp;·&nbsp;&nbsp;Belo Horizonte, MG
                </p>
                <h1 class="animate-fade-up delay-200 font-display text-5xl lg:text-7xl italic leading-[1.05] text-charcoal mb-7">
                    {{ $procedure['h1'] }}
                </h1>
                <p class="animate-fade-up delay-300 text-muted text-lg leading-relaxed max-w-2xl mb-10">
                    {{ $procedure['hero_lead'] }}
                </p>
                <div class="animate-fade-up delay-400">
                    <a href="{{ $waProc }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-3 bg-rose text-white px-8 py-4 rounded-full font-medium text-sm tracking-wide hover:bg-deep-rose transition-all duration-300 shadow-lg shadow-rose/25 hover:shadow-rose/35 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Agendar avaliação
                    </a>
                </div>

                {{-- Facts strip --}}
                <div class="animate-fade-up delay-600 grid grid-cols-2 md:grid-cols-4 gap-px mt-14 bg-blush/30 border border-blush/30 rounded-2xl overflow-hidden">
                    @foreach ($procedure['facts'] as $fact)
                        <div class="bg-cream p-5 text-center">
                            <p class="text-[0.65rem] tracking-[0.18em] uppercase text-muted mb-1.5">{{ $fact['label'] }}</p>
                            <p class="font-display text-xl lg:text-2xl italic text-rose leading-tight">{{ $fact['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ======================================================
             WHAT IS
        ====================================================== --}}
        <section class="py-24 lg:py-32 bg-white">
            <div class="max-w-3xl mx-auto px-6 lg:px-8">
                <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Entenda o tratamento</p>
                <h2 class="font-display text-4xl lg:text-5xl italic text-charcoal leading-tight mb-6">
                    {{ $procedure['what_is_title'] }}
                </h2>
                <div class="w-12 h-px bg-gold mb-8"></div>
                @foreach ($procedure['what_is'] as $paragraph)
                    <p class="text-muted leading-relaxed mb-5 text-[1.02rem]">{{ $paragraph }}</p>
                @endforeach
            </div>
        </section>

        {{-- ======================================================
             BENEFITS
        ====================================================== --}}
        <section class="py-24 lg:py-32 bg-cream relative overflow-hidden">
            <div class="absolute top-0 left-0 w-96 h-96 rounded-full bg-blush/10 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            <div class="max-w-5xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Por que fazer</p>
                    <h2 class="font-display text-4xl lg:text-5xl italic text-charcoal leading-tight">
                        Os benefícios para você
                    </h2>
                    <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach ($procedure['benefits'] as $benefit)
                        <div class="flex gap-5 bg-white border border-blush/30 rounded-2xl p-7 hover:border-rose/30 hover:shadow-lg hover:shadow-rose/5 transition-all duration-300">
                            <div class="shrink-0 w-10 h-10 rounded-full bg-rose/10 flex items-center justify-center mt-0.5">
                                <svg class="w-5 h-5 text-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-display text-xl italic text-charcoal mb-1.5">{{ $benefit['title'] }}</h3>
                                <p class="text-muted text-sm leading-relaxed">{{ $benefit['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ======================================================
             HOW IT WORKS
        ====================================================== --}}
        <section class="py-24 lg:py-32 bg-charcoal relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none opacity-[0.04]"
                 style="background-image: radial-gradient(circle, #E8B4B8 1px, transparent 1px); background-size: 32px 32px;"></div>
            <div class="max-w-4xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Passo a passo</p>
                    <h2 class="font-display text-4xl lg:text-5xl italic text-cream leading-tight">
                        Como funciona
                    </h2>
                    <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($procedure['steps'] as $i => $step)
                        <div class="relative bg-white/[0.03] border border-white/10 rounded-2xl p-7 hover:border-gold/25 transition-colors duration-300">
                            <span class="font-display text-5xl italic text-rose/60 leading-none">0{{ $i + 1 }}</span>
                            <h3 class="font-display text-xl italic text-cream mt-4 mb-2">{{ $step['title'] }}</h3>
                            <p class="text-muted text-sm leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ======================================================
             FAQ
        ====================================================== --}}
        <section class="py-24 lg:py-32 bg-cream relative overflow-hidden">
            <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full bg-blush/10 translate-x-1/2 translate-y-1/2 pointer-events-none"></div>
            <div class="max-w-3xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center mb-14">
                    <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Perguntas frequentes</p>
                    <h2 class="font-display text-4xl lg:text-5xl italic text-charcoal leading-tight">
                        {{ $procedure['name'] }}: o que você precisa saber
                    </h2>
                    <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                </div>
                <div class="space-y-3">
                    @foreach ($procedure['faq'] as $item)
                        <details class="group bg-white border border-blush/30 rounded-2xl overflow-hidden hover:border-rose/30 transition-colors duration-300">
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

        {{-- ======================================================
             RELATED PROCEDURES
        ====================================================== --}}
        <section class="py-24 lg:py-32 bg-white">
            <div class="max-w-6xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-14">
                    <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Conheça também</p>
                    <h2 class="font-display text-4xl lg:text-5xl italic text-charcoal leading-tight">
                        Outros tratamentos
                    </h2>
                    <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($others as $otherSlug => $other)
                        <a href="{{ route('procedure', $otherSlug) }}"
                           class="group relative bg-cream border border-blush/30 rounded-2xl p-7 hover:border-rose/30 hover:shadow-xl hover:shadow-rose/5 transition-all duration-500 hover:-translate-y-1.5">
                            <div class="w-8 h-px bg-gold mb-5"></div>
                            <h3 class="font-display text-xl italic text-charcoal mb-2 leading-tight">{{ $other['name'] }}</h3>
                            <p class="text-muted text-sm leading-relaxed">{{ $other['card_desc'] }}</p>
                            <div class="mt-5 flex items-center gap-1.5 text-rose text-sm font-medium opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-x-2 group-hover:translate-x-0">
                                <span>Saiba mais</span>
                                <span>→</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ======================================================
             FINAL CTA
        ====================================================== --}}
        <section class="py-24 lg:py-36 bg-deep-rose relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-white/5 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-black/10 -translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

            <div class="max-w-3xl mx-auto px-6 lg:px-8 text-center relative z-10">
                <p class="text-xs tracking-[0.25em] uppercase text-blush font-medium mb-6">Dê o primeiro passo</p>
                <h2 class="font-display text-4xl lg:text-6xl italic text-white leading-tight mb-8">
                    Vamos conversar sobre {{ $procedure['name'] }}?
                </h2>
                <p class="text-white/65 text-lg mb-12 leading-relaxed max-w-xl mx-auto">
                    Agende uma avaliação sem compromisso com a Dra. Emily Beatriz em Belo Horizonte e descubra o que esse tratamento pode fazer por você.
                </p>
                <a href="{{ $waProc }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-3 bg-white text-deep-rose px-10 py-5 rounded-full font-semibold text-sm tracking-wide hover:bg-cream transition-all duration-300 shadow-2xl hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Agendar pelo WhatsApp
                </a>
                <p class="text-white/40 text-xs mt-6 tracking-widest uppercase">Dra. Emily Beatriz · CRO-{{ $cro }} · Belo Horizonte, MG</p>
            </div>
        </section>
    </main>
</x-site-layout>
