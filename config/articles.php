<?php

/*
|--------------------------------------------------------------------------
| Artigos
|--------------------------------------------------------------------------
|
| Conteúdo editorial do site. Mesma abordagem de config/procedures.php: um
| array por artigo, alimentando a página visível, o JSON-LD e o sitemap a
| partir de uma fonte única. A chave é o slug usado em /artigos/{slug}.
|
| Voz: todo texto é escrito pela Dra. Emily Beatriz, em primeira pessoa.
| Cirurgiã-dentista que preza pela ciência e pela beleza, fala com mulheres
| e passa confiança e autoridade em harmonização facial. Tom de conversa,
| sem jargão e sem cara de texto gerado: frases de tamanhos variados, dados
| citados de passagem e nada de travessões ou fórmulas prontas.
|
| Estrutura de cada item:
|   title             => <title> da página
|   h1                => título principal
|   eyebrow           => sobretítulo
|   meta_description  => meta description
|   excerpt           => resumo curto (card do índice)
|   published         => data de publicação (Y-m-d)
|   updated           => data da última revisão (Y-m-d)
|   answer            => resposta direta em 40-60 palavras, exibida logo abaixo
|                        do H1. É o trecho que buscadores e assistentes extraem.
|   sections          => [['heading' => ..., 'body' => [parágrafo, ...]], ...]
|   takeaways         => lista de pontos-chave (opcional)
|   faq               => [['q' => ..., 'a' => ...], ...]
|   related           => slugs de config/procedures.php
|   sources           => [['publisher' => ..., 'title' => ..., 'url' => ...,
|                        'year' => ...], ...] referências citadas no fim do
|                        artigo e no JSON-LD (citation). Use só fontes
|                        verificadas, que sustentem o que o texto afirma.
|                        O título fica como no original, mesmo com nome de
|                        marca: a regra de não citar marcas vale para o
|                        texto do artigo, não para as fontes.
|
| Observação sobre valores: o Código de Ética Odontológica (art. 44, I)
| proíbe anunciar preços. Por isso o artigo sobre custo
| explica o que compõe o investimento, sem tabela de preços.
|
*/

