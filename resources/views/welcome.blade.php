@php
    $waHero      = \App\Support\WhatsApp::url('Olá! Conheci a Dra. Emily pelo site e gostaria de agendar uma consulta.');
    $waResultados = \App\Support\WhatsApp::url('Olá! Vi os antes e depois no site e quero saber como me transformar assim.');
    $waContato   = \App\Support\WhatsApp::url('Olá! Decidi me colocar em primeiro lugar e gostaria de agendar uma conversa sem compromisso com a Dra. Emily.');
    $featuredResults = collect(config('results'))->where('featured', true)->values();
    $resultProcedures = collect(config('procedures'))->only(collect(config('results'))->pluck('procedure')->unique());
    $cro         = config('clinic.cro');
    $years       = config('clinic.years_experience');
    $instagram   = config('clinic.instagram');
    $instagramUrl = 'https://www.instagram.com/' . $instagram . '/';
    $domain      = config('clinic.domain');
    $siteUrl     = 'https://' . $domain;
    $phone       = '+' . config('clinic.whatsapp');

    $procedures   = collect(config('procedures'));
    $featured     = $procedures->firstWhere('featured', true);
    $featuredSlug = $procedures->search(fn ($p) => ($p['featured'] ?? false) === true);
    $regular      = $procedures->reject(fn ($p) => ($p['featured'] ?? false) === true || ($p['kind'] ?? null) === 'concern');
    $concerns     = $procedures->filter(fn ($p) => isset($p['concern']));

    $testimonials = [
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
    ];
    [$leadQuote, $leadName] = $testimonials[3];
    $otherTestimonials = collect($testimonials)->except(3);
@endphp

