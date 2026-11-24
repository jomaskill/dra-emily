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

    // A data de modificação vai na URL para que uma foto trocada com o mesmo
    // nome (ex.: ao cobrir os olhos de uma paciente) não fique presa no cache
    // do navegador, que guarda imagens por horas.
    $versioned = function (string $path): string {
        $modified = @filemtime(public_path($path));

        return asset($path).($modified ? '?v='.$modified : '');
    };
    $webp = $base.'.webp';
    $hasWebp = is_file(public_path($webp));

    // Variantes de largura geradas em public/, no padrão {base}-{largura}w.webp.
    // São descobertas automaticamente: basta gerar o arquivo para que ele entre
    // no srcset, sem alterar quem usa o componente.
    $srcset = collect([480, 768, 1120])
        ->filter(fn (int $candidate): bool => is_file(public_path($base.'-'.$candidate.'w.webp')))
        ->map(fn (int $candidate): string => $versioned($base.'-'.$candidate.'w.webp').' '.$candidate.'w');

    if ($hasWebp && $srcset->isNotEmpty()) {
        $intrinsic = @getimagesize(public_path($webp)) ?: @getimagesize(public_path($src));

        if ($intrinsic && $intrinsic[0] > 1120) {
            $srcset->push($versioned($webp).' '.$intrinsic[0].'w');
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
                    srcset="{{ $versioned($webp) }}"
                @endif
        >
    @endif
    <img src="{{ $versioned($src) }}"
         alt="{{ $alt }}"
         @if ($width) width="{{ $width }}" @endif
         @if ($height) height="{{ $height }}" @endif
         loading="{{ $loading }}"
         decoding="async"
         @if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
         {{ $attributes }}>
</picture>
