<script type="application/ld+json">
[
  {
    "@@context": "https://schema.org",
    "@@type": "Dentist",
    "name": "Dra. Emily Beatriz — Harmonização Facial",
    "description": "Especialista em harmonização facial em Belo Horizonte, MG. Realizamos botox, preenchimento labial, bioestimuladores de colágeno, microagulhamento, fios de PDO, bichectomia e harmonização facial completa com resultados naturais e personalizados.",
    "url": "{{ $siteUrl }}/",
    "telephone": "{{ $phone }}",
    "image": "{{ $siteUrl }}/foto-emily.jpg",
    "logo": "{{ $siteUrl }}/foto-emily.jpg",
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
      "name": "Emily Beatriz",
      "jobTitle": "Cirurgiã-Dentista — Especialista em Harmonização Orofacial",
      "identifier": "CRO {{ $cro }}"
    },
    "aggregateRating": {
      "@@type": "AggregateRating",
      "ratingValue": "5.0",
      "bestRating": "5",
      "worstRating": "1",
      "ratingCount": "7",
      "reviewCount": "7"
    },
    "review": [
      {
        "@@type": "Review",
        "author": { "@@type": "Person", "name": "Carol Araújo" },
        "reviewRating": { "@@type": "Rating", "ratingValue": "5", "bestRating": "5" },
        "reviewBody": "Fui e sou paciente dela. Excelente profissional, trabalha muito bem. A gente sente quando alguém ama o que faz, e a Dra. Emily é essa pessoa. Fiz bioestimulador de colágeno, preenchimento labial e outros procedimentos com botox! Meu rosto ficou mais harmônico e minha pele melhorou uns 90%. Enfim, amei os resultados."
      },
      {
        "@@type": "Review",
        "author": { "@@type": "Person", "name": "Dabila Araújo" },
        "reviewRating": { "@@type": "Rating", "ratingValue": "5", "bestRating": "5" },
        "reviewBody": "Sem palavras para o resultado! Fiz botox e preenchimento labial e fiquei simplesmente apaixonada. Atendimento impecável, muito cuidado em cada detalhe, super profissional e me deixou segura o tempo todo. O resultado ficou natural, elegante e valorizou muito minha autoestima. Indico de olhos fechados, uma profissional maravilhosa!"
      },
      {
        "@@type": "Review",
        "author": { "@@type": "Person", "name": "Viviane Fernandes" },
        "reviewRating": { "@@type": "Rating", "ratingValue": "5", "bestRating": "5" },
        "reviewBody": "Profissional impecável, com cuidado no pré e no pós-procedimento. Estou muito satisfeita com o meu resultado."
      }
    ]
  },
  {
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
      {
        "@@type": "Question",
        "name": "O que é harmonização facial?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Harmonização facial é um conjunto de procedimentos estéticos minimamente invasivos que equilibram as proporções e a harmonia do rosto, valorizando a beleza natural de cada pessoa. Em Belo Horizonte, a Dra. Emily Beatriz realiza tratamentos como botox, preenchimento labial, bioestimuladores de colágeno, fios de PDO e microagulhamento de forma personalizada."
        }
      },
      {
        "@@type": "Question",
        "name": "Botox dói? Como funciona o procedimento em BH?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "A aplicação de botox (toxina botulínica) é feita com agulhas finíssimas e causa desconforto mínimo. O procedimento é rápido, seguro e os resultados surgem em até 15 dias, suavizando as rugas de expressão de forma natural. A Dra. Emily Beatriz realiza botox em Belo Horizonte com técnica refinada para resultados sutis e duradouros."
        }
      },
      {
        "@@type": "Question",
        "name": "Quanto tempo dura o preenchimento labial?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "O preenchimento labial com ácido hialurônico tem duração de 6 a 18 meses, variando de acordo com o metabolismo de cada paciente e a quantidade de produto utilizado. É um dos procedimentos mais procurados em BH para lábios mais volumosos e definidos com resultado natural."
        }
      },
      {
        "@@type": "Question",
        "name": "O que é bioestimulador de colágeno e para quem é indicado?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "O bioestimulador de colágeno é um tratamento injetável que estimula a produção natural de colágeno pela pele, promovendo firmeza, elasticidade e rejuvenescimento progressivo. É indicado para quem deseja melhorar a qualidade e a aparência da pele com resultados naturais e duradouros, sem aparência artificial."
        }
      },
      {
        "@@type": "Question",
        "name": "O que é microagulhamento e quantas sessões são necessárias?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Microagulhamento é uma técnica estética que utiliza micropunturas controladas para estimular a renovação celular da pele, melhorando textura, manchas, poros dilatados e sinais de envelhecimento. O protocolo habitual é de 3 a 6 sessões, com intervalo de 30 dias, variando conforme o objetivo de cada paciente."
        }
      },
      {
        "@@type": "Question",
        "name": "O que são fios de PDO e como funciona o lifting?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Fios de PDO são fios bioabsorvíveis inseridos sob a pele para promover lifting facial sem cirurgia. Eles sustentam os tecidos e estimulam o colágeno, resultando em um rosto mais firme e jovem. O efeito melhora progressivamente ao longo das semanas após a aplicação."
        }
      },
      {
        "@@type": "Question",
        "name": "Qual a diferença entre botox e preenchimento facial?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "O botox (toxina botulínica) age nos músculos, relaxando-os para suavizar rugas de expressão como as da testa e ao redor dos olhos. Já o preenchimento com ácido hialurônico adiciona volume e contorno em áreas como lábios, maçãs do rosto e sulcos, sem agir na musculatura. Os dois podem ser combinados em uma harmonização facial completa."
        }
      },
      {
        "@@type": "Question",
        "name": "Como agendar uma consulta com a Dra. Emily Beatriz em BH?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Para agendar uma consulta de harmonização facial, botox ou qualquer procedimento estético com a Dra. Emily Beatriz em Belo Horizonte, basta clicar no botão de WhatsApp disponível no site. O atendimento é feito por nossa equipe de forma rápida e atenciosa."
        }
      }
    ]
  },
  {
    "@@context": "https://schema.org",
    "@@type": "WebSite",
    "name": "Dra. Emily Beatriz — Harmonização Facial",
    "url": "{{ $siteUrl }}/",
    "inLanguage": "pt-BR",
    "potentialAction": {
      "@@type": "ContactAction",
      "target": "https://wa.me/{{ config('clinic.whatsapp') }}"
    }
  }
]
</script>
