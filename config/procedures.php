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
|
*/

return [

    'botox' => [
        'num' => '01',
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
        'num' => '04',
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
        'num' => '04',
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

];
