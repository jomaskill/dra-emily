@props([
    'case',
])

@php
    $procedure = config('procedures.'.$case['procedure']);
    $isVertical = $case['type'] === 'combined' && ($case['layout'] ?? 'horizontal') === 'vertical';
    $label = 'absolute z-10 bg-ink text-linen text-xs px-2.5 py-1';
@endphp

<article data-result-card="{{ $case['id'] }}"
         {{ $attributes->class('group relative flex flex-col bg-ink') }}>
    <div class="relative aspect-square overflow-hidden">
        @if ($case['type'] === 'combined')
            <x-result-photo :src="$case['image']" :alt="'Antes e depois — '.$case['alt']" position="object-center"
                            sizes="(min-width: 1024px) 400px, (min-width: 768px) 50vw, 85vw" />
        @else
            <div class="flex h-full">
                <div class="relative w-1/2 overflow-hidden bg-clay-deep/40">
                    <x-result-photo :src="$case['before']" :alt="'Antes — '.$case['alt']"
                                    sizes="(min-width: 1024px) 200px, (min-width: 768px) 25vw, 43vw" />
                </div>
                {{-- Divisor fino em mostarda --}}
                <div class="w-px shrink-0 bg-ochre" aria-hidden="true"></div>
                <div class="relative w-1/2 overflow-hidden bg-clay-deep/40">
                    <x-result-photo :src="$case['after']" :alt="'Depois — '.$case['alt']"
                                    sizes="(min-width: 1024px) 200px, (min-width: 768px) 25vw, 43vw" />
                </div>
            </div>
        @endif
        {{-- Fotos montadas na vertical têm o "depois" embaixo; na horizontal, à direita. --}}
        <span class="{{ $label }} top-0 left-0">Antes</span>
        <span class="{{ $label }} {{ $isVertical ? 'bottom-7 left-0' : 'top-0 right-0' }} !bg-clay">Depois</span>
        {{-- Assinatura exigida pela Resolução CFO 196/2019: nome e registro do profissional na imagem. --}}
        <span class="absolute bottom-0 inset-x-0 z-10 bg-gradient-to-t from-ink/70 to-transparent pt-6 pb-2 text-center text-[10px] tracking-wide text-linen/85">
            Dra. Emily Beatriz · CRO {{ config('clinic.cro') }}
        </span>
    </div>
    <div class="pt-5 flex items-end justify-between gap-4">
        <div>
            @if ($procedure)
                <a href="{{ route('procedure', $case['procedure']) }}"
                   class="text-sm text-ochre hover:text-sand transition-colors">{{ $procedure['name'] }}</a>
            @endif
            <p class="font-display text-2xl text-linen leading-tight mt-1">{{ $case['title'] }}</p>
            @if (! empty($case['detail']))
                <p class="text-linen/60 text-sm mt-1">{{ $case['detail'] }}</p>
            @endif
        </div>
        <a href="{{ \App\Support\WhatsApp::forResult($case) }}" target="_blank" rel="noopener noreferrer"
           class="shrink-0 text-sm text-linen underline decoration-ochre underline-offset-4 hover:text-ochre transition-colors">Quero isso</a>
    </div>
</article>
