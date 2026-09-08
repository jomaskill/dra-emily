@php
    $physician = [
        '@type' => 'Physician',
        '@id' => $siteUrl.'/#emily',
        'name' => 'Dra. Emily Beatriz',
        'jobTitle' => 'Cirurgiã-Dentista — Especialista em Harmonização Orofacial',
        'identifier' => 'CRO '.$cro,
        'url' => $siteUrl.'/',
    ];

    $json = static fn ($value): string => json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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
    "author": {!! $json($physician) !!},
    "reviewedBy": {!! $json($physician) !!},
    "publisher": { "@@id": "{{ $siteUrl }}/#clinic" },
    "about": { "@@id": "{{ $siteUrl }}/#clinic" },
    "isPartOf": { "@@id": "{{ $siteUrl }}/#website" },
    "speakable": {
      "@@type": "SpeakableSpecification",
      "cssSelector": ["#resposta", "#faq"]
    }
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
