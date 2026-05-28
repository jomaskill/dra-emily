<script type="application/ld+json">
[
  {
    "@@context": "https://schema.org",
    "@@type": "MedicalProcedure",
    "name": {!! json_encode($procedure['name'].' — Belo Horizonte', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!},
    "description": {!! json_encode($procedure['meta_description'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!},
    "url": "{{ $canonical }}",
    "bodyLocation": "Face",
    "howPerformed": {!! json_encode($procedure['hero_lead'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!},
    "performer": {
      "@@type": "Physician",
      "name": "Dra. Emily Beatriz",
      "jobTitle": "Cirurgiã-Dentista — Especialista em Harmonização Orofacial",
      "identifier": "CRO {{ $cro }}",
      "url": "{{ $siteUrl }}/",
      "areaServed": "Belo Horizonte, MG"
    }
  },
  {
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Início", "item": "{{ $siteUrl }}/" },
      { "@@type": "ListItem", "position": 2, "name": "Procedimentos", "item": "{{ $siteUrl }}/#procedimentos" },
      { "@@type": "ListItem", "position": 3, "name": {!! json_encode($procedure['name'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}, "item": "{{ $canonical }}" }
    ]
  },
  {
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
      @foreach ($procedure['faq'] as $item)
      {
        "@@type": "Question",
        "name": {!! json_encode($item['q'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!},
        "acceptedAnswer": { "@@type": "Answer", "text": {!! json_encode($item['a'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!} }
      }@if (! $loop->last),@endif
      @endforeach
    ]
  }
]
</script>
