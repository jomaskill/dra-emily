@php
    $navBase = $navBase ?? '';

    $whatsappDigits = preg_replace('/\D/', '', (string) config('clinic.whatsapp'));
    $phoneDisplay = preg_match('/^(\d{2})(\d{2})(\d+)(\d{4})$/', $whatsappDigits, $parts) === 1
        ? sprintf('+%s (%s) %s-%s', $parts[1], $parts[2], $parts[3], $parts[4])
        : '+' . $whatsappDigits;
@endphp

{{-- ======================================================
     FOOTER
====================================================== --}}
<footer id="contato" class="bg-ink text-linen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-20 lg:pt-24 pb-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-14">
            {{-- Brand --}}
            <div>
                <a href="{{ $navBase ?: '/' }}" class="flex items-center gap-4 mb-6" aria-label="Dra. Emily Beatriz, página inicial">
                    <x-monogram class="h-14 w-auto text-linen" />
                    <span class="font-display text-2xl text-linen leading-tight">Dra. Emily<br>Beatriz</span>
                </a>
                <p class="text-linen/70 text-sm leading-relaxed max-w-xs">
                    Ajudando mulheres a se apaixonarem pelo próprio reflexo em Santa Rosa, Pampulha — Belo Horizonte, MG.
                </p>
            </div>

            {{-- Navigation --}}
            <div>
                <p class="font-display text-xl text-linen mb-5">Navegação</p>
                <ul class="space-y-2.5">
                    <li><a href="{{ $navBase }}#sobre" class="text-linen/70 text-sm hover:text-ochre transition-colors">Nossa história</a></li>
                    <li><a href="{{ $navBase }}#procedimentos" class="text-linen/70 text-sm hover:text-ochre transition-colors">Procedimentos</a></li>
                    <li><a href="{{ $navBase }}#antes-depois" class="text-linen/70 text-sm hover:text-ochre transition-colors">Resultados</a></li>
                    <li><a href="{{ $navBase }}#faq" class="text-linen/70 text-sm hover:text-ochre transition-colors">Perguntas frequentes</a></li>
                    <li><a href="{{ route('articles.index') }}" class="text-linen/70 text-sm hover:text-ochre transition-colors">Artigos</a></li>
                    <li><a href="{{ $navBase }}#contato" class="text-linen/70 text-sm hover:text-ochre transition-colors">Contato</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <p class="font-display text-xl text-linen mb-5">Contato</p>
                <div class="space-y-3.5">
                    <a href="{{ $waFooter }}" target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-3 text-linen/70 text-sm hover:text-ochre transition-colors">
                        <x-whatsapp-icon class="w-4 h-4 shrink-0 text-ochre" />
                        {{ $phoneDisplay }}
                    </a>
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-3 text-linen/70 text-sm hover:text-ochre transition-colors">
                        <svg class="w-4 h-4 shrink-0 text-ochre" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        {{ "@$instagram" }}
                    </a>
                    <address class="not-italic flex items-start gap-3 text-linen/70 text-sm">
                        <svg class="w-4 h-4 shrink-0 text-ochre mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>
                            @if(config('clinic.address_street'))
                                {{ config('clinic.address_street') }}<br>
                                @if(config('clinic.address_neighborhood')) {{ config('clinic.address_neighborhood') }}, @endif
                            @endif
                            {{ config('clinic.city') }}, {{ config('clinic.state') }}@if(config('clinic.address_zip'))<br>
                                CEP {{ config('clinic.address_zip') }}@endif
                        </span>
                    </address>
                    @if (config('clinic.areas_served'))
                        <p class="text-linen/70 text-sm leading-relaxed mt-4">
                            Atendemos {{ implode(', ', config('clinic.areas_served')) }}
                            e demais regiões de {{ config('clinic.city') }}.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-linen/15 pt-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-linen/70 text-xs">© {{ date('Y') }} Dra. Emily Beatriz. Todos os direitos reservados.</p>
            <p class="text-linen/70 text-xs tracking-wide">Registrada no CRO-{{ $cro }} &nbsp;·&nbsp; Belo Horizonte, MG</p>
        </div>
    </div>
</footer>
