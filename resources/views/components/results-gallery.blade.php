@props([
    'cases',
    'ctaUrl',
    'id' => 'resultados',
    'heading',
    'lead' => null,
    'ctaLabel' => 'Quero agendar minha avaliação',
])

{{--
    Galeria de antes e depois. No celular os cards ficam numa faixa com
    rolagem horizontal (o próximo card aparece na borda como convite ao
    deslize); a partir do tablet viram grade de 2 e depois 3 colunas.
--}}
<section id="{{ $id }}" {{ $attributes->class('bg-ink text-linen') }}>
    <div class="max-w-7xl mx-auto lg:px-8 py-24 lg:py-36">
        <div class="grid grid-cols-1 lg:grid-cols-[1.4fr_1fr] gap-6 lg:gap-12 items-end mb-10 lg:mb-14 px-5 lg:px-0">
            <h2 class="font-display text-[clamp(2.4rem,4.6vw,4rem)] leading-[1.05] [&_em]:text-ochre">{!! $heading !!}</h2>
            @if ($lead)
                <p class="text-linen/70 leading-relaxed max-w-[40ch] lg:justify-self-end">{{ $lead }}</p>
            @endif
        </div>

        {{ $slot }}

        <div class="flex md:grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 overflow-x-auto md:overflow-visible snap-x snap-mandatory scroll-px-5 px-5 lg:px-0 pb-4 md:pb-0 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($cases as $case)
                <x-result-card :case="$case" class="w-[82vw] max-w-sm md:w-auto md:max-w-none shrink-0 snap-start" />
            @endforeach
        </div>

        @if (count($cases) > 1)
            <p class="md:hidden px-5 text-linen/60 text-sm mt-3" aria-hidden="true">Deslize para ver mais →</p>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mt-12 lg:mt-16 pt-10 border-t border-linen/15 mx-5 lg:mx-0">
            <p class="text-linen/60 text-sm leading-relaxed max-w-[52ch]">
                Cada pessoa é única e os resultados variam. Imagens publicadas com autorização dos pacientes.
            </p>
            <a href="{{ $ctaUrl }}" target="_blank" rel="noopener noreferrer" class="btn shrink-0">
                {{ $ctaLabel }}
            </a>
        </div>
    </div>
</section>
