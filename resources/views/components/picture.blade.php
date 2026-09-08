@props([
    'src',
    'alt',
    'width' => null,
    'height' => null,
    'loading' => 'lazy',
    'fetchpriority' => null,
    'wrapperClass' => 'block w-full h-full',
])

@php
    $webp = preg_replace('/\.[^.]+$/', '', $src) . '.webp';
    $hasWebp = is_file(public_path($webp));
@endphp

<picture class="{{ $wrapperClass }}">
    @if ($hasWebp)
        <source srcset="{{ asset($webp) }}" type="image/webp">
    @endif
    <img src="{{ asset($src) }}"
         alt="{{ $alt }}"
         @if ($width) width="{{ $width }}" @endif
         @if ($height) height="{{ $height }}" @endif
         loading="{{ $loading }}"
         decoding="async"
         @if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
         {{ $attributes }}>
</picture>
