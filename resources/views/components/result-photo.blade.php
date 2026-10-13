@props([
    'src',
    'alt',
    'sizes' => null,
    'position' => 'object-top',
])

{{--
    Foto de um caso de antes e depois. Enquanto o arquivo não existir em
    public/, mostra um placeholder no mesmo espaço para o layout não mudar
    quando a foto real for adicionada.
--}}
@if (is_file(public_path($src)))
    <x-picture :src="$src" :alt="$alt" :sizes="$sizes" width="1200" height="1500" loading="lazy"
               class="w-full h-full object-cover {{ $position }} group-hover:scale-[1.03] transition-transform duration-700 ease-out-quint" />
@else
    <div data-placeholder="{{ $src }}" role="img" aria-label="{{ $alt }} (foto em breve)"
         class="w-full h-full flex flex-col items-center justify-center gap-2 bg-clay-deep/40 text-linen/50">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M3 8.5A1.5 1.5 0 014.5 7h2.3l1.4-2h7.6l1.4 2h2.3A1.5 1.5 0 0121 8.5v9a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 17.5v-9z"/>
            <circle cx="12" cy="13" r="3.5" stroke-width="1.2"/>
        </svg>
        <span class="text-xs">Foto em breve</span>
    </div>
@endif
