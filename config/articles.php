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
|   topics            => slugs de config/topics.php (ao menos um). O primeiro
|                        é o tema principal do artigo.
|   image, image_alt  => foto do artigo em public/blog/{slug}/ e seu texto
|                        alternativo (opcional). Aparece no topo, no
|                        compartilhamento e no JSON-LD. Sem ela, a capa segue
|                        tipográfica. Nunca use public/artigos/: uma pasta com
|                        o nome de uma rota faz o nginx responder 403.
|   meta_description  => meta description
|   excerpt           => resumo curto (card do índice)
|   published         => data de publicação (Y-m-d)
|   updated           => data da última revisão (Y-m-d)
|   sections          => [['heading' => ..., 'body' => [parágrafo, ...]], ...]
|                        Parágrafo aceita link interno: [texto](procedure:slug)
|                        ou [texto](article:slug). Slug inexistente quebra a
|                        página em vez de publicar link morto.
|                        Seção aceita 'figure' => ['src' => ..., 'alt' => ...,
|                        'caption' => ...] (caption opcional): imagem em
|                        public/ exibida depois dos parágrafos. Gere as
|                        variantes {base}.webp e {base}-480w/768w/1120w.webp.
|   takeaways        => lista de pontos-chave (opcional)
|   faq               => [['q' => ..., 'a' => ...], ...]
|   related           => slugs de config/procedures.php
|   sources           => [['publisher' => ..., 'title' => ..., 'url' => ...,
|                        'year' => ...], ...] referências citadas no fim do
|                        artigo e no JSON-LD (citation). De 2 a 3 fontes,
|                        nunca mais. Use só fontes
|                        verificadas, que sustentem o que o texto afirma.
|                        O título fica como no original, mesmo com nome de
|                        marca: a regra de não citar marcas vale para o
|                        texto do artigo, não para as fontes. A exceção é
|                        "botox": a palavra gera alerta no Google Ads, então
|                        fonte com ela no título não entra.
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
        'topics' => ['antes-de-agendar'],
        'meta_description' => 'O que define o valor da harmonização facial em BH: áreas tratadas, quantidade de produto, técnica e acompanhamento. Entenda antes de agendar.',
        'excerpt' => 'Não existe preço único para harmonização facial. Explico o que entra no valor e por que desconfiar de quem passa preço sem ver o seu rosto.',
        'published' => '2026-08-18',
        'updated' => '2026-08-18',
        'sections' => [
            [
                'heading' => 'Por que eu não passo valor por telefone',
                'body' => [
                    'Harmonização facial é o nome de um conjunto de tratamentos, e cada rosto pede uma combinação diferente. Duas mulheres podem chegar pedindo a mesma coisa e sair da avaliação com planos bem diferentes. Uma precisa só de [toxina botulínica](procedure:toxina-botulinica) em duas áreas. A outra pode precisar de [preenchimento](procedure:preenchimento-facial), [bioestimulador](procedure:bioestimulador-de-colageno) e [fios](procedure:fios-de-pdo).',
                    'Por isso, qualquer valor dito antes de eu ver o seu rosto seria um chute. E chute, em saúde, costuma virar argumento de venda em vez de plano de tratamento.',
                ],
            ],
            [
                'heading' => 'O que entra na conta',
                'body' => [
                    'Primeiro, quantas áreas vamos tratar. Cuidar só da testa é diferente de cuidar da testa, do meio das sobrancelhas e do canto dos olhos, porque a quantidade de produto muda.',
                    'Depois, a quantidade de produto em si. Cada rosto pede uma medida. Quando vejo uma oferta muito abaixo do que se costuma cobrar, fico com o pé atrás. A própria Anvisa trata isso como sinal de alerta, porque pode esconder produto sem registro ou aplicação feita por quem não tem formação.',
                    'Também conta a técnica. Um resultado natural depende de conhecer muito bem o rosto por dentro. É isso que ajuda o rosto a parecer harmonioso, e não artificial.',
                    'E, por fim, o acompanhamento. Retorno e ajustes depois do procedimento fazem parte do tratamento.',
                ],
            ],
            [
                'heading' => 'O barato que sai caro',
                'body' => [
                    'Consertar um procedimento malfeito costuma ser mais difícil e mais demorado do que fazer certo desde o início. O ácido hialurônico ainda pode ser dissolvido com uma enzima. Já os preenchedores permanentes são bem mais complicados de corrigir, e às vezes não dá para desfazer.',
                    'Antes de escolher pelo preço, confira [três coisas](article:quem-nao-pode-fazer): se quem vai aplicar tem registro no conselho profissional, se o produto tem registro na Anvisa e se a avaliação foi feita olhando para você. Quando quiser, marque a sua avaliação comigo. A gente monta o seu plano com calma.',
                ],
            ],
        ],
        'takeaways' => [
            'O valor só sai depois da avaliação, porque depende do seu rosto.',
            'Áreas tratadas, quantidade de produto, técnica e acompanhamento formam o investimento.',
            'Preço muito abaixo do normal é sinal de alerta, segundo a Anvisa.',
            'Fazer bem da primeira vez é mais simples do que corrigir depois.',
        ],
        'faq' => [
            ['q' => 'Dá para parcelar o tratamento?', 'a' => 'Aceito cartão de crédito, débito e Pix. As condições eu apresento na avaliação, junto com o plano de tratamento.'],
            ['q' => 'Preciso fazer tudo de uma vez?', 'a' => 'Não. Muitas vezes eu divido o plano em etapas e começo pelo que faz mais diferença para você. A gente decide isso junto na avaliação.'],
            ['q' => 'A avaliação tem custo?', 'a' => 'A primeira conversa serve para eu entender o que você deseja e olhar o seu rosto com calma. As condições atuais você confere pelo WhatsApp antes de agendar.'],
        ],
        'related' => ['harmonizacao-facial', 'full-face', 'toxina-botulinica'],
        'sources' => [
            ['publisher' => 'Anvisa', 'title' => 'Procedimento seguro — Estética com segurança', 'url' => 'https://www.gov.br/anvisa/pt-br/comunicacao/campanhas/estetica/procedimento-seguro', 'year' => '2024'],
            ['publisher' => 'Anvisa', 'title' => 'Anvisa recomenda: preenchedores dérmicos somente dentro das indicações aprovadas', 'url' => 'https://www.gov.br/anvisa/pt-br/assuntos/noticias-anvisa/2026/anvisa-recomenda-preenchedores-dermicos-somente-dentro-das-indicacoes-aprovadas', 'year' => '2026'],
            ['publisher' => 'Clinical, Cosmetic and Investigational Dermatology', 'title' => 'A 10-point plan for avoiding hyaluronic acid dermal filler-related complications during facial aesthetic procedures and algorithms for management', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC6257077/', 'year' => '2018'],
        ],
    ],

    'tempo-de-recuperacao' => [
        'title' => 'Quanto tempo dura a recuperação de cada procedimento?',
        'h1' => 'Quanto tempo dura a recuperação de cada procedimento?',
        'eyebrow' => 'Antes de agendar',
        'topics' => ['antes-de-agendar', 'toxina-botulinica'],
        'meta_description' => 'Quanto tempo leva a recuperação de toxina botulínica, preenchimento, bioestimulador, microagulhamento e fios de PDO. Saiba antes de agendar.',
        'excerpt' => 'Quantos dias reservar depois de cada procedimento? Conto o que esperar para você escolher a melhor data.',
        'published' => '2026-08-29',
        'updated' => '2026-08-29',
        'sections' => [
            [
                'heading' => 'Sai daqui e segue o dia',
                'body' => [
                    'A [toxina botulínica](procedure:toxina-botulinica) e o [preenchimento labial](procedure:preenchimento-labial) têm a recuperação mais tranquila. Você sai do consultório e segue a sua rotina. Podem ficar uns pontinhos vermelhos onde eu apliquei e um pouco de inchaço nos primeiros dias, principalmente nos lábios.',
                    'Os cuidados são simples. Não massageie a região, deixe o exercício pesado para depois do primeiro dia e fique longe de sauna e calor forte por um ou dois dias.',
                ],
            ],
            [
                'heading' => 'Alguns dias de cuidado',
                'body' => [
                    'O [microagulhamento](procedure:microagulhamento) deixa a pele vermelha e sensível por alguns dias, parecido com quando a gente pega sol demais. Nessa fase, protetor solar é obrigatório.',
                    'O [bioestimulador de colágeno](procedure:bioestimulador-de-colageno) costuma deixar você voltar à rotina na hora. Ele só pede alguns cuidados em casa nos dias seguintes, que mudam conforme o produto. Eu explico tudo antes de você ir embora.',
                ],
            ],
            [
                'heading' => 'Uma a duas semanas',
                'body' => [
                    'Os [fios de PDO](procedure:fios-de-pdo) ficam sob a pele, então pedem um pouco mais de cuidado. Inchaço e sensibilidade são esperados.',
                    'Por uma a duas semanas, eu peço para você evitar abrir muito a boca, massagear o rosto e ir à sauna.',
                ],
            ],
            [
                'heading' => 'Tem evento marcado?',
                'body' => [
                    'Minha dica é marcar com pelo menos 15 dias de antecedência. É o tempo para a toxina botulínica chegar ao efeito completo e para o inchaço de um preenchimento ceder de vez. Para os fios, quanto mais folga, melhor.',
                    'Se tem casamento, formatura ou foto importante chegando, me conte na avaliação. A gente planeja tudo pensando na sua data.',
                ],
            ],
        ],
        'takeaways' => [
            'Toxina botulínica e preenchimento deixam você voltar à rotina no mesmo dia.',
            'Microagulhamento deixa a pele sensível por alguns dias e pede protetor solar.',
            'Fios de PDO pedem de uma a duas semanas de cuidados.',
            'Para eventos, marque com pelo menos 15 dias de antecedência.',
        ],
        'faq' => [
            ['q' => 'Posso trabalhar no dia seguinte?', 'a' => 'Na maioria dos casos, sim. Toxina botulínica, preenchimento e bioestimulador deixam você voltar na hora. O microagulhamento pode deixar a pele vermelha por alguns dias, e os fios de PDO pedem mais cuidado.'],
            ['q' => 'Posso fazer exercício depois?', 'a' => 'Eu peço para evitar esforço pesado nos primeiros dias na maioria dos procedimentos, e por mais tempo depois dos fios de PDO. As orientações certas para o seu caso eu passo na consulta.'],
            ['q' => 'Quando vejo o resultado final?', 'a' => 'Depende do procedimento. O preenchimento aparece na hora. A toxina botulínica começa a agir em poucos dias e chega ao efeito completo em cerca de duas semanas. Bioestimulador e fios agem aos poucos, ao longo de semanas.'],
        ],
        'related' => ['toxina-botulinica', 'preenchimento-labial', 'microagulhamento'],
        'sources' => [
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Fillers: FAQs', 'url' => 'https://www.aad.org/cosmetic/wrinkles/fillers-faqs', 'year' => 's.d.'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Botulinum toxin therapy: FAQs', 'url' => 'https://www.aad.org/public/cosmetic/wrinkles/botulinum-toxin-faqs', 'year' => 's.d.'],
            ['publisher' => 'Life (Basel)', 'title' => 'Pre- and Post-Procedural Considerations and Thread Types for Thread Lifting', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC11766856/', 'year' => '2025'],
        ],
    ],

    'quem-nao-pode-fazer' => [
        'title' => 'Quem não pode fazer harmonização facial? | Dra. Emily Beatriz',
        'h1' => 'Quem não pode fazer harmonização facial?',
        'eyebrow' => 'Antes de agendar',
        'topics' => ['antes-de-agendar'],
        'meta_description' => 'Gravidez, algumas condições de saúde e expectativas fora da realidade podem adiar a harmonização facial. Entenda quando a resposta é não.',
        'excerpt' => 'Uma boa avaliação inclui a chance de eu dizer não. Veja quando o procedimento fica para depois ou não é indicado.',
        'published' => '2026-09-09',
        'updated' => '2026-09-09',
        'sections' => [
            [
                'heading' => 'As contraindicações mais comuns',
                'body' => [
                    'Gravidez e amamentação são as situações mais comuns. Não há prova de que o procedimento faça mal ao bebê, mas também não há estudos que garantam a segurança nessa fase, e as próprias bulas dizem isso. Na dúvida, a gente espera. Eu sempre peço para adiar.',
                    'Infecção na região que vamos tratar, incluindo herpes, impede o procedimento até cicatrizar por completo. Aplicar em cima de uma infecção pode espalhá-la.',
                    'Doença autoimune em atividade, problema de coagulação do sangue e uso de anticoagulante pedem uma conversa com o seu médico antes. Nem sempre a resposta é não, mas a conversa vem primeiro.',
                    'Se você tem alergia a algum componente do produto, como a lidocaína, um anestésico que vem em muitos [preenchedores](procedure:preenchimento-facial), aquele produto fica de fora.',
                ],
            ],
            [
                'heading' => 'Quando a resposta é "ainda não"',
                'body' => [
                    'Algumas situações só mudam a data. Tratamento odontológico recente, tratamento de pele em andamento e pele irritada costumam pedir um intervalo.',
                    'Esperar o momento certo protege o seu resultado e o seu investimento.',
                ],
            ],
            [
                'heading' => 'Quando a expectativa é o problema',
                'body' => [
                    'Tem uma contraindicação que quase nunca aparece em lista: esperar do procedimento algo que ele não consegue entregar. O caso mais comum é trazer a foto de outra pessoa e pedir aquele rosto. Cada rosto tem a sua estrutura, e o mesmo procedimento fica diferente em cada um.',
                    'Os [lábios](procedure:preenchimento-labial) mostram isso bem. O volume que fica lindo numa boca pode pesar em outra. Por isso, às vezes, a minha avaliação sincera termina com a recomendação de não fazer.',
                    'Dizer sim a qualquer pedido sem avaliar seria passar para você um risco que cabe a mim avaliar. Se você está pensando em fazer, marque uma avaliação. A gente conversa com calma sobre o que faz sentido para o seu rosto.',
                ],
            ],
        ],
        'takeaways' => [
            'Grávidas e mulheres amamentando devem adiar os procedimentos injetáveis.',
            'Infecção na região, incluindo herpes, adia o procedimento até cicatrizar.',
            'Doença autoimune e problema de coagulação pedem conversa com o seu médico.',
            'Expectativa impossível de atender é motivo para não fazer.',
        ],
        'faq' => [
            ['q' => 'Posso fazer toxina botulínica amamentando?', 'a' => 'Eu oriento esperar. Não há estudos que mostrem que é seguro durante a amamentação, então os procedimentos injetáveis ficam para depois.'],
            ['q' => 'Tenho doença autoimune, posso fazer?', 'a' => 'Depende da doença e do momento. Em atividade, não. Quando ela está controlada, a gente pode avaliar junto com o médico que acompanha você. Traga essa informação para a avaliação.'],
            ['q' => 'Existe idade mínima ou máxima?', 'a' => 'Não existe um número fixo. O que define a indicação é a avaliação do seu rosto, do seu objetivo e da sua saúde.'],
        ],
        'related' => ['harmonizacao-facial', 'preenchimento-labial', 'toxina-botulinica'],
        'sources' => [
            ['publisher' => 'U.S. National Library of Medicine (MedlinePlus)', 'title' => 'PrabotulinumtoxinA-xvfs Injection', 'url' => 'https://medlineplus.gov/druginfo/meds/a619021.html', 'year' => '2020'],
            ['publisher' => 'Clinical, Cosmetic and Investigational Dermatology', 'title' => 'Patient factors influencing dermal filler complications: prevention, assessment, and treatment', 'url' => 'https://www.dovepress.com/patient-factors-influencing-dermal-filler-complications-prevention-ass-peer-reviewed-article-CCID', 'year' => '2015'],
            ['publisher' => 'International Journal of Women\'s Dermatology', 'title' => 'Cosmetic Surgery and Body Dysmorphic Disorder – An Update', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC5986110/', 'year' => '2017'],
        ],
    ],

    'como-se-preparar' => [
        'title' => 'Como se preparar para o seu procedimento | Dra. Emily Beatriz',
        'h1' => 'Como se preparar para o seu procedimento',
        'eyebrow' => 'Antes de agendar',
        'topics' => ['antes-de-agendar'],
        'meta_description' => 'O que fazer antes de toxina botulínica, preenchimento ou bioestimulador em BH. Cuidados simples que ajudam a evitar roxos e deixam tudo mais tranquilo.',
        'excerpt' => 'Alguns cuidados simples nos dias anteriores ajudam a evitar roxos e deixam o procedimento mais tranquilo.',
        'published' => '2026-09-19',
        'updated' => '2026-09-19',
        'sections' => [
            [
                'heading' => 'Na semana anterior',
                'body' => [
                    'O mais importante é me contar tudo o que você usa. Faça uma lista dos remédios, suplementos e produtos naturais, e traga para a consulta. Anti-inflamatório, aspirina, anticoagulante e alguns suplementos, como ômega 3, ginkgo biloba e vitamina E em dose alta, aumentam a chance de ficar roxo.',
                    'Uma coisa eu peço sempre: nunca pare um remédio por conta própria por causa de um procedimento estético. Se algo precisar mudar, quem decide é o médico que receitou.',
                    'Se você tem herpes labial de vez em quando e vai [preencher os lábios](procedure:preenchimento-labial), me avise. Dá para fazer uma prevenção antes, e ela ajuda bastante.',
                ],
            ],
            [
                'heading' => 'Nas 48 horas antes',
                'body' => [
                    'Evite bebida alcoólica. O álcool aumenta bastante a chance de roxo, que é a queixa mais comum depois do procedimento e também a mais fácil de evitar.',
                    'Nesses dias, deixe a pele da região em paz, sem nada que possa irritá-la.',
                ],
            ],
            [
                'heading' => 'No dia',
                'body' => [
                    'Venha com o rosto limpo e sem maquiagem, ou reserve uns minutos para tirar aqui. A pele precisa estar bem limpa para eu higienizar antes de aplicar.',
                    'Coma antes e beba água. Chegar em jejum aumenta a chance de passar mal durante a aplicação.',
                    'E reserve um tempo. Sair correndo para outro compromisso tira a calma do momento, e as [orientações do pós](article:tempo-de-recuperacao) merecem ser ouvidas com atenção.',
                ],
            ],
            [
                'heading' => 'O que trazer para a conversa',
                'body' => [
                    'Anote suas dúvidas antes. É muito comum esquecer na hora e lembrar no caminho de volta.',
                    'Se você tem uma foto de referência, pode trazer. Só venha aberta a ouvir o que combina com o seu rosto. As melhores consultas são aquelas em que o seu desejo e o seu rosto se encontram. Quando estiver pronta, é só marcar a sua avaliação.',
                ],
            ],
        ],
        'takeaways' => [
            'Traga a lista de tudo o que você toma, inclusive suplementos.',
            'Evite álcool nos dois dias anteriores para reduzir o risco de roxos.',
            'Nunca pare um remédio por conta própria antes de um procedimento estético.',
            'Venha sem maquiagem, alimentada e sem pressa.',
        ],
        'faq' => [
            ['q' => 'Preciso ficar em jejum?', 'a' => 'Não, pelo contrário. Coma antes. Chegar em jejum aumenta a chance de se sentir mal durante o procedimento.'],
            ['q' => 'Posso tomar analgésico antes?', 'a' => 'Evite anti-inflamatório e aspirina, que aumentam a chance de roxo. Se você usa algum remédio todo dia, me conte na avaliação em vez de parar por conta própria.'],
            ['q' => 'Posso ir de maquiagem?', 'a' => 'O ideal é chegar com o rosto limpo. Se não der, reserve alguns minutos para tirar a maquiagem antes do procedimento.'],
        ],
        'related' => ['toxina-botulinica', 'preenchimento-labial', 'bioestimulador-de-colageno'],
        'sources' => [
            ['publisher' => 'Journal of Clinical and Aesthetic Dermatology', 'title' => 'The Management of Bruising following Nonsurgical Cosmetic Treatment', 'url' => 'https://jcadonline.com/aesthetic-complications-bruising/', 'year' => '2017'],
            ['publisher' => 'Clinical, Cosmetic and Investigational Dermatology', 'title' => 'Patient factors influencing dermal filler complications: prevention, assessment, and treatment', 'url' => 'https://www.dovepress.com/patient-factors-influencing-dermal-filler-complications-prevention-ass-peer-reviewed-article-CCID', 'year' => '2015'],
            ['publisher' => 'The Dermatologist', 'title' => 'Preventing and Managing Vasovagal Syncope', 'url' => 'https://hmpgloballearningnetwork.com/site/thederm/clinical-tips/preventing-and-managing-vasovagal-syncope', 'year' => '2024'],
        ],
    ],

    'harmonizacao-facial-depois-dos-40' => [
        'title' => 'Harmonização facial depois dos 40 e 50 anos',
        'h1' => 'Harmonização facial depois dos 40 e 50 anos: o que muda',
        'eyebrow' => 'Pele madura',
        'topics' => ['flacidez-e-firmeza', 'idade-e-perfil'],
        'meta_description' => 'Harmonização facial aos 40, 50 e na menopausa: flacidez, bigode chinês e perda de volume pedem outro plano. Veja o que faz sentido em cada fase.',
        'excerpt' => 'Depois dos 40, o rosto não pede mais volume: pede sustentação e qualidade de pele. Explico o que muda em cada fase.',
        'published' => '2026-10-13',
        'updated' => '2026-10-13',
        'sections' => [
            [
                'heading' => 'O que acontece com o rosto a partir dos 40',
                'body' => [
                    'O rosto não envelhece só na pele. Por volta dos 40, várias mudanças se somam. O colágeno continua caindo, as pequenas bolsas de gordura que dão volume ao rosto diminuem e escorregam um pouco, e até o osso por baixo de tudo perde um pouco de forma. Os estudos mostram que é esse conjunto que faz o rosto perder sustentação.',
                    'No espelho, você percebe o [bigode chinês](procedure:bigode-chines) mais marcado, as maçãs do rosto mais baixas e o contorno da mandíbula menos nítido. A [olheira](procedure:preenchimento-de-olheiras) fica mais funda, e a pele, mais fina e sem viço.',
                ],
            ],
            [
                'heading' => 'Por que o plano é diferente do de quem tem 30',
                'body' => [
                    'Aos 30, a harmonização costuma ser preventiva. Um pouco de toxina botulínica para as primeiras rugas de expressão e pequenos ajustes de proporção. Depois dos 40, querer resolver tudo com preenchimento é o caminho mais curto para um rosto pesado e artificial. É justamente isso que eu evito.',
                    'O que funciona é cuidar da sustentação. Quando eu devolvo volume nos pontos que seguram o rosto, como as maçãs, o bigode chinês já suaviza, e o sulco só recebe um retoque se precisar. O [bioestimulador](procedure:bioestimulador-de-colageno) deixa a pele mais firme aos poucos, ao longo de meses. E os [fios de PDO](article:fios-de-sustentacao-antes-da-plastica) ajudam a reposicionar a pele quando a flacidez é leve ou moderada.',
                ],
            ],
            [
                'heading' => 'Depois dos 50 e na menopausa',
                'body' => [
                    'Na menopausa, a queda dos hormônios faz a pele perder colágeno bem mais rápido, principalmente nos primeiros anos. Ela fica mais fina e mais seca em pouco tempo. Se você sente que o rosto mudou de repente, saiba que isso tem explicação.',
                    'Nessa fase, estimular o colágeno é a base do tratamento, quase sempre combinado com sustentação e um pouco de volume onde faz falta. O resultado vem aos poucos, ao longo de alguns meses. Meu objetivo é um rosto descansado, nunca a cara de quem fez muita coisa.',
                    'Também é a fase em que eu preciso ser mais sincera com você. Quando a flacidez é grande, os tratamentos sem cirurgia melhoram a pele, mas não fazem o papel de um lifting. Conversar sobre isso antes evita frustração e dinheiro gasto no lugar errado. Na avaliação, a gente olha o seu rosto com calma e monta um plano para a fase que você está vivendo.',
                ],
            ],
            [
                'heading' => 'E os homens?',
                'body' => [
                    'No rosto masculino acontece a mesma coisa, com algumas diferenças. A pele é mais grossa e os músculos são mais fortes. Os homens costumam procurar contorno de mandíbula, olheira, papada e uma testa mais lisa, sempre preservando os [traços masculinos](article:harmonizacao-facial-em-homens).',
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
            ['q' => 'A harmonização facial fica artificial em pele madura?', 'a' => 'Não precisa ficar. O aspecto artificial vem do excesso de produto, principalmente de preenchimento. Cuidando da sustentação e usando pouca quantidade, o resultado é um rosto descansado e natural.'],
        ],
        'related' => ['bioestimulador-de-colageno', 'flacidez-facial', 'bigode-chines', 'preenchimento-facial'],
        'sources' => [
            ['publisher' => 'Aesthetic Surgery Journal', 'title' => 'The Facial Aging Process From the "Inside Out"', 'url' => 'https://academic.oup.com/asj/article/41/10/1107/5873339', 'year' => '2021'],
            ['publisher' => 'American Society of Plastic Surgeons', 'title' => 'What you need to know about thread lifts', 'url' => 'https://www.plasticsurgery.org/news/blog/what-you-need-to-know-about-thread-lifts', 'year' => '2018'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Caring for your skin in menopause', 'url' => 'https://www.aad.org/public/everyday-care/skin-care-secrets/anti-aging/skin-care-during-menopause', 'year' => '2025'],
        ],
    ],

    'harmonizacao-facial-em-homens' => [
        'title' => 'Por que tantos homens fazem harmonização facial',
        'h1' => 'Por que tantos homens estão fazendo harmonização facial',
        'eyebrow' => 'Para homens',
        'topics' => ['idade-e-perfil', 'toxina-botulinica'],
        'meta_description' => 'Homens famosos contaram que fizeram harmonização facial. Veja o que os homens costumam buscar e como tratar o rosto sem perder os traços masculinos.',
        'excerpt' => 'Em poucos dias, um cantor e o governador eleito de Minas contaram que fizeram harmonização. Fica a dúvida que todo homem tem: dá para fazer sem parecer que fez?',
        'published' => '2026-10-13',
        'updated' => '2026-10-13',
        'sections' => [
            [
                'heading' => 'Uma semana de homens falando do assunto',
                'body' => [
                    'No começo de outubro, o cantor Fiuk mostrou na televisão o resultado de uma harmonização feita para acertar pequenos detalhes do rosto. Em Minas, o assunto chegou até a política. Logo depois de eleito, o governador Cleitinho Azevedo fez alguns procedimentos no rosto, e a clínica contou que a ideia era tirar o cansaço da campanha.',
                    'O que me chamou atenção é que nenhum deles escondeu. Até pouco tempo atrás, homem que fazia toxina botulínica não contava nem para os amigos. Hoje o tema aparece na televisão, e quem tinha vontade de perguntar se sente mais à vontade para marcar uma avaliação.',
                ],
            ],
            [
                'heading' => 'O que os homens costumam me pedir',
                'body' => [
                    'Poucos homens chegam dizendo que querem ficar mais bonitos. O pedido vem de lado. Os colegas perguntam se ele está doente, a esposa diz que ele parece bravo o tempo todo, a foto mostra alguém mais velho do que ele se sente. Por trás disso, quase sempre estão a [olheira](procedure:preenchimento-de-olheiras) funda, a testa e o meio das sobrancelhas muito marcados, a papada e um [contorno de mandíbula](procedure:preenchimento-mandibula-e-queixo) que perdeu definição.',
                    'Muitos chegam por outro caminho, o [bruxismo](procedure:toxina-botulinica-bruxismo), aquele hábito de apertar ou ranger os dentes. Vêm tratar a dor e o desgaste com toxina botulínica no músculo da mastigação, e é ali, na cadeira, que começam a perguntar sobre a testa ou as olheiras.',
                ],
            ],
            [
                'heading' => 'Rosto de homem pede outro planejamento',
                'body' => [
                    'A pele do homem é mais grossa, os músculos são mais fortes e os ossos do rosto têm outro desenho. A mandíbula é mais larga, o queixo vem mais para frente e a sobrancelha é mais baixa e reta. Quando uma técnica pensada para o rosto feminino é usada sem adaptação, as maçãs do rosto arredondam, a ponta da sobrancelha sobe e os lábios ganham volume. Daí vem aquela cara de quem fez alguma coisa.',
                    'Por isso, no rosto masculino, eu ajusto a dose da toxina botulínica, que costuma ser maior, e mudo os pontos de aplicação para a sobrancelha continuar reta. No preenchimento, o produto vai mais para o canto da mandíbula e para o queixo, e bem menos para as maçãs e os lábios. Muitas vezes, o que mais rejuvenesce um homem é tratar a olheira e devolver nitidez à mandíbula, e só.',
                ],
            ],
            [
                'heading' => 'Vários procedimentos no mesmo dia',
                'body' => [
                    'Dá para combinar tratamentos numa mesma sessão, e às vezes isso faz sentido. Só que o inchaço de cada um se soma e, se aparecer alguma reação, fica mais difícil saber de onde ela veio. Cada técnica também tem seu tempo. A toxina leva até duas semanas para agir, e o [bioestimulador](procedure:bioestimulador-de-colageno) trabalha ao longo de meses.',
                    'Para quem vai fazer pela primeira vez, eu prefiro começar por uma ou duas áreas. Assim a gente vê como o rosto responde, ajusta no retorno e decide com calma o próximo passo.',
                ],
            ],
            [
                'heading' => 'Antes de marcar',
                'body' => [
                    'A Anvisa recomenda usar os preenchedores só dentro das indicações aprovadas, porque os problemas mais sérios costumam aparecer quando o produto vai para áreas ou quantidades fora do que o fabricante indica. Então confira o registro de quem vai aplicar no conselho profissional, pergunte qual produto será usado e peça a etiqueta com o lote. Avaliação por mensagem, sem examinar o rosto, não serve.',
                    'E pergunte se o profissional tem casos masculinos para mostrar. Antes e depois de mulher diz pouco sobre como ele trabalha um rosto de homem. Se quiser, marque uma avaliação comigo e a gente conversa sobre o que faz sentido para o seu rosto.',
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
            ['publisher' => 'TMC', 'title' => 'Cleitinho, governador de MG, faz harmonização facial', 'url' => 'https://tmc.com.br/lifestyle/cleitinho-azevedo-eleito-governador-harmonizacao/', 'year' => '2026'],
            ['publisher' => 'Anvisa', 'title' => 'Anvisa recomenda: preenchedores dérmicos somente dentro das indicações aprovadas', 'url' => 'https://www.gov.br/anvisa/pt-br/assuntos/noticias-anvisa/2026/anvisa-recomenda-preenchedores-dermicos-somente-dentro-das-indicacoes-aprovadas', 'year' => '2026'],
        ],
    ],

    'rosto-de-ozempic' => [
        'title' => 'Rosto de Ozempic: flacidez depois de emagrecer',
        'h1' => 'O que acontece com o rosto de quem emagrece com Ozempic ou Mounjaro',
        'eyebrow' => 'Emagrecimento',
        'topics' => ['flacidez-e-firmeza'],
        'meta_description' => 'Rosto de Ozempic é a flacidez e a perda de volume depois de emagrecer rápido com canetas. Entenda por que acontece e o que dá para fazer, em Belo Horizonte.',
        'excerpt' => 'A balança desce, as roupas voltam a servir e o rosto parece mais cansado. Explico por que isso acontece e por que encher o rosto de volta não resolve.',
        'published' => '2026-10-22',
        'updated' => '2026-10-22',
        'sections' => [
            [
                'heading' => 'De onde veio esse nome',
                'body' => [
                    'O apelido nasceu nos Estados Unidos, quando dermatologistas começaram a receber pessoas com o rosto encovado depois de perder muitos quilos em poucos meses. Aqui no Brasil o uso das canetas cresceu muito, e desde março, quando a patente da semaglutida venceu, novas versões do remédio começaram a chegar às farmácias.',
                    'Apesar do nome, quem muda o rosto é a velocidade do emagrecimento, e não o remédio. O mesmo acontece depois de uma cirurgia bariátrica ou de uma dieta muito restrita. A caneta só tornou esse tipo de perda de peso bem mais comum.',
                ],
            ],
            [
                'heading' => 'O que muda no rosto',
                'body' => [
                    'O rosto tem pequenas bolsas de gordura que funcionam como almofadas. São elas que dão volume às maçãs do rosto, preenchem as têmporas e sustentam a pele ao redor dos olhos e da boca. Quando você emagrece rápido, essas almofadas murcham junto, e a pele, que passou anos acomodada sobre elas, não tem tempo de se retrair.',
                    'Os sinais aparecem em lugares previsíveis. Têmporas fundas, maçãs do rosto achatadas, [olheira](procedure:preenchimento-de-olheiras) mais marcada, [bigode chinês](procedure:bigode-chines) mais profundo e pele sobrando na linha da mandíbula e no pescoço. Numa pesquisa recente com dermatologistas americanos, a queixa mais comum de quem usava as canetas foi justamente a perda de volume no meio do rosto, seguida da flacidez na mandíbula.',
                    'A idade pesa. Uma pele mais jovem ainda tem bastante colágeno e costuma se readaptar melhor. Com o passar dos anos, a mesma perda de peso tende a deixar o rosto com cara de cansado. Perder músculo junto com a gordura, o que é comum quando o emagrecimento é rápido, também contribui.',
                ],
            ],
            [
                'heading' => 'Por que encher de volta não funciona',
                'body' => [
                    'A primeira ideia de muita gente é repor com preenchimento todo o volume que foi embora. Parece lógico, mas costuma dar errado. O rosto perdeu gordura em vários lugares ao mesmo tempo, e a pele ficou mais fina e frouxa. Colocar ácido hialurônico em todos esses pontos deixa o rosto pesado e inchado, com aquele aspecto de travesseiro que denuncia o procedimento de longe.',
                    'O que falta, de verdade, é sustentação e uma pele de melhor qualidade. Por isso eu coloco volume só onde ele segura o resto, e em pouca quantidade. A Anvisa também recomenda usar os preenchedores só dentro das indicações aprovadas, respeitando as áreas e as quantidades indicadas.',
                ],
            ],
            [
                'heading' => 'O que eu costumo indicar',
                'body' => [
                    'O [bioestimulador de colágeno](procedure:bioestimulador-de-colageno) costuma ser a base. Ele faz a sua própria pele produzir colágeno novo ao longo de alguns meses, e o rosto vai ganhando firmeza aos poucos. Em geral são poucas sessões, com algumas semanas de intervalo.',
                    'O [preenchimento com ácido hialurônico](procedure:preenchimento-facial) entra só em pontos certos, nas têmporas e nas maçãs do rosto, que sustentam o meio do rosto. Devolver volume ali costuma suavizar também o bigode chinês e a olheira, e muitas vezes evita preencher cada sulco. Se a flacidez for maior, os [fios de PDO](article:fios-de-sustentacao-antes-da-plastica) ajudam a reposicionar a pele, e o [microagulhamento](procedure:microagulhamento) melhora a textura.',
                    'Tem um limite que eu faço questão de falar na avaliação. Quando sobra muita pele, principalmente no pescoço, nenhum tratamento sem cirurgia resolve por completo. Saber disso antes evita gastar com o tratamento errado.',
                ],
            ],
            [
                'heading' => 'Durante ou depois de emagrecer?',
                'body' => [
                    'Você não precisa esperar terminar o acompanhamento com o endocrinologista para começar a cuidar do rosto. O bioestimulador e os cuidados com a pele podem começar durante o emagrecimento, porque preparam a pele para o que vem. Já a reposição de volume rende mais quando o peso está perto de se estabilizar. Antes disso, o rosto continua mudando e o preenchimento pode precisar de ajuste.',
                    'Quem prescreve e acompanha a caneta é o seu médico. Conte a ele que pretende tratar o rosto, e me conte na avaliação que usa o remédio, há quanto tempo e quanto já perdeu. Comer proteína suficiente e fazer algum treino de força, como o médico costuma orientar, ajuda a perder menos músculo no caminho.',
                    'Se você está nessa fase, marque uma avaliação. A gente olha o seu rosto com calma e escolhe o melhor momento para cada etapa.',
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
        'title' => 'Rosto perdeu firmeza? Talvez você não precise de plástica',
        'h1' => 'Seu rosto perdeu firmeza? Talvez você ainda não precise de uma plástica',
        'eyebrow' => 'Flacidez',
        'topics' => ['flacidez-e-firmeza'],
        'meta_description' => 'Sentiu o rosto cair e pensou em plástica? Os fios de sustentação levantam o contorno sem cirurgia. Veja quando eles bastam e quando não.',
        'excerpt' => 'Sentiu o rosto cair e já pensa em cirurgia? Antes, conheça os fios de sustentação. Eles levantam o contorno com anestesia local, e você volta à rotina em poucos dias.',
        'published' => '2026-10-30',
        'updated' => '2026-10-30',
        'sections' => [
            [
                'heading' => 'Quando o espelho começa a incomodar',
                'body' => [
                    'Escuto muito esta frase de mulheres de 40 e poucos anos: "meu rosto caiu, acho que só plástica resolve". Eu entendo. A mandíbula perde a definição, as bochechas descem um pouco e o [bigode chinês](procedure:bigode-chines) fica mais marcado. Você dorme bem e, mesmo assim, se acha com cara de cansada.',
                    'Nessa fase, o que costuma acontecer é uma [flacidez](procedure:flacidez-facial) leve ou moderada. E para esse grau existe um caminho bem mais simples do que a cirurgia.',
                ],
            ],
            [
                'heading' => 'O que os fios de sustentação fazem',
                'body' => [
                    'Os [fios de PDO](procedure:fios-de-pdo) são feitos de um material usado há muitos anos em pontos cirúrgicos, que o próprio corpo absorve com o tempo. Eu coloco os fios por baixo da pele com agulhas finas, em trajetos que puxam o rosto para cima.',
                    'Eles agem de dois jeitos. Na hora, levantam o contorno. Nos meses seguintes, estimulam a pele a produzir colágeno ao redor de cada fio, e isso ajuda a manter a firmeza.',
                    'O resultado é uma mandíbula mais definida, as bochechas de volta ao lugar e uma expressão mais descansada. O rosto continua sendo o seu, com a sustentação de alguns anos atrás. A Sociedade Americana de Cirurgiões Plásticos descreve bem quem mais aproveita os fios: mulheres na faixa dos 40, com flacidez leve ou moderada.',
                ],
            ],
            [
                'heading' => 'Fios ou plástica, qual a diferença',
                'body' => [
                    'O lifting facial é a cirurgia plástica do rosto. Ele retira a pele que sobrou e reposiciona as camadas mais profundas. O resultado é maior e dura mais. Em troca, vem com anestesia mais forte, cicatriz, curativo e algumas semanas de recuperação.',
                    'Com os fios, a aplicação leva cerca de uma hora, com anestesia local, e você vai para casa no mesmo dia. Dá para voltar ao trabalho em poucos dias. Nas primeiras semanas, eu peço alguns cuidados, como não abrir muito a boca, não massagear o rosto e evitar sauna.',
                    'O levantamento é mais discreto, e é justamente isso que deixa o resultado natural. O efeito dura vários meses. Quando os fios são absorvidos, dá para repetir, e o colágeno que se formou ajuda a segurar parte do resultado.',
                ],
            ],
            [
                'heading' => 'Melhor ainda quando combinado',
                'body' => [
                    '[Aos 45](article:harmonizacao-facial-depois-dos-40), a flacidez quase nunca vem sozinha. O rosto também perdeu um pouco de volume, e a pele está mais fina.',
                    'Por isso eu costumo combinar os fios com [bioestimulador de colágeno](procedure:bioestimulador-de-colageno), que deixa a pele mais firme ao longo dos meses. Quando precisa, entra também um pouco de preenchimento nos pontos que sustentam o rosto, como as maçãs. Cada tratamento faz a sua parte, e o conjunto vai além do que os fios fariam sozinhos.',
                ],
            ],
            [
                'heading' => 'Quando eu indico a plástica',
                'body' => [
                    'Aqui eu faço questão de ser honesta. Se a pele do pescoço e da mandíbula já sobra bastante, os fios não vão entregar o que você espera. Nesse caso, eu indico uma conversa com um cirurgião plástico. A própria Sociedade Americana de Cirurgiões Plásticos lembra que os tratamentos sem cirurgia não chegam ao resultado de um lifting, mas ajudam a adiá-lo.',
                    'Também falo dos riscos, como em qualquer procedimento. Os mais conhecidos são pequenas retrações na pele e alguma assimetria. Por isso eu planejo cada trajeto com cuidado, uso só os fios necessários e trabalho apenas com produto registrado na Anvisa.',
                ],
            ],
            [
                'heading' => 'Antes de marcar a cirurgia, faça uma avaliação',
                'body' => [
                    'Se você sente que o rosto caiu, venha fazer uma avaliação antes de decidir pela plástica. Eu examino a sua pele, o grau de flacidez e o volume do rosto. Depois explico com clareza se os fios resolvem, se vale combinar com outro tratamento ou se a cirurgia é mesmo o melhor caminho para você.',
                ],
            ],
        ],
        'takeaways' => [
            'Aos 40 e poucos, a flacidez costuma ser leve ou moderada, e os fios resolvem bem nesses casos.',
            'Os fios levantam o contorno na hora e estimulam colágeno nos meses seguintes.',
            'A aplicação é feita com anestesia local, e você volta à rotina em poucos dias.',
            'Quando a pele já sobra bastante, a plástica é o melhor caminho, e eu digo isso na avaliação.',
        ],
        'faq' => [
            ['q' => 'Fios de sustentação doem?', 'a' => 'O procedimento é feito com anestesia local, então o desconforto é pequeno. Nos primeiros dias, a região pode ficar sensível e um pouco inchada, e isso é esperado.'],
            ['q' => 'Quanto tempo dura o resultado dos fios?', 'a' => 'O efeito dos fios de PDO dura vários meses e varia com a sua pele e o seu estilo de vida. Depois que o corpo absorve os fios, dá para repetir.'],
            ['q' => 'Posso fazer fios e bioestimulador no mesmo plano?', 'a' => 'Pode, e muitas vezes é o que eu indico. Os fios cuidam da sustentação, e o bioestimulador deixa a pele mais firme. A ordem e o intervalo entre os dois eu defino na avaliação.'],
        ],
        'related' => ['fios-de-pdo', 'flacidez-facial', 'bioestimulador-de-colageno', 'bigode-chines'],
        'sources' => [
            ['publisher' => 'American Society of Plastic Surgeons', 'title' => 'What you need to know about thread lifts', 'url' => 'https://www.plasticsurgery.org/news/blog/what-you-need-to-know-about-thread-lifts', 'year' => '2018'],
            ['publisher' => 'American Society of Plastic Surgeons', 'title' => 'Facelift Surgery', 'url' => 'https://www.plasticsurgery.org/cosmetic-procedures/facelift', 'year' => 's.d.'],
            ['publisher' => 'Life (Basel)', 'title' => 'Pre- and Post-Procedural Considerations and Thread Types for Thread Lifting', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC11766856/', 'year' => '2025'],
        ],
    ],

    'harmonizacao-facial-aos-20-anos' => [
        'title' => 'Harmonização facial aos 20 anos: o que faz sentido',
        'h1' => 'Harmonização facial aos 20 e poucos anos: o que faz sentido para você',
        'eyebrow' => 'Pele jovem',
        'topics' => ['idade-e-perfil', 'toxina-botulinica'],
        'meta_description' => 'Harmonização facial aos 20 anos: toxina, bruxismo, lábios e cuidados de pele que fazem sentido na sua idade. Veja como planejar com segurança em BH.',
        'excerpt' => 'Começar a cuidar do rosto cedo pode ser ótimo, desde que com a indicação certa. Conto o que faz sentido aos 20 e poucos anos e o que eu prefiro evitar.',
        'published' => '2026-11-02',
        'updated' => '2026-11-02',
        'sections' => [
            [
                'heading' => 'Começar cedo pode ser uma ótima ideia',
                'body' => [
                    'Cada vez mais mulheres jovens chegam ao consultório, e eu acho isso ótimo. Quem começa cedo e com orientação chega [aos 40](article:harmonizacao-facial-depois-dos-40) com bem menos para corrigir. E, nessa fase, o caminho costuma ser sutil, mais de prevenção do que de correção.',
                    'O segredo é fazer o que o seu rosto pede agora, e não o que está na moda. Nessa idade, a pele ainda produz bastante colágeno e o rosto tem volume de sobra. O plano é bem diferente do de uma mulher mais madura, e por isso a avaliação faz tanta diferença.',
                ],
            ],
            [
                'heading' => 'O que costuma fazer sentido nessa fase',
                'body' => [
                    '[Toxina botulínica](procedure:toxina-botulinica) para as primeiras linhas. Se uma ruguinha na testa ou entre as sobrancelhas continua lá mesmo com o rosto relaxado, uma dose baixa ajuda a evitar que ela se aprofunde. Os estudos mais recentes veem essa prevenção com bons olhos, e eu indico com critério, olhando a força de cada músculo.',
                    '[Bruxismo](procedure:toxina-botulinica-bruxismo). Se você range ou aperta os dentes, principalmente à noite, a toxina no músculo da mastigação alivia a dor, protege os dentes e ainda suaviza o contorno do rosto. Como dentista, gosto muito desse tratamento, porque cuida da saúde e da estética ao mesmo tempo.',
                    'Lábios. Um [preenchimento labial](procedure:preenchimento-labial) sutil dá viço e define o contorno sem transformar a sua boca. Combina muito com essa idade.',
                    'Pele e marcas de acne. O [microagulhamento](procedure:microagulhamento) melhora a textura, os poros e as cicatrizes de acne, depois que a acne estiver controlada.',
                    'Proporção. Uma assimetria que incomoda ou um queixo mais para trás podem ser equilibrados com pouco produto, sempre respeitando os seus traços.',
                ],
            ],
            [
                'heading' => 'Menos produtos na pia do banheiro',
                'body' => [
                    'Nas redes sociais, é comum ver rotinas de skincare com uma fila de ácidos e esfoliantes. E, muitas vezes, o protetor solar nem aparece.',
                    'Glicólico, salicílico, retinol e esfoliante, tudo no mesmo dia e todo dia, desgastam a proteção natural da pele. E pele irritada parece mais velha. A Academia Americana de Dermatologia dá uma regra simples: se o produto arde ou queima, pare de usar.',
                    'Para a maioria das mulheres nessa fase, eu oriento o básico bem feito. Sabonete suave, hidratante e protetor solar FPS 30 ou mais, todos os dias.',
                ],
            ],
            [
                'heading' => 'O que eu evito',
                'body' => [
                    'Copiar a boca ou a mandíbula de outra pessoa costuma dar um resultado que não combina com o resto do rosto. Repetir preenchimento sem critério, ano após ano, também acumula produto. Na consulta, eu mostro o que valoriza os seus traços e monto um plano que acompanha você com o tempo.',
                    'Se eu perceber que o incômodo é mais emocional do que físico, vou dizer com carinho. Harmonização boa é aquela em que você se reconhece no espelho, só que mais descansada e mais confiante.',
                ],
            ],
            [
                'heading' => 'Por onde começar',
                'body' => [
                    'Marque uma avaliação. Eu analiso o seu rosto e a sua pele, entendo o que incomoda você e monto um plano por etapas. Às vezes ele inclui um procedimento agora. Às vezes, só cuidados de pele por um tempo. Você sai sabendo o que faz sentido para a sua idade e para o seu orçamento.',
                    'E o protetor solar de todo dia continua sendo o seu melhor aliado contra as rugas, em qualquer idade.',
                ],
            ],
        ],
        'takeaways' => [
            'Aos 20 e poucos anos, quem define o tratamento é a indicação, e não a idade.',
            'Toxina para as primeiras linhas, bruxismo, lábios sutis e cuidados com a pele são bons pontos de partida.',
            'Muitos ácidos ao mesmo tempo irritam a pele, então menos é mais.',
            'Uma avaliação cedo ajuda a prevenir e a evitar exageros.',
        ],
        'faq' => [
            ['q' => 'Com que idade posso começar a toxina botulínica?', 'a' => 'Não existe uma idade certa. Eu indico quando já aparece uma linha marcada com o rosto em repouso, ou quando há bruxismo. Quando há indicação, costumo começar com doses baixas.'],
            ['q' => 'Harmonização aos 20 anos fica artificial?', 'a' => 'Não precisa ficar. Nessa idade, o segredo é pouco produto e muito planejamento. O objetivo é valorizar os seus traços, e não mudar o seu rosto.'],
            ['q' => 'Tenho acne. Posso fazer algum procedimento?', 'a' => 'Primeiro, trate a acne com um dermatologista. Com a pele inflamada, a maior parte dos procedimentos fica para depois. As marcas e cicatrizes podem ser tratadas com microagulhamento quando a pele estiver sob controle.'],
        ],
        'related' => ['toxina-botulinica', 'toxina-botulinica-bruxismo', 'preenchimento-labial', 'microagulhamento'],
        'sources' => [
            ['publisher' => 'Muscles (MDPI)', 'title' => 'Proactive Aesthetic Strategies: Evaluating the Preventive Role of Botulinum Toxin in Facial Aging', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC12372128/', 'year' => '2025'],
            ['publisher' => 'American Academy of Dermatology', 'title' => '11 ways to reduce premature skin aging', 'url' => 'https://www.aad.org/public/everyday-care/skin-care-secrets/anti-aging/reduce-premature-aging-skin', 'year' => '2021'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Dermatologist-recommended skin care for your 20s', 'url' => 'https://www.aad.org/public/everyday-care/skin-care-basics/care/skin-care-in-your-20s', 'year' => '2023'],
        ],
    ],

    'harmonizacao-facial-antes-das-festas' => [
        'title' => 'Harmonização facial antes das festas: o que dá tempo de fazer',
        'h1' => 'Ainda dá tempo de cuidar do rosto até as festas? Veja o que fazer em novembro e em dezembro',
        'eyebrow' => 'Fim de ano',
        'topics' => ['antes-de-agendar'],
        'meta_description' => 'Natal, Réveillon e verão: o que começar em novembro e o que deixar para dezembro entre toxina, preenchimento, bioestimulador e fios. Planeje em BH.',
        'excerpt' => 'Bioestimulador e fios pedem semanas. Toxina e preenchimento pedem uns dias de folga antes do evento. Conto como eu organizo o seu calendário até as festas.',
        'published' => '2026-11-03',
        'updated' => '2026-11-03',
        'sections' => [
            [
                'heading' => 'Novembro é o mês de começar',
                'body' => [
                    'Do começo de novembro até o Réveillon são uns dois meses. Parece pouco, mas para a maior parte dos procedimentos do rosto é um prazo confortável, desde que cada um entre na hora certa.',
                    'A minha lógica é simples. Alguns tratamentos trabalham devagar, porque dependem de o seu corpo produzir colágeno, e levam semanas para mostrar resultado. Outros agem rápido, mas pedem uns dias de folga antes de uma data importante, para o inchaço sumir. Os primeiros eu faço agora. Os outros, mais perto da festa.',
                ],
            ],
            [
                'heading' => 'O que eu gosto de começar agora',
                'body' => [
                    'O [bioestimulador de colágeno](procedure:bioestimulador-de-colageno) é o melhor exemplo. Ele não preenche nada na hora. Ele estimula a sua pele a produzir colágeno novo, e isso leva semanas. Costuma ser feito em mais de uma sessão, com algumas semanas entre elas. Começando no início de novembro, a sessão seguinte cai em dezembro, e a pele vai ganhando firmeza ao longo do verão.',
                    'Os [fios de PDO](procedure:fios-de-pdo) também combinam com novembro. A sustentação melhora com o colágeno que eles estimulam, e o rosto precisa de alguns dias para desinchar. Os estudos orientam evitar sauna, piscina e bebida alcoólica por cerca de uma semana depois, o que pesa bastante em dezembro. Por isso eu prefiro colocar os fios com uma boa folga antes de qualquer festa.',
                    'O [microagulhamento](procedure:microagulhamento) é feito em sessões, mais ou menos uma por mês. A Academia Americana de Dermatologia explica que a melhora começa a aparecer em algumas semanas, e o resultado completo vem em alguns meses. Começando agora, dá tempo de fazer mais de uma sessão antes do fim do ano.',
                ],
            ],
            [
                'heading' => 'O que pode ficar para dezembro',
                'body' => [
                    'A [toxina botulínica](procedure:toxina-botulinica) começa a agir poucos dias depois da aplicação, e o efeito completo leva um pouco mais. Para o Natal, eu gosto de aplicar até o começo de dezembro. Para o Réveillon, até o meio do mês. E tem uma vantagem: o efeito dura alguns meses, então a aplicação de dezembro acompanha você pelo verão.',
                    'O [preenchimento labial](procedure:preenchimento-labial) e o [preenchimento facial](procedure:preenchimento-facial) mostram resultado na hora. Só que a boca e o rosto podem ficar um pouco inchados nos primeiros dias. A Academia Americana de Dermatologia diz que isso costuma passar em até duas semanas, muitas vezes antes. Então a regra é parecida com a da toxina: deixe uma boa folga antes da data que importa para você.',
                    'Se você quer combinar tratamentos, a ordem é a mesma, com o bioestimulador agora e a toxina em dezembro. Os cuidados de cada procedimento nos dias seguintes estão no [artigo sobre recuperação](article:tempo-de-recuperacao).',
                ],
            ],
            [
                'heading' => 'Sol, piscina e viagem de fim de ano',
                'body' => [
                    'Dezembro em Belo Horizonte é quente, e muita gente viaja para a praia nas festas. Isso entra no planejamento. Nos primeiros dias depois do preenchimento ou dos fios, sol forte, calor, piscina e sauna podem aumentar o inchaço. Então eu evito marcar esses procedimentos em cima da viagem.',
                    'Depois do microagulhamento, a pele fica mais sensível, e o protetor solar passa a fazer parte do tratamento. Por isso eu organizo as sessões para que nenhuma caia logo antes de uma viagem de praia.',
                    'E o protetor solar de todo dia, reaplicado na praia, vale para todo mundo, com ou sem procedimento. É ele que ajuda a preservar o colágeno que a gente trabalhou para construir.',
                ],
            ],
            [
                'heading' => 'Como eu monto o seu calendário',
                'body' => [
                    'Na avaliação, me conte as datas que importam para você: a confraternização do trabalho, a formatura, a ceia, a viagem. Com elas em mãos, eu olho o seu rosto e a sua pele e encaixo cada procedimento no tempo certo, para nenhuma etapa cair em cima de um compromisso.',
                    'Se der para vir ainda em novembro, melhor, porque sobra espaço para os tratamentos que trabalham devagar. Se só der em dezembro, ainda dá para planejar a toxina e o preenchimento com calma. Para chegar bem preparada na consulta, veja [como se preparar](article:como-se-preparar).',
                ],
            ],
        ],
        'takeaways' => [
            'Bioestimulador, fios de PDO e microagulhamento pedem semanas, então o ideal é começar em novembro.',
            'Toxina botulínica e preenchimento podem ficar para dezembro, com cerca de duas semanas de folga antes do evento.',
            'Depois do preenchimento e dos fios, evite sol forte, piscina e sauna nos primeiros dias.',
            'Leve as datas das suas festas e viagens para a avaliação.',
        ],
        'faq' => [
            ['q' => 'Posso fazer toxina botulínica uma semana antes do Natal?', 'a' => 'Pode, mas talvez o efeito ainda não esteja completo, porque ele leva alguns dias para aparecer. Por isso eu prefiro aplicar com cerca de duas semanas de folga antes de uma data importante.'],
            ['q' => 'O bioestimulador feito em novembro já aparece nas festas?', 'a' => 'O bioestimulador trabalha aos poucos. As primeiras mudanças costumam surgir em algumas semanas, e o melhor resultado vem depois de alguns meses, conforme o colágeno é produzido. Começando em novembro, a pele vai ganhando firmeza ao longo do verão.'],
            ['q' => 'Posso ir à praia depois de um procedimento?', 'a' => 'Depende do procedimento. Depois do preenchimento, eu oriento alguns dias longe do sol forte. Depois dos fios de PDO, cerca de uma semana sem piscina e sauna. Protetor solar, sempre. Na avaliação, eu ajusto as orientações à sua viagem.'],
        ],
        'related' => ['bioestimulador-de-colageno', 'fios-de-pdo', 'microagulhamento', 'preenchimento-facial'],
        'sources' => [
            ['publisher' => 'Life (Basel)', 'title' => 'Pre- and Post-Procedural Considerations and Thread Types for Thread Lifting', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC11766856/', 'year' => '2025'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Fillers: FAQs', 'url' => 'https://www.aad.org/cosmetic/wrinkles/fillers-faqs', 'year' => 's.d.'],
            ['publisher' => 'American Academy of Dermatology', 'title' => 'Microneedling can fade scars, uneven skin tone, and more', 'url' => 'https://www.aad.org/public/cosmetic/scars-stretch-marks/microneedling-fade-scars', 'year' => '2023'],
        ],
    ],

    'pdrn-dna-de-salmao-na-pele' => [
        'title' => 'PDRN, o DNA de salmão: o que faz na pele | Dra. Emily Beatriz',
        'h1' => 'PDRN, o DNA de salmão: o que ele faz pela sua pele e quando vale ir além do sérum',
        'eyebrow' => 'Tendência de pele',
        'topics' => ['flacidez-e-firmeza'],
        'meta_description' => 'O sérum de DNA de salmão virou moda. Conto o que ele faz pela pele, o que é permitido no Brasil e quando vale ir além do sérum, em BH.',
        'excerpt' => 'O sérum de DNA de salmão tomou conta das prateleiras. Conto o que ele faz de verdade, por que no Brasil ele é só para passar na pele e o que eu indico quando você quer mais viço ou firmeza.',
        'published' => '2026-11-09',
        'updated' => '2026-11-09',
        'sections' => [
            [
                'heading' => 'O que é esse tal de DNA de salmão',
                'body' => [
                    'O nome assusta um pouco, mas a ideia é simples. PDRN é um DNA tirado do salmão ou da truta e purificado com muito cuidado. Essa limpeza toda serve para o corpo aceitar bem a substância.',
                    'Ele chegou aqui pela onda do skincare coreano. Hoje aparece em sérum, creme, máscara e até sabonete. Todos os produtos com PDRN que existem no Brasil estão registrados na Anvisa como cosméticos.',
                    'O interesse tem motivo. As pesquisas indicam que o PDRN ajuda a pele a se reparar e estimula as células que fabricam colágeno. A minha pergunta, quando um ativo vira moda, é outra. O quanto disso chega mesmo à sua pele do jeito que ele está sendo vendido?',
                ],
            ],
            [
                'heading' => 'O que os estudos mostram até agora',
                'body' => [
                    'Os estudos sobre PDRN ainda são poucos e pequenos. O resultado mais firme apareceu na cicatrização de feridas. No rejuvenescimento, houve melhora de rugas e as participantes ficaram satisfeitas, mas com um efeito mais discreto.',
                    'Tem um detalhe que quase ninguém comenta. Nos estudos de rejuvenescimento, o ativo entrou na pele com agulha, por injeção ou microagulhamento. Nenhum deles testou só o sérum passado em casa.',
                    'Faz sentido. As células que produzem colágeno ficam numa camada mais funda da pele, que o creme não alcança. Eu gosto do ativo, e prefiro ser sincera com você sobre o que ele consegue fazer hoje.',
                ],
            ],
            [
                'heading' => 'O que é permitido aqui no Brasil',
                'body' => [
                    'Como os produtos com PDRN são cosméticos, o uso permitido é na superfície da pele. O parecer do Conselho Regional de Medicina do Paraná deixa claro que injetar PDRN não é permitido e que ainda faltam provas para esse uso.',
                    'A Anvisa também já explicou que registrar como cosmético um produto pensado para ser injetado é irregular. Por isso eu não injeto PDRN no consultório. No seu rosto, eu uso só produtos registrados para aquilo que eu faço. Isso também é cuidar de você.',
                ],
            ],
            [
                'heading' => 'Quando eu indico ir além do sérum',
                'body' => [
                    'Se o que te incomoda é textura, poros, manchinhas ou aquele viço que sumiu, eu costumo indicar o [microagulhamento](procedure:microagulhamento). As micropunturas fazem a sua própria pele produzir colágeno. Em geral são algumas sessões, com um mês de intervalo, e a pele fica vermelhinha por poucos dias. A melhora vem aos poucos.',
                    'Quando a queixa é a pele perdendo firmeza, o caminho costuma ser o [bioestimulador de colágeno](procedure:bioestimulador-de-colageno). É um injetável registrado para isso, que faz o seu corpo produzir colágeno novo devagar. O efeito pode durar até 2 anos.',
                    'Muitas vezes os dois entram no mesmo plano, cada um no seu tempo. Os cuidados dos dias seguintes estão no [artigo sobre recuperação](article:tempo-de-recuperacao).',
                ],
            ],
            [
                'heading' => 'Traga o seu sérum para a avaliação',
                'body' => [
                    'Se você já usa um sérum com PDRN e gosta dele, pode continuar. Ele faz parte da rotina de casa, junto com o protetor solar, que segue sendo o melhor amigo do seu colágeno.',
                    'Na avaliação, me mostre os produtos que você usa. Eu olho a sua pele, entendo o que te incomoda e monto um plano que une o cuidado de casa com o que só o consultório consegue fazer. Se quiser, antes dê uma olhada em [como se preparar](article:como-se-preparar).',
                ],
            ],
        ],
        'takeaways' => [
            'PDRN é um DNA purificado de salmão ou truta que ajuda a pele a se reparar.',
            'Nos estudos de rejuvenescimento, ele entrou na pele com agulha, e as pesquisas ainda são pequenas.',
            'No Brasil, os produtos com PDRN são cosméticos para passar na pele, e injetar não é permitido.',
            'Para viço, eu indico microagulhamento. Para firmeza, bioestimulador de colágeno.',
        ],
        'faq' => [
            ['q' => 'O sérum com PDRN funciona?', 'a' => 'Ele pode complementar a sua rotina. Mas os estudos de rejuvenescimento levaram o PDRN para dentro da pele com agulha, e não testaram o sérum sozinho em casa. Por isso eu vejo o sérum como cuidado diário, e não como substituto de um tratamento.'],
            ['q' => 'Posso fazer injeção de PDRN em BH?', 'a' => 'Hoje os produtos com PDRN estão registrados na Anvisa como cosméticos, que são para passar na pele. Injetar não é permitido, e por isso eu não faço. Para estimular colágeno com agulha, eu uso tratamentos registrados para isso.'],
            ['q' => 'Microagulhamento e bioestimulador fazem a mesma coisa que o PDRN?', 'a' => 'Os três têm a ver com colágeno, mas agem de jeitos diferentes. O microagulhamento melhora textura, poros e viço. O bioestimulador trabalha a firmeza. Na avaliação eu vejo qual faz sentido para a sua pele.'],
        ],
        'related' => ['microagulhamento', 'bioestimulador-de-colageno', 'flacidez-facial'],
        'sources' => [
            ['publisher' => 'Cureus', 'title' => 'Polynucleotides and Polydeoxyribonucleotides for Skin Rejuvenation, Postoperative Scar Prevention, and Wound Healing: A Systematic Review of Randomized Clinical Trials', 'url' => 'https://assets.cureus.com/uploads/review_article/pdf/512241/20260710-252748-uc019b.pdf', 'year' => '2026'],
            ['publisher' => 'Conselho Regional de Medicina do Paraná', 'title' => 'Parecer n.º 2936/2025: utilização de PDRN (polidesoxirribonucleotídeo)', 'url' => 'https://sistemas.cfm.org.br/normas/arquivos/pareceres/PR/2025/2936_2025.pdf', 'year' => '2025'],
            ['publisher' => 'Anvisa', 'title' => 'Nota Técnica n.º 33/2023/SEI/GHCOS/DIRE3/ANVISA', 'url' => 'https://www.gov.br/anvisa/pt-br/setorregulado/regularizacao/cosmeticos/notas-tecnicas/sei_2537871_nota_tecnica_33.pdf', 'year' => '2023'],
        ],
    ],

    'rinomodelacao-nariz-e-queixo' => [
        'title' => 'Rinomodelação e queixo em BH | Dra. Emily Beatriz',
        'h1' => 'Seu nariz incomoda de perfil? Às vezes o equilíbrio está no queixo',
        'eyebrow' => 'Perfil do rosto',
        'topics' => ['idade-e-perfil'],
        'meta_description' => 'O nariz parece maior nas fotos de lado? Entenda como nariz e queixo se equilibram e como a rinomodelação e o queixo ajudam, com a Dra. Emily, em BH.',
        'excerpt' => 'O nariz que incomoda nas fotos de lado nem sempre é o problema. Explico por que nariz e queixo são vistos em conjunto e como eu planejo os dois para equilibrar o seu perfil.',
        'published' => '2026-11-18',
        'updated' => '2026-11-18',
        'sections' => [
            [
                'heading' => 'Por que o nariz chama atenção nas fotos de perfil',
                'body' => [
                    'Ouço muito esta queixa. De frente, o nariz não incomoda. Na foto de lado, ele parece maior do que deveria.',
                    'Antes de pensar em mexer no nariz, eu olho o perfil inteiro, da testa até o pescoço. Quem vê o seu rosto não repara no nariz sozinho. Os estudos mostram que o tamanho que o nariz parece ter depende muito do que está em volta dele, como os lábios e o queixo. Quando o queixo fica um pouco para trás, o nariz ganha destaque sem ter crescido nada.',
                ],
            ],
            [
                'heading' => 'Quando somar volume deixa o nariz com cara de menor',
                'body' => [
                    'A [rinomodelação](procedure:rinomodelacao-e-refinamento-facial) usa ácido hialurônico para disfarçar pequenas ondulações no meio do nariz e dar mais apoio à ponta. Ela acrescenta volume, então o nariz não diminui de verdade. Mesmo assim, ele costuma parecer menor.',
                    'Uma pesquisa brasileira comparou fotos de perfil de antes e depois da rinomodelação. Na maioria dos casos, quem olhava as fotos enxergou um nariz menor.',
                    'A explicação está na linha do perfil. Quando o nariz fica mais reto e a ponta ganha sustentação, aquele calombinho deixa de roubar a atenção.',
                ],
            ],
            [
                'heading' => 'O queixo também desenha o seu perfil',
                'body' => [
                    'O queixo é o outro lado dessa balança. Quando ele está bem posicionado, o rosto ganha estrutura e o nariz deixa de ser o ponto que mais aparece de lado.',
                    'O [preenchimento de queixo](procedure:preenchimento-mandibula-e-queixo) usa um ácido hialurônico mais firme, feito para dar projeção. Os estudos com pessoas de queixo um pouco recuado mostram melhora na grande maioria dos casos, e ela continua visível quase um ano depois. Os efeitos colaterais costumam ser leves, como dor no local, roxinho e inchaço.',
                ],
            ],
            [
                'heading' => 'Como eu planejo nariz e queixo no mesmo plano',
                'body' => [
                    'Na avaliação, eu olho o seu rosto de frente e de perfil e procuro onde está o desequilíbrio. Às vezes ele está no nariz. Às vezes o nariz está ótimo e o que falta é projeção no queixo. Em muitos casos, um pouquinho nos dois pontos deixa o perfil mais harmônico do que muito produto num lugar só.',
                    'Prefiro ser sincera sobre os limites. A rinomodelação não diminui o nariz, não substitui a cirurgia e não resolve problema de respiração. Mudanças maiores continuam sendo caso de cirurgia, e se esse for o seu caso, eu vou te dizer.',
                    'O nariz tem uma circulação delicada. Por isso eu uso só ácido hialurônico nessa região, porque ele é absorvido com o tempo e pode ser dissolvido se for preciso. Antes de qualquer aplicação, também confiro se você pode fazer o procedimento, com os cuidados que explico no artigo sobre [quem não pode fazer harmonização](article:quem-nao-pode-fazer).',
                ],
            ],
            [
                'heading' => 'Traga as suas fotos de perfil para a avaliação',
                'body' => [
                    'Se o seu nariz te incomoda nas fotos de lado, traga essas fotos para a nossa conversa. Elas me mostram o que você enxerga e o que gostaria de mudar. A partir daí, eu monto um plano que pode incluir o nariz, o queixo ou os dois, sempre respeitando os seus traços.',
                    'O resultado do ácido hialurônico aparece na hora e costuma durar mais de um ano. Para chegar tranquila no dia, dê uma olhada em [como se preparar](article:como-se-preparar) e nos cuidados do [artigo sobre recuperação](article:tempo-de-recuperacao).',
                ],
            ],
        ],
        'takeaways' => [
            'De perfil, o nariz é visto em conjunto com os lábios e o queixo.',
            'A rinomodelação acrescenta volume, mas um nariz mais reto costuma parecer menor.',
            'Um queixo bem projetado equilibra o perfil e tira o destaque do nariz.',
            'No nariz eu uso só ácido hialurônico, que é absorvido e pode ser dissolvido.',
        ],
        'faq' => [
            ['q' => 'Preenchimento no queixo faz o nariz parecer menor?', 'a' => 'Pode ajudar, porque o nariz é visto em relação ao queixo e aos lábios. Quando o queixo está para trás, o nariz costuma chamar mais atenção de perfil. Na avaliação eu vejo se o equilíbrio vem do queixo, do nariz ou dos dois.'],
            ['q' => 'Dá para fazer rinomodelação e queixo no mesmo dia?', 'a' => 'Em muitos casos, sim. Eu decido na avaliação, conforme o seu rosto e o que cada área pede, e te explico antes como fica cada etapa.'],
            ['q' => 'A rinomodelação deixa o nariz menor?', 'a' => 'Ela não diminui o tamanho, porque acrescenta volume. Mas, ao deixar o nariz mais reto e dar apoio à ponta, costuma fazer ele parecer menor de perfil. Para diminuir de verdade, o caminho é a cirurgia.'],
        ],
        'related' => ['rinomodelacao-e-refinamento-facial', 'preenchimento-mandibula-e-queixo', 'preenchimento-facial', 'harmonizacao-facial'],
        'sources' => [
            ['publisher' => 'Revista Brasileira de Cirurgia Plástica', 'title' => 'Percepção da redução do tamanho após rinoplastia de aumento não cirúrgica: Análise retrospectiva de 116 casos', 'url' => 'https://www.rbcp.org.br/details/3338/en-US/perception-of-size-reduction-after-non-surgical-augmentation-rhinoplasty--retrospective-analysis-of-116-cases', 'year' => '2023'],
            ['publisher' => 'Korean Journal of Orthodontics', 'title' => 'Facial profile parameters and their relative influence on bilabial prominence and the perceptions of facial profile attractiveness: A novel approach', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC4130914/', 'year' => '2014'],
            ['publisher' => 'Plastic and Reconstructive Surgery', 'title' => 'A Randomized Trial to Assess Effectiveness and Safety of a Hyaluronic Acid Filler for Chin Augmentation and Correction of Chin Retrusion', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC9698183/', 'year' => '2022'],
        ],
    ],

    'harmonizacao-facial-natural' => [
        'title' => 'Harmonização facial natural | Dra. Emily Beatriz',
        'h1' => 'O que faz uma harmonização facial parecer natural',
        'eyebrow' => 'Resultado natural',
        'topics' => ['flacidez-e-firmeza'],
        'image' => 'blog/harmonizacao-facial-natural/capa.jpg',
        'image_alt' => 'Ilustração de um rosto feminino com pequenos pontos de aplicação distribuídos pelas três regiões do rosto',
        'meta_description' => 'O que faz uma harmonização facial parecer natural? Entenda por que o rosto envelhece em camadas e como a Dra. Emily planeja o rosto inteiro, em BH.',
        'excerpt' => 'As mulheres andam cansadas de rosto com cara de preenchido. Explico por que o rosto envelhece em camadas e como eu planejo o rosto inteiro para você sair descansada, com os seus traços.',
        'published' => '2026-11-24',
        'updated' => '2026-11-24',
        'sections' => [
            [
                'heading' => 'O que os números dizem sobre o cansaço dos preenchedores',
                'body' => [
                    'Todo ano a ISAPS, a sociedade internacional de cirurgia plástica estética, publica um levantamento com cirurgiões do mundo inteiro. O relatório mais recente mostrou uma queda grande nas aplicações de ácido hialurônico, de cerca de um quarto. E o Brasil continua entre os países que mais fazem procedimentos estéticos.',
                    'Eu vejo esses números com otimismo. Para mim, eles mostram mulheres que continuam querendo cuidar do rosto, mas que se cansaram de resultados que aparecem de longe. Maçãs marcadas demais, lábios fora de proporção, um rosto inchado em vez de descansado. Esse sempre foi o resultado que eu evito, e é sobre isso que quero conversar com você.',
                ],
            ],
            [
                'heading' => 'O rosto envelhece em camadas',
                'body' => [
                    'Os estudos sobre envelhecimento mostram que o rosto muda em várias camadas ao mesmo tempo. O osso vai perdendo um pouco do apoio que dava. A gordura do rosto muda de lugar e de volume. As estruturas que seguram tudo ficam mais frouxas. E a pele, que é o que você vê no espelho, mostra o resultado disso tudo.',
                    'Por isso preencher só o sulco que incomoda quase nunca resolve. O [bigode chinês](procedure:bigode-chines), por exemplo, muitas vezes aparece porque as maçãs do rosto perderam sustentação. Quando eu devolvo apoio no lugar certo, o sulco suaviza sem que eu precise colocar produto direto nele.',
                ],
                'figure' => [
                    'src' => 'blog/harmonizacao-facial-natural/camadas-do-rosto.jpg',
                    'alt' => 'Ilustração das quatro camadas do rosto, pele, gordura, músculos e ligamentos e osso, com o que muda em cada uma e o tratamento que atua nela',
                    'caption' => 'Cada camada muda de um jeito com o tempo, e cada tratamento atua em uma delas.',
                ],
            ],
            [
                'heading' => 'Por que eu evito somar volume no mesmo lugar',
                'body' => [
                    'Existe até um apelido para o rosto com excesso de preenchimento, o rosto de travesseiro. As pesquisas apontam uma causa comum. Repetir o preenchimento em intervalos curtos faz o produto ir se acumulando, até o rosto ficar com cara de artificial.',
                    'O efeito que você vê no espelho vai diminuindo com o tempo, mas isso não significa que o produto sumiu por completo. Por isso, em cada manutenção, eu avalio o que ainda está ali antes de repor.',
                    'Muitas vezes escolho outro caminho, como o [bioestimulador de colágeno](procedure:bioestimulador-de-colageno), que melhora a firmeza com o colágeno que o seu próprio corpo produz.',
                ],
                'figure' => [
                    'src' => 'blog/harmonizacao-facial-natural/acumulo-ou-planejamento.jpg',
                    'alt' => 'Dois rostos lado a lado: à esquerda, grandes manchas de volume nas maçãs do rosto e nos lábios; à direita, pequenos pontos distribuídos pelo rosto inteiro',
                    'caption' => 'À esquerda, volume concentrado em poucos pontos. À direita, pequenas doses distribuídas pelo rosto, a lógica do planejamento global.',
                ],
            ],
            [
                'heading' => 'Como eu planejo o rosto inteiro',
                'body' => [
                    'Na avaliação, eu divido o seu rosto em três partes. A de cima vai da testa ao olhar. A do meio reúne maçãs do rosto, olheiras e nariz. A de baixo tem lábios, queixo e mandíbula. Olhar as três ao mesmo tempo me mostra onde está o desequilíbrio, que nem sempre fica no ponto que mais te incomoda.',
                    'Com esse mapa em mãos, eu combino o que cada região precisa. A [toxina botulínica](procedure:toxina-botulinica) suaviza a expressão, o ácido hialurônico devolve apoio e o bioestimulador cuida da qualidade da pele. Esse plano completo é o [Full Face](procedure:full-face), e ele pode ser feito em etapas, no seu ritmo.',
                ],
                'figure' => [
                    'src' => 'blog/harmonizacao-facial-natural/tercos-do-rosto.jpg',
                    'alt' => 'Ilustração de um rosto feminino dividido em terço superior, com testa, sobrancelhas e olhar, terço médio, com maçãs do rosto, olheiras e nariz, e terço inferior, com lábios, queixo e mandíbula',
                    'caption' => 'Os três terços do rosto, que eu avalio em conjunto antes de qualquer aplicação.',
                ],
            ],
            [
                'heading' => 'O que levar para a sua avaliação',
                'body' => [
                    'Se você quer se cuidar sem que ninguém perceba o que foi feito, traga para a nossa conversa o que te incomoda e também o que você gosta no seu rosto. Esses traços são a sua identidade, e o meu trabalho é preservá-los.',
                    'A foto abaixo é de um caso meu, publicado com autorização. Fiz o [preenchimento de mandíbula e queixo](procedure:preenchimento-mandibula-e-queixo) distribuindo o produto ao longo de todo o contorno, e o perfil ganhou definição sem perder os traços dela. Cada rosto responde de um jeito, e o seu plano nasce da sua avaliação.',
                    'Antes de agendar, dê uma olhada em [como se preparar](article:como-se-preparar) e entenda [o que compõe o valor de uma harmonização](article:quanto-custa-harmonizacao-facial). Na avaliação eu te mostro o plano completo e a gente decide por onde começar.',
                ],
                'figure' => [
                    'src' => 'blog/harmonizacao-facial-natural/mandibula-e-queixo-antes-e-depois.jpg',
                    'alt' => 'Perfil de uma mulher antes e depois do preenchimento de mandíbula e queixo, com o contorno do rosto mais definido depois do tratamento',
                    'caption' => 'Antes e depois de preenchimento de mandíbula e queixo feito por mim, publicado com autorização. O resultado varia de pessoa para pessoa.',
                ],
            ],
        ],
        'takeaways' => [
            'O rosto envelhece em camadas, do osso à pele, e o plano precisa olhar para todas elas.',
            'Repetir preenchimento no mesmo ponto em pouco tempo acumula produto e deixa o rosto artificial.',
            'Pequenos ajustes espalhados pelo rosto inteiro dão um resultado mais equilibrado.',
            'Na manutenção, eu avalio o que ainda está ali antes de repor qualquer produto.',
        ],
        'faq' => [
            ['q' => 'Harmonização facial deixa o rosto artificial?', 'a' => 'O aspecto artificial costuma vir de excesso de produto ou de volume concentrado em poucos pontos. Quando o plano olha para o rosto inteiro e usa quantidades pequenas, você fica com um rosto descansado e com os seus traços.'],
            ['q' => 'Já fiz preenchimento antes. Ainda dá para ter um resultado natural?', 'a' => 'Dá. Na avaliação eu vejo o que ainda está no seu rosto. Quando faz sentido, o ácido hialurônico pode ser dissolvido antes de um novo plano.'],
            ['q' => 'Preciso tratar todas as regiões de uma vez?', 'a' => 'Não. O plano do rosto inteiro pode ser feito em etapas, começando pelo que traz mais resultado para você. A gente define a ordem na avaliação.'],
        ],
        'related' => ['full-face', 'harmonizacao-facial', 'bioestimulador-de-colageno', 'preenchimento-facial'],
        'sources' => [
            ['publisher' => 'ISAPS', 'title' => 'ISAPS International Survey on Aesthetic/Cosmetic Procedures performed in 2025', 'url' => 'https://www.isaps.org/media/ua4leneo/isaps-global-survey_2025.pdf', 'year' => '2026'],
            ['publisher' => 'Plastic and Reconstructive Surgery Global Open', 'title' => 'The Science and Theory behind Facial Aging', 'url' => 'https://pmc.ncbi.nlm.nih.gov/articles/PMC4174174/', 'year' => '2013'],
            ['publisher' => 'Clinical, Cosmetic and Investigational Dermatology', 'title' => 'A Review: Causes, Consequences, and Management Strategies of Facial Overfilling', 'url' => 'https://www.dovepress.com/a-review-causes-consequences-and-management-strategies-of-facial-overf-peer-reviewed-fulltext-article-CCID', 'year' => '2025'],
        ],
    ],

];
