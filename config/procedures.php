<?php

/*
|--------------------------------------------------------------------------
| Procedimentos
|--------------------------------------------------------------------------
|
| Conteúdo de cada página de procedimento (SEO + corpo). A chave do array
| é o slug usado na URL: /procedimentos/{slug}.
|
| Estrutura de cada item:
|   num               => número decorativo exibido no card da home
|   updated           => data da última revisão do conteúdo (usada no sitemap)
|   name              => nome curto do procedimento
|   card_desc         => descrição curta (card da home)
|   title             => <title> da página (com localização)
|   meta_description  => meta description
|   eyebrow           => sobretítulo do hero
|   h1                => título principal (H1)
|   hero_lead         => parágrafo de abertura
|   facts             => [['label' => ..., 'value' => ...], ...] faixa de destaques
|   what_is_title     => título da seção "o que é"
|   what_is           => [parágrafo, parágrafo, ...]
|   benefits          => [['title' => ..., 'desc' => ...], ...]
|   steps             => [['title' => ..., 'desc' => ...], ...] como funciona
|   faq               => [['q' => ..., 'a' => ...], ...]
|   comparison        => tabela comparativa opcional:
|                        ['title' => ..., 'intro' => ..., 'columns' => [a, b],
|                         'rows' => [['label' => ..., 'a' => ..., 'b' => ...], ...]]
|
*/

