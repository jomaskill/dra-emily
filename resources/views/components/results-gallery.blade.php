@props([
    'cases',
    'ctaUrl',
    'id' => 'resultados',
    'eyebrow' => 'Resultados reais',
    'heading',
    'lead' => null,
    'ctaLabel' => 'Quero agendar minha avaliação',
])

{{--
    Galeria de antes e depois. No celular os cards ficam numa faixa com
    rolagem horizontal (o próximo card aparece na borda como convite ao
    deslize); a partir do tablet viram grade de 2 e depois 3 colunas.
--}}
<section id="{{ $id }}" {{ $attributes->class('py-20 lg:py-36 bg-charcoal relative overflow-hidden') }}>
    <div class="absolute inset-0 pointer-events-none opacity-[0.04]"
         style="background-image: radial-gradient(circle, #E8B4B8 1px, transparent 1px); background-size: 32px 32px;"></div>
    <div class="max-w-7xl mx-auto lg:px-8 relative z-10">
        <div class="text-center mb-10 lg:mb-16 px-6">
            <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">{{ $eyebrow }}</p>
            <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl italic text-cream leading-tight">{!! $heading !!}</h2>
            <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
            @if ($lead)
                <p class="text-muted mt-4 text-sm max-w-sm mx-auto leading-relaxed">{{ $lead }}</p>
            @endif
        </div>

        {{ $slot }}

        <div class="flex md:grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 overflow-x-auto md:overflow-visible snap-x snap-mandatory scroll-px-6 px-6 lg:px-0 pb-4 md:pb-0 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($cases as $case)
                <x-result-card :case="$case" :cta-url="$ctaUrl" class="w-[82vw] max-w-sm md:w-auto md:max-w-none shrink-0 snap-start" />
            @endforeach
        </div>

        @if (count($cases) > 1)
            <p class="md:hidden text-center text-muted text-[11px] tracking-[0.2em] uppercase mt-3" aria-hidden="true">Deslize para ver mais →</p>
        @endif

        <div class="text-center mt-10 lg:mt-14 px-6">
            <a href="{{ $ctaUrl }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center justify-center gap-2 w-full sm:w-auto bg-rose hover:bg-deep-rose text-white text-sm font-medium tracking-wide px-8 py-4 rounded-full transition-colors duration-300">
                {{ $ctaLabel }}
            </a>
            <p class="text-muted text-xs mt-6 tracking-wide leading-relaxed">
                * Cada pessoa é única e os resultados variam. Imagens publicadas com autorização das pacientes.
            </p>
        </div>
    </div>
</section>