return [

    'quanto-custa-harmonizacao-facial' => [
        'title' => 'Quanto custa harmonização facial em BH? | Dra. Emily Beatriz',
        'h1' => 'Quanto custa uma harmonização facial em Belo Horizonte?',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'O que define o valor de uma harmonização facial em Belo Horizonte: número de áreas, quantidade de produto, técnica e acompanhamento. Entenda antes de agendar.',
        'excerpt' => 'Não existe preço único, e desconfiar de quem promete um é o primeiro cuidado. Explico o que realmente entra no valor de uma harmonização.',
        'published' => '2026-08-18',
        'updated' => '2026-08-18',
        'answer' => 'Não existe um valor único para harmonização facial. O investimento depende de quantas áreas vamos tratar, da quantidade de produto, da técnica e do acompanhamento depois. Por isso eu só fecho o orçamento depois da avaliação presencial, quando sei exatamente o que o seu rosto precisa.',
        'sections' => [
            [
                'heading' => 'Por que eu não passo preço por telefone',
                'body' => [
                    'Harmonização facial não é um procedimento só. É o nome de um conjunto de tratamentos. Duas mulheres que chegam pedindo "harmonização" podem sair da avaliação com planos completamente diferentes: uma precisa só de toxina em duas áreas, a outra de preenchimento, bioestimulador e fios.',
                    'Então qualquer valor dito antes de eu ver o seu rosto seria um chute. E, em saúde, chute costuma virar argumento de venda em vez de plano de tratamento.',
                ],
            ],
            [
                'heading' => 'O que entra na conta',
                'body' => [
                    'O primeiro ponto é quantas áreas vamos tratar. Toxina só na testa custa diferente de toxina na testa, entre as sobrancelhas e ao redor dos olhos, porque a quantidade de produto muda.',
                    'O segundo é a quantidade de produto. Preenchedores e bioestimuladores são medidos em seringas ou frascos, e cada rosto pede uma quantidade. Quando vejo uma proposta muito abaixo do mercado, fico com o pé atrás. A própria Anvisa aponta preço muito abaixo do praticado como sinal de alerta, porque costuma esconder produto sem registro ou aplicação feita por quem não tem formação para isso.',
                    'O terceiro é a técnica. Um resultado natural depende de conhecer a anatomia do rosto a fundo, e é isso que separa um rosto harmonioso de um rosto que parece feito.',
                    'O quarto é o acompanhamento. Retorno, ajuste e suporte depois do procedimento fazem parte do tratamento, e não são extras.',
                ],
            ],
            [
                'heading' => 'O barato que sai caro',
                'body' => [
                    'Corrigir um procedimento malfeito é mais difícil, mais demorado e mais desconfortável do que fazer certo da primeira vez. O ácido hialurônico ainda pode ser dissolvido com uma enzima. Já os preenchedores permanentes são muito mais complicados de corrigir, e às vezes não há como desfazer.',
                    'Antes de decidir pelo preço, confira três coisas: o registro de quem vai aplicar no conselho profissional, se o produto tem registro na Anvisa e se a avaliação foi feita olhando para você, e não para uma tabela. Nada disso custa nada e evita boa parte dos problemas.',
                ],
            ],
        ],
        'takeaways' => [
            'O valor só é definido depois da avaliação, porque depende do que o seu rosto precisa.',
            'Áreas tratadas, quantidade de produto, técnica e acompanhamento compõem o investimento.',
            'Preço muito abaixo do mercado é sinal de alerta, segundo a própria Anvisa.',
            'Corrigir um procedimento malfeito é mais difícil do que fazer bem da primeira vez.',
        ],
        'faq' => [
            ['q' => 'Dá para parcelar o tratamento?', 'a' => 'Aceito cartão de crédito, débito e Pix. As condições eu apresento na avaliação, junto com o plano de tratamento.'],
            ['q' => 'Preciso fazer tudo de uma vez?', 'a' => 'Não. Muitas vezes eu divido o plano em etapas e começo pelo que traz mais resultado. A gente decide isso junto na avaliação.'],
            ['q' => 'A avaliação tem custo?', 'a' => 'A primeira conversa serve para eu entender o que você deseja e avaliar o seu rosto. As condições atuais você confere pelo WhatsApp antes de agendar.'],
        ],
        'related' => ['harmonizacao-facial', 'full-face', 'toxina-botulinica'],
        'sources' => [
            ['publisher' => 'Anvisa', 'title' => 'Procedimento seguro — Estética com segurança', 'url' => 'https://www.gov.br/anvisa/pt-br/comunicacao/campanhas/estetica/procedimento-seguro', 'year' => '2024'],
            ['publisher' => 'Anvisa', 'title' => 'Anvisa recomenda: preenchedores dérmicos somente dentro das indicações aprovadas', 'url' => 'https://www.gov.br/anvisa/pt-br/assuntos/noticias-anvisa/2026/anvisa-recomenda-preenchedores-dermicos-somente-dentro-das-indicacoes-aprovadas', 'year' => '2026'],
            ['publisher' => 'Clinical, Cosmetic and Investigational Dermatology', 'title' => 'A 10-point plan for avoiding hyaluronic acid dermal filler-related complications during facial aesthetic procedures and algorithms for management', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC6257077/', 'year' => '2018'],
        ],
    ],

    'tempo-de-recuperacao' => [
        'title' => 'Quanto tempo dura a recuperação de cada procedimento? | Dra. Emily Beatriz',
        'h1' => 'Quanto tempo dura a recuperação de cada procedimento?',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'Recuperação de toxina botulínica, preenchimento, bioestimulador, microagulhamento e fios de PDO: quanto tempo cada um pede antes de agendar.',
        'excerpt' => 'A pergunta que decide a data do seu agendamento: quantos dias reservar depois de cada procedimento.',
        'published' => '2026-08-29',
        'updated' => '2026-08-29',
        'answer' => 'Na maioria dos procedimentos faciais você volta à rotina no mesmo dia. Toxina botulínica e preenchimento têm retorno imediato, com um inchaço leve nas primeiras 24 a 48 horas. O microagulhamento deixa a pele sensível por alguns dias. Já os fios de PDO, por serem mais invasivos, pedem de uma a duas semanas de cuidados.',
        'sections' => [
            [
                'heading' => 'Sai daqui e segue o dia',
                'body' => [
                    'Toxina botulínica e preenchimento labial são os procedimentos com a recuperação mais tranquila. Você sai do consultório e retoma o dia normalmente. É comum ficarem pontinhos vermelhos onde eu apliquei e algum inchaço nas primeiras 24 a 48 horas, principalmente nos lábios.',
                    'Os cuidados são simples: não massagear a região, evitar exercício intenso nas primeiras 24 horas e ficar longe de sauna e calor excessivo por um ou dois dias.',
                ],
            ],
            [
                'heading' => 'Alguns dias de cuidado',
                'body' => [
                    'O microagulhamento deixa a pele vermelha e sensível por alguns dias, às vezes até uma semana, parecido com uma queimadura de sol leve. Nesse período, protetor solar deixa de ser recomendação e vira condição para o resultado aparecer.',
                    'O bioestimulador de colágeno costuma permitir que você volte à rotina na hora, mas pede atenção às massagens dos dias seguintes, que variam conforme o produto. Eu explico cada uma antes de você ir embora.',
                ],
            ],
            [
                'heading' => 'Uma a duas semanas',
                'body' => [
                    'Os fios de PDO são colocados sob a pele, por isso pedem mais cuidado. Inchaço e sensibilidade são esperados, e por uma a duas semanas eu peço para você evitar abrir muito a boca, massagear o rosto e frequentar sauna.',
                ],
            ],
            [
                'heading' => 'Tem evento marcado?',
                'body' => [
                    'Minha regra prática é esta: quanto mais o procedimento depende de os tecidos se acomodarem, mais antecedência ele pede. A toxina botulínica precisa de pelo menos 15 dias para o efeito completo. O preenchimento pede de 7 a 14 dias para o inchaço ceder de vez. Fios de PDO, pelo menos duas semanas.',
                    'Se tem casamento, formatura ou foto importante chegando, me conte na avaliação. O planejamento muda conforme o prazo.',
                ],
            ],
        ],
        'takeaways' => [
            'Toxina botulínica e preenchimento permitem voltar à rotina no mesmo dia.',
            'Microagulhamento deixa a pele sensível por alguns dias e pede protetor solar rigoroso.',
            'Fios de PDO pedem de uma a duas semanas de cuidados.',
            'Para eventos, conte 15 dias para a toxina e mais tempo para procedimentos invasivos.',
        ],
        'faq' => [
            ['q' => 'Posso trabalhar no dia seguinte?', 'a' => 'Na maioria dos casos, sim. Toxina botulínica, preenchimento e bioestimulador permitem retorno imediato. O microagulhamento pode deixar a pele vermelha por alguns dias, e os fios de PDO pedem mais cuidado.'],
            ['q' => 'Posso fazer exercício depois?', 'a' => 'Eu oriento evitar esforço intenso nas primeiras 24 a 48 horas na maioria dos procedimentos, e por mais tempo depois dos fios de PDO. As orientações exatas eu passo para o seu caso.'],
            ['q' => 'Quando vejo o resultado final?', 'a' => 'Depende do procedimento. O preenchimento tem resultado imediato, a toxina botulínica leva de 3 a 15 dias, e bioestimulador e fios são progressivos ao longo de semanas.'],
        ],
        'related' => ['toxina-botulinica', 'preenchimento-labial', 'microagulhamento'],
        'sources' => [
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Fillers: FAQs', 'url' => 'https://www.aad.org/cosmetic/wrinkles/fillers-faqs', 'year' => 's.d.'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Botulinum toxin therapy: FAQs', 'url' => 'https://www.aad.org/public/cosmetic/wrinkles/botulinum-toxin-faqs', 'year' => 's.d.'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Microneedling can fade scars, uneven skin tone, and more', 'url' => 'https://www.aad.org/public/cosmetic/scars-stretch-marks/microneedling-fade-scars', 'year' => '2023'],
            ['publisher' => 'Life (Basel)', 'title' => 'Pre- and Post-Procedural Considerations and Thread Types for Thread Lifting', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC11766856/', 'year' => '2025'],
        ],
    ],

    'quem-nao-pode-fazer' => [
        'title' => 'Quem não pode fazer harmonização facial? | Dra. Emily Beatriz',
        'h1' => 'Quem não pode fazer harmonização facial?',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'Gestantes, algumas condições de saúde e expectativas irreais são motivos para adiar ou não indicar harmonização facial. Entenda quando a resposta é não.',
        'excerpt' => 'Uma boa avaliação inclui a possibilidade de eu dizer não. Conheça as situações em que o procedimento é adiado ou desaconselhado.',
        'published' => '2026-09-09',
        'updated' => '2026-09-09',
        'answer' => 'Gestantes e lactantes não devem fazer procedimentos injetáveis. Infecção ativa na região, doença autoimune em atividade, distúrbio de coagulação e alergia a algum componente do produto também contraindicam ou pedem avaliação médica antes. E expectativa irreal é motivo legítimo para eu não indicar: se o resultado esperado não é possível, o procedimento não deve ser feito.',
        'sections' => [
            [
                'heading' => 'As contraindicações mais comuns',
                'body' => [
                    'Gravidez e amamentação são as situações mais frequentes. Não existe prova de que o procedimento faça mal ao bebê, mas também não existem estudos que garantam a segurança nesse período, e as próprias bulas dizem isso. Em saúde, na dúvida, a gente espera. Eu sempre peço para adiar.',
                    'Infecção ativa na área que vamos tratar, incluindo herpes, impede o procedimento até cicatrizar por completo. Aplicar em cima de uma infecção pode espalhá-la.',
                    'Doença autoimune em atividade, distúrbio de coagulação e uso de anticoagulante pedem uma conversa com o médico que acompanha você. Nem sempre a resposta é não, mas sempre é conversar antes.',
                    'Alergia conhecida a algum componente do produto, como a lidocaína que vem em muitos preenchedores, contraindica aquele produto.',
                ],
            ],
            [
                'heading' => 'Quando a resposta é "ainda não"',
                'body' => [
                    'Algumas situações só mudam o momento. Tratamento odontológico recente, tratamento de pele em andamento e pele inflamada costumam pedir um intervalo.',
                    'É uma decisão técnica. Fazer na hora errada compromete o resultado pelo qual você está pagando.',
                ],
            ],
            [
                'heading' => 'Quando a expectativa é o problema',
                'body' => [
                    'Tem uma contraindicação que quase nunca aparece em lista: a expectativa que o procedimento não consegue atender. O exemplo mais comum é trazer a foto de outra pessoa e pedir aquele rosto. Estruturas diferentes dão resultados diferentes com o mesmo procedimento.',
                    'Os lábios são o exemplo mais claro. O volume que fica lindo numa boca pode pesar em outra, e insistir em copiar a referência é o caminho mais curto para um resultado artificial. Por isso, às vezes, a minha avaliação honesta termina com a recomendação de não fazer.',
                    'Quem aceita qualquer pedido sem avaliar não está sendo gentil com você. Está passando para você um risco que cabia ao profissional avaliar.',
                ],
            ],
        ],
        'takeaways' => [
            'Gestantes e lactantes devem adiar procedimentos injetáveis.',
            'Infecção ativa na região, incluindo herpes, contraindica até cicatrizar.',
            'Doença autoimune e distúrbio de coagulação pedem avaliação junto com o seu médico.',
            'Expectativa impossível de atender é motivo legítimo para não fazer.',
        ],
        'faq' => [
            ['q' => 'Posso fazer toxina botulínica amamentando?', 'a' => 'Eu oriento esperar. Não há estudos que comprovem a segurança durante a amamentação, então procedimentos injetáveis ficam para depois.'],
            ['q' => 'Tenho doença autoimune, posso fazer?', 'a' => 'Depende da doença e do momento. Em atividade, não. Quando ela está controlada, a gente pode avaliar junto com o médico que acompanha você. Traga essa informação para a avaliação.'],
            ['q' => 'Existe idade mínima ou máxima?', 'a' => 'Não existe um número fixo. O que orienta a indicação é a avaliação: a estrutura do seu rosto, o seu objetivo e o seu histórico de saúde.'],
        ],
        'related' => ['harmonizacao-facial', 'preenchimento-labial', 'toxina-botulinica'],
        'sources' => [
            ['publisher' => 'U.S. National Library of Medicine (DailyMed)', 'title' => 'BOTOX COSMETIC (onabotulinumtoxinA) injection, powder, lyophilized, for solution', 'url' => 'https://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?setid=485d9b71-6881-42c5-a620-a4360c7192ab', 'year' => '2024'],
            ['publisher' => 'Allergan Aesthetics', 'title' => 'JUVÉDERM VOLLURE XC injectable gel — Directions for Use', 'url' => 'https://www.rxabbvie.com/pdf/juvederm-vollure-xc_dfu.pdf', 'year' => '2023'],
            ['publisher' => 'Clinical, Cosmetic and Investigational Dermatology', 'title' => 'Patient factors influencing dermal filler complications: prevention, assessment, and treatment', 'url' => 'https://www.dovepress.com/patient-factors-influencing-dermal-filler-complications-prevention-ass-peer-reviewed-article-CCID', 'year' => '2015'],
            ['publisher' => 'Clinical, Cosmetic and Investigational Dermatology', 'title' => 'The 10-Point Plan 2021: Updated Concepts for Improved Procedural Safety During Facial Filler Treatments', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC8279269/', 'year' => '2021'],
            ['publisher' => 'International Journal of Women\'s Dermatology', 'title' => 'Cosmetic Surgery and Body Dysmorphic Disorder – An Update', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC5986110/', 'year' => '2017'],
        ],
    ],

    'como-se-preparar' => [
        'title' => 'Como se preparar para o seu procedimento | Dra. Emily Beatriz',
        'h1' => 'Como se preparar para o seu procedimento',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'O que fazer antes de toxina botulínica, preenchimento ou bioestimulador em Belo Horizonte. Preparo simples que melhora o resultado e reduz hematomas.',
        'excerpt' => 'Alguns cuidados nos dias anteriores reduzem hematomas e melhoram o resultado. Nenhum deles é complicado.',
        'published' => '2026-09-19',
        'updated' => '2026-09-19',
        'answer' => 'Nos dias anteriores, evite bebida alcoólica por 24 a 48 horas e me conte todos os medicamentos e suplementos que você usa, principalmente anti-inflamatórios e anticoagulantes, que aumentam a chance de hematoma. Venha com o rosto limpo, sem maquiagem, depois de comer e bem hidratada. E traga suas dúvidas anotadas.',
        'sections' => [
            [
                'heading' => 'Na semana anterior',
                'body' => [
                    'O mais importante é a informação. Faça uma lista de tudo o que você toma, incluindo suplementos e fitoterápicos, e traga para a consulta. Anti-inflamatório, ácido acetilsalicílico, anticoagulante, ômega 3, ginkgo biloba e vitamina E em dose alta aumentam a chance de ficar roxo.',
                    'Uma coisa eu peço sempre: nunca suspenda um remédio por conta própria para fazer um procedimento estético. Se algo precisar de ajuste, quem decide é o médico que receitou.',
                    'Se você tem herpes labial de vez em quando e vai preencher os lábios, me avise. Existe uma prevenção específica para esse caso, e ela faz diferença.',
                ],
            ],
            [
                'heading' => 'Nas 48 horas antes',
                'body' => [
                    'Evite bebida alcoólica. O álcool aumenta bastante a chance de hematoma, que é a queixa mais comum depois do procedimento e também a mais fácil de evitar.',
                    'Evite também sol forte e procedimentos agressivos na pele, como peeling, esfoliação forte ou depilação com cera na área que vamos tratar.',
                ],
            ],
            [
                'heading' => 'No dia',
                'body' => [
                    'Venha com o rosto limpo e sem maquiagem, ou reserve uns minutos para tirar aqui. A pele precisa estar livre para a antissepsia.',
                    'Coma antes e beba água. Chegar em jejum aumenta a chance de passar mal durante a aplicação, principalmente nos procedimentos mais longos.',
                    'E reserve um tempo. Sair correndo para outro compromisso transforma um momento de cuidado em mais uma tarefa, e as orientações do pós merecem ser ouvidas com calma.',
                ],
            ],
            [
                'heading' => 'O que trazer para a conversa',
                'body' => [
                    'Anote suas dúvidas antes. É muito comum esquecer na hora e lembrar no caminho de volta.',
                    'Se você tem uma referência do resultado que deseja, pode trazer. Só venha aberta a ouvir o que é possível no seu rosto. As melhores consultas são aquelas em que o seu desejo e a sua anatomia se encontram.',
                ],
            ],
        ],
        'takeaways' => [
            'Traga a lista completa de remédios e suplementos que você usa.',
            'Evite álcool nas 48 horas anteriores para reduzir hematomas.',
            'Nunca suspenda um remédio por conta própria antes de um procedimento estético.',
            'Venha sem maquiagem, depois de comer e com tempo reservado.',
        ],
        'faq' => [
            ['q' => 'Preciso ficar em jejum?', 'a' => 'Não, pelo contrário. Coma antes. Chegar em jejum aumenta a chance de mal-estar durante o procedimento.'],
            ['q' => 'Posso tomar analgésico antes?', 'a' => 'Evite anti-inflamatórios e ácido acetilsalicílico, que aumentam a chance de hematoma. Se você usa algum remédio de forma contínua, me conte na avaliação em vez de suspender por conta própria.'],
            ['q' => 'Posso ir de maquiagem?', 'a' => 'O ideal é chegar com o rosto limpo. Se não der, reserve alguns minutos para tirar a maquiagem antes do procedimento.'],
        ],
        'related' => ['toxina-botulinica', 'preenchimento-labial', 'bioestimulador-de-colageno'],
        'sources' => [
            ['publisher' => 'Journal of Clinical and Aesthetic Dermatology', 'title' => 'The Management of Bruising following Nonsurgical Cosmetic Treatment', 'url' => 'https://jcadonline.com/aesthetic-complications-bruising/', 'year' => '2017'],
            ['publisher' => 'Clinical, Cosmetic and Investigational Dermatology', 'title' => 'Patient factors influencing dermal filler complications: prevention, assessment, and treatment', 'url' => 'https://www.dovepress.com/patient-factors-influencing-dermal-filler-complications-prevention-ass-peer-reviewed-article-CCID', 'year' => '2015'],
            ['publisher' => 'Stony Brook Medicine, Dermatology', 'title' => 'Dermal Fillers Instructions', 'url' => 'https://stonybrookmedicine.edu/sites/default/files/Dermal%20Fillers%20Patient%20Instructions.pdf', 'year' => '2024'],
            ['publisher' => 'The Dermatologist', 'title' => 'Preventing and Managing Vasovagal Syncope', 'url' => 'https://hmpgloballearningnetwork.com/site/thederm/clinical-tips/preventing-and-managing-vasovagal-syncope', 'year' => '2024'],
        ],
    ],

    'harmonizacao-facial-depois-dos-40' => [
        'title' => 'Harmonização facial depois dos 40 e 50 anos | Dra. Emily Beatriz',
        'h1' => 'Harmonização facial depois dos 40 e 50 anos: o que muda',
        'eyebrow' => 'Pele madura',
        'meta_description' => 'Harmonização facial aos 40, 50 e na menopausa: flacidez, bigode chinês e perda de volume pedem outro plano. Veja o que faz sentido em cada fase.',
        'excerpt' => 'Depois dos 40, o rosto não pede mais volume: pede sustentação e qualidade de pele. Explico o que muda em cada fase.',
        'published' => '2026-10-13',
        'updated' => '2026-10-13',
        'answer' => 'Depois dos 40, a harmonização muda de foco. Em vez de volume e pequenos ajustes, eu priorizo sustentação e qualidade da pele, com bioestimulador de colágeno, reposição de volume nas maçãs do rosto e, quando há flacidez, fios de PDO. Depois dos 50 e na menopausa, a flacidez ganha prioridade e o tratamento costuma ser combinado e gradual.',
        'sections' => [
            [
                'heading' => 'O que acontece com o rosto a partir dos 40',
                'body' => [
                    'O envelhecimento do rosto não acontece só na pele. Por volta dos 40, três coisas se somam: o colágeno continua caindo, as bolsas de gordura do rosto diminuem e mudam de lugar, e até o osso da face perde um pouco de volume. O resultado é um rosto que vai perdendo sustentação.',
                    'No espelho, isso aparece como bigode chinês mais marcado, maçãs do rosto mais baixas, contorno da mandíbula menos nítido, olheira mais funda e uma pele mais fina e sem viço.',
                ],
            ],
            [
                'heading' => 'Por que o plano é diferente do de quem tem 30',
                'body' => [
                    'Aos 30, a harmonização costuma ser preventiva, com toxina para as primeiras rugas de expressão e pequenos ajustes de proporção. Depois dos 40, tentar resolver tudo com preenchimento é o caminho mais rápido para um rosto pesado e artificial, e é exatamente o que eu evito.',
                    'O que funciona é tratar a estrutura. Repor volume nos pontos que sustentam o rosto, como as maçãs, ajuda a suavizar o bigode chinês, e o sulco recebe só um ajuste local quando precisa. O bioestimulador melhora a firmeza da pele aos poucos, ao longo de meses. E os fios de PDO reposicionam os tecidos quando a flacidez é leve ou moderada.',
                ],
            ],
            [
                'heading' => 'Depois dos 50 e na menopausa',
                'body' => [
                    'Na menopausa, a queda dos hormônios acelera a perda de colágeno: a pele perde cerca de 30% dele nos primeiros cinco anos e fica mais fina e seca em pouco tempo. É comum a sensação de que o rosto mudou de repente, e ela tem explicação.',
                    'Nessa fase, o estímulo de colágeno é a base do tratamento, quase sempre combinado com sustentação e reposição de volume. O resultado é construído aos poucos, ao longo de alguns meses, e o objetivo é um rosto descansado, nunca a cara de quem fez muita coisa.',
                    'É também a fase em que eu preciso ser mais honesta. Em flacidez acentuada, os tratamentos sem cirurgia melhoram a pele, mas não substituem um lifting cirúrgico. Saber disso antes evita frustração e dinheiro gasto no lugar errado.',
                ],
            ],
            [
                'heading' => 'E os homens?',
                'body' => [
                    'Os mesmos processos acontecem no rosto masculino, com algumas diferenças: a pele é mais espessa e a musculatura, mais forte. Os homens costumam buscar contorno de mandíbula, tratamento de olheira e papada e rugas da testa mais suaves, sempre preservando os traços masculinos.',
                ],
            ],
        ],
        'takeaways' => [
            'Depois dos 40, o foco sai do volume e vai para a sustentação e a qualidade da pele.',
            'Tratar a sustentação do rosto deixa o resultado mais natural do que encher cada sulco.',
            'Na menopausa, o estímulo de colágeno é a base do tratamento.',
            'Em flacidez acentuada, os tratamentos sem cirurgia melhoram a pele, mas não substituem um lifting.',
        ],
        'faq' => [
            ['q' => 'Existe idade limite para fazer harmonização facial?', 'a' => 'Não. O que define a indicação é a avaliação do rosto e da saúde, e não a idade. Muitas mulheres começam depois dos 50 e têm ótimos resultados com um plano feito para a fase delas.'],
            ['q' => 'Qual o melhor tratamento para o rosto depois dos 50?', 'a' => 'Em geral, eu combino bioestimulador de colágeno, reposição de volume e, quando há flacidez, fios de PDO. O plano exato depende do seu rosto e sai da avaliação.'],
            ['q' => 'A harmonização facial fica artificial em pele madura?', 'a' => 'Não precisa ficar. O aspecto artificial vem do excesso de produto, principalmente de preenchimento. Com foco em sustentação e quantidades conservadoras, o resultado é um rosto descansado e natural.'],
        ],
        'related' => ['bioestimulador-de-colageno', 'flacidez-facial', 'bigode-chines', 'preenchimento-facial'],
        'sources' => [
            ['publisher' => 'Aesthetic Surgery Journal', 'title' => 'The Facial Aging Process From the "Inside Out"', 'url' => 'https://academic.oup.com/asj/article/41/10/1107/5873339', 'year' => '2021'],
            ['publisher' => 'Aesthetic Plastic Surgery', 'title' => 'Changes in the facial skeleton with aging: implications and clinical applications in facial rejuvenation', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC3404279/', 'year' => '2012'],
            ['publisher' => 'Plastic and Reconstructive Surgery Global Open', 'title' => 'Advances in Poly-L-lactic Acid Injections for Facial and Neck Rejuvenation', 'url' => 'https://doi.org/10.1097/GOX.0000000000007029', 'year' => '2025'],
            ['publisher' => 'American Society of Plastic Surgeons', 'title' => 'What you need to know about thread lifts', 'url' => 'https://www.plasticsurgery.org/news/blog/what-you-need-to-know-about-thread-lifts', 'year' => '2018'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Caring for your skin in menopause', 'url' => 'https://www.aad.org/public/everyday-care/skin-care-secrets/anti-aging/skin-care-during-menopause', 'year' => '2025'],
            ['publisher' => 'American Society of Plastic Surgeons', 'title' => 'Facelift Surgery', 'url' => 'https://www.plasticsurgery.org/cosmetic-procedures/facelift', 'year' => 's.d.'],
        ],
    ],

    'harmonizacao-facial-em-homens' => [
        'title' => 'Por que tantos homens fazem harmonização facial | Dra. Emily Beatriz',
        'h1' => 'Por que tantos homens estão fazendo harmonização facial',
        'eyebrow' => 'Para homens',
        'meta_description' => 'Homens famosos mostraram a harmonização facial nas últimas semanas. Veja o que os homens costumam buscar e como tratar o rosto sem perder os traços masculinos.',
        'excerpt' => 'Em poucos dias, um cantor, um ator e o governador eleito de Minas contaram que fizeram harmonização. Fica a dúvida que todo homem tem: dá para fazer sem parecer que fez?',
        'published' => '2026-10-13',
        'updated' => '2026-10-13',
        'answer' => 'Os homens procuram a harmonização por motivos bem práticos: parecer menos cansados, recuperar o contorno da mandíbula e suavizar as rugas da testa. O bom resultado depende de respeitar a anatomia masculina, com doses ajustadas a uma musculatura mais forte, pouco produto e foco na mandíbula e no queixo. Assim o rosto fica descansado e continua com cara de homem.',
        'sections' => [
            [
                'heading' => 'Uma semana de homens falando do assunto',
                'body' => [
                    'No começo de outubro, o cantor Fiuk, de 35 anos, mostrou na televisão o resultado de uma harmonização feita para corrigir pequenos detalhes do rosto. Na mesma semana, o ator Henri Castelli, de 48, voltou a uma clínica em São Paulo para repetir o tratamento que tinha feito em 2024. E em Minas o tema chegou à política: um dia depois de eleito governador, Cleitinho Azevedo fez preenchimento, bioestimulador de colágeno, ultrassom microfocado e um peeling. Segundo a clínica que o atendeu, a ideia era tirar do rosto o desgaste da campanha.',
                    'O que me chamou atenção é que nenhum deles escondeu. Até pouco tempo atrás, homem que aplicava toxina não comentava nem com os amigos. Hoje o assunto aparece em programa de auditório, e quem tinha vontade de perguntar se sente mais à vontade para marcar uma avaliação.',
                ],
            ],
            [
                'heading' => 'O que os homens costumam me pedir',
                'body' => [
                    'Poucos homens chegam dizendo que querem ficar mais bonitos. O pedido vem de lado: os colegas perguntam se ele está doente, a esposa diz que ele parece bravo o tempo todo, a foto de perfil mostra alguém mais velho do que ele se sente. Por trás disso estão sinais bem conhecidos, como olheira funda, testa e região entre as sobrancelhas muito marcadas, papada e um contorno de mandíbula que foi perdendo definição.',
                    'Muitos chegam por outro caminho, o bruxismo. Vêm tratar a dor e o desgaste dos dentes com toxina no masseter, e é ali, na cadeira de dentista, que começam a perguntar sobre a testa ou as olheiras.',
                ],
            ],
            [
                'heading' => 'Rosto de homem pede outro planejamento',
                'body' => [
                    'A pele masculina é mais grossa, a musculatura é mais forte e a estrutura óssea é diferente: mandíbula mais larga, queixo mais projetado, sobrancelha mais baixa e reta. Quando uma técnica pensada para o rosto feminino é aplicada sem adaptação, as maçãs do rosto arredondam, a ponta da sobrancelha sobe e os lábios ganham volume. É daí que vem aquela cara de quem fez alguma coisa.',
                    'Por isso, no rosto masculino, eu ajusto a dose da toxina, que costuma ser maior, e mudo os pontos de aplicação para manter a sobrancelha reta. No preenchimento, o produto vai mais para o ângulo da mandíbula e para o queixo, e bem menos para as maçãs do rosto e os lábios. Muitas vezes, o que mais rejuvenesce um homem é tratar a olheira e devolver nitidez à mandíbula, sem mexer em mais nada.',
                ],
            ],
            [
                'heading' => 'Vários procedimentos no mesmo dia',
                'body' => [
                    'Dá para combinar tratamentos numa sessão, e em alguns planos isso faz sentido. Só que o inchaço de cada um se soma e, se aparecer alguma reação, fica mais difícil saber o que a causou. Cada técnica também tem seu tempo: a toxina leva até duas semanas para fazer efeito, e o bioestimulador trabalha ao longo de meses.',
                    'Para quem vai fazer pela primeira vez, eu prefiro começar por uma ou duas áreas. Assim a gente vê como o rosto responde, ajusta no retorno e decide com calma o próximo passo.',
                ],
            ],
            [
                'heading' => 'Antes de marcar',
                'body' => [
                    'A Anvisa classifica os preenchedores como dispositivos médicos de alto risco, e as complicações graves costumam acontecer quando o produto é aplicado fora das áreas ou dos volumes indicados pelo fabricante. Então confira o registro de quem vai aplicar no conselho profissional, pergunte qual produto será usado e peça a etiqueta com o lote. Avaliação por mensagem, sem examinar o rosto, não serve.',
                    'E pergunte se o profissional tem casos masculinos para mostrar. Antes e depois de mulher diz pouco sobre como ele trabalha um rosto de homem.',
                ],
            ],
        ],
        'takeaways' => [
            'Os homens buscam parecer descansados, e não mudar de rosto.',
            'Pele mais grossa e músculo mais forte pedem doses e pontos de aplicação diferentes.',
            'Técnica feminina sem adaptação é o que deixa o homem com cara de que fez.',
            'Na primeira vez, uma ou duas áreas bem feitas rendem mais do que um pacote completo.',
        ],
        'faq' => [
            ['q' => 'Homem precisa de mais toxina botulínica do que mulher?', 'a' => 'Em geral, sim. A musculatura masculina é mais forte e costuma pedir doses maiores para o mesmo efeito. A quantidade exata eu defino na consulta, avaliando a força de cada músculo.'],
            ['q' => 'O efeito dura menos no rosto masculino?', 'a' => 'A toxina botulínica pode durar um pouco menos em quem tem músculos muito fortes, mas a diferença é pequena. Preenchimento e bioestimulador duram o mesmo tempo que nas mulheres.'],
            ['q' => 'Preciso me afastar do trabalho?', 'a' => 'Na maioria dos casos, não. Pode haver um leve inchaço ou um pequeno roxo por alguns dias. Se você tem um compromisso importante, eu recomendo marcar o procedimento com uma ou duas semanas de folga.'],
        ],
        'related' => ['harmonizacao-facial-masculina', 'toxina-botulinica', 'toxina-botulinica-bruxismo', 'preenchimento-facial'],
        'sources' => [
            ['publisher' => 'ABC Agora', 'title' => 'Aos 35 anos, Fiuk faz harmonização facial e especialista alerta para prevenção do envelhecimento', 'url' => 'https://abcagora.com.br/2026/10/01/fiuk-harmonizacao-facial-30-anos/', 'year' => '2026'],
            ['publisher' => 'O Tempo', 'title' => 'Henri Castelli faz nova harmonização facial e reforça rotina de procedimentos estéticos', 'url' => 'https://www.otempo.com.br/entretenimento/2026/10/3/henri-castelli-faz-nova-harmonizacao-facial-e-reforca-rotina-de-procedimentos-esteticos-veja', 'year' => '2026'],
            ['publisher' => 'TMC', 'title' => 'Cleitinho, governador de MG, faz harmonização facial', 'url' => 'https://tmc.com.br/lifestyle/cleitinho-azevedo-eleito-governador-harmonizacao/', 'year' => '2026'],
            ['publisher' => 'Anvisa', 'title' => 'Anvisa recomenda: preenchedores dérmicos somente dentro das indicações aprovadas', 'url' => 'https://www.gov.br/anvisa/pt-br/assuntos/noticias-anvisa/2026/anvisa-recomenda-preenchedores-dermicos-somente-dentro-das-indicacoes-aprovadas', 'year' => '2026'],
        ],
    ],

    'rosto-de-ozempic' => [
        'title' => 'Rosto de Ozempic: flacidez depois de emagrecer | Dra. Emily Beatriz',
        'h1' => 'O que acontece com o rosto de quem emagrece com Ozempic ou Mounjaro',
        'eyebrow' => 'Emagrecimento',
        'meta_description' => 'Rosto de Ozempic é a flacidez e a perda de volume depois de emagrecer rápido com canetas. Entenda por que acontece e o que dá para fazer, em Belo Horizonte.',
        'excerpt' => 'A balança desce, as roupas voltam a servir e o rosto parece mais cansado. Explico por que isso acontece e por que encher o rosto de volta não resolve.',
        'published' => '2026-10-22',
        'updated' => '2026-10-22',
        'answer' => 'O chamado rosto de Ozempic é a flacidez e a perda de volume que aparecem quando se emagrece muito em pouco tempo, com canetas como Ozempic e Mounjaro. A gordura que sustentava o rosto vai embora antes que a pele consiga se adaptar. No tratamento, eu combino bioestimulador de colágeno, para devolver firmeza, com preenchimento em poucos pontos de sustentação, sem tentar encher o rosto de volta.',
        'sections' => [
            [
                'heading' => 'De onde veio esse nome',
                'body' => [
                    'O apelido nasceu nos Estados Unidos, em consultórios de dermatologia que começaram a receber pessoas de meia-idade com o rosto encovado depois de perder muitos quilos em poucos meses. Aqui o uso das canetas cresceu muito, e desde março, quando a patente da semaglutida venceu no Brasil, novas versões do remédio começaram a chegar às farmácias.',
                    'Apesar do nome, o rosto não muda por causa do remédio. Muda por causa da velocidade do emagrecimento. O mesmo acontece depois de uma cirurgia bariátrica ou de uma dieta muito restritiva. A caneta só tornou esse tipo de perda de peso bem mais comum.',
                ],
            ],
            [
                'heading' => 'O que muda no rosto',
                'body' => [
                    'O rosto tem pequenas bolsas de gordura que funcionam como almofadas. São elas que dão volume às maçãs do rosto, preenchem as têmporas e sustentam a pele ao redor dos olhos e da boca. Quando o corpo emagrece rápido, essas bolsas diminuem junto, e a pele, que levou anos se acomodando sobre elas, não tem tempo de se retrair.',
                    'O resultado aparece em lugares previsíveis: têmporas fundas, maçãs do rosto achatadas, olheira mais marcada, bigode chinês mais profundo e pele sobrando na linha da mandíbula e no pescoço. Num levantamento com 400 profissionais, apresentado num congresso americano de cirurgia dermatológica em novembro de 2025, a queixa mais citada por quem usava essas canetas foi justamente a perda de volume no meio do rosto, seguida da flacidez na mandíbula.',
                    'A idade pesa. Aos 30, a pele ainda tem colágeno de sobra e costuma se readaptar melhor. Depois dos 45, a mesma perda de peso tende a deixar o rosto com aspecto mais cansado. A perda de massa muscular, comum quando se emagrece rápido, também contribui.',
                ],
            ],
            [
                'heading' => 'Por que encher de volta não funciona',
                'body' => [
                    'A primeira ideia de muita gente é repor com preenchimento todo o volume que foi embora. Parece lógico, mas costuma dar errado. O rosto perdeu gordura em muitos lugares ao mesmo tempo, e a pele ficou mais fina e frouxa. Colocar ácido hialurônico em todos esses pontos deixa o rosto pesado e inchado, com aquele aspecto de travesseiro que denuncia o procedimento de longe.',
                    'O problema principal é de sustentação e de qualidade da pele. Eu coloco volume só onde ele segura o resto, e em pouca quantidade.',
                ],
            ],
            [
                'heading' => 'O que eu costumo indicar',
                'body' => [
                    'O bioestimulador de colágeno costuma ser a base. Ele faz a própria pele produzir colágeno novo ao longo de alguns meses, e o rosto vai ganhando firmeza aos poucos. Em geral são de uma a três sessões, com algumas semanas de intervalo.',
                    'O preenchimento com ácido hialurônico entra de forma pontual, nas têmporas e nas maçãs do rosto, que são os pontos que sustentam o terço médio. Devolver volume ali costuma suavizar também o bigode chinês e a olheira, e muitas vezes evita preencher cada sulco. Se a flacidez for maior, os fios de PDO ajudam a reposicionar os tecidos, e o microagulhamento melhora a textura da pele.',
                    'Tem também um limite que eu faço questão de falar na avaliação. Quando sobra muita pele, principalmente no pescoço, nenhum tratamento sem cirurgia resolve por completo. Saber disso antes evita gastar com o tratamento errado.',
                ],
            ],
            [
                'heading' => 'Durante ou depois de emagrecer?',
                'body' => [
                    'Você não precisa esperar a última consulta com o endocrinologista para começar a cuidar do rosto. O bioestimulador e os cuidados com a pele podem começar durante o tratamento, porque preparam a pele para o que vem. Já a reposição de volume rende mais quando o peso está perto de se estabilizar. Antes disso, o rosto continua mudando e o preenchimento pode precisar de ajuste.',
                    'Quem prescreve e acompanha a caneta é o seu médico. Conte a ele que pretende tratar o rosto, e me conte que usa o remédio, há quanto tempo e quanto já perdeu. Comer proteína suficiente e manter algum treino de força, como o médico costuma orientar, ajuda a perder menos músculo no caminho.',
                ],
            ],
        ],
        'takeaways' => [
            'O rosto muda pela velocidade do emagrecimento, e não pelo remédio em si.',
            'As áreas mais afetadas são têmporas, maçãs do rosto, olheiras, bigode chinês e mandíbula.',
            'Repor todo o volume perdido com preenchimento deixa o rosto pesado e artificial.',
            'Bioestimulador para firmeza e preenchimento só nos pontos de sustentação costumam funcionar melhor.',
        ],
        'faq' => [
            ['q' => 'Todo mundo que usa Ozempic ou Mounjaro fica com o rosto flácido?', 'a' => 'Não. Depende de quanto peso se perde, da velocidade, da idade e da qualidade da pele. Quem perde pouco peso ou é mais jovem muitas vezes não nota diferença no rosto.'],
            ['q' => 'Se eu parar a caneta, o rosto volta ao que era?', 'a' => 'Se o peso voltar, parte da gordura do rosto volta junto. Mas a flacidez que já aconteceu na pele não se desfaz sozinha, por isso o cuidado com a qualidade da pele continua importante.'],
            ['q' => 'Posso fazer harmonização enquanto uso a caneta?', 'a' => 'Na maioria dos casos, sim. Eu só mudo a ordem: primeiro o que melhora a pele, depois a reposição de volume, quando o peso estiver mais estável. Me conte na avaliação que você usa o remédio.'],
        ],
        'related' => ['bioestimulador-de-colageno', 'preenchimento-facial', 'flacidez-facial', 'fios-de-pdo'],
        'sources' => [
            ['publisher' => 'Metrópoles', 'title' => 'Ozempic: STJ mantém fim da patente para março de 2026. Veja o que muda', 'url' => 'https://www.metropoles.com/saude/stj-mantem-fim-patente-ozempic-2026', 'year' => '2025'],
            ['publisher' => 'Dermatology Times', 'title' => 'New Survey Reveals Rise in GLP-1 Patients Seeking Cosmetic Care', 'url' => 'https://www.dermatologytimes.com/view/new-survey-reveals-rise-in-glp-1-patients-seeking-cosmetic-care', 'year' => '2025'],
            ['publisher' => 'Anvisa', 'title' => 'Anvisa recomenda: preenchedores dérmicos somente dentro das indicações aprovadas', 'url' => 'https://www.gov.br/anvisa/pt-br/assuntos/noticias-anvisa/2026/anvisa-recomenda-preenchedores-dermicos-somente-dentro-das-indicacoes-aprovadas', 'year' => '2026'],
        ],
    ],

    'fios-de-sustentacao-antes-da-plastica' => [
        'title' => 'Rosto perdeu firmeza? Talvez você não precise de plástica | Dra. Emily Beatriz',
        'h1' => 'Seu rosto perdeu firmeza? Talvez você ainda não precise de uma plástica',
        'eyebrow' => 'Flacidez',
        'meta_description' => 'Sentiu o rosto cair e pensou em plástica? Aos 40 e poucos, os fios de sustentação levantam o contorno sem cirurgia. Veja quando eles bastam.',
        'excerpt' => 'Sentiu o rosto cair e já está pensando em cirurgia? Antes disso, conheça os fios de sustentação, que levantam o contorno com anestesia local e voltam você à rotina em poucos dias.',
        'published' => '2026-10-30',
        'updated' => '2026-10-30',
        'answer' => 'Para quem tem 40 e poucos anos e sente o rosto caindo, os fios de sustentação costumam ser uma ótima alternativa antes da cirurgia plástica. Eles levantam o contorno da mandíbula e das bochechas com anestesia local, em cerca de uma hora, e estimulam colágeno. Funcionam melhor na flacidez leve a moderada, que é a mais comum nessa idade.',
        'sections' => [
            [
                'heading' => 'Quando o espelho começa a incomodar',
                'body' => [
                    'Ouço muito esta frase de mulheres de 40 e poucos anos: "meu rosto caiu, acho que só plástica resolve". E eu entendo. A mandíbula perde a definição, as bochechas descem um pouco, o bigode chinês aparece mais, e a gente começa a se achar cansada mesmo depois de uma boa noite de sono.',
                    'Só que, nessa idade, o que costuma estar acontecendo é uma flacidez leve a moderada. E para esse grau de flacidez existe um caminho bem menos invasivo do que a cirurgia.',
                ],
            ],
            [
                'heading' => 'O que os fios de sustentação fazem',
                'body' => [
                    'Os fios de PDO são feitos do mesmo material usado há décadas em suturas cirúrgicas, e o corpo absorve com o tempo. Eu coloco os fios sob a pele com agulhas finas, seguindo trajetos que puxam os tecidos para cima. Eles fazem duas coisas: levantam o contorno na hora e estimulam a produção de colágeno ao redor de cada fio nos meses seguintes.',
                    'O resultado é um contorno de mandíbula mais nítido, as bochechas de volta ao lugar e uma expressão mais descansada. O seu rosto continua sendo o seu, só que com a sustentação de alguns anos atrás.',
                    'A Sociedade Americana de Cirurgiões Plásticos descreve a candidata ideal aos fios justamente assim: alguém entre o fim dos 30 e o começo dos 50 anos, com flacidez leve a moderada.',
                ],
            ],
            [
                'heading' => 'Fios ou plástica: a diferença na prática',
                'body' => [
                    'O lifting facial, que é a cirurgia plástica do rosto, remove a pele que sobrou e reposiciona os tecidos mais profundos. O resultado é maior e dura mais, mas vem com anestesia mais pesada, cicatriz, curativo e uma recuperação que pede algumas semanas longe da rotina.',
                    'Com os fios, a aplicação leva cerca de uma hora, com anestesia local, e você volta para casa no mesmo dia. Nas primeiras uma a duas semanas eu peço alguns cuidados, como evitar abrir muito a boca, massagear o rosto e frequentar sauna, mas dá para retomar o trabalho em poucos dias. O levantamento é mais discreto, de poucos milímetros, e é justamente isso que deixa o resultado natural.',
                    'O efeito dos fios de PDO costuma durar em torno de 8 a 12 meses. Depois que eles são absorvidos, dá para repetir, e o colágeno formado ajuda a manter parte do resultado.',
                ],
            ],
            [
                'heading' => 'Melhor ainda quando combinado',
                'body' => [
                    'Aos 45, a flacidez raramente vem sozinha. O rosto também perdeu um pouco de volume e a pele está mais fina. Por isso eu costumo combinar os fios com bioestimulador de colágeno, que melhora a firmeza da pele ao longo de meses, e, quando precisa, com um pouco de preenchimento nos pontos que sustentam o rosto, como as maçãs. Cada um faz a sua parte, e o conjunto entrega um resultado que só os fios não dariam.',
                ],
            ],
            [
                'heading' => 'Quando eu indico a plástica',
                'body' => [
                    'Faço questão de ser honesta nisso. Se a pele do pescoço e da mandíbula já sobra bastante, os fios não vão dar o resultado que você espera, e eu vou indicar uma conversa com um cirurgião plástico. A própria Sociedade Americana de Cirurgiões Plásticos lembra que os tratamentos sem cirurgia não alcançam o resultado de um lifting, embora ajudem a adiá-lo.',
                    'Também falo dos riscos. Num estudo com 2.000 aplicações de fios de PDO, publicado em 2026, cerca de 12% tiveram alguma intercorrência, principalmente pequenas retrações na pele e assimetria. O risco aumentou com o número de fios e com a idade. Por isso eu planejo cada trajeto, uso só os fios necessários e trabalho apenas com produto registrado na Anvisa.',
                ],
            ],
            [
                'heading' => 'Antes de marcar a cirurgia, faça uma avaliação',
                'body' => [
                    'Se você está com 40 e poucos anos e sente que o rosto caiu, vale passar por uma avaliação antes de decidir pela plástica. Eu examino a sua pele, o grau de flacidez e o volume do rosto, e explico com clareza se os fios resolvem, se vale combinar com outros tratamentos ou se a cirurgia é mesmo o melhor caminho para você.',
                ],
            ],
        ],
        'takeaways' => [
            'Aos 40 e poucos, a maior parte da flacidez é leve a moderada, e os fios costumam resolver bem.',
            'Os fios levantam o contorno na hora e estimulam colágeno nos meses seguintes.',
            'A aplicação é feita com anestesia local, e a volta à rotina leva poucos dias.',
        ],
        'faq' => [
            ['q' => 'Fios de sustentação doem?', 'a' => 'A aplicação é feita com anestesia local, então o desconforto é pequeno. Nos primeiros dias a região pode ficar sensível e um pouco inchada, o que é esperado.'],
            ['q' => 'Quanto tempo dura o resultado dos fios?', 'a' => 'Com os fios de PDO, o resultado costuma durar em torno de 8 a 12 meses, variando com a pele e o estilo de vida. Depois que os fios são absorvidos, dá para repetir.'],
            ['q' => 'Posso fazer fios e bioestimulador no mesmo plano?', 'a' => 'Pode, e muitas vezes é o que eu indico. Os fios cuidam da sustentação e o bioestimulador melhora a firmeza da pele. A ordem e o intervalo entre eles eu defino na avaliação.'],
        ],
        'related' => ['fios-de-pdo', 'flacidez-facial', 'bioestimulador-de-colageno', 'bigode-chines'],
        'sources' => [
            ['publisher' => 'American Society of Plastic Surgeons', 'title' => 'What you need to know about thread lifts', 'url' => 'https://www.plasticsurgery.org/news/blog/what-you-need-to-know-about-thread-lifts', 'year' => '2018'],
            ['publisher' => 'American Society of Plastic Surgeons', 'title' => 'Facelift Surgery', 'url' => 'https://www.plasticsurgery.org/cosmetic-procedures/facelift', 'year' => 's.d.'],
            ['publisher' => 'Life (Basel)', 'title' => 'Pre- and Post-Procedural Considerations and Thread Types for Thread Lifting', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC11766856/', 'year' => '2025'],
            ['publisher' => 'Aesthetic Plastic Surgery', 'title' => 'Incidence and Predictors of Complications After Polydioxanone Thread Lift: A Multicenter Retrospective Cohort Study', 'url' => 'https://pubmed.ncbi.nlm.nih.gov/42236870', 'year' => '2026'],
            ['publisher' => 'Plastic and Reconstructive Surgery Global Open', 'title' => 'Advances in Poly-L-lactic Acid Injections for Facial and Neck Rejuvenation', 'url' => 'https://doi.org/10.1097/GOX.0000000000007029', 'year' => '2025'],
            ['publisher' => 'Anvisa', 'title' => 'Procedimento seguro — Estética com segurança', 'url' => 'https://www.gov.br/anvisa/pt-br/comunicacao/campanhas/estetica/procedimento-seguro', 'year' => '2024'],
        ],
    ],

    'harmonizacao-facial-aos-20-anos' => [
        'title' => 'Harmonização facial aos 20 anos: o que faz sentido | Dra. Emily Beatriz',
        'h1' => 'Harmonização facial aos 20 e poucos anos: o que faz sentido para você',
        'eyebrow' => 'Pele jovem',
        'meta_description' => 'Harmonização facial aos 20 anos: toxina, bruxismo, lábios e cuidados de pele que fazem sentido na sua idade. Veja como planejar com segurança em BH.',
        'excerpt' => 'Começar a cuidar do rosto cedo pode ser ótimo, desde que seja com a indicação certa. Conto o que faz sentido aos 20 e poucos anos e o que eu evito.',
        'published' => '2026-11-02',
        'updated' => '2026-11-02',
        'answer' => 'Aos 20 e poucos anos, harmonização facial faz sentido quando segue uma indicação, e não a idade. Toxina para uma linha que já começa a marcar, tratamento do bruxismo, um preenchimento labial sutil e cuidados com a pele e as marcas de acne são bem indicados nessa fase. O ponto de partida é uma avaliação que planeje a prevenção para o seu rosto.',
        'sections' => [
            [
                'heading' => 'Começar cedo pode ser uma ótima ideia',
                'body' => [
                    'Tenho recebido no consultório cada vez mais mulheres na faixa dos 20 e poucos anos, e acho isso ótimo. Quem começa a cuidar do rosto cedo, com orientação, chega aos 40 com muito menos para corrigir. E não sou só eu que noto: numa pesquisa feita nos Estados Unidos, mais da metade dos cirurgiões plásticos faciais disse estar atendendo mais gente abaixo dos 30, e boa parte busca resultados sutis e preventivos.',
                    'O segredo é fazer o que o seu rosto pede agora, e não o que está em alta. Aos 25, a pele ainda produz colágeno com folga e o rosto tem volume de sobra, então o plano é bem diferente do de quem tem 45. É justamente por isso que vale passar por uma avaliação.',
                ],
            ],
            [
                'heading' => 'O que costuma fazer sentido nessa fase',
                'body' => [
                    'Toxina botulínica para as primeiras linhas. Se você já nota uma ruguinha na testa ou entre as sobrancelhas que continua lá mesmo com o rosto relaxado, a toxina em dose baixa ajuda a evitar que ela se aprofunde. Uma revisão científica de 2025 considerou essa estratégia promissora, e eu indico com critério, olhando a força de cada músculo.',
                    'Bruxismo. Se você range ou aperta os dentes, principalmente à noite, a toxina no masseter alivia a dor, protege os dentes e ainda deixa o contorno do rosto mais suave. Como dentista, esse é um tratamento de que eu gosto muito, porque cuida da saúde e da estética ao mesmo tempo.',
                    'Lábios. Um preenchimento labial sutil, que dá viço e define o contorno sem transformar a sua boca, combina muito bem com essa idade.',
                    'Pele e marcas de acne. O microagulhamento melhora textura, poros e cicatrizes de acne, assim que a acne estiver controlada.',
                    'Proporção. Uma assimetria que incomoda ou um queixo pouco projetado podem ser equilibrados com pouco produto, desde que o plano respeite os seus traços.',
                ],
            ],
            [
                'heading' => 'Menos produtos na pia do banheiro',
                'body' => [
                    'Um estudo publicado na revista Pediatrics analisou os vídeos de skincare mais vistos do TikTok e encontrou, em média, 11 ativos capazes de irritar a pele em cada rotina. Protetor solar aparecia em só uma de cada quatro rotinas da manhã.',
                    'Glicólico, salicílico, retinol e esfoliante, tudo junto e todo dia, desgastam a barreira da pele, e pele irritada parece mais velha. A Academia Americana de Dermatologia resume bem: se o produto arde ou queima, pare de usar. Para a maioria das mulheres de 20 e poucos anos, eu oriento o básico bem feito: sabonete suave, hidratante e protetor solar FPS 30 ou mais, todos os dias.',
                ],
            ],
            [
                'heading' => 'O que eu evito',
                'body' => [
                    'Copiar a boca ou a mandíbula de outra pessoa costuma dar um resultado que não combina com o resto do rosto. E repetir preenchimento sem critério ao longo dos anos acumula produto. Por isso, na consulta, eu mostro o que valoriza os seus traços e monto um plano que acompanha você com o tempo.',
                    'Se eu perceber que o incômodo é mais emocional do que físico, vou dizer com carinho. Harmonização boa é a que faz você se reconhecer no espelho, só que mais descansada e mais confiante.',
                ],
            ],
            [
                'heading' => 'Por onde começar',
                'body' => [
                    'Marque uma avaliação. Nela eu analiso o seu rosto e a sua pele, entendo o que incomoda você e monto um plano por etapas, que pode incluir um procedimento agora ou só cuidados de pele por um tempo. Você sai com clareza do que faz sentido para a sua idade e para o seu orçamento.',
                    'E o protetor solar de todo dia continua sendo o seu melhor aliado contra as rugas, em qualquer idade.',
                ],
            ],
        ],
        'takeaways' => [
            'Aos 20 e poucos anos, o que define o tratamento é a indicação, e não a idade.',
            'Toxina para as primeiras linhas, bruxismo, lábios sutis e cuidados com a pele são ótimos pontos de partida.',
            'Rotina com muitos ácidos ao mesmo tempo irrita a pele: menos é mais.',
            'Uma avaliação cedo ajuda a planejar a prevenção e a evitar excessos.',
        ],
        'faq' => [
            ['q' => 'Com que idade posso começar a toxina botulínica?', 'a' => 'Não existe uma idade certa. Eu indico quando já aparece uma linha marcada com o rosto em repouso, ou quando há bruxismo. Quando há indicação, costumo começar com doses baixas.'],
            ['q' => 'Harmonização aos 20 anos fica artificial?', 'a' => 'Não precisa ficar. Nessa idade, o segredo é pouco produto e muito planejamento. O objetivo é valorizar os seus traços, e não mudar o seu rosto.'],
            ['q' => 'Tenho acne. Posso fazer algum procedimento?', 'a' => 'Primeiro, trate a acne com um dermatologista. Com a pele inflamada, a maior parte dos procedimentos fica para depois. As marcas e cicatrizes podem ser tratadas com microagulhamento quando a pele estiver sob controle.'],
        ],
        'related' => ['toxina-botulinica', 'toxina-botulinica-bruxismo', 'preenchimento-labial', 'microagulhamento'],
        'sources' => [
            ['publisher' => 'O Tempo', 'title' => 'Skincare complexo e procedimentos precoces podem fazer mais mal do que bem à pele; entenda', 'url' => 'https://www.otempo.com.br/interessa/2026/10/21/skincare-complexo-e-procedimentos-precoces-podem-fazer-mais-mal-do-que-bem-a-pele-entenda', 'year' => '2026'],
            ['publisher' => 'American Academy of Facial Plastic and Reconstructive Surgery', 'title' => 'AAFPRS reveals the trends defining facial plastic surgery', 'url' => 'https://aafprs.org/Media/Press_Releases/New_Trends_in_Facial_Plastic_Surgery.aspx', 'year' => '2026'],
            ['publisher' => 'Northwestern University (ScienceDaily)', 'title' => 'Burning for Beauty: How TikTok Skin Trends Are Harming Young Girls', 'url' => 'https://www.sciencedaily.com/releases/2025/06/250609054355.htm', 'year' => '2025'],
            ['publisher' => 'Muscles (MDPI)', 'title' => 'Proactive Aesthetic Strategies: Evaluating the Preventive Role of Botulinum Toxin in Facial Aging', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC12372128/', 'year' => '2025'],
            ['publisher' => 'American Academy of Dermatology', 'title' => '11 ways to reduce premature skin aging', 'url' => 'https://www.aad.org/public/everyday-care/skin-care-secrets/anti-aging/reduce-premature-aging-skin', 'year' => '2021'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Dermatologist-recommended skin care for your 20s', 'url' => 'https://www.aad.org/public/everyday-care/skin-care-basics/care/skin-care-in-your-20s', 'year' => '2023'],
        ],
    ],

];
