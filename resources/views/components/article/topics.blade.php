@props([
    'topics',
    'current' => null,
    'label' => 'Temas',
])

{{--
    Temas como etiquetas. Recebe $topics (slug => tema) e, nas páginas de tema,
    $current com o slug que não deve virar link para si mesmo.
--}}
<nav aria-label="{{ $label }}" {{ $attributes }}>
    <ul class="flex flex-wrap gap-2">
        @foreach ($topics as $topicSlug => $topic)
            <li>
                @if ($topicSlug === $current)
                    <span aria-current="page" class="inline-flex items-center rounded-full bg-clay px-4 py-2 text-[0.95rem] text-linen">{{ $topic['name'] }}</span>
                @else
                    <a href="{{ route('articles.topic', $topicSlug) }}"
                       class="inline-flex items-center rounded-full bg-sand/70 px-4 py-2 text-[0.95rem] text-ink hover:bg-sand hover:text-clay-deep transition-colors duration-300">
                        {{ $topic['name'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
