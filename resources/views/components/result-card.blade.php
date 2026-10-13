@props([
    'case',
])

@php
    $procedure = config('procedures.'.$case['procedure']);
    $isVertical = $case['type'] === 'combined' && ($case['layout'] ?? 'horizontal') === 'vertical';
    $pill = 'absolute z-10 text-white text-[10px] font-medium tracking-[0.2em] uppercase backdrop-blur-sm px-2.5 py-1 rounded-full';
@endphp

<article data-result-card="{{ $case['id'] }}"
         {{ $attributes->class('group relative flex flex-col rounded-2xl overflow-hidden border border-white/5 hover:border-gold/25 bg-charcoal transition-all duration-500 md:hover:-translate-y-1.5') }}>
    <div class="relative aspect-square overflow-hidden">
        @if ($case['type'] === 'combined')
            <x-result-photo :src="$case['image']" :alt="'Antes e depois — '.$case['alt']" position="object-center"
                            sizes="(min-width: 1024px) 400px, (min-width: 768px) 50vw, 85vw" />
        @else
            <div class="flex h-full">
                <div class="relative w-1/2 overflow-hidden bg-[#3A2A2A]">
                    <x-result-photo :src="$case['before']" :alt="'Antes — '.$case['alt']"
                                    sizes="(min-width: 1024px) 200px, (min-width: 768px) 25vw, 43vw" />
                </div>
                {{-- Gold divider --}}
                <div class="relative z-10 flex flex-col items-center justify-center w-0.5 shrink-0">
                    <div class="w-full flex-1 bg-gold/40"></div>
                    <div class="w-7 h-7 rounded-full bg-gold flex items-center justify-center shadow-lg shrink-0 my-1">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h8M12 8v8"/></svg>
                    </div>
                    <div class="w-full flex-1 bg-gold/40"></div>
                </div>
                <div class="relative w-1/2 overflow-hidden bg-[#2A1820]">
                    <x-result-photo :src="$case['after']" :alt="'Depois — '.$case['alt']"
                                    sizes="(min-width: 1024px) 200px, (min-width: 768px) 25vw, 43vw" />
                </div>
            </div>
        @endif
        {{-- Fotos montadas na vertical têm o "depois" embaixo; na horizontal, à direita. --}}
        <span class="{{ $pill }} top-3 left-3 bg-charcoal/70">Antes</span>
        <span class="{{ $pill }} {{ $isVertical ? 'bottom-8 left-3' : 'top-3 right-3' }} bg-rose/75">Depois</span>
        {{-- Assinatura exigida pela Resolução CFO 196/2019: nome e registro do profissional na imagem. --}}
        <span class="absolute bottom-0 inset-x-0 z-10 bg-gradient-to-t from-black/60 to-transparent pt-6 pb-2 text-center text-[9px] tracking-[0.15em] uppercase text-white/80">
            Dra. Emily Beatriz · CRO {{ config('clinic.cro') }}
        </span>
    </div>
    <div class="border-t border-white/5 p-5 flex items-end justify-between gap-4">
        <div>
            @if ($procedure)
                <a href="{{ route('procedure', $case['procedure']) }}"
                   class="text-[10px] tracking-[0.2em] uppercase text-gold hover:text-blush transition-colors">{{ $procedure['name'] }}</a>
            @endif
            <p class="font-display text-xl italic text-cream leading-tight mt-1">{{ $case['title'] }}</p>
            @if (! empty($case['detail']))
                <p class="text-muted text-xs mt-1">{{ $case['detail'] }}</p>
            @endif
        </div>
        <a href="{{ \App\Support\WhatsApp::forResult($case) }}" target="_blank" rel="noopener noreferrer"
           class="shrink-0 text-xs text-rose hover:text-blush transition-colors font-medium tracking-wide">Quero isso →</a>
    </div>
</article>
