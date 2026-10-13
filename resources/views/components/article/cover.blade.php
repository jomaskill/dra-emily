@props([
    'article',
])

{{--
    Capa tipográfica do artigo: um bloco na cor do ateliê, o número do artigo
    em Bodoni itálico e o fio do logo. Escala pelo próprio contêiner, então
    serve tanto para a miniatura do índice quanto para o destaque.
--}}
@php
    $tones = [
        'clay' => 'bg-clay text-linen [--thread:var(--color-ochre)]',
        'ink' => 'bg-ink text-linen [--thread:var(--color-ochre)]',
        'sand' => 'bg-sand text-clay-deep [--thread:var(--color-clay)]',
        'clay-deep' => 'bg-clay-deep text-linen [--thread:var(--color-ochre)]',
        'ochre' => 'bg-ochre text-ink [--thread:var(--color-clay-deep)]',
    ];
@endphp

<div {{ $attributes->class(['@container relative overflow-hidden select-none', $tones[$article['tone']] ?? $tones['clay']]) }} aria-hidden="true">
    <p class="hidden @[16rem]:block absolute top-[8%] left-[7%] text-[max(0.7rem,3.4cqw)] tracking-[0.18em] uppercase opacity-80">
        {{ $article['eyebrow'] }}
    </p>
    <x-thread class="absolute top-[16%] -right-[6%] w-[62%] h-auto !text-(--thread)" />
    <span class="absolute left-[6%] -bottom-[0.13em] font-display italic leading-none text-[46cqw] [font-variation-settings:'opsz'_96]">
        {{ $article['number'] }}
    </span>
</div>