return [

    'botox' => [
        'comparison' => [
            'title' => 'Botox ou preenchimento: qual é a diferença?',
            'intro' => 'São tratamentos diferentes e complementares. O botox relaxa a musculatura que causa as rugas de expressão; o preenchimento devolve volume e contorno. Muitas pacientes fazem os dois.',
            'columns' => ['Botox', 'Preenchimento com ácido hialurônico'],
            'rows' => [
                ['label' => 'Como age', 'a' => 'Relaxa temporariamente os músculos responsáveis pelas rugas de expressão.', 'b' => 'Adiciona volume e contorno, sem agir na musculatura.'],
                ['label' => 'Indicado para', 'a' => 'Linhas da testa, glabela e ao redor dos olhos.', 'b' => 'Lábios, contorno e regiões que perderam volume.'],
                ['label' => 'Resultado aparece', 'a' => '3 a 15 dias', 'b' => 'Imediato'],
                ['label' => 'Duração média', 'a' => '4 a 6 meses', 'b' => '6 a 18 meses'],
                ['label' => 'Tempo de sessão', 'a' => '~30 minutos', 'b' => '~40 minutos'],
            ],
        ],
        'num' => '01',
        'updated' => '2026-09-08',
        'name' => 'Botox',
        'card_desc' => 'Suaviza rugas e linhas de expressão com um resultado leve e natural — o famoso olhar descansado de quem dormiu bem.',
        'title' => 'Botox em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Botox (toxina botulínica) em Belo Horizonte com a Dra. Emily Beatriz. Suaviza rugas da testa, olhos e sobrancelha com resultado natural. Agende pelo WhatsApp.',
        'eyebrow' => 'Toxina Botulínica',
        'h1' => 'Botox em Belo Horizonte',
        'hero_lead' => 'O tratamento mais procurado para suavizar rugas e linhas de expressão sem perder a naturalidade. Aplicado pela Dra. Emily Beatriz com técnica refinada, devolve ao rosto um aspecto leve, descansado e absolutamente seu.',
        'facts' => [
            ['label' => 'Resultado', 'value' => '3 a 15 dias'],
            ['label' => 'Duração', 'value' => '4 a 6 meses'],
            ['label' => 'Sessão', 'value' => '~30 minutos'],
            ['label' => 'Retorno', 'value' => 'Imediato'],
        ],
        'what_is_title' => 'O que é o botox?',
        'what_is' => [
            'O botox é o nome popular da toxina botulínica, uma substância que relaxa de forma temporária os músculos responsáveis pelas rugas de expressão. Ao suavizar a contração desses músculos, as linhas da testa, da sobrancelha e ao redor dos olhos (os famosos "pés de galinha") ficam visivelmente mais leves.',
            'Mais do que um tratamento antienvelhecimento, o botox é uma forma de devolver ao rosto a expressão de tranquilidade. Quando feito com equilíbrio e por mãos experientes, ninguém percebe que você fez — apenas notam que você está mais bonita, descansada e serena.',
        ],
        'benefits' => [
            ['title' => 'Rugas suavizadas', 'desc' => 'Linhas da testa, glabela e olhos atenuadas de forma natural, preservando a sua expressão.'],
            ['title' => 'Olhar descansado', 'desc' => 'Aquele aspecto de quem dormiu bem — leveza no rosto sem parecer "congelado".'],
            ['title' => 'Prevenção', 'desc' => 'Aplicado de forma preventiva, retarda a formação de novas rugas ao longo dos anos.'],
            ['title' => 'Rápido e prático', 'desc' => 'Procedimento de poucos minutos, sem afastamento das atividades do dia a dia.'],
        ],
        'steps' => [
            ['title' => 'Avaliação', 'desc' => 'A Dra. Emily estuda a sua musculatura facial e a sua expressão para planejar uma aplicação personalizada.'],
            ['title' => 'Aplicação', 'desc' => 'A toxina é aplicada com agulhas ultrafinas nos pontos certos. O desconforto é mínimo e a sessão dura cerca de 30 minutos.'],
            ['title' => 'Resultado', 'desc' => 'O efeito começa a aparecer em 3 a 15 dias, revelando um rosto mais suave e descansado de forma gradual e natural.'],
        ],
        'faq' => [
            ['q' => 'Botox dói?', 'a' => 'O desconforto é mínimo. A aplicação é feita com agulhas finíssimas e a maioria das pacientes descreve apenas uma leve picada. Não é necessário anestesia na maioria dos casos.'],
            ['q' => 'O resultado fica artificial?', 'a' => 'Não. Quando aplicado com técnica e equilíbrio, como faz a Dra. Emily em Belo Horizonte, o botox preserva a sua expressão natural — o objetivo é suavizar, nunca "congelar" o rosto.'],
            ['q' => 'Quanto tempo dura o efeito do botox?', 'a' => 'Em média de 4 a 6 meses, variando conforme o metabolismo de cada pessoa. Com a manutenção regular, os resultados tendem a durar cada vez mais.'],
            ['q' => 'Quando posso voltar às atividades?', 'a' => 'Imediatamente. Recomenda-se apenas evitar exercícios intensos, calor excessivo e deitar nas primeiras horas após a aplicação.'],
        ],
    ],

    'preenchimento-labial' => [
        'num' => '02',
        'updated' => '2026-09-08',
        'name' => 'Preenchimento Labial',
        'card_desc' => 'Lábios mais definidos, hidratados e harmônicos com ácido hialurônico — volume na medida certa, com resultado natural.',
        'title' => 'Preenchimento Labial em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Preenchimento labial com ácido hialurônico em Belo Horizonte com a Dra. Emily Beatriz. Lábios definidos, hidratados e naturais. Agende sua avaliação pelo WhatsApp.',
        'eyebrow' => 'Ácido Hialurônico',
        'h1' => 'Preenchimento Labial em Belo Horizonte',
        'hero_lead' => 'Lábios mais bonitos não precisam ser maiores — precisam ser harmônicos. Com ácido hialurônico e um olhar atento à sua face, a Dra. Emily Beatriz cria contornos definidos, hidratados e proporcionais ao seu rosto.',
        'facts' => [
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '6 a 18 meses'],
            ['label' => 'Sessão', 'value' => '~40 minutos'],
            ['label' => 'Anestesia', 'value' => 'Tópica'],
        ],
        'what_is_title' => 'O que é o preenchimento labial?',
        'what_is' => [
            'O preenchimento labial é um procedimento que utiliza ácido hialurônico — uma substância naturalmente presente no nosso corpo — para dar volume, definição e hidratação aos lábios. O resultado é imediato e pode ser ajustado de acordo com o que cada paciente deseja.',
            'O segredo de um preenchimento bonito está na proporção. A Dra. Emily Beatriz trabalha respeitando a anatomia e a personalidade de cada rosto, criando lábios que parecem naturais — bonitos porque são seus, apenas valorizados.',
        ],
        'benefits' => [
            ['title' => 'Contorno definido', 'desc' => 'Bordas mais nítidas e simétricas, corrigindo assimetrias de forma sutil.'],
            ['title' => 'Volume na medida', 'desc' => 'Mais preenchidos sem exageros — exatamente o que combina com o seu rosto.'],
            ['title' => 'Hidratação', 'desc' => 'O ácido hialurônico devolve viço e maciez aos lábios ressecados.'],
            ['title' => 'Resultado imediato', 'desc' => 'Você já sai do consultório vendo a diferença, com efeito completo em poucos dias.'],
        ],
        'steps' => [
            ['title' => 'Conversa & desenho', 'desc' => 'Entendemos o que você deseja e desenhamos juntas o formato ideal para o seu rosto.'],
            ['title' => 'Anestesia tópica', 'desc' => 'Um creme anestésico garante muito conforto durante todo o procedimento.'],
            ['title' => 'Aplicação', 'desc' => 'O ácido hialurônico é aplicado com precisão, modelando o volume e o contorno em cerca de 40 minutos.'],
        ],
        'faq' => [
            ['q' => 'O preenchimento labial fica natural?', 'a' => 'Sim. O resultado natural depende da técnica e do bom senso na quantidade de produto. A Dra. Emily prioriza a harmonia com o seu rosto, evitando o aspecto artificial.'],
            ['q' => 'Quanto tempo dura o preenchimento labial?', 'a' => 'Em média de 6 a 18 meses, dependendo do seu metabolismo e do volume aplicado. Depois, o produto é absorvido naturalmente pelo corpo.'],
            ['q' => 'Incha muito depois?', 'a' => 'É comum um leve inchaço nas primeiras 24 a 48 horas, que desaparece naturalmente. Em poucos dias os lábios assumem o resultado final.'],
            ['q' => 'Posso escolher o volume?', 'a' => 'Com certeza. O procedimento é totalmente personalizado — desde uma hidratação sutil até mais volume e definição, sempre respeitando a sua anatomia.'],
        ],
    ],

    'harmonizacao-facial' => [
        'num' => '03',
        'updated' => '2026-09-08',
        'name' => 'Harmonização Facial',
        'card_desc' => 'Um conjunto de procedimentos que equilibra as proporções do rosto e valoriza a sua beleza natural, de forma personalizada.',
        'title' => 'Harmonização Facial em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Harmonização facial em Belo Horizonte com a Dra. Emily Beatriz. Equilíbrio das proporções do rosto com botox, preenchimento e bioestimuladores. Agende pelo WhatsApp.',
        'eyebrow' => 'Equilíbrio & Proporção',
        'h1' => 'Harmonização Facial em Belo Horizonte',
        'hero_lead' => 'Mais do que um único procedimento, a harmonização facial é um olhar completo sobre o seu rosto. A Dra. Emily Beatriz combina técnicas para equilibrar proporções, suavizar o tempo e revelar a sua beleza — sempre de forma natural.',
        'facts' => [
            ['label' => 'Abordagem', 'value' => 'Personalizada'],
            ['label' => 'Técnicas', 'value' => 'Combinadas'],
            ['label' => 'Resultado', 'value' => 'Progressivo'],
            ['label' => 'Foco', 'value' => 'Naturalidade'],
        ],
        'what_is_title' => 'O que é harmonização facial?',
        'what_is' => [
            'Harmonização facial é o nome dado ao conjunto de procedimentos estéticos minimamente invasivos que trabalham juntos para equilibrar as proporções do rosto. Pode incluir botox, preenchimento labial e facial, bioestimuladores de colágeno, fios de PDO e outros tratamentos — combinados de acordo com a necessidade de cada pessoa.',
            'O objetivo nunca é transformar você em outra pessoa, mas valorizar o que você já tem de mais bonito. Em Belo Horizonte, a Dra. Emily Beatriz constrói cada plano de harmonização de forma individual, respeitando a sua identidade e os seus desejos.',
        ],
        'benefits' => [
            ['title' => 'Proporções equilibradas', 'desc' => 'Contornos, volumes e ângulos do rosto trabalhados em conjunto para um resultado harmônico.'],
            ['title' => 'Plano personalizado', 'desc' => 'Cada protocolo é desenhado para o seu rosto, nunca uma receita pronta.'],
            ['title' => 'Resultado natural', 'desc' => 'Mudanças sutis que somam — sem nunca parecer artificial ou exagerado.'],
            ['title' => 'Mais autoestima', 'desc' => 'O reflexo no espelho volta a combinar com como você se sente por dentro.'],
        ],
        'steps' => [
            ['title' => 'Avaliação completa', 'desc' => 'A Dra. Emily analisa o seu rosto como um todo, ouve seus desejos e identifica o que pode ser valorizado.'],
            ['title' => 'Plano de tratamento', 'desc' => 'Juntas, definimos quais procedimentos combinam com o seu objetivo, seu tempo e o seu momento.'],
            ['title' => 'Execução & acompanhamento', 'desc' => 'Os procedimentos são realizados com segurança e acompanhados de perto até o resultado final.'],
        ],
        'faq' => [
            ['q' => 'Harmonização facial é o mesmo que botox?', 'a' => 'Não exatamente. O botox é um dos procedimentos que pode fazer parte da harmonização facial, mas a harmonização é um conceito mais amplo, que combina diferentes técnicas para equilibrar todo o rosto.'],
            ['q' => 'O resultado fica artificial?', 'a' => 'Não, quando bem feita. A filosofia da Dra. Emily é a naturalidade: o objetivo é realçar a sua beleza, não mudar quem você é.'],
            ['q' => 'Quantas sessões são necessárias?', 'a' => 'Depende do seu plano personalizado. Alguns procedimentos são feitos em sessão única, outros exigem manutenção. Tudo é definido na avaliação.'],
            ['q' => 'Quanto tempo dura a harmonização facial?', 'a' => 'Varia conforme as técnicas utilizadas — de alguns meses (botox) a mais de um ano (preenchimentos e bioestimuladores). A manutenção mantém o resultado.'],
        ],
    ],

    'full-face' => [
        'comparison' => [
            'title' => 'Full Face ou harmonização facial: qual é a diferença?',
            'intro' => 'Full Face é uma forma de harmonização facial, não um tratamento à parte. A diferença está na amplitude: a harmonização pode tratar uma região específica, enquanto o Full Face planeja o rosto inteiro de uma só vez.',
            'columns' => ['Full Face', 'Harmonização facial'],
            'rows' => [
                ['label' => 'Abrangência', 'a' => 'Rosto completo: terços superior, médio e inferior avaliados juntos.', 'b' => 'Pode tratar apenas as regiões que a paciente deseja ajustar.'],
                ['label' => 'Planejamento', 'a' => 'Mapeamento facial completo antes de qualquer aplicação.', 'b' => 'Avaliação focada no objetivo trazido pela paciente.'],
                ['label' => 'Técnicas', 'a' => 'Protocolo combinado, executado em etapas.', 'b' => 'Uma ou mais técnicas, conforme o caso.'],
                ['label' => 'Resultado', 'a' => 'Global: o conjunto do rosto ganha equilíbrio.', 'b' => 'Progressivo e direcionado à região tratada.'],
            ],
        ],
        'num' => '04',
        'updated' => '2026-09-08',
        'featured' => true,
        'view' => 'procedures.full-face',
        'name' => 'Full Face',
        'card_desc' => 'A harmonização facial completa: o rosto trabalhado em todas as suas regiões para um resultado global, equilibrado e elegante.',
        'card_tagline' => 'O tratamento mais completo',
        'title' => 'Full Face em Belo Horizonte | Harmonização Completa | Dra. Emily Beatriz',
        'meta_description' => 'Full Face em Belo Horizonte com a Dra. Emily Beatriz. Harmonização facial completa que trabalha todas as regiões do rosto de forma global e natural. Agende pelo WhatsApp.',
        'eyebrow' => 'Harmonização Completa',
        'h1' => 'Full Face em Belo Horizonte',
        'hero_lead' => 'O Full Face é a abordagem mais completa da harmonização facial: em vez de tratar uma região isolada, a Dra. Emily Beatriz trabalha o rosto inteiro de forma integrada, criando um resultado global, equilibrado e profundamente natural.',
        'facts' => [
            ['label' => 'Abordagem', 'value' => 'Rosto completo'],
            ['label' => 'Técnicas', 'value' => 'Integradas'],
            ['label' => 'Planejamento', 'value' => 'Individual'],
            ['label' => 'Resultado', 'value' => 'Global'],
        ],
        'what_is_title' => 'O que é o Full Face?',
        'what_is' => [
            'Full Face é o conceito de harmonização facial que considera o rosto como um todo. Em vez de focar apenas nos lábios ou na testa, o tratamento avalia e trabalha as diversas regiões — terço superior, médio e inferior — de maneira integrada, para que o conjunto fique em equilíbrio.',
            'Essa visão global permite resultados mais sofisticados e duradouros. Em Belo Horizonte, a Dra. Emily Beatriz utiliza uma combinação de preenchedores, bioestimuladores e toxina botulínica para devolver sustentação, contorno e leveza ao rosto, respeitando sempre a naturalidade.',
        ],
        'benefits' => [
            ['title' => 'Visão global', 'desc' => 'O rosto inteiro avaliado e tratado em conjunto, evitando desproporções entre regiões.'],
            ['title' => 'Contorno & sustentação', 'desc' => 'Volume restaurado nos pontos certos para um efeito de lifting natural.'],
            ['title' => 'Resultado sofisticado', 'desc' => 'Mudanças sutis em várias áreas somam um efeito elegante e harmonioso.'],
            ['title' => 'Mais duradouro', 'desc' => 'A combinação de técnicas tende a oferecer resultados mais estáveis ao longo do tempo.'],
        ],
        'steps' => [
            ['title' => 'Mapeamento facial', 'desc' => 'A Dra. Emily faz uma análise detalhada de cada região do rosto e da sua proporção geral.'],
            ['title' => 'Protocolo combinado', 'desc' => 'Define-se a combinação ideal de procedimentos para o seu rosto e o seu objetivo.'],
            ['title' => 'Execução em etapas', 'desc' => 'O tratamento pode ser realizado em uma ou mais sessões, com acompanhamento próximo do resultado.'],
        ],
        'thirds' => [
            ['label' => 'Terço Superior', 'desc' => 'Testa, sobrancelhas e olhar. Suavização de rugas e elevação sutil das sobrancelhas para um olhar mais aberto e descansado.'],
            ['label' => 'Terço Médio', 'desc' => 'Maçãs do rosto, olheiras e nariz. Restauração de volume e projeção das maçãs, devolvendo sustentação e contorno ao rosto.'],
            ['label' => 'Terço Inferior', 'desc' => 'Lábios, mandíbula e queixo. Definição do contorno facial, projeção do queixo e harmonia dos lábios com o conjunto.'],
        ],
        'includes' => ['botox', 'preenchimento-labial', 'bioestimulador-de-colageno'],
        'faq' => [
            ['q' => 'Qual a diferença entre Full Face e harmonização facial?', 'a' => 'O Full Face é a forma mais completa de harmonização facial: trabalha o rosto inteiro de maneira integrada, enquanto uma harmonização pontual pode focar apenas em uma região específica.'],
            ['q' => 'O Full Face é feito em uma única sessão?', 'a' => 'Pode ser realizado em uma sessão mais longa ou dividido em etapas, dependendo do plano definido na avaliação e do conforto da paciente.'],
            ['q' => 'Fica com aparência artificial?', 'a' => 'Não. Justamente por trabalhar o rosto de forma equilibrada, o Full Face bem executado pela Dra. Emily entrega um resultado natural e harmonioso.'],
            ['q' => 'Para quem o Full Face é indicado?', 'a' => 'Para quem deseja um resultado mais completo e duradouro, ou para quem apresenta sinais de envelhecimento em diferentes regiões do rosto. A indicação é definida na avaliação.'],
        ],
    ],

    'bioestimulador-de-colageno' => [
        'num' => '05',
        'updated' => '2026-09-08',
        'name' => 'Bioestimulador de Colágeno',
        'card_desc' => 'Estimula o seu corpo a produzir colágeno, devolvendo firmeza, viço e qualidade à pele de forma progressiva e natural.',
        'title' => 'Bioestimulador de Colágeno em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Bioestimulador de colágeno em Belo Horizonte com a Dra. Emily Beatriz. Mais firmeza, viço e qualidade de pele com resultado natural e progressivo. Agende pelo WhatsApp.',
        'eyebrow' => 'Firmeza & Qualidade de Pele',
        'h1' => 'Bioestimulador de Colágeno em Belo Horizonte',
        'hero_lead' => 'O tratamento que trabalha de dentro para fora: em vez de apenas preencher, o bioestimulador faz a sua própria pele produzir mais colágeno. O resultado é firmeza, viço e rejuvenescimento que aparecem de forma gradual e natural.',
        'facts' => [
            ['label' => 'Resultado', 'value' => 'Progressivo'],
            ['label' => 'Duração', 'value' => 'Até 24 meses'],
            ['label' => 'Sessões', 'value' => '1 a 3'],
            ['label' => 'Foco', 'value' => 'Qualidade da pele'],
        ],
        'what_is_title' => 'O que é o bioestimulador de colágeno?',
        'what_is' => [
            'O bioestimulador de colágeno é uma substância injetável que estimula o próprio organismo a produzir colágeno novo — a proteína responsável pela firmeza e pela sustentação da pele. Com o passar dos anos, produzimos cada vez menos colágeno, e é aí que esse tratamento faz diferença.',
            'Diferente do preenchimento, que adiciona volume de imediato, o bioestimulador melhora a qualidade da pele ao longo do tempo. Em Belo Horizonte, a Dra. Emily Beatriz indica esse tratamento para quem busca um rejuvenescimento natural, sem aparência artificial.',
        ],
        'benefits' => [
            ['title' => 'Mais firmeza', 'desc' => 'A pele recupera sustentação e elasticidade conforme o colágeno é produzido.'],
            ['title' => 'Viço e luminosidade', 'desc' => 'A textura melhora e a pele ganha um aspecto mais saudável e iluminado.'],
            ['title' => 'Resultado natural', 'desc' => 'Como a mudança é gradual, o rejuvenescimento acontece de forma discreta e elegante.'],
            ['title' => 'Longa duração', 'desc' => 'Os estímulos de colágeno podem manter seus efeitos por até 2 anos.'],
        ],
        'steps' => [
            ['title' => 'Avaliação da pele', 'desc' => 'A Dra. Emily avalia a qualidade, a flacidez e as necessidades da sua pele.'],
            ['title' => 'Aplicação', 'desc' => 'O bioestimulador é aplicado nas regiões indicadas, em sessões espaçadas conforme o protocolo.'],
            ['title' => 'Estímulo progressivo', 'desc' => 'Nas semanas e meses seguintes, o seu corpo produz colágeno e o resultado aparece gradualmente.'],
        ],
        'faq' => [
            ['q' => 'Bioestimulador é a mesma coisa que preenchimento?', 'a' => 'Não. O preenchimento adiciona volume imediato com ácido hialurônico, enquanto o bioestimulador faz a sua pele produzir o próprio colágeno, melhorando a qualidade dela ao longo do tempo.'],
            ['q' => 'Em quanto tempo aparece o resultado?', 'a' => 'O resultado é progressivo: começa a ser percebido em algumas semanas e atinge seu melhor estágio após alguns meses, conforme o colágeno é produzido.'],
            ['q' => 'Quantas sessões preciso fazer?', 'a' => 'Em geral de 1 a 3 sessões, dependendo do produto e do grau de flacidez. O protocolo ideal é definido na avaliação.'],
            ['q' => 'Quanto tempo dura?', 'a' => 'Os efeitos podem durar até 2 anos, já que o estímulo de colágeno é duradouro. Manutenções periódicas prolongam o resultado.'],
        ],
    ],

    'microagulhamento' => [
        'num' => '06',
        'updated' => '2026-09-08',
        'name' => 'Microagulhamento',
        'card_desc' => 'Micropunturas que estimulam a renovação da pele — textura mais lisa, poros menos aparentes e viço recuperado.',
        'title' => 'Microagulhamento em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Microagulhamento em Belo Horizonte com a Dra. Emily Beatriz. Melhora textura, poros, manchas e linhas finas estimulando a renovação da pele. Agende pelo WhatsApp.',
        'eyebrow' => 'Qualidade de Pele',
        'h1' => 'Microagulhamento em Belo Horizonte',
        'hero_lead' => 'O tratamento para quem quer melhorar a pele em si: textura, poros, manchas e aquele viço que o tempo vai levando. A Dra. Emily Beatriz trabalha com protocolos personalizados, respeitando o tempo de recuperação de cada pele.',
        'facts' => [
            ['label' => 'Sessões', 'value' => '3 a 6'],
            ['label' => 'Intervalo', 'value' => '~30 dias'],
            ['label' => 'Sessão', 'value' => '~60 minutos'],
            ['label' => 'Recuperação', 'value' => '1 a 3 dias'],
        ],
        'what_is_title' => 'O que é o microagulhamento?',
        'what_is' => [
            'O microagulhamento é uma técnica que cria micropunturas controladas na pele com agulhas muito finas. Esses microestímulos ativam o processo natural de reparação do organismo, que responde produzindo colágeno e elastina — as estruturas responsáveis por firmeza e elasticidade.',
            'O resultado não é uma mudança de traços, e sim uma melhora na qualidade da pele: textura mais uniforme, poros menos aparentes, manchas atenuadas e um aspecto geral mais saudável. Como o estímulo é progressivo, os resultados aparecem ao longo das semanas seguintes a cada sessão.',
        ],
        'benefits' => [
            ['title' => 'Textura mais uniforme', 'desc' => 'A pele fica visivelmente mais lisa ao toque, com relevo mais regular.'],
            ['title' => 'Poros menos aparentes', 'desc' => 'O estímulo de colágeno ajuda a reduzir a aparência dos poros dilatados.'],
            ['title' => 'Manchas atenuadas', 'desc' => 'A renovação celular contribui para uniformizar o tom da pele ao longo das sessões.'],
            ['title' => 'Viço recuperado', 'desc' => 'Aquele aspecto de pele descansada e saudável, que costuma ser o primeiro a se perder.'],
        ],
        'steps' => [
            ['title' => 'Avaliação da pele', 'desc' => 'A Dra. Emily analisa o seu tipo de pele e as suas queixas para definir a profundidade e o número de sessões.'],
            ['title' => 'Anestesia tópica', 'desc' => 'Um creme anestésico é aplicado antes do procedimento para deixar a sessão confortável.'],
            ['title' => 'Aplicação & cuidados', 'desc' => 'As micropunturas são feitas de forma uniforme e você recebe orientações de cuidado para os dias seguintes.'],
        ],
        'faq' => [
            ['q' => 'Microagulhamento dói?', 'a' => 'Com o creme anestésico aplicado antes, a maioria das pacientes descreve apenas uma sensação de calor ou leve arranhado. O desconforto é bem tolerado e passa rápido.'],
            ['q' => 'Quantas sessões são necessárias?', 'a' => 'O protocolo habitual é de 3 a 6 sessões, com intervalo em torno de 30 dias. O número exato depende da sua pele e do objetivo, e é definido na avaliação.'],
            ['q' => 'Como fica a pele depois?', 'a' => 'É normal a pele ficar avermelhada e sensível por 1 a 3 dias, parecida com uma leve queimadura de sol. Nesse período é importante usar protetor solar e seguir os cuidados orientados.'],
            ['q' => 'Posso fazer em qualquer época do ano?', 'a' => 'Sim, desde que a proteção solar seja rigorosa depois de cada sessão. Muitas pacientes preferem os meses de menor exposição ao sol para facilitar esse cuidado.'],
        ],
    ],

    'fios-de-pdo' => [
        'num' => '07',
        'updated' => '2026-09-08',
        'name' => 'Fios de PDO',
        'card_desc' => 'Sustentação sem cirurgia: fios bioabsorvíveis que reposicionam os tecidos e estimulam colágeno.',
        'title' => 'Fios de PDO em Belo Horizonte | Lifting sem Cirurgia | Dra. Emily Beatriz',
        'meta_description' => 'Fios de PDO em Belo Horizonte com a Dra. Emily Beatriz. Sustentação facial sem cirurgia, com estímulo de colágeno e resultado natural. Agende pelo WhatsApp.',
        'eyebrow' => 'Sustentação Facial',
        'h1' => 'Fios de PDO em Belo Horizonte',
        'hero_lead' => 'Para quem sente que o rosto perdeu sustentação mas não quer passar por uma cirurgia. Os fios de PDO reposicionam suavemente os tecidos e estimulam colágeno, com um resultado que melhora ao longo das semanas.',
        'facts' => [
            ['label' => 'Resultado', 'value' => 'Progressivo'],
            ['label' => 'Duração', 'value' => '8 a 12 meses'],
            ['label' => 'Sessão', 'value' => '~60 minutos'],
            ['label' => 'Recuperação', 'value' => 'Poucos dias'],
        ],
        'what_is_title' => 'O que são fios de PDO?',
        'what_is' => [
            'Os fios de PDO são fios bioabsorvíveis, feitos de polidioxanona — o mesmo material usado há décadas em suturas cirúrgicas. Eles são inseridos sob a pele com agulhas finas e cumprem duas funções: dar sustentação imediata aos tecidos e estimular a produção de colágeno ao redor do trajeto.',
            'Com o tempo, o próprio organismo absorve os fios, mas o colágeno formado permanece. Por isso o resultado é chamado de lifting sem bisturi: não substitui uma cirurgia plástica, e sim oferece uma alternativa menos invasiva para quem busca mais firmeza e definição de contorno.',
        ],
        'benefits' => [
            ['title' => 'Sustentação imediata', 'desc' => 'Os tecidos são reposicionados no momento da aplicação, com efeito visível desde o primeiro dia.'],
            ['title' => 'Estímulo de colágeno', 'desc' => 'Além da sustentação, os fios ativam a produção de colágeno na região tratada.'],
            ['title' => 'Sem cirurgia', 'desc' => 'Procedimento ambulatorial, com anestesia local e sem necessidade de internação.'],
            ['title' => 'Resultado natural', 'desc' => 'O objetivo é devolver contorno, não mudar a sua expressão.'],
        ],
        'steps' => [
            ['title' => 'Planejamento', 'desc' => 'A Dra. Emily avalia a flacidez, o contorno e os pontos de sustentação para definir o tipo e o trajeto dos fios.'],
            ['title' => 'Anestesia local', 'desc' => 'A região é anestesiada para que a inserção seja confortável.'],
            ['title' => 'Inserção & acompanhamento', 'desc' => 'Os fios são posicionados e você recebe as orientações de cuidado para os primeiros dias.'],
        ],
        'faq' => [
            ['q' => 'Fios de PDO substituem a cirurgia plástica?', 'a' => 'Não. São procedimentos diferentes. Os fios oferecem sustentação e estímulo de colágeno de forma menos invasiva, mas não alcançam o mesmo grau de correção de uma cirurgia. Na avaliação a Dra. Emily explica o que é realista no seu caso.'],
            ['q' => 'Quanto tempo dura o efeito?', 'a' => 'Os fios são absorvidos pelo organismo em alguns meses, mas o colágeno estimulado permanece. Em média o resultado se mantém de 8 a 12 meses, variando conforme a pele e o estilo de vida de cada paciente.'],
            ['q' => 'A recuperação é demorada?', 'a' => 'Costuma ser rápida. É comum haver inchaço e sensibilidade nos primeiros dias, com orientação para evitar esforço físico intenso e movimentos amplos do rosto nesse período.'],
            ['q' => 'Dá para combinar com outros tratamentos?', 'a' => 'Sim. Os fios são frequentemente combinados com bioestimuladores e preenchimento dentro de um plano de harmonização facial, sempre definido em avaliação individual.'],
        ],
    ],

    'bichectomia' => [
        'num' => '08',
        'updated' => '2026-09-08',
        'name' => 'Bichectomia',
        'card_desc' => 'Cirurgia que reduz as bolsas de gordura das bochechas, afinando o terço inferior do rosto.',
        'title' => 'Bichectomia em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Bichectomia em Belo Horizonte com a Dra. Emily Beatriz, cirurgiã-dentista. Redução das bolsas de Bichat com avaliação criteriosa e resultado natural. Agende pelo WhatsApp.',
        'eyebrow' => 'Procedimento Cirúrgico',
        'h1' => 'Bichectomia em Belo Horizonte',
        'hero_lead' => 'A bichectomia afina o terço inferior do rosto ao reduzir as bolsas de gordura das bochechas. É um procedimento cirúrgico, indicado apenas para alguns casos — e a avaliação criteriosa é a parte mais importante dele.',
        'facts' => [
            ['label' => 'Tipo', 'value' => 'Cirúrgico'],
            ['label' => 'Sessão', 'value' => '~60 minutos'],
            ['label' => 'Anestesia', 'value' => 'Local'],
            ['label' => 'Resultado final', 'value' => '3 a 6 meses'],
        ],
        'what_is_title' => 'O que é a bichectomia?',
        'what_is' => [
            'A bichectomia é a remoção parcial das bolsas de Bichat, estruturas de gordura localizadas na região das bochechas. Ao reduzi-las, o terço inferior do rosto fica mais afinado e o contorno mandibular, mais evidente.',
            'É um procedimento cirúrgico, realizado por via intraoral e com anestesia local. Não é indicado para todo mundo: em rostos naturalmente finos, a remoção pode acentuar demais o envelhecimento com o passar dos anos. Por isso a avaliação vem antes de qualquer decisão, e em muitos casos a recomendação é não operar.',
        ],
        'benefits' => [
            ['title' => 'Contorno mais definido', 'desc' => 'O ângulo da mandíbula ganha destaque à medida que o volume da bochecha diminui.'],
            ['title' => 'Sem cicatriz aparente', 'desc' => 'O acesso é feito por dentro da boca, sem incisão na pele do rosto.'],
            ['title' => 'Anestesia local', 'desc' => 'Procedimento ambulatorial, sem necessidade de internação.'],
            ['title' => 'Resultado definitivo', 'desc' => 'A gordura removida não retorna, o que torna a indicação correta ainda mais importante.'],
        ],
        'steps' => [
            ['title' => 'Avaliação criteriosa', 'desc' => 'A Dra. Emily analisa proporções, volume e histórico para verificar se a bichectomia é mesmo indicada para você.'],
            ['title' => 'Cirurgia', 'desc' => 'Com anestesia local, o acesso é feito por dentro da boca e as bolsas são reduzidas de forma controlada.'],
            ['title' => 'Pós-operatório', 'desc' => 'Você recebe orientações de alimentação, higiene e retorno para acompanhar a cicatrização.'],
        ],
        'faq' => [
            ['q' => 'Bichectomia é indicada para todo mundo?', 'a' => 'Não. Em rostos naturalmente afinados a remoção pode acentuar o aspecto de envelhecimento com o passar dos anos. A indicação depende das proporções do seu rosto e é definida em avaliação individual — e não é raro a recomendação ser não fazer.'],
            ['q' => 'Como é a recuperação?', 'a' => 'É comum haver inchaço e desconforto nos primeiros dias, com orientação de alimentação leve e higiene específica. A maioria das pacientes retoma a rotina em cerca de uma semana, seguindo as orientações do pós-operatório.'],
            ['q' => 'Quando aparece o resultado final?', 'a' => 'O inchaço inicial mascara o resultado. O contorno definitivo costuma se estabelecer entre 3 e 6 meses após a cirurgia, à medida que os tecidos se acomodam.'],
            ['q' => 'A gordura volta depois?', 'a' => 'Não. As bolsas de Bichat removidas não se regeneram, e por isso o resultado é considerado definitivo. É justamente essa característica que torna a avaliação prévia tão importante.'],
        ],
    ],

];
