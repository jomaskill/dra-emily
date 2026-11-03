@php
    $domain    = config('clinic.domain');
    $canonical = 'https://'.$domain.'/artigos/tema/'.$slug;
    $waTopic   = \App\Support\WhatsApp::url('Olá! Li os artigos sobre “'.$topic['name'].'” no site e gostaria de agendar uma avaliação.');
@endphp

<x-site-layout
    :title="$topic['title']"
    :description="$topic['description']"
    :canonical="$canonical"
    :nav-base="'/'"
    :whatsapp-origin="'pelos artigos sobre “'.$topic['name'].'”'">

    <x-slot:schema>
        @include('partials.article-collection-schema', [
            'name' => $topic['name'].' — Artigos da Dra. Emily Beatriz',
            'breadcrumb' => $topic['name'],
        ])
    </x-slot:schema>

    <main class="pt-18">
        <header class="max-w-6xl mx-auto px-5 lg:px-8 pt-12 lg:pt-20 pb-10 lg:pb-12">
            <nav aria-label="Você está em" class="mb-10">
                <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                    <li><a href="{{ route('home') }}" class="hover:text-clay transition-colors">Início</a></li>
                    <li aria-hidden="true">/</li>
                    <li><a href="{{ route('articles.index') }}" class="hover:text-clay transition-colors">Artigos</a></li>
                </ol>
            </nav>
            <h1 class="font-display text-[clamp(2.6rem,1.8rem+3.6vw,4.4rem)] leading-[1.04] text-ink max-w-[22ch]">
                {{ $topic['name'] }}
            </h1>
            <p class="font-serif text-ink-soft text-[1.2rem] md:text-[1.3rem] leading-snug max-w-[52ch] mt-6">
                {{ $topic['intro'] }}
            </p>
            <x-article.topics :topics="config('topics')" :current="$slug" class="mt-9" />
        </header>

        <section class="max-w-6xl mx-auto px-5 lg:px-8 pb-24 lg:pb-32">
            <ul aria-label="Artigos sobre {{ $topic['name'] }}" class="border-t rule">
                @foreach ($articles as $articleSlug => $article)
                    <x-article.row :slug="$articleSlug" :article="$article" />
                @endforeach
            </ul>
        </section>

        <x-closing-cta :url="$waTopic" label="Agendar avaliação">
            <x-slot:heading>Ficou com alguma <em>dúvida</em>?</x-slot:heading>
            A avaliação é uma conversa. Traga suas perguntas e vamos entender, junto com você, o que faz sentido para você.
        </x-closing-cta>

        @include('partials.medical-disclaimer')
    </main>
</x-site-layout>
