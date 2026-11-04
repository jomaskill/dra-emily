@props([
    'items',
    'questionClass' => 'font-display text-[1.35rem]',
])

{{--
    Lista de perguntas em <details>, separadas por fios finos.
    Cada item é ['q' => pergunta, 'a' => resposta]. A primeira pergunta abre
    aberta, para que a resposta já esteja visível ao carregar a página.
--}}
<div {{ $attributes->class('border-t rule') }}>
    @foreach ($items as ['q' => $question, 'a' => $answer])
        <details class="group border-b rule" @if ($loop->first) open @endif>
            <summary class="flex items-start justify-between gap-6 py-6 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden">
                <span class="{{ $questionClass }} leading-snug text-ink group-open:text-clay transition-colors duration-300">
                    {{ $question }}
                </span>
                <svg class="w-5 h-5 shrink-0 mt-1.5 text-clay transition-transform duration-500 ease-out-quint group-open:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-width="1.3" d="M12 4v16m8-8H4"/>
                </svg>
            </summary>
            <p class="pb-7 -mt-1 text-ink-soft leading-relaxed max-w-[62ch]">{{ $answer }}</p>
        </details>
    @endforeach
</div>