<x-site-layout
    title="Clínica de Harmonização Facial em BH | Dra. Emily Beatriz"
    description="Harmonização facial, toxina botulínica e preenchimento labial em BH com a Dra. Emily Beatriz. Resultados naturais e personalizados. Agende pelo WhatsApp!"
    canonical="{{ $siteUrl }}/"
    og-title="Clínica de Harmonização Facial em BH | Dra. Emily Beatriz"
    og-description="Especialista em harmonização facial, toxina botulínica e preenchimento labial em Belo Horizonte, MG. Resultados naturais que revelam a melhor versão de você."
    :nav-base="''"
    whatsapp-origin="pela página inicial do site">

    <x-slot:schema>
        @include('partials.schema')
    </x-slot:schema>

    <main>
        {{-- ======================================================
             HERO
             Texto à esquerda, foto sangrando até a borda direita e o fio
             do logo passando entre os dois.
        ====================================================== --}}
        <section class="relative bg-linen pt-18 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_minmax(0,42vw)] lg:min-h-[calc(100svh-4.5rem)]">

                <div class="relative z-10 flex flex-col justify-end px-5 lg:pr-0 lg:pl-[max(2rem,calc((100vw-80rem)/2+2rem))] pt-12 pb-12 lg:pt-20 lg:pb-24">
                    <h1 class="animate-fade-up text-sm text-ink-soft mb-7 leading-relaxed">
                        Clínica de harmonização facial em Belo Horizonte<span class="hidden sm:inline"> · </span><br class="sm:hidden">Santa Rosa, Pampulha
                    </h1>

                    <p class="animate-fade-up delay-100 font-display text-[clamp(3rem,7.4vw,6.6rem)] leading-[1.02] text-ink lg:-mr-[14%]">
                        Sinta-se bem cada vez que se <em class="text-clay">olhar</em> no espelho
                    </p>

                    <p class="animate-fade-up delay-200 text-ink-soft text-lg leading-relaxed mt-8 mb-10 max-w-[38ch]">
                        Dra. Emily Beatriz ajuda você a redescobrir sua confiança. Cada tratamento é pensado para o seu rosto: natural, suave e completamente personalizado.
                    </p>

                    <div class="animate-fade-up delay-300 flex flex-wrap items-center gap-x-8 gap-y-5">
                        <a href="{{ $waHero }}" target="_blank" rel="noopener noreferrer" class="btn">
                            <x-whatsapp-icon />
                            Agendar consulta
                        </a>
                        <a href="#antes-depois" class="thread-link text-ink hover:text-clay transition-colors">Ver resultados reais</a>
                    </div>
                </div>

                <x-thread class="hidden lg:block absolute z-20 left-[44%] top-[26%] w-[26%] pointer-events-none" />

                <figure class="relative">
                    <div class="aspect-[4/5] lg:aspect-auto lg:absolute lg:inset-0 bg-sand">
                        <x-picture src="foto-emily.jpg"
                                   alt="Dra. Emily Beatriz segurando uma seringa de ácido hialurônico, em estúdio"
                                   width="1400"
                                   height="2100"
                                   loading="eager"
                                   fetchpriority="high"
                                   sizes="(min-width: 1024px) 42vw, 100vw"
                                   class="w-full h-full object-cover object-[30%_top]" />
                    </div>
                    <figcaption class="px-5 py-4 lg:p-0 lg:absolute lg:left-0 lg:bottom-0 lg:bg-linen lg:pt-4 lg:pr-6 text-[0.8rem] text-ink-soft leading-relaxed">
                        <strong class="text-ink font-semibold">Dra. Emily Beatriz</strong><br>
                        Cirurgiã-dentista · CRO-{{ $cro }} · +{{ $years }} anos cuidando de rostos
                    </figcaption>
                </figure>
            </div>
        </section>

        {{-- ======================================================
             BEFORE & AFTER
        ====================================================== --}}
        <x-results-gallery id="antes-depois"
                           :cases="$featuredResults"
                           :cta-url="$waResultados"
                           heading="Veja o que muda quando você se coloca em <em>primeiro lugar</em>"
                           lead="Resultados reais de pacientes reais que decidiram investir em si mesmas.">
            <nav aria-label="Resultados por procedimento" class="flex gap-x-6 gap-y-2 overflow-x-auto md:flex-wrap px-5 lg:px-0 mb-10 lg:mb-14 text-sm [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <span class="shrink-0 text-linen/60">Ver por procedimento:</span>
                @foreach ($resultProcedures as $resultSlug => $resultProcedure)
                    <a href="{{ route('procedure', $resultSlug) }}#resultados"
                       class="shrink-0 text-linen underline decoration-ochre/60 underline-offset-4 hover:decoration-ochre transition-colors">{{ $resultProcedure['name'] }}</a>
                @endforeach
            </nav>
        </x-results-gallery>

        {{-- ======================================================
             ABOUT
        ====================================================== --}}
        <section id="sobre" class="bg-sand/45">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32 grid grid-cols-1 lg:grid-cols-[5fr_6fr] gap-14 lg:gap-24 items-center">
                <div class="aspect-[4/5] overflow-hidden bg-sand -mx-5 lg:mx-0">
                    <x-picture src="foto-emily-2.jpg"
                               sizes="(min-width: 1024px) 520px, 100vw"
                               alt="Dra. Emily Beatriz no consultório de harmonização facial em Belo Horizonte"
                               width="1400"
                               height="2100"
                               loading="lazy"
                               class="w-full h-full object-cover object-top" />
                </div>

                <div>
                    <h2 class="font-display text-[clamp(2.4rem,4.4vw,3.8rem)] leading-[1.05] text-ink mb-8">
                        Uma parceira na sua jornada de <em class="text-clay">autoconfiança</em>
                    </h2>
                    <div class="space-y-5 text-ink-soft leading-relaxed text-[1.05rem] max-w-[60ch]">
                        <p>
                            Dra. Emily acredita que toda mulher merece se sentir bem com o que vê no espelho. Por isso, ela não trata rostos: ela escuta histórias, entende desejos e constrói transformações que fazem sentido para cada pessoa.
                        </p>
                        <p>
                            Com mais de {{ $years }} anos de experiência e um olhar delicado, ela cria resultados que parecem sempre naturais, porque o objetivo nunca é mudar quem você é, mas revelar a melhor versão de você mesma.
                        </p>
                        <p>
                            Ela também atende homens, com um planejamento que preserva os traços masculinos. Conheça a <a href="{{ route('procedure', 'harmonizacao-facial-masculina') }}" class="thread-link text-ink hover:text-clay transition-colors">harmonização facial masculina</a>.
                        </p>
                    </div>
                    <x-thread class="w-40 h-auto my-10" />
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-3 text-ink">
                        @foreach (['Escuta ativa', 'Resultado natural', 'Atendimento personalizado', 'Segurança em primeiro lugar'] as $value)
                            <li class="flex items-baseline gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-ochre shrink-0 translate-y-[-2px]" aria-hidden="true"></span>
                                {{ $value }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        {{-- ======================================================
             CONCERNS
             Entrada pela queixa, com as palavras que o público usa na busca.
             Fonte: entradas de config/procedures.php com a chave "concern".
        ====================================================== --}}
        <section id="queixas" class="bg-linen">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-28 lg:pt-40">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-end mb-12 lg:mb-16">
                    <h2 class="font-display text-[clamp(2.4rem,4.6vw,4rem)] leading-[1.04] text-ink">
                        O que mais <em class="text-clay">incomoda</em> você?
                    </h2>
                    <p class="text-ink-soft leading-relaxed max-w-[44ch] lg:justify-self-end">
                        Comece pela sua queixa. Cada página explica a causa e os tratamentos que fazem sentido para ela.
                    </p>
                </div>

                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-10 border-t rule">
                    @foreach ($concerns as $concernSlug => $concernPage)
                        <li>
                            <a href="{{ route('procedure', $concernSlug) }}"
                               class="group flex h-full items-baseline justify-between gap-6 py-7 border-b rule">
                                <span>
                                    <span class="block font-display text-2xl lg:text-[1.75rem] leading-[1.15] text-ink group-hover:text-clay transition-colors duration-300">{{ $concernPage['concern']['label'] }}</span>
                                    <span class="block mt-2 text-ink-soft leading-relaxed">{{ $concernPage['concern']['desc'] }}</span>
                                </span>
                                <span class="text-clay transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- ======================================================
             PROCEDURES
             Índice em linhas: número, nome e descrição.
        ====================================================== --}}
        <section id="procedimentos" class="bg-linen">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-24 lg:pt-32 pb-24 lg:pb-32">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-end mb-14 lg:mb-20">
                    <h2 class="font-display text-[clamp(2.4rem,4.6vw,4rem)] leading-[1.04] text-ink">
                        Cada rosto pede um <em class="text-clay">plano</em> próprio
                    </h2>
                    <p class="text-ink-soft leading-relaxed max-w-[44ch] lg:justify-self-end">
                        Conheça em detalhes cada procedimento realizado pela Dra. Emily Beatriz em Belo Horizonte. As técnicas se combinam conforme a sua avaliação.
                    </p>
                </div>

                <ul class="border-t rule">
                    @foreach ($regular as $slug => $proc)
                        @php($includes = $procedures->only($proc['includes'] ?? [])->pluck('name'))
                        <li>
                            <a href="{{ route('procedure', $slug) }}"
                               class="group grid grid-cols-[2.75rem_1fr] md:grid-cols-[5rem_minmax(0,1fr)_minmax(0,1.1fr)_2rem] gap-x-4 md:gap-x-8 gap-y-2 items-baseline py-7 md:py-8 border-b rule transition-[padding] duration-500 ease-out-quint md:hover:pl-4">
                                <span class="font-display text-xl text-ochre">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="font-display text-[clamp(1.6rem,2.8vw,2.4rem)] leading-[1.1] text-ink group-hover:text-clay transition-colors duration-300">{{ $proc['name'] }}</span>
                                <span class="col-start-2 md:col-start-auto text-ink-soft leading-relaxed max-w-[48ch]">
                                    {{ $proc['card_desc'] }}
                                    @if ($includes->isNotEmpty())
                                        <span class="block mt-2 text-sm text-ink">Pode combinar {{ $includes->join(', ', ' e ') }}.</span>
                                    @endif
                                </span>
                                <span class="hidden md:block justify-self-end text-clay transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- ======================================================
             FULL FACE (destaque em argila)
        ====================================================== --}}
        @if ($featured)
            <section class="bg-clay text-linen">
                <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32 grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-14 lg:gap-20 items-center">
                    <div>
                        @if (! empty($featured['card_tagline']))
                            <p class="text-sm text-linen mb-6">{{ $featured['card_tagline'] }}</p>
                        @endif
                        <h2 class="font-display text-[clamp(3rem,7vw,6rem)] leading-[1.02]">
                            {{ $featured['name'] }}
                        </h2>
                        <p class="text-linen text-lg leading-relaxed max-w-[42ch] mt-7 mb-10">
                            {{ $featured['card_desc'] }}
                        </p>
                        <a href="{{ route('procedure', $featuredSlug) }}" class="btn btn-light">
                            Conhecer o Full Face
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                    <ul class="border-t border-linen/35" aria-label="Os três terços do rosto">
                        @foreach ([
                            ['Terço superior', 'Testa, glabela e um olhar descansado.'],
                            ['Terço médio', 'Maçãs do rosto, olheiras e sulcos.'],
                            ['Terço inferior', 'Lábios, mandíbula e queixo.'],
                        ] as [$third, $thirdDesc])
                            <li class="grid grid-cols-1 sm:grid-cols-[11rem_1fr] gap-x-6 gap-y-1 py-6 border-b border-linen/35">
                                <span class="font-display text-2xl">{{ $third }}</span>
                                <span class="text-linen sm:pt-1.5">{{ $thirdDesc }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif

        {{-- ======================================================
             TESTIMONIALS
        ====================================================== --}}
        <section class="bg-linen">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-28 lg:py-40 grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-16 lg:gap-20 items-start">
                <figure class="lg:sticky lg:top-32">
                    <h2 class="text-sm text-ink-soft mb-8">Palavras de quem se olhou no espelho e se apaixonou</h2>
                    <blockquote class="font-display text-[clamp(1.8rem,3vw,2.7rem)] leading-[1.18] text-ink max-w-[30ch]">
                        “{{ $leadQuote }}”
                    </blockquote>
                    <figcaption class="mt-8 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-ink-soft">
                        <span class="text-ink font-semibold">{{ $leadName }}</span>
                        <span aria-hidden="true">·</span>
                        <span class="flex items-center gap-2">
                            <span class="flex gap-0.5 text-ochre" aria-hidden="true">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </span>
                            5,0 no Google · 14 avaliações
                        </span>
                    </figcaption>
                </figure>

                <div class="lg:border-l rule lg:pl-10 border-t lg:border-t-0">
                    @foreach ($otherTestimonials as [$quote, $name, $source])
                        <figure class="py-7 lg:first:pt-0 border-b rule last:border-b-0">
                            <blockquote class="text-ink-soft leading-relaxed text-[0.97rem]">“{{ $quote }}”</blockquote>
                            <figcaption class="mt-3 text-sm text-ink font-semibold">{{ $name }} <span class="font-normal text-ink-soft">· {{ $source }}</span></figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ======================================================
             FAQ
        ====================================================== --}}
        <section id="faq" class="bg-sand/45">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32 grid grid-cols-1 lg:grid-cols-[1fr_1.6fr] gap-12 lg:gap-20 items-start">
                <div class="lg:sticky lg:top-32">
                    <h2 class="font-display text-[clamp(2.4rem,4.4vw,3.8rem)] leading-[1.05] text-ink">
                        Perguntas <em class="text-clay">frequentes</em>
                    </h2>
                    <p class="text-ink-soft leading-relaxed mt-6 max-w-[34ch]">
                        Ficou alguma dúvida? Pergunte direto para a Dra. Emily pelo WhatsApp.
                    </p>
                </div>

                {{-- Fonte única: config/faq.php. O mesmo array alimenta o JSON-LD FAQPage. --}}
                <x-faq-list :items="config('faq.home')" />
            </div>
        </section>

        <x-closing-cta :url="$waContato">
            <x-slot:heading>E se hoje fosse o dia de se colocar em <em>primeiro lugar</em>?</x-slot:heading>
            Uma conversa sem compromisso para entender o que você deseja, o que você sente e o que podemos construir juntas. Atendimento em Belo Horizonte, MG.
        </x-closing-cta>

        @include('partials.medical-disclaimer')

    </main>
</x-site-layout>
