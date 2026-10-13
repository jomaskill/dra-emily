{{--
    Tabela comparativa de um procedimento.
    Espera $procedure['comparison'] — ver a documentação em config/procedures.php.
    Tabelas de comparação são um dos formatos que mecanismos de busca e de
    resposta extraem com mais facilidade.
--}}
@php($comparison = $procedure['comparison'] ?? null)

@if ($comparison)
    <section class="bg-linen border-t rule">
        <div class="max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12 items-end mb-12">
                <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] text-ink">
                    {{ $comparison['title'] }}
                </h2>
                @if (! empty($comparison['intro']))
                    <p class="text-ink-soft leading-relaxed max-w-[52ch] lg:justify-self-end">
                        {{ $comparison['intro'] }}
                    </p>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left min-w-[36rem]">
                    <caption class="sr-only">{{ $comparison['title'] }}</caption>
                    <thead>
                        <tr class="border-b border-ink">
                            <th scope="col" class="w-[22%] pr-6 py-5">
                                <span class="sr-only">Critério</span>
                            </th>
                            @foreach ($comparison['columns'] as $column)
                                <th scope="col" class="px-6 py-5 font-display text-2xl text-ink font-normal">
                                    {{ $column }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparison['rows'] as $row)
                            <tr class="border-b rule">
                                <th scope="row" class="pr-6 py-5 align-top text-sm text-clay font-semibold">
                                    {{ $row['label'] }}
                                </th>
                                <td class="px-6 py-5 align-top text-ink-soft text-[0.96rem] leading-relaxed">{{ $row['a'] }}</td>
                                <td class="px-6 py-5 align-top text-ink-soft text-[0.96rem] leading-relaxed">{{ $row['b'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endif
