<?php

/*
|--------------------------------------------------------------------------
| Resultados (antes e depois)
|--------------------------------------------------------------------------
|
| Casos exibidos na galeria de antes e depois da home e na seção
| #resultados de cada página de procedimento. Os caminhos são relativos a
| public/. Enquanto o arquivo não existir, o card mostra um placeholder:
| basta salvar a foto no caminho indicado para que ela apareça.
|
| Toda foto real de paciente precisa de registro de mídia com autorização
| (classification: patient + authorization_reference) antes da publicação.
|
| Estrutura de cada item:
|   id         => identificador único do caso
|   procedure  => slug em config('procedures')
|   title      => legenda curta do card
|   type       => 'split' (duas fotos) ou 'combined' (uma foto já montada)
|   before     => foto "antes" (somente split)
|   after      => foto "depois" (somente split)
|   image      => foto combinada (somente combined)
|   layout     => somente combined: 'horizontal' (antes à esquerda) ou
|                 'vertical' (antes em cima, depois embaixo)
|   alt        => texto alternativo base
|   detail     => opcional; contexto do caso, ex.: "Resultado final · 30 dias"
|   featured   => exibido na galeria da home
|
*/

return [
    [
        'id' => 'harmonizacao-facial-contorno-1',
        'procedure' => 'harmonizacao-facial',
        'title' => 'Papada reduzida, contorno definido',
        'type' => 'combined',
        'image' => 'resultados/harmonizacao-facial-contorno-1.jpg',
        'layout' => 'horizontal',
        'alt' => 'redução de papada com enzima em Belo Horizonte — Dra. Emily Beatriz',
        'detail' => 'Enzima para gordura localizada da papada',
        'featured' => true,
    ],
    [
        // Mesmo caso de harmonizacao-facial-contorno-1, exibido também na
        // página do procedimento que de fato foi feito (enzima para papada).
        'id' => 'enzima-para-papada-1',
        'procedure' => 'enzima-para-papada',
        'title' => 'Papada reduzida, contorno definido',
        'type' => 'combined',
        'image' => 'resultados/harmonizacao-facial-contorno-1.jpg',
        'layout' => 'horizontal',
        'alt' => 'redução de papada com enzima em Belo Horizonte — Dra. Emily Beatriz',
        'detail' => 'Enzima para gordura localizada da papada',
        'featured' => false,
    ],
    [
        'id' => 'preenchimento-labial-1',
        'procedure' => 'preenchimento-labial',
        'title' => 'Lábios com contorno definido',
        'type' => 'combined',
        'image' => 'resultados/preenchimento-labial-1.jpg',
        'layout' => 'horizontal',
        'alt' => 'preenchimento labial de perfil em Belo Horizonte — Dra. Emily Beatriz',
        'featured' => true,
    ],
    [
        'id' => 'toxina-botulinica-testa-1',
        'procedure' => 'toxina-botulinica',
        'title' => 'Testa lisa, expressão natural',
        'type' => 'combined',
        'image' => 'resultados/toxina-botulinica-testa-1.jpg',
        'layout' => 'vertical',
        'alt' => 'toxina botulínica nas rugas da testa em Belo Horizonte — Dra. Emily Beatriz',
        'featured' => true,
    ],
    [
        'id' => 'preenchimento-labial-3',
        'procedure' => 'preenchimento-labial',
        'title' => 'Arco do cupido desenhado',
        'type' => 'combined',
        'image' => 'resultados/preenchimento-labial-3.jpg',
        'layout' => 'vertical',
        'alt' => 'preenchimento labial com definição do arco do cupido em Belo Horizonte — Dra. Emily Beatriz',
        'featured' => true,
    ],
    [
        'id' => 'microagulhamento-1',
        'procedure' => 'microagulhamento',
        'title' => 'Textura e manchas da pele',
        'type' => 'combined',
        'image' => 'resultados/microagulhamento-1.jpg',
        'layout' => 'vertical',
        'alt' => 'microagulhamento na testa para textura e manchas em Belo Horizonte — Dra. Emily Beatriz',
        'featured' => true,
    ],
    [
        'id' => 'toxina-botulinica-pes-de-galinha-1',
        'procedure' => 'toxina-botulinica',
        'title' => 'Pés de galinha suavizados',
        'type' => 'combined',
        'image' => 'antes-e-depois.jpg',
        'layout' => 'horizontal',
        'alt' => 'toxina botulínica nas rugas ao redor dos olhos em Belo Horizonte — Dra. Emily Beatriz',
        'featured' => true,
    ],
    [
        'id' => 'preenchimento-labial-5',
        'procedure' => 'preenchimento-labial',
        'title' => 'Lábios mais volumosos',
        'type' => 'split',
        'before' => 'antes-1.jpg',
        'after' => 'depois-1.jpg',
        'alt' => 'preenchimento labial em Belo Horizonte — Dra. Emily Beatriz',
        'featured' => false,
    ],
    [
        'id' => 'preenchimento-labial-2',
        'procedure' => 'preenchimento-labial',
        'title' => 'Hidratação e volume',
        'type' => 'combined',
        'image' => 'resultados/preenchimento-labial-2.jpg',
        'layout' => 'horizontal',
        'alt' => 'preenchimento labial em close em Belo Horizonte — Dra. Emily Beatriz',
        'featured' => false,
    ],
    [
        'id' => 'preenchimento-labial-4',
        'procedure' => 'preenchimento-labial',
        'title' => 'Volume na medida certa',
        'type' => 'combined',
        'image' => 'resultados/preenchimento-labial-4.jpg',
        'layout' => 'vertical',
        'alt' => 'preenchimento labial natural em Belo Horizonte — Dra. Emily Beatriz',
        'featured' => false,
    ],
];
