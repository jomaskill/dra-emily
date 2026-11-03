@php
    $siteUrl      = 'https://'.config('clinic.domain');
    $canonical    = $siteUrl.'/dra-emily-beatriz';
    $cro          = config('clinic.cro');
    $years        = config('clinic.years_experience');
    $instagramUrl = 'https://www.instagram.com/'.config('clinic.instagram').'/';
    $waAuthor     = \App\Support\WhatsApp::url('Olá! Conheci a Dra. Emily pelo site e gostaria de agendar uma avaliação.');
    $description  = 'Dra. Emily Beatriz é cirurgiã-dentista (CRO-'.$cro.') e atende em Belo Horizonte há mais de '.$years.' anos, com harmonização orofacial de resultado natural.';
    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'ProfilePage',
            '@id' => $canonical.'#webpage',
            'url' => $canonical,
            'name' => 'Dra. Emily Beatriz',
            'description' => $description,
            'inLanguage' => 'pt-BR',
            'dateModified' => $articles->max('updated'),
            'isPartOf' => \App\Support\SiteSchema::website(),
            'mainEntity' => \App\Support\SiteSchema::person(),
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Início', 'item' => $siteUrl.'/'],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Dra. Emily Beatriz', 'item' => $canonical],
            ],
        ],
    ];
@endphp

<x-site-layout
    title="Dra. Emily Beatriz: cirurgiã-dentista em Belo Horizonte"
    :description="$description"
    :canonical="$canonical"
    :nav-base="'/'"
    whatsapp-origin="pela página da Dra. Emily no site">

    <x-slot:schema>
        <script type="application/ld+json">
        {!! \App\Support\SiteSchema::json($schema) !!}
        </script>
    </x-slot:schema>

    <main class="pt-18">
        <section class="max-w-6xl mx-auto px-5 lg:px-8 pt-12 lg:pt-20 pb-20 lg:pb-24 grid grid-cols-1 lg:grid-cols-[5fr_6fr] gap-12 lg:gap-20 items-center">
            <div class="aspect-[4/5] overflow-hidden bg-sand rounded-sm">
                <x-picture src="foto-emily-2.jpg"
                           sizes="(min-width: 1024px) 480px, 100vw"
                           alt="Dra. Emily Beatriz, cirurgiã-dentista, no consultório em Belo Horizonte"
                           width="1400"
                           height="2100"
                           loading="eager"
                           fetchpriority="high"
                           class="w-full h-full object-cover object-top" />
            </div>

            <div>
                <p class="text-sm font-medium text-clay mb-5">Quem escreve</p>
                <h1 class="font-display text-[clamp(2.6rem,1.8rem+3.6vw,4.4rem)] leading-[1.04] text-ink">Dra. Emily Beatriz</h1>
                <p class="text-ink-soft mt-4">Cirurgiã-dentista, harmonização orofacial · CRO-{{ $cro }}</p>

                <div class="space-y-5 font-serif text-[1.15rem] leading-relaxed text-ink mt-8 max-w-[52ch]">
                    <p>
                        Atende em {{ config('clinic.city') }}, no bairro {{ config('clinic.address_neighborhood') }}, com mais de {{ $years }} anos de experiência e um princípio simples: o resultado tem que parecer você.
                    </p>
                    <p>
                        Antes de propor qualquer tratamento, ela escuta. Procura entender o que incomoda e o que faz sentido para cada rosto, porque o objetivo nunca é mudar quem você é.
                    </p>
                    <p>
                        Atende mulheres e homens. Nos artigos deste site, escreve as respostas que costuma dar na primeira conversa e cita as fontes no fim de cada texto.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-x-8 gap-y-4 mt-10">
                    <a href="{{ $waAuthor }}" target="_blank" rel="noopener noreferrer" class="btn">
                        <x-whatsapp-icon />
                        Agendar avaliação
                    </a>
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer me" class="thread-link text-ink">Instagram</a>
                </div>
            </div>
        </section>

        <section class="bg-sand/45" aria-labelledby="artigos-da-autora">
            <div class="max-w-6xl mx-auto px-5 lg:px-8 py-20 lg:py-24">
                <h2 id="artigos-da-autora" class="font-display text-[clamp(1.9rem,1.4rem+1.6vw,2.4rem)] leading-tight text-ink mb-6">Artigos da Dra. Emily</h2>
                <x-article.topics :topics="config('topics')" class="mb-8" />
                <ul aria-label="Todos os artigos" class="border-t rule">
                    @foreach ($articles as $articleSlug => $article)
                        <x-article.row :slug="$articleSlug" :article="$article" />
                    @endforeach
                </ul>
            </div>
        </section>

        @include('partials.medical-disclaimer')
    </main>
</x-site-layout>
