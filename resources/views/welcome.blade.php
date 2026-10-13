@php
    $waHero      = \App\Support\WhatsApp::url('Olá! Conheci a Dra. Emily pelo site e gostaria de agendar uma consulta.');
    $waResultados = \App\Support\WhatsApp::url('Olá! Vi os antes e depois no site e quero saber como me transformar assim.');
    $waContato   = \App\Support\WhatsApp::url('Olá! Decidi me colocar em primeiro lugar e gostaria de agendar uma conversa sem compromisso com a Dra. Emily.');
    $featuredResults = collect(config('results'))->where('featured', true)->values();
    $resultProcedures = collect(config('procedures'))->only(collect(config('results'))->pluck('procedure')->unique());
    $cro         = config('clinic.cro');
    $instagram   = config('clinic.instagram');
    $instagramUrl = 'https://www.instagram.com/' . $instagram . '/';
    $domain      = config('clinic.domain');
    $siteUrl     = 'https://' . $domain;
    $phone       = '+' . config('clinic.whatsapp');
@endphp

<x-site-layout
    title="Dra. Emily Beatriz | Harmonização Facial, Toxina Botulínica e Preenchimento em BH"
    description="Harmonização facial, toxina botulínica e preenchimento labial em BH com a Dra. Emily Beatriz. Resultados naturais e personalizados. Agende pelo WhatsApp!"
    canonical="{{ $siteUrl }}/"
    og-title="Dra. Emily Beatriz | Harmonização Facial, Toxina Botulínica e Preenchimento em BH"
    og-description="Especialista em harmonização facial, toxina botulínica e preenchimento labial em Belo Horizonte, MG. Resultados naturais que revelam a melhor versão de você."
    :nav-base="''"
    whatsapp-origin="pela página inicial do site">

    <x-slot:schema>
        @include('partials.schema')
    </x-slot:schema>

    <main>
        {{-- ======================================================
             HERO
        ====================================================== --}}
        <section class="min-h-screen pt-20 flex items-center relative overflow-hidden bg-cream">
            {{-- Decorative blush orb --}}
            <div class="absolute right-0 top-0 w-[55vw] h-[55vw] max-w-3xl rounded-full bg-blush/20 translate-x-1/3 -translate-y-1/4 pointer-events-none"></div>
            <div class="absolute left-1/3 bottom-0 w-64 h-64 rounded-full bg-rose/5 translate-y-1/2 pointer-events-none"></div>
            {{-- Subtle grid texture --}}
            <div class="absolute inset-0 pointer-events-none opacity-[0.015]"
                 style="background-image: repeating-linear-gradient(0deg, #2A1F1F 0px, transparent 1px, transparent 80px), repeating-linear-gradient(90deg, #2A1F1F 0px, transparent 1px, transparent 80px);"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-center w-full">

                {{-- Text content --}}
                <div class="relative z-10">
                    <p class="animate-fade-up delay-100 text-xs tracking-[0.25em] uppercase text-rose font-medium mb-6">
                        Santa Rosa, Pampulha&nbsp;&nbsp;·&nbsp;&nbsp;Belo Horizonte, MG
                    </p>

                    <h1 class="animate-fade-up delay-200 font-display text-6xl lg:text-7xl xl:text-[5.5rem] italic leading-[1.04] text-charcoal mb-8">
                        Sinta-se bem<br>
                        cada vez que<br>
                        <span class="text-rose font-light">se olhar no espelho.</span>
                    </h1>

                    <p class="animate-fade-up delay-300 text-muted text-lg leading-relaxed mb-10 max-w-md">
                        Dra. Emily Beatriz ajuda você a redescobrir sua confiança. Cada tratamento é pensado para revelar o melhor de você — de forma natural, suave e completamente personalizada.
                    </p>

                    <div class="animate-fade-up delay-400 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <a href="{{ $waHero }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-3 bg-rose text-white px-8 py-4 rounded-full font-medium text-sm tracking-wide hover:bg-deep-rose transition-all duration-300 shadow-lg shadow-rose/25 hover:shadow-rose/35 hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Agendar Consulta
                        </a>
                        <a href="#antes-depois" class="flex items-center gap-2 text-charcoal text-sm font-medium px-2 py-4 hover:text-rose transition-colors group">
                            Veja resultados reais
                            <span class="transition-transform duration-300 group-hover:translate-y-0.5 inline-block">↓</span>
                        </a>
                    </div>

                    {{-- Trust badges --}}
                    <div class="animate-fade-up delay-600 flex items-center gap-6 mt-12 pt-8 border-t border-blush/40">
                        <div class="text-center">
                            <p class="font-display text-3xl italic text-rose">+{{ config('clinic.years_experience') }}</p>
                            <p class="text-xs text-muted tracking-wide mt-0.5">anos cuidando de você</p>
                        </div>
                        <div class="w-px h-10 bg-blush/50"></div>
                        <div class="text-center">
                            <p class="font-display text-3xl italic text-rose">100%</p>
                            <p class="text-xs text-muted tracking-wide mt-0.5">resultados naturais</p>
                        </div>
                        <div class="w-px h-10 bg-blush/50"></div>
                        <div class="text-center">
                            <p class="font-display text-3xl italic text-rose">BH</p>
                            <p class="text-xs text-muted tracking-wide mt-0.5">Minas Gerais</p>
                        </div>
                    </div>
                </div>

                {{-- Photo --}}
                <div class="animate-scale-in delay-300 relative flex justify-center lg:justify-end">
                    <div class="relative">
                        {{-- Offset decorative frame --}}
                        <div class="absolute -top-5 -left-5 w-full h-full rounded-3xl border border-blush/50 pointer-events-none"></div>
                        {{-- Gold accent lines --}}
                        <div class="absolute -right-8 top-1/4 w-px h-20 bg-gold/50 pointer-events-none"></div>
                        <div class="absolute -right-10 top-1/4 w-px h-12 bg-blush/40 pointer-events-none"></div>

                        {{-- Photo --}}
                        <div class="relative w-72 sm:w-80 lg:w-96 xl:w-[420px] aspect-[3/4] rounded-3xl overflow-hidden bg-gradient-to-br from-blush/40 to-rose/10 shadow-2xl shadow-rose/10">
                            <x-picture src="foto-emily.jpg"
                                       alt="Dra. Emily Beatriz — Especialista em Harmonização Facial, Toxina Botulínica e Preenchimento em Belo Horizonte MG"
                                       width="1400"
                                       height="2100"
                                       loading="eager"
                                       fetchpriority="high"
                                       sizes="(min-width: 1280px) 420px, (min-width: 1024px) 384px, (min-width: 640px) 320px, 288px"
                                       class="w-full h-full object-cover object-top" />
                        </div>

                        {{-- Floating credential badge --}}
                        <div class="absolute -bottom-4 -left-4 bg-white border border-blush/40 shadow-xl shadow-rose/10 rounded-2xl p-4 backdrop-blur-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-rose/10 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-charcoal leading-tight">Cirurgiã-Dentista</p>
                                    <p class="text-xs text-muted">CRO-{{ $cro }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================
             BEFORE & AFTER
        ====================================================== --}}
        <x-results-gallery id="antes-depois"
                           :cases="$featuredResults"
                           :cta-url="$waResultados"
                           eyebrow="Histórias reais de transformação"
                           heading="Veja o que muda quando<br class='hidden sm:block'> você se coloca em primeiro lugar"
                           lead="Resultados reais de pacientes reais que decidiram investir em si mesmos.">
            <nav aria-label="Resultados por procedimento" class="flex gap-2 overflow-x-auto md:flex-wrap md:justify-center px-6 mb-8 lg:mb-12 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach ($resultProcedures as $resultSlug => $resultProcedure)
                    <a href="{{ route('procedure', $resultSlug) }}#resultados"
                       class="shrink-0 text-xs text-cream/80 hover:text-white border border-white/15 hover:border-gold/50 rounded-full px-4 py-2 transition-colors duration-300">{{ $resultProcedure['name'] }}</a>
                @endforeach
            </nav>
        </x-results-gallery>

        {{-- ======================================================
             ABOUT
        ====================================================== --}}
        <section id="sobre" class="py-28 lg:py-36 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                    {{-- Photo --}}
                    <div class="relative order-2 lg:order-1">
                        <div class="absolute inset-0 -translate-x-4 translate-y-4 rounded-3xl bg-blush/20 pointer-events-none"></div>
                        <div class="relative w-full aspect-[4/5] rounded-3xl overflow-hidden bg-gradient-to-br from-blush/30 to-rose/5 shadow-xl shadow-rose/5">
                            <x-picture src="foto-emily-2.jpg"
                                       sizes="(min-width: 1024px) 480px, 100vw"
                                       alt="Dra. Emily Beatriz — Harmonização Facial e Estética em Belo Horizonte"
                                       width="1400"
                                       height="2100"
                                       loading="lazy"
                                       class="w-full h-full object-cover object-top" />
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="order-1 lg:order-2">
                        <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Quem é a Dra. Emily</p>
                        <h2 class="font-display text-5xl lg:text-6xl italic text-charcoal leading-tight mb-6">
                            Uma parceira na sua jornada de autoconfiança
                        </h2>
                        <div class="w-12 h-px bg-gold mb-8"></div>
                        <p class="text-muted leading-relaxed mb-4 text-[0.97rem]">
                            Dra. Emily acredita que toda mulher merece se sentir bem com o que vê no espelho. Por isso, ela não trata rostos — ela escuta histórias, entende desejos e constrói transformações que fazem sentido para cada pessoa.
                        </p>
                        <p class="text-muted leading-relaxed mb-8 text-[0.97rem]">
                            Com mais de {{ config('clinic.years_experience') }} anos de experiência e um olhar delicado, ela cria resultados que parecem sempre naturais — porque o objetivo nunca é mudar quem você é, mas revelar a melhor versão de você mesma.
                        </p>
                        {{-- Values --}}
                        <div class="flex flex-wrap gap-2">
                            @foreach (['Escuta ativa', 'Resultado natural', 'Atendimento personalizado', 'Segurança em primeiro lugar', 'CRO-' . $cro] as $value)
                                <span class="text-xs font-medium tracking-wide text-rose border border-blush/60 px-3.5 py-1.5 rounded-full bg-rose/5">
                                    {{ $value }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================
             PROCEDURES
        ====================================================== --}}
        <section id="procedimentos" class="py-28 lg:py-36 bg-cream relative overflow-hidden">
            <div class="absolute top-0 left-0 w-96 h-96 rounded-full bg-blush/10 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16 lg:mb-20">
                    <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">O que podemos fazer por você</p>
                    <h2 class="font-display text-5xl lg:text-6xl italic text-charcoal leading-tight">
                        Tratamentos que revelam<br class="hidden sm:block"> a sua melhor versão
                    </h2>
                    <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                    <p class="text-muted mt-5 text-[0.97rem] max-w-xl mx-auto leading-relaxed">
                        Conheça em detalhes cada procedimento realizado pela Dra. Emily Beatriz em Belo Horizonte.
                    </p>
                </div>

                @php
                    $procedures   = collect(config('procedures'));
                    $featured     = $procedures->firstWhere('featured', true);
                    $featuredSlug = $procedures->search(fn ($p) => ($p['featured'] ?? false) === true);
                    $regular      = $procedures->reject(fn ($p) => ($p['featured'] ?? false) === true);
                    $leadSlug     = $regular->keys()->first();
                    $lead         = $regular->first();
                    $leadIncludes = $procedures->only($lead['includes'] ?? [])->pluck('name');
                    $others       = $regular->except($leadSlug);
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    {{-- Lead procedure (Harmonização Facial) --}}
                    <a href="{{ route('procedure', $leadSlug) }}"
                       class="group relative flex flex-col md:col-span-2 overflow-hidden rounded-2xl border border-rose/20 bg-gradient-to-br from-blush/25 via-white to-white p-8 lg:p-10 hover:border-rose/40 hover:shadow-xl hover:shadow-rose/10 transition-all duration-500 hover:-translate-y-1">
                        <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full bg-blush/25 blur-2xl pointer-events-none group-hover:bg-blush/40 transition-colors duration-700"></div>

                        <div class="relative flex items-center gap-3 mb-8">
                            <span class="font-display italic text-xl text-rose leading-none">{{ $lead['num'] }}</span>
                            <span class="h-px flex-1 bg-gold/50"></span>
                            <span class="text-[0.65rem] tracking-[0.22em] uppercase text-rose font-semibold">{{ $lead['eyebrow'] }}</span>
                        </div>

                        <h3 class="relative font-display text-4xl lg:text-5xl italic text-charcoal leading-[1.05] mb-4">
                            {{ $lead['name'] }}
                        </h3>
                        <p class="relative text-muted leading-relaxed max-w-md text-[0.97rem]">{{ $lead['card_desc'] }}</p>

                        @if ($leadIncludes->isNotEmpty())
                            <div class="relative flex flex-wrap items-center gap-2 mt-6">
                                <span class="text-xs text-muted mr-1">Pode combinar</span>
                                @foreach ($leadIncludes as $includedName)
                                    <span class="text-xs text-charcoal/80 border border-blush/60 bg-white/70 px-3 py-1 rounded-full">{{ $includedName }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="relative mt-auto pt-8">
                            <span class="inline-flex items-center gap-2.5 bg-rose text-white px-6 py-3 rounded-full font-medium text-sm tracking-wide group-hover:bg-deep-rose transition-colors duration-300">
                                Conhecer a harmonização
                                <span class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span>
                            </span>
                        </div>
                    </a>

                    {{-- Other procedures --}}
                    @foreach ($others as $slug => $proc)
                        <a href="{{ route('procedure', $slug) }}"
                           class="group flex flex-col bg-white border border-blush/30 rounded-2xl p-7 lg:p-8 hover:border-rose/30 hover:shadow-xl hover:shadow-rose/5 transition-all duration-500 hover:-translate-y-1">
                            <div class="flex items-center gap-3 mb-7">
                                <span class="font-display italic text-xl text-rose leading-none">{{ $proc['num'] }}</span>
                                <span class="h-px flex-1 bg-blush/50 group-hover:bg-gold/60 transition-colors duration-500"></span>
                            </div>
                            <h3 class="font-display text-[1.7rem] italic text-charcoal leading-tight mb-3">
                                {{ $proc['name'] }}
                            </h3>
                            <p class="text-muted text-sm leading-relaxed">{{ $proc['card_desc'] }}</p>
                            <div class="mt-auto pt-7 flex items-center justify-between">
                                <span class="text-sm font-medium text-rose">Saiba mais</span>
                                <span class="w-9 h-9 rounded-full border border-blush/60 flex items-center justify-center text-rose text-sm group-hover:bg-rose group-hover:border-rose group-hover:text-white transition-colors duration-300" aria-hidden="true">→</span>
                            </div>
                        </a>
                    @endforeach
                </div>

            {{-- Featured procedure (Full Face) --}}
            @if ($featured)
                <a href="{{ route('procedure', $featuredSlug) }}"
                   class="group relative block overflow-hidden rounded-3xl bg-charcoal mt-5 hover:-translate-y-1 transition-transform duration-500">
                    {{-- texture + glow --}}
                    <div class="absolute inset-0 pointer-events-none opacity-[0.05]"
                         style="background-image: radial-gradient(circle, #E8B4B8 1px, transparent 1px); background-size: 30px 30px;"></div>
                    <div class="absolute -right-16 -top-16 w-72 h-72 rounded-full bg-rose/20 blur-2xl pointer-events-none group-hover:bg-rose/30 transition-colors duration-700"></div>
                    <div class="absolute right-1/3 -bottom-20 w-64 h-64 rounded-full bg-gold/10 blur-2xl pointer-events-none"></div>

                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-[1.3fr_1fr] gap-8 p-10 lg:p-14 items-center">
                        <div>
                            <div class="flex items-center gap-3 mb-5">
                                <span class="text-[0.65rem] tracking-[0.22em] uppercase text-charcoal font-semibold bg-gold px-3 py-1 rounded-full">
                                    Destaque
                                </span>
                                <span class="text-xs tracking-[0.22em] uppercase text-blush">{{ $featured['card_tagline'] ?? '' }}</span>
                            </div>
                            <h3 class="font-display text-4xl lg:text-6xl italic text-cream leading-[1.05] mb-4">
                                {{ $featured['name'] }}
                            </h3>
                            <p class="text-cream/55 leading-relaxed max-w-lg mb-8 text-[1.02rem]">
                                {{ $featured['card_desc'] }}
                            </p>
                            <span class="inline-flex items-center gap-2.5 bg-rose text-white px-7 py-3.5 rounded-full font-medium text-sm tracking-wide group-hover:bg-deep-rose transition-colors duration-300">
                                Conhecer o Full Face
                                <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                            </span>
                        </div>
                        {{-- decorative three-thirds motif --}}
                        <div class="hidden lg:flex flex-col gap-3" aria-hidden="true">
                            @foreach (['Terço Superior', 'Terço Médio', 'Terço Inferior'] as $third)
                                <div class="flex items-center gap-4 border border-white/10 rounded-2xl px-6 py-4 group-hover:border-gold/30 transition-colors duration-500">
                                    <div class="w-2 h-2 rounded-full bg-gold shrink-0"></div>
                                    <span class="font-display text-xl italic text-cream/90">{{ $third }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </a>
            @endif
            </div>
        </section>

        {{-- ======================================================
             TESTIMONIALS
        ====================================================== --}}
        <section class="py-28 lg:py-36 bg-white relative overflow-hidden">
            <div class="absolute right-0 top-0 w-72 h-72 rounded-full bg-blush/10 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16 lg:mb-20">
                    <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Quem já viveu essa experiência</p>
                    <h2 class="font-display text-5xl lg:text-6xl italic text-charcoal leading-tight">
                        Palavras de quem se olhou<br>no espelho e se apaixonou
                    </h2>
                    <div class="w-12 h-px bg-gold mx-auto mt-6"></div>

                    <div class="flex items-center justify-center gap-2.5 mt-6">
                        <div class="flex gap-0.5" aria-hidden="true">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-charcoal font-medium">5,0</span>
                        <span class="text-muted text-sm">·</span>
                        <span class="text-muted text-sm tracking-wide">14 avaliações no Google</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
                    @foreach ([
                        [
                            'Fui e sou paciente dela. Excelente profissional, trabalha muito bem. A gente sente quando alguém ama o que faz, e a Dra. Emily é essa pessoa. Fiz bioestimulador de colágeno, preenchimento labial e outros procedimentos com toxina botulínica! Meu rosto ficou mais harmônico e minha pele melhorou uns 90%. Enfim, amei os resultados.',
                            'Carine Andrade', 'Avaliação no Google',
                        ],
                        [
                            'Sem palavras para o resultado! Fiz toxina botulínica e preenchimento labial e fiquei simplesmente apaixonada. Atendimento impecável, muito cuidado em cada detalhe, super profissional e me deixou segura o tempo todo. O resultado ficou natural, elegante e valorizou muito minha autoestima. Indico de olhos fechados, uma profissional maravilhosa!',
                            'Dabila Araújo', 'Avaliação no Google',
                        ],
                        [
                            'Profissional impecável, com cuidado no pré e no pós-procedimento. Estou muito satisfeita com o meu resultado.',
                            'Viviane Fernandes', 'Avaliação no Google',
                        ],
                        [
                            'Trabalho impecável! Valorizou cada detalhe do meu rosto, mantendo a naturalidade. Sem contar a qualidade do atendimento. Dra. Emily muito prestativa e cuidadosa. Super recomendo!',
                            'Ana Carolina', 'Avaliação no Google',
                        ],
                        [
                            'Trabalho impecável! Dra. Emily é um amor de pessoa, me senti à vontade durante todo o atendimento, sem falar do procedimento, que ficou um arraso. Já estou ansiosa para voltar, indico de olhos fechados!',
                            'Luana Castilho', 'Avaliação no Google',
                        ],
                        [
                            'Fiz 3 procedimentos com a Dra. Emily, ela foi muito atenciosa, paciente e profissional. Gostei demais da experiência.',
                            'Jeh Marques', 'Avaliação no Google',
                        ],
                    ] as [$quote, $name, $city])
                        <div class="relative bg-cream border border-blush/40 rounded-2xl p-8 hover:border-rose/30 hover:shadow-lg hover:shadow-rose/5 transition-all duration-300">
                            <div class="flex gap-0.5 mb-5">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <div class="font-display text-7xl text-blush/40 leading-none -mt-3 mb-1 select-none" aria-hidden="true">"</div>
                            <p class="font-display text-[1.2rem] italic text-charcoal leading-relaxed mb-6">
                                {{ $quote }}
                            </p>
                            <div class="border-t border-blush/40 pt-4">
                                <p class="font-semibold text-charcoal text-sm">{{ $name }}</p>
                                <p class="text-muted text-xs tracking-wide mt-0.5">{{ $city }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ======================================================
             FAQ
        ====================================================== --}}
        <section id="faq" class="py-28 lg:py-36 bg-cream relative overflow-hidden">
            <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full bg-blush/10 translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

            <div class="max-w-3xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center mb-14">
                    <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Tudo o que você quer saber</p>
                    <h2 class="font-display text-5xl lg:text-6xl italic text-charcoal leading-tight">
                        Perguntas frequentes
                    </h2>
                    <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                </div>

                <div class="space-y-3">
                    {{-- Fonte única: config/faq.php. O mesmo array alimenta o JSON-LD FAQPage. --}}
                    @foreach (config('faq.home') as ['q' => $question, 'a' => $answer])
                        <details class="group bg-white border border-blush/30 rounded-2xl overflow-hidden hover:border-rose/30 transition-colors duration-300">
                            <summary class="flex items-center justify-between gap-4 px-7 py-5 cursor-pointer list-none select-none">
                                <span class="font-display text-xl italic text-charcoal leading-snug group-open:text-rose transition-colors duration-300">
                                    {{ $question }}
                                </span>
                                <span class="shrink-0 w-7 h-7 rounded-full border border-blush/50 flex items-center justify-center text-rose group-open:bg-rose group-open:border-rose group-open:text-white transition-all duration-300">
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300 group-open:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </span>
                            </summary>
                            <div class="px-7 pb-6 pt-1">
                                <div class="w-full h-px bg-blush/30 mb-4"></div>
                                <p class="text-muted leading-relaxed text-[0.96rem]">{{ $answer }}</p>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ======================================================
             FINAL CTA
        ====================================================== --}}
        <section class="py-28 lg:py-40 bg-deep-rose relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-white/5 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-black/10 -translate-x-1/2 translate-y-1/2 pointer-events-none"></div>
            <div class="absolute inset-0 pointer-events-none opacity-5"
                 style="background-image: repeating-linear-gradient(45deg, #FAF6F2 0px, transparent 1px, transparent 40px, #FAF6F2 41px);"></div>

            <div class="max-w-3xl mx-auto px-6 lg:px-8 text-center relative z-10">
                <p class="text-xs tracking-[0.25em] uppercase text-blush font-medium mb-6">Você merece se sentir assim</p>
                <h2 class="font-display text-5xl lg:text-6xl xl:text-7xl italic text-white leading-tight mb-8">
                    E se hoje fosse o dia em que você decidiu se colocar em primeiro lugar?
                </h2>
                <p class="text-white/65 text-lg mb-12 leading-relaxed max-w-xl mx-auto">
                    Uma conversa sem compromisso para entender o que você deseja, o que você sente e o que podemos construir juntas. Estamos aqui para isso.
                </p>
                <a href="{{ $waContato }}"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-3 bg-white text-deep-rose px-10 py-5 rounded-full font-semibold text-sm tracking-wide hover:bg-cream transition-all duration-300 shadow-2xl hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Agendar pelo WhatsApp
                </a>
                <p class="text-white/40 text-xs mt-6 tracking-widest uppercase">Sua jornada começa com uma conversa · Belo Horizonte, MG</p>
            </div>
        </section>
        @include('partials.medical-disclaimer')

    </main>
</x-site-layout>
