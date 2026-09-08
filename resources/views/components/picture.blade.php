@props([
    'src',
    'alt',
    'width' => null,
    'height' => null,
    'loading' => 'lazy',
    'fetchpriority' => null,
    'sizes' => null,
    'wrapperClass' => 'block w-full h-full',
])

@php
    $base = preg_replace('/\.[^.]+$/', '', $src);
    $webp = $base.'.webp';
    $hasWebp = is_file(public_path($webp));

    // Variantes de largura geradas em public/, no padrão {base}-{largura}w.webp.
    // São descobertas automaticamente: basta gerar o arquivo para que ele entre
    // no srcset, sem alterar quem usa o componente.
    $srcset = collect([480, 768, 1120])
        ->filter(fn (int $candidate): bool => is_file(public_path($base.'-'.$candidate.'w.webp')))
        ->map(fn (int $candidate): string => asset($base.'-'.$candidate.'w.webp').' '.$candidate.'w');

    if ($hasWebp && $srcset->isNotEmpty()) {
        $intrinsic = @getimagesize(public_path($webp)) ?: @getimagesize(public_path($src));

        if ($intrinsic && $intrinsic[0] > 1120) {
            $srcset->push(asset($webp).' '.$intrinsic[0].'w');
        }
    }
@endphp

<picture class="{{ $wrapperClass }}">
    @if ($hasWebp)
        <source type="image/webp"
                @if ($srcset->isNotEmpty())
                    srcset="{{ $srcset->implode(', ') }}"
                    @if ($sizes) sizes="{{ $sizes }}" @endif
                @else
                    srcset="{{ asset($webp) }}"
                @endif
        >
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
