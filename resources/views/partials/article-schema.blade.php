@php
    $professional = \App\Support\SiteSchema::person();
    $clinic = \App\Support\SiteSchema::clinic();
    $website = \App\Support\SiteSchema::website();
    $procedures = $related->map(fn (array $procedure, string $procedureSlug): array => [
        '@type' => 'MedicalProcedure',
        'name' => $procedure['name'],
        'url' => $siteUrl.'/procedimentos/'.$procedureSlug,
    ])->values()->all();

    $json = \App\Support\SiteSchema::json(...);
@endphp
<script type="application/ld+json">
[
  {
    "@@context": "https://schema.org",
    "@@type": "MedicalWebPage",
    "@@id": "{{ $canonical }}#webpage",
    "url": "{{ $canonical }}",
    "name": {!! $json($article['h1']) !!},
    "headline": {!! $json($article['h1']) !!},
    "description": {!! $json($article['meta_description']) !!},
    "inLanguage": "pt-BR",
    "datePublished": "{{ $article['published'] }}",
    "dateModified": "{{ $article['updated'] }}",
    "lastReviewed": "{{ $article['updated'] }}",
    "author": {!! $json($professional) !!},
    "reviewedBy": {!! $json($professional) !!},
    "publisher": {!! $json($clinic) !!},
    "about": {!! $json($procedures) !!},
    "isPartOf": {!! $json($website) !!},
    "mainEntity": { "@@id": "{{ $canonical }}#article" },
    "speakable": {
      "@@type": "SpeakableSpecification",
      "cssSelector": ["#resposta", "#faq"]
    },
    "citation": {!! $json(array_map(static fn (array $source): array => [
        '@type' => 'CreativeWork',
        'name' => $source['title'],
        'url' => $source['url'],
        'publisher' => ['@type' => 'Organization', 'name' => $source['publisher']],
    ], $article['sources'])) !!}
  },
  {
    "@@context": "https://schema.org",
    "@@type": "BlogPosting",
    "@@id": "{{ $canonical }}#article",
    "mainEntityOfPage": { "@@id": "{{ $canonical }}#webpage" },
    "url": "{{ $canonical }}",
    "headline": {!! $json($article['h1']) !!},
    "description": {!! $json($article['meta_description']) !!},
    "image": {!! $json($imageUrl ?? $siteUrl.'/foto-emily.jpg') !!},
    "inLanguage": "pt-BR",
    "datePublished": "{{ $article['published'] }}",
    "dateModified": "{{ $article['updated'] }}",
    "author": {!! $json($professional) !!},
    "publisher": {!! $json($clinic) !!},
    "isPartOf": {!! $json($website) !!},
    "articleSection": {!! $json($topics->first()['name']) !!},
    "keywords": {!! $json($topics->pluck('name')->values()->all()) !!}
  },
  {
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Início", "item": "{{ $siteUrl }}/" },
      { "@@type": "ListItem", "position": 2, "name": "Artigos", "item": "{{ $siteUrl }}/artigos" },
      { "@@type": "ListItem", "position": 3, "name": {!! $json($article['h1']) !!}, "item": "{{ $canonical }}" }
    ]
  },
  {
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "@@id": "{{ $canonical }}#faq",
    "inLanguage": "pt-BR",
    "mainEntity": [
      @foreach ($article['faq'] as $item)
      {
        "@@type": "Question",
        "name": {!! $json($item['q']) !!},
        "acceptedAnswer": { "@@type": "Answer", "text": {!! $json($item['a']) !!} }
      }@if (! $loop->last),@endif
      @endforeach
    ]
  }
]
</script>
