@props([
    'article',
    'size' => 'md',
])

{{--
    Linha de autoria: retrato, nome e, abaixo, tempo de leitura e data.
--}}
@php
    $published = \Illuminate\Support\Carbon::parse($article['published']);
    $avatar = $size === 'sm' ? 'w-7 h-7' : 'w-12 h-12';
@endphp

<div {{ $attributes->class('flex items-center gap-3') }}>
    <x-article.avatar :class="$avatar" />
    @if ($size === 'sm')
        <p class="text-sm text-ink-soft">
            <span class="text-ink">Dra. Emily Beatriz</span>
            <span class="mx-1" aria-hidden="true">·</span>
            <time datetime="{{ $article['published'] }}">{{ $published->translatedFormat('j \d\e M') }}</time>
            <span class="mx-1" aria-hidden="true">·</span>
            {{ $article['reading_minutes'] }} min de leitura
        </p>
    @else
        <div class="text-[0.95rem] leading-snug">
            <p class="text-ink font-medium">
                Dra. Emily Beatriz
                <span class="text-ink-soft font-normal">· CRO-{{ config('clinic.cro') }}</span>
            </p>
            <p class="text-ink-soft">
                {{ $article['reading_minutes'] }} min de leitura
                <span class="mx-1" aria-hidden="true">·</span>
                <time datetime="{{ $article['published'] }}">{{ $published->translatedFormat('j \d\e F \d\e Y') }}</time>
            </p>
        </div>
    @endif
</div>
