<?php

/*
|--------------------------------------------------------------------------
| Perguntas frequentes — home
|--------------------------------------------------------------------------
|
| Fonte única das perguntas frequentes exibidas na home. O mesmo array
| alimenta a seção visível (#faq em welcome.blade.php) e o JSON-LD do tipo
| FAQPage (partials/schema.blade.php), garantindo que o dado estruturado
| sempre corresponda ao conteúdo visível — exigência do Google para
| elegibilidade de resultados enriquecidos.
|
| As páginas de procedimento seguem o mesmo padrão em config/procedures.php.
|
| Estrutura de cada item:
|   q => pergunta
|   a => resposta
|
*/

return [

    'home' => [
        [
            'q' => 'O que é harmonização facial e o que pode ser feito?',
            'a' => 'Harmonização facial é um conjunto de procedimentos estéticos minimamente invasivos — como botox, preenchimento labial, bioestimuladores de colágeno, fios de PDO e microagulhamento — que equilibram as proporções do rosto e valorizam a beleza natural de cada pessoa. Em Belo Horizonte, a Dra. Emily Beatriz realiza todos esses tratamentos de forma personalizada e com resultados naturais.',
        ],
        [
            'q' => 'Botox dói? O resultado fica artificial?',
            'a' => 'O botox é aplicado com agulhas ultrafinas e causa desconforto mínimo. Os resultados surgem em 7 a 15 dias e, quando feito por uma profissional experiente como a Dra. Emily, o aspecto é completamente natural — ninguém percebe que você fez, só notam que você está mais bonita e descansada.',
        ],
        [
            'q' => 'Quanto tempo dura o preenchimento labial?',
            'a' => 'O preenchimento labial com ácido hialurônico dura em média de 6 a 18 meses, dependendo do seu organismo e do volume aplicado. É um dos procedimentos mais procurados em BH por quem deseja lábios mais definidos e volumosos de forma natural e segura.',
        ],
        [
            'q' => 'O que é bioestimulador de colágeno? Vale a pena?',
            'a' => 'O bioestimulador de colágeno é uma injeção que estimula o seu próprio organismo a produzir colágeno, melhorando a firmeza, a textura e a luminosidade da pele ao longo do tempo. Os resultados são progressivos e naturais — e sim, valem muito a pena para quem quer rejuvenescer sem aparência artificial.',
        ],
        [
            'q' => 'Para que serve o microagulhamento?',
            'a' => 'O microagulhamento é uma técnica que cria micropunturas controladas na pele para estimular a renovação celular. Ele melhora manchas, poros dilatados, textura irregular, linhas finas e sinais de envelhecimento. O protocolo habitual é de 3 a 6 sessões, espaçadas em torno de 30 dias.',
        ],
        [
            'q' => 'O que são fios de PDO? É lifting sem cirurgia?',
            'a' => 'Sim! Os fios de PDO são fios bioabsorvíveis inseridos sob a pele para promover sustentação e estímulo de colágeno — funcionando como um lifting sem bisturi. O resultado melhora progressivamente ao longo das semanas e é completamente natural.',
        ],
        [
            'q' => 'Posso combinar vários procedimentos na mesma consulta?',
            'a' => 'Na maioria dos casos, sim. A Dra. Emily faz uma avaliação completa do seu rosto antes de qualquer procedimento e pode montar um protocolo personalizado combinando diferentes tratamentos para alcançar o melhor resultado possível de forma segura.',
        ],
        [
            'q' => 'Como agendar uma consulta em Belo Horizonte?',
            'a' => 'É simples: basta clicar no botão de WhatsApp em qualquer lugar do site. Nossa equipe responde rapidamente e agenda o seu horário. A primeira consulta é uma conversa — sem compromisso — para entender o que você deseja e o que podemos fazer por você.',
        ],
    ],

];
