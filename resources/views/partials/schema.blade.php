<script type="application/ld+json">
[
  {
    "@@context": "https://schema.org",
    "@@type": "Dentist",
    "@@id": "{{ $siteUrl }}/#clinic",
    "name": "Dra. Emily Beatriz — Harmonização Facial",
    "description": "Especialista em harmonização facial em Belo Horizonte, MG. Realizamos botox, preenchimento labial, bioestimuladores de colágeno, microagulhamento, fios de PDO, bichectomia e harmonização facial completa com resultados naturais e personalizados.",
    "url": "{{ $siteUrl }}/",
    "telephone": "{{ $phone }}",
    "image": "{{ $siteUrl }}/foto-emily.jpg",
    "logo": {
      "@@type": "ImageObject",
      "url": "{{ $siteUrl }}/logo.png",
      "contentUrl": "{{ $siteUrl }}/logo.png",
      "width": 1080,
      "height": 1080,
      "caption": "Dra. Emily Beatriz — Harmonização Facial"
    },
    "priceRange": "$$",
    "currenciesAccepted": "BRL",
    "paymentAccepted": "Cartão de crédito, débito, Pix",
    "address": {
      "@@type": "PostalAddress",
      "streetAddress": "{{ config('clinic.address_street') }}",
      "addressLocality": "{{ config('clinic.city') }}",
      "addressRegion": "{{ config('clinic.state') }}",
      "postalCode": "{{ config('clinic.address_zip') }}",
      "addressCountry": "BR"
    },
    "geo": {
      "@@type": "GeoCoordinates",
      "latitude": "{{ config('clinic.latitude') }}",
      "longitude": "{{ config('clinic.longitude') }}"
    },
    "areaServed": [
      { "@@type": "City", "name": "Belo Horizonte" },
      { "@@type": "Neighborhood", "name": "Santa Rosa" },
      { "@@type": "Neighborhood", "name": "Pampulha" },
      { "@@type": "Neighborhood", "name": "Venda Nova" },
      { "@@type": "Neighborhood", "name": "Caiçara" },
      { "@@type": "AdministrativeArea", "name": "Minas Gerais" }
    ],
    "sameAs": [
      "{{ $instagramUrl }}",
      "https://wa.me/{{ config('clinic.whatsapp') }}"@if (config('clinic.google_business_url')),
      "{{ config('clinic.google_business_url') }}"@endif

    ],
    "hasMap": "{{ config('clinic.google_business_url') ?: 'https://maps.google.com/?q=R.+Conselheiro+Galv%C3%A3o%2C+64+Santa+Rosa+Belo+Horizonte+MG' }}",
    "openingHoursSpecification": [
      {
        "@@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
        "opens": "09:00",
        "closes": "18:00"
      }
    ],
    "medicalSpecialty": "Dentistry",
    "knowsAbout": [
      "Harmonização Facial",
      "Harmonização Orofacial",
      "Botox",
      "Toxina Botulínica",
      "Preenchimento Labial",
      "Preenchimento Facial",
      "Preenchimento com Ácido Hialurônico",
      "Bioestimulador de Colágeno",
      "Microagulhamento",
      "Fios de PDO",
      "Bichectomia",
      "Estética Facial",
      "Beleza em BH"
    ],
    "employee": {
      "@@type": "Physician",
      "@@id": "{{ $siteUrl }}/#emily",
      "url": "{{ $siteUrl }}/",
      "name": "Emily Beatriz",
      "jobTitle": "Cirurgiã-Dentista — Especialista em Harmonização Orofacial",
      "identifier": "CRO {{ $cro }}"
    }
    {{--
      aggregateRating/review removidos de propósito: avaliações sobre o próprio
      negócio, publicadas no site do próprio negócio, são "self-serving reviews"
      e estão fora da política de dados estruturados do Google — o markup não
      gera resultado enriquecido e expõe o site a ação manual. Os depoimentos
      seguem visíveis na página para quem lê. Para voltar a marcar avaliações,
      use uma integração de terceiros (ex.: Google Business Profile).
    --}}
  },
  {
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "@@id": "{{ $siteUrl }}/#faq",
    "isPartOf": { "@@id": "{{ $siteUrl }}/#webpage" },
    "about": { "@@id": "{{ $siteUrl }}/#clinic" },
    "inLanguage": "pt-BR",
    {{-- Fonte única: config/faq.php — o mesmo array renderiza a seção #faq visível. --}}
    "mainEntity": [
      @foreach (config('faq.home') as $item)
      {
        "@@type": "Question",
        "name": {!! json_encode($item['q'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!},
        "acceptedAnswer": { "@@type": "Answer", "text": {!! json_encode($item['a'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!} }
      }@if (! $loop->last),@endif
      @endforeach
    ]
  },
  {
    "@@context": "https://schema.org",
    "@@type": "WebSite",
    "@@id": "{{ $siteUrl }}/#website",
    "name": "Dra. Emily Beatriz — Harmonização Facial",
    "url": "{{ $siteUrl }}/",
    "publisher": { "@@id": "{{ $siteUrl }}/#clinic" },
    "inLanguage": "pt-BR",
    "potentialAction": {
      "@@type": "ContactAction",
      "target": "https://wa.me/{{ config('clinic.whatsapp') }}"
    }
  },
  {
    "@@context": "https://schema.org",
    "@@type": "WebPage",
    "@@id": "{{ $siteUrl }}/#webpage",
    "url": "{{ $siteUrl }}/",
    "name": "Dra. Emily Beatriz | Harmonização Facial, Botox e Preenchimento em BH",
    "isPartOf": { "@@id": "{{ $siteUrl }}/#website" },
    "about": { "@@id": "{{ $siteUrl }}/#clinic" },
    "primaryImageOfPage": { "@@type": "ImageObject", "url": "{{ $siteUrl }}/foto-emily.jpg" },
    "inLanguage": "pt-BR",
    "speakable": {
      "@@type": "SpeakableSpecification",
      "cssSelector": ["#faq", "#sobre"]
    }
  }
]
</script>
