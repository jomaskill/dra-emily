{{-- ======================================================
     TABLE OF CONTENTS
     Atalhos para as seções da página. Recebe $sections (âncora => rótulo).
     Toda âncora precisa existir na página.
====================================================== --}}
<nav aria-label="Nesta página" class="bg-linen border-y rule">
    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-4 flex flex-wrap items-baseline gap-x-6 gap-y-2 text-sm">
        <span class="text-ink-soft">Nesta página</span>
        @foreach ($sections as $anchor => $label)
            <a href="#{{ $anchor }}" class="text-ink hover:text-clay transition-colors">{{ $label }}</a>
        @endforeach
    </div>
</nav>
