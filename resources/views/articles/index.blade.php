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
    :nav-base="'/'">

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
        <header class="bg-cream pt-32 lg:pt-40 pb-16 lg:pb-20 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-[45vw] h-[45vw] max-w-xl rounded-full bg-blush/20 translate-x-1/3 -translate-y-1/4 pointer-events-none"></div>

            <div class="max-w-3xl mx-auto px-6 lg:px-8 text-center relative z-10">
                <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-5">Antes de agendar</p>
                <h1 class="font-display text-5xl lg:text-6xl italic text-charcoal leading-[1.08] mb-7">
                    As perguntas que vêm antes
                </h1>
                <div class="w-12 h-px bg-gold mx-auto mb-7"></div>
                <p class="text-muted text-lg leading-relaxed max-w-xl mx-auto">
                    Quanto custa, quanto tempo leva para se recuperar, quem não pode fazer e como se preparar.
                    As dúvidas que aparecem antes de marcar a primeira conversa, respondidas com franqueza.
                </p>
            </div>
        </header>

        <section class="bg-white py-16 lg:py-24">
            <div class="max-w-4xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($articles as $slug => $article)
                        <a href="{{ route('article', $slug) }}"
                           class="group flex flex-col bg-cream border border-blush/30 rounded-2xl p-8 hover:border-rose/30 hover:shadow-xl hover:shadow-rose/5 transition-all duration-500 hover:-translate-y-1.5">
                            <div class="w-8 h-px bg-gold mb-6"></div>

                            <h2 class="font-display text-2xl italic text-charcoal leading-snug mb-4 group-hover:text-rose transition-colors duration-300">
                                {{ $article['h1'] }}
                            </h2>

                            <p class="text-muted text-[0.96rem] leading-relaxed mb-6 grow">
                                {{ $article['excerpt'] }}
                            </p>

                            <div class="flex items-center justify-between gap-4 pt-5 border-t border-blush/30">
                                <time datetime="{{ $article['published'] }}" class="text-xs text-muted tracking-wide">
                                    {{ \Illuminate\Support\Carbon::parse($article['published'])->translatedFormat('d \d\e F \d\e Y') }}
                                </time>
                                <span class="flex items-center gap-1.5 text-rose text-sm font-medium opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-x-2 group-hover:translate-x-0">
                                    <span>Ler</span>
                                    <span aria-hidden="true">→</span>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        @include('partials.medical-disclaimer')
    </main>
</x-site-layout>
