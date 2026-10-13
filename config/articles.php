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
|
| Observação sobre valores: as normas de publicidade odontológica no Brasil
| restringem a divulgação de preços e promoções. Por isso o artigo sobre custo
| explica o que compõe o investimento, sem tabela de preços.
|
*/

return [

    'quanto-custa-harmonizacao-facial' => [
        'title' => 'Quanto custa harmonização facial em BH? | Dra. Emily Beatriz',
        'h1' => 'Quanto custa uma harmonização facial em Belo Horizonte?',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'O que define o valor de uma harmonização facial em Belo Horizonte: número de áreas, quantidade de produto, técnica e acompanhamento. Entenda antes de agendar.',
        'excerpt' => 'Não existe preço único, e desconfiar de quem promete um é o primeiro cuidado. Entenda o que realmente compõe o investimento.',
        'published' => '2026-08-18',
        'updated' => '2026-08-18',
        'answer' => 'Não existe valor único para harmonização facial. O investimento depende de quantas áreas serão tratadas, da quantidade de produto necessária, da técnica escolhida e do acompanhamento incluído. Por isso o orçamento só é fechado depois da avaliação presencial, quando se sabe exatamente o que o seu rosto precisa.',
        'sections' => [
            [
                'heading' => 'Por que ninguém consegue dizer o preço por telefone',
                'body' => [
                    'Harmonização facial não é um procedimento único: é um nome que reúne vários tratamentos diferentes. Dois pacientes que pedem "harmonização" podem sair da avaliação com planos completamente distintos — um precisando apenas de toxina botulínica em duas áreas, outro de um protocolo combinando preenchimento, bioestimulador e fios.',
                    'Por isso um valor dito antes da avaliação é, na melhor das hipóteses, um chute. Na pior, é uma âncora comercial que não corresponde ao que você realmente precisa.',
                ],
            ],
            [
                'heading' => 'O que compõe o investimento',
                'body' => [
                    'O primeiro fator é o número de áreas tratadas. Toxina botulínica apenas na testa custa diferente de toxina botulínica na testa, glabela e região dos olhos, simplesmente porque a quantidade de produto muda.',
                    'O segundo é a quantidade de produto. Preenchimentos e bioestimuladores são medidos em seringas ou frascos, e a quantidade necessária depende do seu rosto e do resultado desejado. Aqui vale um alerta: propostas muito abaixo do mercado costumam significar produto diluído, marca sem procedência ou aplicação por quem não tem formação para isso.',
                    'O terceiro é a técnica e a formação de quem aplica. Um resultado natural depende de conhecimento de anatomia facial, e é isso que separa um rosto harmonioso de um rosto que "parece feito".',
                    'O quarto é o acompanhamento. Retorno, ajustes e suporte no pós-procedimento fazem parte do tratamento, não são extras.',
                ],
            ],
            [
                'heading' => 'Por que o mais barato costuma sair caro',
                'body' => [
                    'Correções de procedimentos malfeitos são mais caras, mais demoradas e mais desconfortáveis do que o tratamento original. Em alguns casos é preciso esperar o produto ser absorvido — meses — antes de conseguir corrigir.',
                    'Antes de decidir por valor, confirme o registro do profissional no conselho, a procedência dos produtos e se a avaliação foi realmente individual. Esses três pontos custam nada e evitam a maior parte dos problemas.',
                ],
            ],
        ],
        'takeaways' => [
            'O valor só é definido após a avaliação, porque depende do que o seu rosto precisa.',
            'Número de áreas, quantidade de produto, técnica e acompanhamento compõem o investimento.',
            'Preço muito abaixo do mercado costuma indicar produto ou formação inadequados.',
            'Corrigir um procedimento malfeito custa mais do que fazê-lo bem da primeira vez.',
        ],
        'faq' => [
            ['q' => 'Dá para parcelar o tratamento?', 'a' => 'As formas de pagamento aceitas são cartão de crédito, débito e Pix. As condições são apresentadas na avaliação, junto com o plano de tratamento.'],
            ['q' => 'Preciso fazer tudo de uma vez?', 'a' => 'Não. Em muitos casos o plano é dividido em etapas, priorizando o que traz mais resultado primeiro. Isso é definido em conjunto na avaliação.'],
            ['q' => 'A avaliação tem custo?', 'a' => 'A primeira conversa serve para entender o que você deseja e avaliar o seu rosto. Consulte as condições atuais pelo WhatsApp antes de agendar.'],
        ],
        'related' => ['harmonizacao-facial', 'full-face', 'toxina-botulinica'],
    ],

    'tempo-de-recuperacao' => [
        'title' => 'Quanto tempo dura a recuperação de cada procedimento? | Dra. Emily Beatriz',
        'h1' => 'Quanto tempo dura a recuperação de cada procedimento?',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'Recuperação de toxina botulínica, preenchimento, bioestimulador, microagulhamento, fios de PDO e bichectomia: quanto tempo cada um pede antes de agendar.',
        'excerpt' => 'A pergunta que decide a data do seu agendamento: quantos dias você precisa reservar depois de cada procedimento.',
        'published' => '2026-08-29',
        'updated' => '2026-08-29',
        'answer' => 'A maioria dos procedimentos estéticos faciais permite retomar a rotina no mesmo dia. Toxina botulínica e preenchimento têm retorno imediato, com inchaço leve por 24 a 48 horas. Microagulhamento pede de 1 a 3 dias de pele sensível. Fios de PDO e bichectomia, por serem mais invasivos, pedem cerca de uma semana de cuidados.',
        'sections' => [
            [
                'heading' => 'Retorno imediato à rotina',
                'body' => [
                    'Toxina botulínica e preenchimento labial são os procedimentos com menor tempo de recuperação. Você sai da clínica e retoma o dia normalmente. É comum haver pequenos pontos avermelhados nos locais de aplicação e algum inchaço nas primeiras 24 a 48 horas, especialmente nos lábios.',
                    'As restrições existem, mas são simples: evitar deitar ou fazer exercício intenso nas primeiras horas, não massagear a região e evitar calor excessivo, como sauna, no mesmo dia.',
                ],
            ],
            [
                'heading' => 'Alguns dias de cuidado',
                'body' => [
                    'Microagulhamento deixa a pele avermelhada e sensível por 1 a 3 dias, com aspecto parecido com uma leve queimadura de sol. Nesse período a proteção solar deixa de ser recomendação e passa a ser condição para o resultado.',
                    'Bioestimulador de colágeno costuma permitir retorno imediato, mas pede atenção às orientações de massagem no pós-procedimento, que variam conforme o produto utilizado.',
                ],
            ],
            [
                'heading' => 'Cerca de uma semana',
                'body' => [
                    'Fios de PDO envolvem inserção sob a pele e por isso pedem mais cuidado. Inchaço e sensibilidade nos primeiros dias são esperados, com orientação para evitar esforço físico intenso e movimentos amplos do rosto durante o período indicado.',
                    'Bichectomia é o procedimento mais invasivo entre os oferecidos, e é cirúrgico. Inchaço e desconforto nos primeiros dias são normais, com alimentação leve e higiene específica. A maioria dos pacientes retoma a rotina em cerca de uma semana, mas o resultado final só aparece meses depois, quando os tecidos se acomodam.',
                ],
            ],
            [
                'heading' => 'Planejando a data',
                'body' => [
                    'Se você tem um evento marcado, a regra prática é simples: quanto mais o procedimento depende de acomodação dos tecidos, mais antecedência ele pede. A toxina botulínica precisa de pelo menos 15 dias para o efeito completo. Preenchimento pede de 7 a 14 dias para o inchaço ceder. Procedimentos cirúrgicos pedem meses.',
                    'Na avaliação, diga se há uma data importante à frente. O planejamento muda conforme o prazo disponível.',
                ],
            ],
        ],
        'takeaways' => [
            'Toxina botulínica e preenchimento permitem retomar a rotina no mesmo dia.',
            'Microagulhamento pede de 1 a 3 dias de pele sensível e proteção solar rigorosa.',
            'Fios de PDO e bichectomia pedem cerca de uma semana de cuidados.',
            'Para eventos, conte 15 dias para toxina botulínica e mais tempo para procedimentos invasivos.',
        ],
        'faq' => [
            ['q' => 'Posso trabalhar no dia seguinte?', 'a' => 'Na maioria dos procedimentos, sim. Toxina botulínica, preenchimento e bioestimulador permitem retorno imediato. Microagulhamento pode deixar a pele visivelmente avermelhada por alguns dias, e procedimentos cirúrgicos pedem mais tempo.'],
            ['q' => 'Posso fazer exercício depois?', 'a' => 'A orientação habitual é evitar esforço físico intenso nas primeiras 24 a 48 horas na maioria dos procedimentos, e por mais tempo em fios de PDO e bichectomia. As orientações específicas são dadas no seu caso.'],
            ['q' => 'Quando vejo o resultado final?', 'a' => 'Varia bastante: preenchimento tem resultado imediato, toxina botulínica leva de 3 a 15 dias, bioestimulador e fios são progressivos ao longo de semanas, e a bichectomia leva de 3 a 6 meses.'],
        ],
        'related' => ['toxina-botulinica', 'preenchimento-labial', 'microagulhamento'],
    ],

    'quem-nao-pode-fazer' => [
        'title' => 'Quem não pode fazer harmonização facial? | Dra. Emily Beatriz',
        'h1' => 'Quem não pode fazer harmonização facial?',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'Gestantes, algumas condições de saúde e expectativas irreais são motivos para adiar ou não indicar harmonização facial. Entenda quando a resposta é não.',
        'excerpt' => 'Uma boa avaliação inclui a possibilidade de dizer não. Conheça as situações em que o procedimento é adiado ou desaconselhado.',
        'published' => '2026-09-09',
        'updated' => '2026-09-09',
        'answer' => 'Gestantes e lactantes não devem realizar procedimentos injetáveis. Infecção ativa na região, doenças autoimunes descompensadas, distúrbios de coagulação e alergia a algum componente também contraindicam. Além disso, expectativas irreais são motivo legítimo para não indicar: se o resultado esperado não é alcançável, o procedimento não deve ser feito.',
        'sections' => [
            [
                'heading' => 'Contraindicações mais comuns',
                'body' => [
                    'Gestação e amamentação são as situações mais frequentes. Não porque exista prova de dano, mas porque não existem estudos que garantam segurança nesse período — e em saúde, ausência de evidência não é evidência de segurança. A orientação é adiar.',
                    'Infecção ativa na área a ser tratada, incluindo lesões de herpes, contraindica o procedimento até a resolução completa. Aplicar sobre um processo infeccioso pode espalhá-lo.',
                    'Doenças autoimunes em fase ativa, distúrbios de coagulação e uso de determinados medicamentos pedem avaliação conjunta com o médico que acompanha o caso. Nem sempre significa não, mas significa conversar antes.',
                    'Alergia conhecida a algum componente do produto é contraindicação absoluta para aquele produto específico.',
                ],
            ],
            [
                'heading' => 'Quando a resposta é "ainda não"',
                'body' => [
                    'Algumas situações não impedem o tratamento, apenas mudam o momento. Procedimentos odontológicos recentes, tratamentos dermatológicos em curso e pele com processo inflamatório ativo costumam pedir um intervalo.',
                    'Isso é uma decisão técnica, não burocracia. Fazer no momento errado compromete o resultado que você está pagando para ter.',
                ],
            ],
            [
                'heading' => 'Quando a expectativa é o problema',
                'body' => [
                    'Existe uma contraindicação que raramente aparece em lista: a expectativa que o procedimento não consegue atender. Trazer a foto de outra pessoa e pedir aquele rosto é o exemplo mais comum. Estruturas ósseas diferentes produzem resultados diferentes com o mesmo procedimento.',
                    'Bichectomia é o caso em que isso mais aparece. Em rostos naturalmente afinados, remover as bolsas de gordura pode acentuar o aspecto de envelhecimento com o passar dos anos. É por isso que uma avaliação honesta às vezes termina com a recomendação de não fazer.',
                    'Um profissional que aceita qualquer pedido sem avaliar não está sendo prestativo. Está terceirizando para você um risco que era dele avaliar.',
                ],
            ],
        ],
        'takeaways' => [
            'Gestantes e lactantes devem adiar procedimentos injetáveis.',
            'Infecção ativa na região contraindica até a resolução completa.',
            'Condições autoimunes e de coagulação pedem avaliação conjunta com o médico assistente.',
            'Expectativa inalcançável é motivo legítimo para não indicar o procedimento.',
        ],
        'faq' => [
            ['q' => 'Posso fazer toxina botulínica amamentando?', 'a' => 'A orientação é adiar. Não há estudos que comprovem segurança durante a amamentação, e por isso procedimentos injetáveis não são indicados nesse período.'],
            ['q' => 'Tenho doença autoimune, posso fazer?', 'a' => 'Depende da condição e do momento. Doenças autoimunes em fase ativa contraindicam, mas casos controlados podem ser avaliados em conjunto com o médico que acompanha você. Traga essa informação na avaliação.'],
            ['q' => 'Existe idade mínima ou máxima?', 'a' => 'Não há um número fixo. O que orienta a indicação é a avaliação individual, considerando a estrutura do rosto, o objetivo e o histórico de saúde de cada paciente.'],
        ],
        'related' => ['harmonizacao-facial', 'bichectomia', 'toxina-botulinica'],
    ],

    'como-se-preparar' => [
        'title' => 'Como se preparar para o seu procedimento | Dra. Emily Beatriz',
        'h1' => 'Como se preparar para o seu procedimento',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'O que fazer antes de toxina botulínica, preenchimento ou bioestimulador em Belo Horizonte. Preparo simples que melhora o resultado e reduz hematomas.',
        'excerpt' => 'Alguns cuidados nos dias anteriores reduzem hematomas e melhoram o resultado. Nenhum deles é complicado.',
        'published' => '2026-09-19',
        'updated' => '2026-09-19',
        'answer' => 'Nos dias anteriores, evite álcool por 24 a 48 horas e informe todos os medicamentos e suplementos que usa, especialmente anti-inflamatórios e anticoagulantes, que aumentam a chance de hematoma. Vá com o rosto limpo, sem maquiagem, depois de comer e bem hidratado. E leve suas dúvidas anotadas.',
        'sections' => [
            [
                'heading' => 'Na semana anterior',
                'body' => [
                    'O ponto mais importante é a informação. Liste todos os medicamentos, suplementos e fitoterápicos que você usa e leve essa lista. Anti-inflamatórios, ácido acetilsalicílico, anticoagulantes, ômega 3, ginkgo biloba e vitamina E em doses altas aumentam a chance de hematoma.',
                    'Nunca suspenda um medicamento por conta própria para fazer um procedimento estético. Se algo precisar ser ajustado, isso é decidido com o médico que prescreveu.',
                    'Se você tem histórico de herpes labial e vai fazer preenchimento nos lábios, avise. Existe orientação preventiva específica para esse caso.',
                ],
            ],
            [
                'heading' => 'Nas 48 horas antes',
                'body' => [
                    'Evite bebida alcoólica. O álcool dilata os vasos e aumenta consideravelmente a chance de hematoma, que é a queixa mais comum do pós-procedimento e a mais fácil de evitar.',
                    'Evite também exposição solar intensa e procedimentos agressivos na pele, como esfoliação forte ou depilação com cera na área a ser tratada.',
                ],
            ],
            [
                'heading' => 'No dia',
                'body' => [
                    'Vá com o rosto limpo e sem maquiagem, ou reserve alguns minutos para removê-la na clínica. A pele precisa estar livre para a antissepsia.',
                    'Alimente-se antes e beba água. Chegar em jejum aumenta a chance de mal-estar durante a aplicação, especialmente em procedimentos mais longos.',
                    'Reserve tempo. Sair correndo para outro compromisso transforma um momento de cuidado em mais uma tarefa, e algumas orientações do pós-procedimento merecem ser ouvidas com calma.',
                ],
            ],
            [
                'heading' => 'O que levar na conversa',
                'body' => [
                    'Anote suas dúvidas antes. É comum esquecer na hora e lembrar no caminho de volta.',
                    'Se tem uma referência do resultado que deseja, leve — mas leve também abertura para ouvir o que é alcançável no seu rosto. A conversa mais útil é aquela em que expectativa e possibilidade se encontram.',
                ],
            ],
        ],
        'takeaways' => [
            'Leve a lista completa de medicamentos e suplementos que usa.',
            'Evite álcool nas 48 horas anteriores para reduzir hematomas.',
            'Nunca suspenda medicamento por conta própria antes de um procedimento estético.',
            'Vá sem maquiagem, depois de comer e com tempo reservado.',
        ],
        'faq' => [
            ['q' => 'Preciso ficar em jejum?', 'a' => 'Não. Ao contrário: alimente-se antes. Chegar em jejum aumenta a chance de mal-estar durante o procedimento.'],
            ['q' => 'Posso tomar analgésico antes?', 'a' => 'Evite anti-inflamatórios e ácido acetilsalicílico, que aumentam a chance de hematoma. Se você usa algum medicamento de forma contínua, informe na avaliação em vez de suspendê-lo por conta própria.'],
            ['q' => 'Posso ir de maquiagem?', 'a' => 'É preferível chegar com o rosto limpo. Se não for possível, reserve alguns minutos para remover a maquiagem antes do procedimento.'],
        ],
        'related' => ['toxina-botulinica', 'preenchimento-labial', 'bioestimulador-de-colageno'],
    ],

    'harmonizacao-facial-depois-dos-40' => [
        'title' => 'Harmonização facial depois dos 40 e 50 anos | Dra. Emily Beatriz',
        'h1' => 'Harmonização facial depois dos 40 e 50 anos: o que muda',
        'eyebrow' => 'Pele madura',
        'meta_description' => 'Harmonização facial aos 40, 50 e na menopausa: flacidez, bigode chinês e perda de volume pedem outro plano. Veja o que faz sentido em cada fase.',
        'excerpt' => 'Depois dos 40, o rosto não pede mais volume: pede sustentação e qualidade de pele. Entenda o que muda em cada fase.',
        'published' => '2026-09-30',
        'updated' => '2026-09-30',
        'answer' => 'Depois dos 40, a harmonização facial muda de foco. Em vez de volume e pequenos ajustes, o plano passa a priorizar sustentação e qualidade da pele, com bioestimulador de colágeno, reposição de volume nas maçãs do rosto e fios de PDO. Depois dos 50 e na menopausa, a flacidez ganha prioridade e o tratamento costuma ser combinado e gradual.',
        'sections' => [
            [
                'heading' => 'O que acontece com o rosto a partir dos 40',
                'body' => [
                    'O envelhecimento do rosto não é só a pele. Por volta dos 40 anos, três processos se somam: a produção de colágeno continua caindo, as bolsas de gordura do rosto diminuem e mudam de lugar, e até o osso da face perde um pouco de volume. O resultado é um rosto que perde sustentação.',
                    'Na prática, isso aparece como o bigode chinês mais marcado, as maçãs do rosto mais baixas, o contorno da mandíbula menos nítido, olheiras mais fundas e uma pele mais fina e sem viço.',
                ],
            ],
            [
                'heading' => 'Por que o plano é diferente do de quem tem 30',
                'body' => [
                    'Aos 30, a harmonização costuma ser preventiva: toxina botulínica para as primeiras rugas de expressão e pequenos ajustes de proporção. Depois dos 40, tentar resolver tudo com preenchimento é o caminho mais rápido para um rosto pesado e artificial.',
                    'O que funciona é tratar a estrutura. Repor volume nos pontos que sustentam o rosto, como as maçãs, suaviza o bigode chinês sem precisar preencher o sulco. O bioestimulador de colágeno melhora a firmeza da pele de dentro para fora. E os fios de PDO reposicionam os tecidos quando há flacidez.',
                ],
            ],
            [
                'heading' => 'Depois dos 50 e na menopausa',
                'body' => [
                    'Na menopausa, a queda dos hormônios acelera a perda de colágeno e a pele fica mais fina e seca em pouco tempo. É comum a sensação de que o rosto mudou de repente.',
                    'Nessa fase, o estímulo de colágeno é a base do tratamento, quase sempre combinado com sustentação e reposição de volume. Os resultados são construídos aos poucos, ao longo de alguns meses, e o objetivo é um rosto descansado, nunca uma aparência de quem fez muita coisa.',
                    'Também é a fase em que a honestidade da avaliação mais importa: em flacidez acentuada, os tratamentos não cirúrgicos melhoram a pele, mas não substituem um lifting cirúrgico. Saber disso antes evita frustração e investimento no lugar errado.',
                ],
            ],
            [
                'heading' => 'E os homens?',
                'body' => [
                    'Os mesmos processos acontecem no rosto masculino, com algumas diferenças: a pele é mais espessa e a musculatura mais forte. Os homens costumam buscar o contorno da mandíbula, o tratamento das olheiras e da papada e a suavização das rugas da testa, sempre preservando os traços masculinos.',
                ],
            ],
        ],
        'takeaways' => [
            'Depois dos 40, o foco sai do volume e vai para a sustentação e a qualidade da pele.',
            'Repor volume nas maçãs do rosto suaviza o bigode chinês melhor do que preencher só o sulco.',
            'Na menopausa, o estímulo de colágeno é a base do tratamento.',
            'Em flacidez acentuada, os tratamentos sem cirurgia melhoram a pele, mas não substituem um lifting.',
        ],
        'faq' => [
            ['q' => 'Existe idade limite para fazer harmonização facial?', 'a' => 'Não. O que define a indicação é a avaliação do rosto e da saúde, não a idade. Muitos pacientes começam depois dos 50 e têm ótimos resultados com um plano adequado à fase.'],
            ['q' => 'Qual o melhor tratamento para o rosto depois dos 50?', 'a' => 'Em geral, a combinação de bioestimulador de colágeno, reposição de volume e, quando há flacidez, fios de PDO. O plano exato depende do seu rosto e é definido na avaliação.'],
            ['q' => 'A harmonização facial fica artificial em pele madura?', 'a' => 'Não precisa ficar. O aspecto artificial vem de excesso de produto, principalmente de preenchimento. Com foco em sustentação e quantidades conservadoras, o resultado é um rosto descansado e natural.'],
        ],
        'related' => ['bioestimulador-de-colageno', 'flacidez-facial', 'bigode-chines', 'preenchimento-facial'],
    ],

    'harmonizacao-facial-em-homens' => [
        'title' => 'Por que tantos homens fazem harmonização facial | Dra. Emily Beatriz',
        'h1' => 'Por que tantos homens estão fazendo harmonização facial',
        'eyebrow' => 'Para homens',
        'meta_description' => 'Homens famosos mostraram a harmonização facial nas últimas semanas. Veja o que os homens costumam buscar e como tratar o rosto sem perder os traços masculinos.',
        'excerpt' => 'Em poucos dias, um cantor, um ator e o governador eleito de Minas contaram que fizeram harmonização. Fica a dúvida que todo homem tem: dá para fazer sem parecer que fez?',
        'published' => '2026-10-08',
        'updated' => '2026-10-08',
        'answer' => 'Os homens procuram a harmonização facial por motivos bem práticos: parecer menos cansado, recuperar o contorno da mandíbula e suavizar as rugas da testa. O bom resultado depende de respeitar a anatomia masculina, com doses ajustadas a uma musculatura mais forte, produto em quantidade conservadora e foco na mandíbula e no queixo. Assim o rosto fica descansado e continua com cara de homem.',
        'sections' => [
            [
                'heading' => 'Uma semana de homens falando do assunto',
                'body' => [
                    'No começo de outubro, o cantor Fiuk, de 35 anos, mostrou na televisão o resultado de uma harmonização feita para corrigir pequenos detalhes do rosto. Na mesma semana, o ator Henri Castelli, de 48, voltou a uma clínica em São Paulo para repetir o tratamento que tinha feito em 2024. E em Minas o tema chegou à política: um dia depois de eleito governador, Cleitinho Azevedo fez preenchimento, bioestimulador de colágeno, ultrassom microfocado e um peeling. Segundo a clínica que o atendeu, a ideia era tirar do rosto o desgaste da campanha.',
                    'O que chama atenção é que nenhum deles escondeu. Até pouco tempo atrás, homem que aplicava toxina botulínica não comentava nem com os amigos. Agora o assunto aparece em programa de auditório e em post de clínica, e quem tinha vontade de perguntar se sente mais à vontade para marcar uma avaliação.',
                ],
            ],
            [
                'heading' => 'O que os homens costumam pedir',
                'body' => [
                    'Poucos homens chegam dizendo que querem ficar mais bonitos. O pedido costuma vir de lado: os colegas perguntam se ele está doente, a esposa diz que ele parece bravo o tempo todo, a foto de perfil mostra alguém mais velho do que ele se sente. Por trás dessas frases estão sinais bem conhecidos, como olheira funda, testa e região entre as sobrancelhas muito marcadas, papada e um contorno de mandíbula que foi perdendo definição.',
                    'Muitos chegam por outro caminho, o bruxismo. Vêm tratar a dor e o desgaste dos dentes com toxina botulínica no masseter e só ali começam a perguntar sobre a testa ou as olheiras.',
                ],
            ],
            [
                'heading' => 'Rosto de homem pede outro planejamento',
                'body' => [
                    'A pele masculina é mais grossa, a musculatura é mais forte e a estrutura óssea é diferente. A mandíbula é mais larga, o queixo mais projetado e a sobrancelha fica mais baixa e reta. Quando uma técnica pensada para o rosto feminino é aplicada sem adaptação, as maçãs do rosto ficam arredondadas, a ponta da sobrancelha sobe e os lábios ganham volume. É daí que vem aquela cara de quem fez alguma coisa.',
                    'Na toxina botulínica, a dose costuma ser maior e os pontos de aplicação mudam para manter a sobrancelha reta. No preenchimento, o produto vai mais para o ângulo da mandíbula e para o queixo, e bem menos para as maçãs do rosto e os lábios. Em muitos casos, o que mais rejuvenesce um homem é tratar a olheira e devolver nitidez à linha da mandíbula, sem mexer em mais nada.',
                ],
            ],
            [
                'heading' => 'Vários procedimentos no mesmo dia',
                'body' => [
                    'Combinar tratamentos numa sessão é possível e, em alguns planos, faz sentido. Só que o inchaço de cada um se soma, e se aparecer uma reação fica mais difícil saber o que a causou. Além disso, cada técnica tem seu tempo. A toxina leva até duas semanas para fazer efeito e o bioestimulador de colágeno trabalha ao longo de meses.',
                    'Para quem vai fazer pela primeira vez, começar por uma ou duas áreas costuma ser o caminho mais tranquilo. Dá para ver como o rosto responde, ajustar no retorno e decidir com calma o próximo passo.',
                ],
            ],
            [
                'heading' => 'Antes de marcar',
                'body' => [
                    'A Anvisa classifica os preenchedores como dispositivos médicos de alto risco, e as complicações graves costumam acontecer quando o produto é aplicado fora das áreas ou dos volumes indicados pelo fabricante. Por isso, confirme o registro do profissional no conselho, pergunte qual produto será usado e peça a etiqueta com o lote. Avaliação feita por mensagem, sem examinar o rosto, não serve.',
                    'Também vale perguntar se o profissional tem casos de homens para mostrar. Antes e depois de mulher diz pouco sobre como ele trabalha um rosto masculino.',
                ],
            ],
        ],
        'takeaways' => [
            'Os homens buscam parecer descansados, não mudar de rosto.',
            'Pele mais grossa e músculo mais forte pedem doses e pontos de aplicação diferentes.',
            'Técnica feminina sem adaptação é o que deixa o homem com cara de que fez.',
            'Na primeira vez, uma ou duas áreas bem feitas rendem mais do que um pacote completo.',
        ],
        'faq' => [
            ['q' => 'Homem precisa de mais toxina botulínica do que mulher?', 'a' => 'Em geral, sim. A musculatura masculina é mais forte e costuma pedir doses maiores para o mesmo efeito. A quantidade exata depende da força de cada músculo, avaliada na consulta.'],
            ['q' => 'O efeito dura menos no rosto masculino?', 'a' => 'A toxina botulínica pode durar um pouco menos em quem tem músculos muito fortes, mas a diferença é pequena. Preenchimento e bioestimulador duram o mesmo tempo que nas mulheres.'],
            ['q' => 'Preciso me afastar do trabalho?', 'a' => 'Na maioria dos casos, não. Pode haver leve inchaço ou um pequeno hematoma por alguns dias. Se houver um compromisso importante, o ideal é marcar o procedimento com uma ou duas semanas de folga.'],
        ],
        'related' => ['harmonizacao-facial-masculina', 'toxina-botulinica', 'toxina-botulinica-bruxismo', 'preenchimento-facial'],
    ],

];
