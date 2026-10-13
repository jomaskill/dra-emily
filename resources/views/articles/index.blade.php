@php
    $domain    = config('clinic.domain');
    $siteUrl   = 'https://'.$domain;
    $canonical = $siteUrl.'/artigos';
    $cro       = config('clinic.cro');
@endphp

<x-site-layout
    title="Artigos | Dra. Emily Beatriz — Harmonização Facial em BH"
    description="Respostas às perguntas que vêm antes de agendar: investimento, recuperação, contraindicações e preparo. Escrito pela Dra. Emily Beatriz, em Belo Horizonte."
    :canonical="$canonical"
    :nav-base="'/'"
    whatsapp-origin="pela página de artigos do site">

    <x-slot:schema>
        <script type="application/ld+json">
        {
          "@@context": "https://schema.org",
          "@@type": "CollectionPage",
          "@@id": "{{ $canonical }}#webpage",
          "url": "{{ $canonical }}",
          "name": "Artigos — Dra. Emily Beatriz",
          "inLanguage": "pt-BR",
          "isPartOf": { "@@id": "{{ $siteUrl }}/#website" },
          "about": { "@@id": "{{ $siteUrl }}/#clinic" },
          "mainEntity": {
            "@@type": "ItemList",
            "itemListElement": [
              @foreach ($articles as $slug => $article)
              {
                "@@type": "ListItem",
                "position": {{ $loop->iteration }},
                "url": "{{ $siteUrl }}/artigos/{{ $slug }}",
                "name": {!! json_encode($article['h1'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
              }@if (! $loop->last),@endif
              @endforeach
            ]
          }
        }
        </script>
    </x-slot:schema>

    <main>
        <header class="bg-linen pt-18">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-16 lg:pt-24 pb-14 lg:pb-20 grid grid-cols-1 lg:grid-cols-[1.4fr_1fr] gap-8 lg:gap-16 items-end">
                <div>
                    <p class="text-sm text-ink-soft mb-6">Antes de agendar</p>
                    <h1 class="font-display text-[clamp(2.8rem,6.4vw,5.4rem)] leading-[1.03] text-ink">
                        As perguntas que <em class="text-clay">vêm antes</em>
                    </h1>
                </div>
                <p class="text-ink-soft text-lg leading-relaxed max-w-[44ch]">
                    Quanto custa, quanto tempo leva para se recuperar, quem não pode fazer e como se preparar.
                    As dúvidas que aparecem antes de marcar a primeira conversa, respondidas com franqueza.
                </p>
            </div>
        </header>

        <section class="bg-linen">
            <div class="max-w-7xl mx-auto px-5 lg:px-8 pb-24 lg:pb-32">
                <ul class="border-t rule">
                    @foreach ($articles as $slug => $article)
                        <li>
                            <a href="{{ route('article', $slug) }}"
                               class="group grid grid-cols-1 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)_9rem] gap-x-10 gap-y-3 items-baseline py-9 border-b rule transition-[padding] duration-500 ease-out-quint lg:hover:pl-4">
                                <h2 class="font-display text-[clamp(1.6rem,2.6vw,2.2rem)] leading-[1.12] text-ink group-hover:text-clay transition-colors duration-300">
                                    {{ $article['h1'] }}
                                </h2>
                                <p class="text-ink-soft leading-relaxed max-w-[56ch]">
                                    {{ $article['excerpt'] }}
                                </p>
                                <time datetime="{{ $article['published'] }}" class="text-sm text-ink-soft lg:text-right">
                                    {{ \Illuminate\Support\Carbon::parse($article['published'])->translatedFormat('d \d\e F \d\e Y') }}
                                </time>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        @include('partials.medical-disclaimer')
    </main>
</x-site-layout>
