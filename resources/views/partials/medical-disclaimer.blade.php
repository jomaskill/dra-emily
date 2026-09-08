{{--
    Aviso médico e data de revisão do conteúdo.
    Aceita $reviewed (Y-m-d) — sem ele, cai na data de revisão da home.
    Conteúdo de saúde precisa dizer que o resultado varia e quando foi revisto:
    é sinal de confiança tanto para leitores quanto para mecanismos de resposta.
--}}
@php
    $reviewed = $reviewed ?? config('clinic.content_updated');
    $reviewedLabel = $reviewed
        ? \Illuminate\Support\Carbon::parse($reviewed)->translatedFormat('d \d\e F \d\e Y')
        : null;
@endphp

<section class="bg-cream border-t border-blush/30">
    <div class="max-w-3xl mx-auto px-6 lg:px-8 py-12">
        <div class="flex flex-col sm:flex-row gap-5 sm:gap-6">

            <svg class="w-5 h-5 shrink-0 text-rose mt-0.5" fill="none" stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.852l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>

            <div>
                <p class="text-xs tracking-[0.2em] uppercase text-rose font-medium mb-3">Aviso importante</p>
                <p class="text-muted text-sm leading-relaxed">
                    {{ config('clinic.medical_disclaimer') }}
                </p>

                @if ($reviewedLabel)
                    <p class="text-muted/80 text-xs mt-4">
                        Conteúdo revisado em
                        <time datetime="{{ $reviewed }}">{{ $reviewedLabel }}</time>
                        por Dra. Emily Beatriz, cirurgiã-dentista &middot; CRO-{{ config('clinic.cro') }}
                    </p>
                @endif
            </div>

        </div>
    </div>
</section>
