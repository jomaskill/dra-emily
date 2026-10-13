@props([
    'alt' => '',
])

{{--
    Retrato redondo da Dra. Emily, recortado no rosto. O tamanho vem da classe
    passada (w-12 h-12, por exemplo).
--}}
<span {{ $attributes->class('block shrink-0 rounded-full overflow-hidden bg-sand') }}>
    <x-picture src="foto-emily.jpg"
               :alt="$alt"
               sizes="160px"
               width="1400"
               height="2100"
               class="w-full h-full object-cover object-top scale-[2.1] origin-[62%_36%]" />
</span>
