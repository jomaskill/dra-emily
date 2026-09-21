<?php

return [

    'whatsapp' => env('CLINIC_WHATSAPP', '5531988480396'),

    'cro' => env('CLINIC_CRO', 'MG-069427'),

    'instagram' => env('CLINIC_INSTAGRAM', 'draemily.beatriz'),

    'city' => env('CLINIC_CITY', 'Belo Horizonte'),

    'state' => env('CLINIC_STATE', 'MG'),

    'address_street' => env('CLINIC_ADDRESS_STREET', 'R. Conselheiro Galvão, 64'),

    'address_neighborhood' => env('CLINIC_ADDRESS_NEIGHBORHOOD', 'Santa Rosa'),

    'address_zip' => env('CLINIC_ADDRESS_ZIP', '31255-750'),

    // Bairros atendidos. Fonte única: alimenta o areaServed do schema e o texto
    // visível no rodapé, para que a marcação não afirme nada que a página não diga.
    'areas_served' => ['Santa Rosa', 'Pampulha', 'Venda Nova', 'Caiçara'],

    'latitude' => env('CLINIC_LATITUDE', '-19.8611003'),

    'longitude' => env('CLINIC_LONGITUDE', '-43.9496221'),

    'domain' => env('CLINIC_DOMAIN', 'dra-emily-beatriz.com.br'),

    // Data da última revisão do conteúdo da home. Usada como <lastmod> no
    // sitemap. Atualize ao alterar textos da página inicial.
    'content_updated' => env('CLINIC_CONTENT_UPDATED', '2026-09-08'),

    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION', ''),

    'google_business_url' => env('GOOGLE_BUSINESS_URL', 'https://maps.app.goo.gl/q4FE8CcJ1L3J9Bc77'),

    'ga4_id' => env('GOOGLE_ANALYTICS_ID', 'G-FHD94M3R1T'),

    'gtm_id' => env('GOOGLE_TAG_MANAGER_ID', 'GTM-W8RW6RXD'),

    // Anos de experiência. Usado no selo da home e no texto da seção "Quem é a
    // Dra. Emily", para que os dois não divirjam.
    'years_experience' => env('CLINIC_YEARS_EXPERIENCE', 5),

    // Aviso exibido nas páginas de procedimento e na home. Conteúdo de saúde
    // precisa deixar claro que o resultado varia e que a avaliação é individual.
    'medical_disclaimer' => 'As informações desta página são de caráter informativo e não substituem uma consulta. Os resultados variam de acordo com as características de cada paciente, e todo tratamento é definido em avaliação individual com a Dra. Emily Beatriz.',

];
