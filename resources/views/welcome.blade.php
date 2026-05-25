<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php
            $wa = 'https://wa.me/' . config('clinic.whatsapp');
            $waConsulta = $wa . '?text=Ol%C3%A1%21%20Gostaria%20de%20agendar%20uma%20consulta%20com%20a%20Dra.%20Emily.';
            $waTransformar = $wa . '?text=Ol%C3%A1%21%20Quero%20saber%20mais%20sobre%20como%20me%20transformar%20assim.';
            $cro = config('clinic.cro');
            $instagram = config('clinic.instagram');
            $instagramUrl = 'https://www.instagram.com/' . $instagram . '/';
        @endphp
        <title>Dra. Emily Beatriz — Sinta-se bem cada vez que se olhar no espelho</title>
        <meta name="description" content="Dra. Emily Beatriz ajuda você a descobrir a sua versão mais confiante em Belo Horizonte, MG. Transformações naturais que respeitam quem você é.">
        <link rel="icon" href="/favicon.ico" sizes="any">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-cream text-charcoal antialiased overflow-x-hidden">

        {{-- ======================================================
             NAV
        ====================================================== --}}
        <nav class="fixed top-0 inset-x-0 z-50 bg-cream/95 backdrop-blur-sm border-b border-blush/30">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between gap-8">

                {{-- Logo --}}
                <a href="#" class="font-display text-2xl italic text-charcoal tracking-tight shrink-0">
                    Dra. Emily Beatriz
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden lg:flex items-center gap-10">
                    <a href="#sobre" class="text-xs font-medium tracking-[0.2em] uppercase text-muted hover:text-rose transition-colors duration-200">Nossa História</a>
                    <a href="#procedimentos" class="text-xs font-medium tracking-[0.2em] uppercase text-muted hover:text-rose transition-colors duration-200">Transformações</a>
                    <a href="#antes-depois" class="text-xs font-medium tracking-[0.2em] uppercase text-muted hover:text-rose transition-colors duration-200">Resultados</a>
                    <a href="#contato" class="text-xs font-medium tracking-[0.2em] uppercase text-muted hover:text-rose transition-colors duration-200">Contato</a>
                </div>

                {{-- WhatsApp CTA --}}
                <a href="{{ $waConsulta }}"
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-2 bg-rose text-white text-xs font-medium tracking-wide px-5 py-2.5 rounded-full hover:bg-deep-rose transition-colors duration-300 shrink-0">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span class="hidden sm:inline">Agendar Consulta</span>
                    <span class="sm:hidden">WhatsApp</span>
                </a>
            </div>
        </nav>

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
                            Belo Horizonte, MG&nbsp;&nbsp;·&nbsp;&nbsp;Transformação com cuidado
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
                            <a href="{{ $waConsulta }}"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-3 bg-rose text-white px-8 py-4 rounded-full font-medium text-sm tracking-wide hover:bg-deep-rose transition-all duration-300 shadow-lg shadow-rose/25 hover:shadow-rose/35 hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Agendar Consulta
                            </a>
                            <a href="#procedimentos" class="flex items-center gap-2 text-charcoal text-sm font-medium px-2 py-4 hover:text-rose transition-colors group">
                                Veja o que podemos fazer por você
                                <span class="transition-transform duration-300 group-hover:translate-y-0.5 inline-block">↓</span>
                            </a>
                        </div>

                        {{-- Trust badges --}}
                        <div class="animate-fade-up delay-600 flex items-center gap-6 mt-12 pt-8 border-t border-blush/40">
                            <div class="text-center">
                                <p class="font-display text-3xl italic text-rose">+5</p>
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
                                <img src="/foto-emily.jpg"
                                     alt="Dra. Emily Beatriz — Especialista em Harmonização Facial em Belo Horizonte"
                                     class="w-full h-full object-cover object-top">
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
                 ABOUT
            ====================================================== --}}
            <section id="sobre" class="py-28 lg:py-36 bg-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                        {{-- Photo --}}
                        <div class="relative order-2 lg:order-1">
                            <div class="absolute inset-0 -translate-x-4 translate-y-4 rounded-3xl bg-blush/20 pointer-events-none"></div>
                            <div class="relative w-full aspect-[4/5] rounded-3xl overflow-hidden bg-gradient-to-br from-blush/30 to-rose/5 shadow-xl shadow-rose/5">
                                <img src="/foto-emily-2.jpg"
                                     alt="Dra. Emily Beatriz"
                                     class="w-full h-full object-cover object-top">
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
                                Com anos de experiência e um olhar delicado, ela cria resultados que parecem sempre naturais — porque o objetivo nunca é mudar quem você é, mas revelar a melhor versão de você mesma.
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
                            Cada tratamento é uma história<br class="hidden sm:block"> de reencontro com você mesma
                        </h2>
                        <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ([
                            ['Rosto Descansado', 'Aquele olhar leve e suave de quem dormiu muito bem. Menos tensão, mais você — sem ninguém perceber o que mudou, só sentir.', '01'],
                            ['Volume & Harmonia', 'Lábios mais cheios, bochechas com vida, contornos que equilibram. O tipo de mudança que faz você se apaixonar pelo próprio reflexo.', '02'],
                            ['Pele que Brilha', 'Uma pele mais firme, mais luminosa, mais jovem — não porque mudou, mas porque floresceu. O brilho que vem de dentro para fora.', '03'],
                            ['Contorno Elegante', 'Um rosto mais afinado e definido. Uma transformação pequena com impacto enorme na sua autoestima e na forma como o mundo te vê.', '04'],
                            ['Firmeza Natural', 'A sensação de levantar o rosto sem que ninguém saiba o segredo. Sustentação e juventude de forma absolutamente discreta.', '05'],
                            ['Você, Reinventada', 'Uma análise completa do seu rosto, dos seus desejos e da sua essência. Uma transformação construída só para você — do jeito que só você merece.', '06'],
                        ] as [$name, $desc, $num])
                            <div class="group relative bg-white border border-blush/30 rounded-2xl p-8 hover:border-rose/30 hover:shadow-xl hover:shadow-rose/5 transition-all duration-500 hover:-translate-y-1.5 cursor-default">
                                <span class="absolute top-5 right-6 font-display text-7xl italic text-blush/30 leading-none select-none group-hover:text-rose/15 transition-colors duration-500">
                                    {{ $num }}
                                </span>
                                <div class="w-8 h-px bg-gold mb-6"></div>
                                <h3 class="font-display text-2xl italic text-charcoal mb-3 leading-tight pr-8">
                                    {{ $name }}
                                </h3>
                                <p class="text-muted text-sm leading-relaxed">{{ $desc }}</p>
                                <div class="mt-6 flex items-center gap-1.5 text-rose text-sm font-medium opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-x-2 group-hover:translate-x-0">
                                    <span>Quero isso para mim</span>
                                    <span>→</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- ======================================================
                 BEFORE & AFTER
            ====================================================== --}}
            <section id="antes-depois" class="py-28 lg:py-36 bg-charcoal relative overflow-hidden">
                <div class="absolute inset-0 pointer-events-none opacity-[0.04]"
                     style="background-image: radial-gradient(circle, #E8B4B8 1px, transparent 1px); background-size: 32px 32px;"></div>

                <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                    <div class="text-center mb-16 lg:mb-20">
                        <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Histórias reais de transformação</p>
                        <h2 class="font-display text-5xl lg:text-6xl italic text-cream leading-tight">
                            Veja o que muda quando<br>você se coloca em primeiro lugar
                        </h2>
                        <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                        <p class="text-muted mt-4 text-sm max-w-sm mx-auto leading-relaxed">
                            Resultados reais de mulheres reais que decidiram investir em si mesmas.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ([
                            ['O olhar que encanta', '1'],
                            ['Lábios que contam histórias', '2'],
                            ['A confiança que você merecia', '3'],
                        ] as [$procedure, $n])
                            <div class="group relative rounded-2xl overflow-hidden border border-white/5 hover:border-gold/25 transition-all duration-500 hover:-translate-y-1.5">
                                {{-- Before / After split --}}
                                <div class="flex h-80 lg:h-[26rem]">
                                    {{-- Before --}}
                                    <div class="relative w-1/2 overflow-hidden bg-[#3A2A2A]">
                                        <img src="/antes-{{ $n }}.jpg"
                                             alt="Antes — {{ $procedure }}"
                                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700">
                                        <div class="absolute top-3 left-3 text-white text-[10px] font-medium tracking-[0.2em] uppercase bg-charcoal/70 backdrop-blur-sm px-2.5 py-1 rounded-full">
                                            Antes
                                        </div>
                                    </div>

                                    {{-- Gold divider --}}
                                    <div class="relative z-10 flex flex-col items-center justify-center" style="width: 2px; flex-shrink: 0;">
                                        <div class="w-full flex-1 bg-gold/40"></div>
                                        <div class="w-7 h-7 rounded-full bg-gold flex items-center justify-center shadow-lg flex-shrink-0 my-1">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h8M12 8v8"/>
                                            </svg>
                                        </div>
                                        <div class="w-full flex-1 bg-gold/40"></div>
                                    </div>

                                    {{-- After --}}
                                    <div class="relative w-1/2 overflow-hidden bg-[#2A1820]">
                                        <img src="/depois-{{ $n }}.jpg"
                                             alt="Depois — {{ $procedure }}"
                                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700">
                                        <div class="absolute top-3 right-3 text-white text-[10px] font-medium tracking-[0.2em] uppercase bg-rose/75 backdrop-blur-sm px-2.5 py-1 rounded-full">
                                            Depois
                                        </div>
                                    </div>
                                </div>

                                {{-- Caption --}}
                                <div class="bg-charcoal border-t border-white/5 p-5 flex items-center justify-between">
                                    <p class="font-display text-xl italic text-cream">{{ $procedure }}</p>
                                    <a href="{{ $waTransformar }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="text-xs text-rose hover:text-blush transition-colors font-medium tracking-wide">
                                        Quero isso →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <p class="text-center text-muted text-xs mt-10 tracking-wide leading-relaxed">
                        * Cada pessoa é única e os resultados variam. Imagens publicadas com autorização das pacientes.
                    </p>
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
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
                        @foreach ([
                            [
                                'A Dra. Emily transformou a minha autoestima. O resultado ficou absolutamente natural e eu me reconheço no espelho — só que melhor.',
                                'Ana C.', 'Belo Horizonte, MG',
                            ],
                            [
                                'Profissional incrível, atenciosa e muito competente. Fiz preenchimento labial e o resultado superou todas as minhas expectativas.',
                                'Juliana R.', 'Contagem, MG',
                            ],
                            [
                                'Tive medo de parecer artificial, mas a Dra. Emily me explicou tudo com paciência e o resultado foi perfeito. Recomendo de olhos fechados!',
                                'Mariana S.', 'Belo Horizonte, MG',
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
                    <a href="{{ $waConsulta }}"
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
        </main>

        {{-- ======================================================
             FOOTER
        ====================================================== --}}
        <footer id="contato" class="bg-charcoal text-cream">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-14">
                    {{-- Brand --}}
                    <div>
                        <a href="#" class="font-display text-3xl italic text-cream block mb-4">
                            Dra. Emily Beatriz
                        </a>
                        <p class="text-muted text-sm leading-relaxed max-w-xs">
                            Ajudando mulheres a se apaixonarem pelo próprio reflexo em Belo Horizonte, MG.
                        </p>
                    </div>

                    {{-- Navigation --}}
                    <div>
                        <p class="text-xs tracking-[0.2em] uppercase text-rose font-medium mb-5">Navegação</p>
                        <ul class="space-y-2.5">
                            <li><a href="#sobre" class="text-muted text-sm hover:text-cream transition-colors">Nossa História</a></li>
                            <li><a href="#procedimentos" class="text-muted text-sm hover:text-cream transition-colors">Transformações</a></li>
                            <li><a href="#antes-depois" class="text-muted text-sm hover:text-cream transition-colors">Resultados</a></li>
                            <li><a href="#contato" class="text-muted text-sm hover:text-cream transition-colors">Contato</a></li>
                        </ul>
                    </div>

                    {{-- Contact --}}
                    <div>
                        <p class="text-xs tracking-[0.2em] uppercase text-rose font-medium mb-5">Contato</p>
                        <div class="space-y-3.5">
                            <a href="{{ $wa }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-3 text-muted text-sm hover:text-cream transition-colors">
                                <svg class="w-4 h-4 shrink-0 text-rose" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                +55 (31) 98848-0396
                            </a>
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-3 text-muted text-sm hover:text-cream transition-colors">
                                <svg class="w-4 h-4 shrink-0 text-rose" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                @{{ $instagram }}
                            </a>
                            <p class="flex items-start gap-3 text-muted text-sm">
                                <svg class="w-4 h-4 shrink-0 text-rose mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Belo Horizonte, MG
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Bottom bar --}}
                <div class="border-t border-white/10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-muted text-xs">© {{ date('Y') }} Dra. Emily Beatriz. Todos os direitos reservados.</p>
                    <p class="text-muted text-xs tracking-wide">Registrada no CRO-{{ $cro }} &nbsp;·&nbsp; Belo Horizonte, MG</p>
                </div>
            </div>
        </footer>

    </body>
</html>
