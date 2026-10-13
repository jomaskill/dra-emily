@props([
    'url',
    'label' => 'Agendar pelo WhatsApp',
])

{{--
    Fechamento das páginas: fundo tinta, título grande e o botão de WhatsApp.
    O título vem no slot "heading" (use <em> para a palavra em destaque);
    o slot padrão é o texto de apoio.
--}}
<section {{ $attributes->class('bg-ink text-linen') }}>
    <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-28 lg:pt-40 pb-20 lg:pb-28">
        <x-thread class="w-56 h-auto mb-10" />
        <h2 class="font-display text-[clamp(2.8rem,7vw,6.4rem)] leading-[1.02] max-w-[16ch] [&_em]:text-ochre">
            {{ $heading }}
        </h2>
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-10 mt-12 lg:mt-16 pt-10 border-t border-linen/15">
            <p class="text-linen/75 text-lg leading-relaxed max-w-[44ch]">
                {{ $slot }}
            </p>
            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="btn shrink-0">
                <x-whatsapp-icon />
                {{ $label }}
            </a>
        </div>
    </div>
</section>
