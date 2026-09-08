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
        'published' => '2026-09-08',
        'updated' => '2026-09-08',
        'answer' => 'Não existe valor único para harmonização facial. O investimento depende de quantas áreas serão tratadas, da quantidade de produto necessária, da técnica escolhida e do acompanhamento incluído. Por isso o orçamento só é fechado depois da avaliação presencial, quando se sabe exatamente o que o seu rosto precisa.',
        'sections' => [
            [
                'heading' => 'Por que ninguém consegue dizer o preço por telefone',
                'body' => [
                    'Harmonização facial não é um procedimento único: é um nome que reúne vários tratamentos diferentes. Duas pacientes que pedem "harmonização" podem sair da avaliação com planos completamente distintos — uma precisando apenas de botox em duas áreas, outra de um protocolo combinando preenchimento, bioestimulador e fios.',
                    'Por isso um valor dito antes da avaliação é, na melhor das hipóteses, um chute. Na pior, é uma âncora comercial que não corresponde ao que você realmente precisa.',
                ],
            ],
            [
                'heading' => 'O que compõe o investimento',
                'body' => [
                    'O primeiro fator é o número de áreas tratadas. Botox apenas na testa custa diferente de botox na testa, glabela e região dos olhos, simplesmente porque a quantidade de produto muda.',
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
        'related' => ['harmonizacao-facial', 'full-face', 'botox'],
    ],

    'tempo-de-recuperacao' => [
        'title' => 'Quanto tempo dura a recuperação de cada procedimento? | Dra. Emily Beatriz',
        'h1' => 'Quanto tempo dura a recuperação de cada procedimento?',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'Recuperação de botox, preenchimento, bioestimulador, microagulhamento, fios de PDO e bichectomia. Saiba quanto tempo cada procedimento pede antes de agendar.',
        'excerpt' => 'A pergunta que decide a data do seu agendamento: quantos dias você precisa reservar depois de cada procedimento.',
        'published' => '2026-09-08',
        'updated' => '2026-09-08',
        'answer' => 'A maioria dos procedimentos estéticos faciais permite retomar a rotina no mesmo dia. Botox e preenchimento têm retorno imediato, com inchaço leve por 24 a 48 horas. Microagulhamento pede de 1 a 3 dias de pele sensível. Fios de PDO e bichectomia, por serem mais invasivos, pedem cerca de uma semana de cuidados.',
        'sections' => [
            [
                'heading' => 'Retorno imediato à rotina',
                'body' => [
                    'Botox e preenchimento labial são os procedimentos com menor tempo de recuperação. Você sai da clínica e retoma o dia normalmente. É comum haver pequenos pontos avermelhados nos locais de aplicação e algum inchaço nas primeiras 24 a 48 horas, especialmente nos lábios.',
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
                    'Bichectomia é o procedimento mais invasivo entre os oferecidos, e é cirúrgico. Inchaço e desconforto nos primeiros dias são normais, com alimentação leve e higiene específica. A maioria das pacientes retoma a rotina em cerca de uma semana, mas o resultado final só aparece meses depois, quando os tecidos se acomodam.',
                ],
            ],
            [
                'heading' => 'Planejando a data',
                'body' => [
                    'Se você tem um evento marcado, a regra prática é simples: quanto mais o procedimento depende de acomodação dos tecidos, mais antecedência ele pede. Botox precisa de pelo menos 15 dias para o efeito completo. Preenchimento pede de 7 a 14 dias para o inchaço ceder. Procedimentos cirúrgicos pedem meses.',
                    'Na avaliação, diga se há uma data importante à frente. O planejamento muda conforme o prazo disponível.',
                ],
            ],
        ],
        'takeaways' => [
            'Botox e preenchimento permitem retomar a rotina no mesmo dia.',
            'Microagulhamento pede de 1 a 3 dias de pele sensível e proteção solar rigorosa.',
            'Fios de PDO e bichectomia pedem cerca de uma semana de cuidados.',
            'Para eventos, conte 15 dias para botox e mais tempo para procedimentos invasivos.',
        ],
        'faq' => [
            ['q' => 'Posso trabalhar no dia seguinte?', 'a' => 'Na maioria dos procedimentos, sim. Botox, preenchimento e bioestimulador permitem retorno imediato. Microagulhamento pode deixar a pele visivelmente avermelhada por alguns dias, e procedimentos cirúrgicos pedem mais tempo.'],
            ['q' => 'Posso fazer exercício depois?', 'a' => 'A orientação habitual é evitar esforço físico intenso nas primeiras 24 a 48 horas na maioria dos procedimentos, e por mais tempo em fios de PDO e bichectomia. As orientações específicas são dadas no seu caso.'],
            ['q' => 'Quando vejo o resultado final?', 'a' => 'Varia bastante: preenchimento tem resultado imediato, botox leva de 3 a 15 dias, bioestimulador e fios são progressivos ao longo de semanas, e a bichectomia leva de 3 a 6 meses.'],
        ],
        'related' => ['botox', 'preenchimento-labial', 'microagulhamento'],
    ],

    'quem-nao-pode-fazer' => [
        'title' => 'Quem não pode fazer harmonização facial? | Dra. Emily Beatriz',
        'h1' => 'Quem não pode fazer harmonização facial?',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'Gestantes, algumas condições de saúde e expectativas irreais são motivos para adiar ou não indicar harmonização facial. Entenda quando a resposta é não.',
        'excerpt' => 'Uma boa avaliação inclui a possibilidade de dizer não. Conheça as situações em que o procedimento é adiado ou desaconselhado.',
        'published' => '2026-09-08',
        'updated' => '2026-09-08',
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
            ['q' => 'Posso fazer botox amamentando?', 'a' => 'A orientação é adiar. Não há estudos que comprovem segurança durante a amamentação, e por isso procedimentos injetáveis não são indicados nesse período.'],
            ['q' => 'Tenho doença autoimune, posso fazer?', 'a' => 'Depende da condição e do momento. Doenças autoimunes em fase ativa contraindicam, mas casos controlados podem ser avaliados em conjunto com o médico que acompanha você. Traga essa informação na avaliação.'],
            ['q' => 'Existe idade mínima ou máxima?', 'a' => 'Não há um número fixo. O que orienta a indicação é a avaliação individual, considerando a estrutura do rosto, o objetivo e o histórico de saúde de cada paciente.'],
        ],
        'related' => ['harmonizacao-facial', 'bichectomia', 'botox'],
    ],

    'como-se-preparar' => [
        'title' => 'Como se preparar para o seu procedimento | Dra. Emily Beatriz',
        'h1' => 'Como se preparar para o seu procedimento',
        'eyebrow' => 'Antes de agendar',
        'meta_description' => 'O que fazer nos dias que antecedem botox, preenchimento ou bioestimulador em Belo Horizonte. Preparo simples que melhora o resultado e reduz hematomas.',
        'excerpt' => 'Alguns cuidados nos dias anteriores reduzem hematomas e melhoram o resultado. Nenhum deles é complicado.',
        'published' => '2026-09-08',
        'updated' => '2026-09-08',
        'answer' => 'Nos dias anteriores, evite álcool por 24 a 48 horas e informe todos os medicamentos e suplementos que usa, especialmente anti-inflamatórios e anticoagulantes, que aumentam a chance de hematoma. Vá com o rosto limpo, sem maquiagem, alimentada e hidratada. E leve suas dúvidas anotadas.',
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
            'Vá sem maquiagem, alimentada e com tempo reservado.',
        ],
        'faq' => [
            ['q' => 'Preciso ficar em jejum?', 'a' => 'Não. Ao contrário: alimente-se antes. Chegar em jejum aumenta a chance de mal-estar durante o procedimento.'],
            ['q' => 'Posso tomar analgésico antes?', 'a' => 'Evite anti-inflamatórios e ácido acetilsalicílico, que aumentam a chance de hematoma. Se você usa algum medicamento de forma contínua, informe na avaliação em vez de suspendê-lo por conta própria.'],
            ['q' => 'Posso ir maquiada?', 'a' => 'É preferível chegar com o rosto limpo. Se não for possível, reserve alguns minutos para remover a maquiagem antes do procedimento.'],
        ],
        'related' => ['botox', 'preenchimento-labial', 'bioestimulador-de-colageno'],
    ],

];
