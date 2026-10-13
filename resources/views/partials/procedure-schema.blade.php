@php
    // howPerformed descreve como o procedimento é realizado. O texto de abertura
    // sozinho não cobria as etapas, que já existem em config/procedures.php.
    $howPerformed = collect($procedure['steps'] ?? [])
        ->map(fn (array $step): string => $step['title'].': '.$step['desc'])
        ->prepend($procedure['hero_lead'])
        ->implode(' ');

    $physician = [
        '@type' => 'Physician',
        '@id' => $siteUrl.'/#emily',
        'name' => 'Dra. Emily Beatriz',
        'jobTitle' => 'Cirurgiã-Dentista — Especialista em Harmonização Orofacial',
        'identifier' => 'CRO '.$cro,
        'url' => $siteUrl.'/',
        'areaServed' => config('clinic.city').', '.config('clinic.state'),
    ];

    $json = static fn ($value): string => json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // Páginas de queixa descrevem uma condição e os tratamentos possíveis, não
    // um procedimento. Cada tratamento aponta para a página dele.
    $isConcern = ($procedure['kind'] ?? null) === 'concern';
    $mainId = $canonical.($isConcern ? '#condition' : '#procedure');
    $possibleTreatment = collect($procedure['treatments'] ?? [])
        ->map(fn (string $treatment): array => [
            '@type' => 'MedicalProcedure',
            'name' => config("procedures.{$treatment}.name"),
            'url' => $siteUrl.'/procedimentos/'.$treatment,
        ])
        ->values()
        ->all();
@endphp
<script type="application/ld+json">
[
  @if ($isConcern)
  {
    "@@context": "https://schema.org",
    "@@type": "MedicalCondition",
    "@@id": "{{ $mainId }}",
    "name": {!! $json($procedure['concern']['label'] ?? $procedure['name']) !!},
    "description": {!! $json($procedure['meta_description']) !!},
    "url": "{{ $canonical }}",
    "associatedAnatomy": { "@@type": "AnatomicalStructure", "name": "Face" },
    "possibleTreatment": {!! $json($possibleTreatment) !!}
  },
  @else
  {
    "@@context": "https://schema.org",
    "@@type": "MedicalProcedure",
    "@@id": "{{ $mainId }}",
    "name": {!! $json($procedure['name'].' — '.config('clinic.city')) !!},
    "description": {!! $json($procedure['meta_description']) !!},
    "url": "{{ $canonical }}",
    "bodyLocation": "Face",
    "howPerformed": {!! $json($howPerformed) !!},
    "performer": {!! $json($physician) !!}
  },
  @endif
  {
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Início", "item": "{{ $siteUrl }}/" },
      { "@@type": "ListItem", "position": 2, "name": "Procedimentos", "item": "{{ $siteUrl }}/#procedimentos" },
      { "@@type": "ListItem", "position": 3, "name": {!! $json($procedure['name']) !!}, "item": "{{ $canonical }}" }
    ]
  },
  {
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "@@id": "{{ $canonical }}#faq",
    "inLanguage": "pt-BR",
    "mainEntity": [
      @foreach ($procedure['faq'] as $item)
      {
        "@@type": "Question",
        "name": {!! $json($item['q']) !!},
        "acceptedAnswer": { "@@type": "Answer", "text": {!! $json($item['a']) !!} }
      }@if (! $loop->last),@endif
      @endforeach
    ]
  },
  {
    "@@context": "https://schema.org",
    "@@type": "MedicalWebPage",
    "@@id": "{{ $canonical }}#webpage",
    "url": "{{ $canonical }}",
    "name": {!! $json($procedure['title']) !!},
    "inLanguage": "pt-BR",
    "about": { "@@id": "{{ $siteUrl }}/#clinic" },
    "mainEntity": { "@@id": "{{ $mainId }}" },
    "publisher": { "@@id": "{{ $siteUrl }}/#clinic" }@if (! empty($procedure['updated'])),
    "lastReviewed": "{{ $procedure['updated'] }}",
    "reviewedBy": {!! $json($physician) !!}@endif,
    "speakable": {
      "@@type": "SpeakableSpecification",
      "cssSelector": ["#o-que-e", "#faq"]
    }
  }
]
</script>
