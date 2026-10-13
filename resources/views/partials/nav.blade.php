@php($navBase = $navBase ?? '')

{{-- ======================================================
     NAV
====================================================== --}}
<nav class="fixed top-0 inset-x-0 z-50 bg-linen border-b rule">
    <div class="max-w-7xl mx-auto px-5 lg:px-8 h-18 flex items-center justify-between gap-8">

        {{-- Logo --}}
        <a href="{{ $navBase ?: '/' }}" class="flex items-center gap-3 shrink-0" aria-label="Dra. Emily Beatriz, página inicial">
            <x-monogram class="h-9 w-auto" />
            <span class="font-display text-lg text-ink leading-none hidden sm:inline">Dra. Emily Beatriz</span>
        </a>

        {{-- Desktop Nav Links --}}
        <div class="hidden lg:flex items-center gap-8 text-[0.95rem]">
            <a href="{{ $navBase }}#antes-depois" class="text-ink-soft hover:text-clay transition-colors duration-200">Resultados</a>
            <a href="{{ $navBase }}#sobre" class="text-ink-soft hover:text-clay transition-colors duration-200">Nossa história</a>
            <a href="{{ $navBase }}#procedimentos" class="text-ink-soft hover:text-clay transition-colors duration-200">Procedimentos</a>
            <a href="{{ $navBase }}#faq" class="text-ink-soft hover:text-clay transition-colors duration-200">Dúvidas</a>
            <a href="{{ route('articles.index') }}" class="text-ink-soft hover:text-clay transition-colors duration-200">Artigos</a>
            <a href="{{ $navBase }}#contato" class="text-ink-soft hover:text-clay transition-colors duration-200">Contato</a>
        </div>

        {{-- WhatsApp CTA --}}
        <a href="{{ $waNav }}"
           target="_blank" rel="noopener noreferrer"
           class="btn !py-2.5 !px-4 !text-sm shrink-0">
            <x-whatsapp-icon class="w-4 h-4" />
            <span class="hidden sm:inline">Agendar consulta</span>
            <span class="sm:hidden">WhatsApp</span>
        </a>
    </div>
</nav>
