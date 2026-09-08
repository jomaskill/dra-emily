{{--
    Tabela comparativa de um procedimento.
    Espera $procedure['comparison'] — ver a documentação em config/procedures.php.
    Tabelas de comparação são um dos formatos que mecanismos de busca e de
    resposta extraem com mais facilidade.
--}}
@php($comparison = $procedure['comparison'] ?? null)

@if ($comparison)
    <section class="py-24 lg:py-32 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">

            <div class="text-center mb-12">
                <p class="text-xs tracking-[0.25em] uppercase text-rose font-medium mb-4">Lado a lado</p>
                <h2 class="font-display text-4xl lg:text-5xl italic text-charcoal leading-tight">
                    {{ $comparison['title'] }}
                </h2>
                <div class="w-12 h-px bg-gold mx-auto mt-6"></div>
                @if (! empty($comparison['intro']))
                    <p class="text-muted leading-relaxed mt-7 max-w-2xl mx-auto">
                        {{ $comparison['intro'] }}
                    </p>
                @endif
            </div>

            <div class="overflow-x-auto rounded-2xl border border-blush/40">
                <table class="w-full border-collapse text-left min-w-[36rem]">
                    <caption class="sr-only">{{ $comparison['title'] }}</caption>
                    <thead>
                        <tr class="bg-cream">
                            <th scope="col" class="w-[22%] px-6 py-5 text-xs tracking-[0.18em] uppercase text-muted font-medium">
                                <span class="sr-only">Critério</span>
                            </th>
                            @foreach ($comparison['columns'] as $column)
                                <th scope="col" class="px-6 py-5 font-display text-xl italic text-charcoal font-normal">
                                    {{ $column }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparison['rows'] as $row)
                            <tr class="border-t border-blush/30 {{ $loop->even ? 'bg-cream/40' : '' }}">
                                <th scope="row" class="px-6 py-5 align-top text-xs tracking-[0.14em] uppercase text-rose font-medium">
                                    {{ $row['label'] }}
                                </th>
                                <td class="px-6 py-5 align-top text-muted text-[0.96rem] leading-relaxed">{{ $row['a'] }}</td>
                                <td class="px-6 py-5 align-top text-muted text-[0.96rem] leading-relaxed">{{ $row['b'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endif
