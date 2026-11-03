<?php

/*
|--------------------------------------------------------------------------
| Temas dos artigos
|--------------------------------------------------------------------------
|
| Cada tema vira uma página em /artigos/tema/{slug}, com link a partir dos
| artigos, do índice e da página da autora. Um artigo declara os seus temas
| na chave "topics" de config/articles.php.
|
| Tema com um artigo só gera página fina: todo tema precisa de pelo menos dois.
|
| Estrutura de cada item:
|   name         => nome exibido nos links e no título da página
|   title        => <title> da página
|   description  => meta description
|   intro        => texto de abertura da página
|
*/

return [

    'antes-de-agendar' => [
        'name' => 'Antes de agendar',
        'title' => 'Antes de agendar harmonização facial | Dra. Emily Beatriz',
        'description' => 'Quanto custa, como se preparar, quanto tempo leva a recuperação e quem não pode fazer: o que vale saber antes de agendar uma harmonização facial.',
        'intro' => 'Valor, preparo, recuperação e contraindicações. O que vale saber antes da primeira conversa, para chegar à avaliação com as dúvidas certas.',
    ],

    'flacidez-e-firmeza' => [
        'name' => 'Flacidez e firmeza',
        'title' => 'Flacidez no rosto: causas e tratamentos | Dra. Emily Beatriz',
        'description' => 'Por que o rosto perde firmeza com a idade ou depois de emagrecer, o que bioestimulador e fios de PDO conseguem fazer e quando a cirurgia é o melhor caminho.',
        'intro' => 'O rosto perde sustentação com o tempo, e mais depressa depois de um emagrecimento rápido. Aqui estão as causas, os tratamentos sem cirurgia e os limites de cada um.',
    ],

    'idade-e-perfil' => [
        'name' => 'Por idade e perfil',
        'title' => 'Harmonização facial por idade e perfil | Dra. Emily Beatriz',
        'description' => 'O plano de harmonização facial muda aos 20, depois dos 40 e no rosto masculino. Veja o que costuma fazer sentido em cada caso, em Belo Horizonte.',
        'intro' => 'Um rosto de 25 anos, um de 50 e um rosto masculino pedem planos diferentes. Veja o que costuma fazer sentido em cada fase e em cada perfil.',
    ],

    'toxina-botulinica' => [
        'name' => 'Toxina botulínica',
        'title' => 'Toxina botulínica: dúvidas comuns | Dra. Emily Beatriz',
        'description' => 'Quanto tempo a toxina botulínica leva para fazer efeito, como é a recuperação, quando vale começar e como ela ajuda no bruxismo.',
        'intro' => 'Quanto tempo leva para fazer efeito, como é a recuperação, quando vale começar e como a toxina botulínica ajuda no bruxismo.',
    ],

];
