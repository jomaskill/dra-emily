{{-- ======================================================
     REGIONS
     Segmentos de uma página-mãe e regiões tratadas em uma página-filha. Fonte:
     as chaves "parent" e "regions" de config/procedures.php.
====================================================== --}}
@if ($segments->isNotEmpty())
    <section id="regioes" class="bg-linen">
        <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-24 lg:pt-32">
            <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] text-ink mb-12 lg:mb-16">
                Preenchimento por <em class="text-clay">objetivo</em>
            </h2>
            <ul class="border-t rule">
                @foreach ($segments as $segmentSlug => $segment)
                    <li>
                        <a href="{{ route('procedure', $segmentSlug) }}"
                           class="group grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)_2rem] gap-x-8 gap-y-2 items-baseline py-7 border-b rule transition-[padding] duration-500 ease-out-quint md:hover:pl-4">
                            <h3 class="font-display text-2xl text-ink group-hover:text-clay transition-colors duration-300">{{ $segment['name'] }}</h3>
                            <p class="text-ink-soft leading-relaxed">{{ collect($segment['regions'])->pluck('name')->join(', ', ' e ') }}.</p>
                            <span class="hidden md:block justify-self-end text-clay transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">→</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@elseif (! empty($procedure['regions']))
    <section id="regioes" class="bg-linen">
        <div class="max-w-7xl mx-auto px-5 lg:px-8 pt-24 lg:pt-32">
            <h2 class="font-display text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.06] text-ink mb-12 lg:mb-16">
                {{ $procedure['regions_title'] }}
            </h2>
            <ul class="border-t rule">
                @foreach ($procedure['regions'] as $region)
                    <li class="grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_minmax(0,1.4fr)] gap-x-8 gap-y-2 items-baseline py-7 border-b rule">
                        <h3 class="font-display text-2xl text-ink">{{ $region['name'] }}</h3>
                        <p class="text-ink-soft leading-relaxed max-w-[64ch]">{{ $region['desc'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif
