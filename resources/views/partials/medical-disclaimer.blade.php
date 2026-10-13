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

<section class="bg-linen border-t rule">
    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-[14rem_1fr] gap-3 md:gap-12">
        <p class="font-display text-xl text-ink">Aviso importante</p>
        <div class="max-w-[68ch]">
            <p class="text-ink-soft text-sm leading-relaxed">
                {{ config('clinic.medical_disclaimer') }}
            </p>

            @if ($reviewedLabel)
                <p class="text-ink-soft text-xs mt-4">
                    Conteúdo revisado em
                    <time datetime="{{ $reviewed }}">{{ $reviewedLabel }}</time>
                    por Dra. Emily Beatriz, cirurgiã-dentista &middot; CRO-{{ config('clinic.cro') }}
                </p>
            @endif
        </div>
    </div>
</section>
