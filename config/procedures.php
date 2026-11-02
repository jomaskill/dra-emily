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
|   includes          => slugs de procedimentos relacionados (chips do card / Full Face)
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
|   kind              => opcional; 'concern' para páginas de queixa (bigode
|                        chinês, flacidez), que descrevem um problema e
|                        apontam os tratamentos em vez de um procedimento
|   treatments        => somente em queixas: até 4 slugs de procedimentos que
|                        tratam a queixa. Substituem a rotação de "relacionados"
|   concern           => opcional; ['label' => ..., 'desc' => ...] coloca a
|                        página no bloco "O que mais incomoda você?" da home
|   parent            => opcional; slug da página-mãe. Entra no breadcrumb e faz
|                        a página aparecer na lista de segmentos da mãe e no
|                        bloco de preenchimento por objetivo da home
|   regions_title     => título da seção de regiões tratadas
|   regions           => [['name' => ..., 'desc' => ...], ...] regiões tratadas
|   related           => opcional; até 4 slugs que substituem a rotação de
|                        "relacionados", para ligar páginas da mesma família
|
| A ordem do array define a lista da home e a rotação de links internos, por
| isso cada página fica ao lado da sua família de tratamentos.
|
| Nunca use nomes comerciais de produtos (toxina, preenchedores,
| bioestimuladores): o Google Ads reprova anúncios cuja página de destino os
| menciona. Use sempre o nome genérico do ativo.
|
*/

return [

    'harmonizacao-facial' => [
        'num' => '01',
        'updated' => '2026-09-08',
        'includes' => ['toxina-botulinica', 'preenchimento-labial', 'bioestimulador-de-colageno', 'fios-de-pdo'],
        'name' => 'Harmonização Facial',
        'card_desc' => 'Um conjunto de procedimentos que equilibra as proporções do rosto e valoriza a sua beleza natural, de forma personalizada.',
        'title' => 'Harmonização Facial em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Harmonização facial em Belo Horizonte com a Dra. Emily Beatriz. Proporções equilibradas com toxina, preenchimento e bioestimulador. Agende pelo WhatsApp.',
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
            'Harmonização facial é o nome dado ao conjunto de procedimentos estéticos minimamente invasivos que trabalham juntos para equilibrar as proporções do rosto. Pode incluir toxina botulínica, preenchimento labial e facial, bioestimuladores de colágeno, fios de PDO e outros tratamentos — combinados de acordo com a necessidade de cada pessoa.',
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
            ['title' => 'Plano de tratamento', 'desc' => 'Junto com você, a Dra. Emily define quais procedimentos combinam com o seu objetivo, seu tempo e o seu momento.'],
            ['title' => 'Execução & acompanhamento', 'desc' => 'Os procedimentos são realizados com segurança e acompanhados de perto até o resultado final.'],
        ],
        'faq' => [
            ['q' => 'Harmonização facial é o mesmo que toxina botulínica?', 'a' => 'Não exatamente. A toxina botulínica é um dos procedimentos que pode fazer parte da harmonização facial, mas a harmonização é um conceito mais amplo, que combina diferentes técnicas para equilibrar todo o rosto.'],
            ['q' => 'O resultado fica artificial?', 'a' => 'Não, quando bem feita. A filosofia da Dra. Emily é a naturalidade: o objetivo é realçar a sua beleza, não mudar quem você é.'],
            ['q' => 'Quantas sessões são necessárias?', 'a' => 'Depende do seu plano personalizado. Alguns procedimentos são feitos em sessão única, outros exigem manutenção. Tudo é definido na avaliação.'],
            ['q' => 'Quanto tempo dura a harmonização facial?', 'a' => 'Varia conforme as técnicas utilizadas — de alguns meses (toxina botulínica) a mais de um ano (preenchimentos e bioestimuladores). A manutenção mantém o resultado.'],
            ['q' => 'Harmonização facial é só para mulheres?', 'a' => 'Não. Cada vez mais homens procuram a harmonização facial para suavizar sinais de cansaço e definir o contorno do rosto. A diferença está no planejamento: no rosto masculino, a Dra. Emily preserva traços como a mandíbula marcada e as sobrancelhas retas.'],
            ['q' => 'A partir de que idade posso fazer harmonização facial?', 'a' => 'Não existe idade certa, e sim indicação. Aos 30, o foco costuma ser prevenção e pequenos ajustes. Aos 40, entram reposição de volume e estímulo de colágeno. A partir dos 50, flacidez e qualidade da pele ganham prioridade. O plano acompanha o seu momento.'],
        ],
    ],

    'harmonizacao-facial-masculina' => [
        'num' => '09',
        'updated' => '2026-10-13',
        'name' => 'Harmonização Facial Masculina',
        'card_desc' => 'Contorno mais definido e aparência descansada, preservando os traços masculinos e sem nenhum aspecto feminilizado.',
        'title' => 'Harmonização Facial Masculina em BH | Dra. Emily Beatriz',
        'meta_description' => 'Harmonização facial masculina em Belo Horizonte com a Dra. Emily Beatriz. Mandíbula definida e aparência descansada, sem perder traços masculinos.',
        'eyebrow' => 'Para Homens',
        'h1' => 'Harmonização Facial Masculina em Belo Horizonte',
        'hero_lead' => 'Parecer descansado, com o contorno do rosto mais firme e sem que ninguém perceba que você fez algo. A harmonização facial masculina respeita a anatomia do homem: realça a mandíbula e o queixo e suaviza o cansaço, sem arredondar o rosto.',
        'facts' => [
            ['label' => 'Foco', 'value' => 'Contorno & cansaço'],
            ['label' => 'Técnicas', 'value' => 'Combinadas'],
            ['label' => 'Retorno', 'value' => 'No mesmo dia'],
            ['label' => 'Resultado', 'value' => 'Discreto'],
        ],
        'what_is_title' => 'O que muda na harmonização facial masculina?',
        'what_is' => [
            'O rosto masculino tem outra arquitetura: mandíbula mais larga e angulada, queixo mais projetado, sobrancelhas retas e pele mais espessa. Uma harmonização pensada para o rosto feminino, aplicada sem esse cuidado, arredonda as maçãs do rosto e arqueia as sobrancelhas — exatamente o que a maioria dos homens não quer.',
            'Por isso o planejamento é outro. A Dra. Emily Beatriz trabalha principalmente o contorno da mandíbula e do queixo, as olheiras, a papada e as rugas de expressão da testa e dos olhos. A toxina botulínica, por exemplo, costuma exigir doses diferentes, porque a musculatura masculina é mais forte.',
            'O objetivo é um resultado que os outros percebam como "você está com uma cara ótima", e não como "você fez alguma coisa". Tudo é definido na avaliação, em Belo Horizonte, com uma conversa franca sobre o que faz sentido para o seu rosto.',
        ],
        'benefits' => [
            ['title' => 'Mandíbula definida', 'desc' => 'O ângulo e a linha da mandíbula ganham contorno, uma das mudanças mais pedidas pelos homens.'],
            ['title' => 'Aparência descansada', 'desc' => 'Olheiras e rugas de cansaço suavizadas, sem mudar a sua expressão.'],
            ['title' => 'Traços preservados', 'desc' => 'Sobrancelhas retas e rosto anguloso mantidos: nada de aspecto feminilizado.'],
            ['title' => 'Discrição', 'desc' => 'Procedimentos rápidos, com retorno à rotina no mesmo dia na maioria dos casos.'],
        ],
        'steps' => [
            ['title' => 'Avaliação', 'desc' => 'A Dra. Emily analisa a estrutura do seu rosto e entende o que incomoda você, sem pressa e sem julgamento.'],
            ['title' => 'Plano sob medida', 'desc' => 'Define-se quais técnicas entram — toxina botulínica, preenchimento de mandíbula e queixo, bioestimulador ou enzima para papada — e em que ordem.'],
            ['title' => 'Aplicação & retorno', 'desc' => 'Os procedimentos são feitos em consultório, com acompanhamento até o resultado final.'],
        ],
        'faq' => [
            ['q' => 'Harmonização facial masculina deixa o rosto feminino?', 'a' => 'Não, quando planejada para o rosto masculino. O risco existe quando se aplica a mesma técnica do rosto feminino, arredondando as maçãs do rosto e arqueando as sobrancelhas. A Dra. Emily faz o oposto: preserva e reforça os traços masculinos.'],
            ['q' => 'Quais procedimentos os homens mais fazem?', 'a' => 'Os mais procurados são toxina botulínica para rugas da testa e dos olhos, preenchimento de mandíbula e queixo, tratamento de olheiras e enzima para papada. A combinação ideal depende da sua avaliação.'],
            ['q' => 'Alguém vai perceber que eu fiz?', 'a' => 'A ideia é que percebam que você está mais descansado, e não o procedimento em si. Por isso a Dra. Emily trabalha com quantidades conservadoras e resultados progressivos.'],
            ['q' => 'Preciso me afastar do trabalho?', 'a' => 'Na maioria dos casos, não. Pode haver um leve inchaço ou pequenos hematomas por alguns dias, mas a rotina costuma ser retomada no mesmo dia.'],
        ],
    ],

    'toxina-botulinica' => [
        'comparison' => [
            'title' => 'Toxina botulínica ou preenchimento: qual é a diferença?',
            'intro' => 'São tratamentos diferentes e complementares. A toxina botulínica relaxa a musculatura que causa as rugas de expressão; o preenchimento devolve volume e contorno. Muitos pacientes fazem os dois.',
            'columns' => ['Toxina botulínica', 'Preenchimento com ácido hialurônico'],
            'rows' => [
                ['label' => 'Como age', 'a' => 'Relaxa temporariamente os músculos responsáveis pelas rugas de expressão.', 'b' => 'Adiciona volume e contorno, sem agir na musculatura.'],
                ['label' => 'Indicado para', 'a' => 'Linhas da testa, glabela e ao redor dos olhos.', 'b' => 'Lábios, contorno e regiões que perderam volume.'],
                ['label' => 'Resultado aparece', 'a' => '3 a 15 dias', 'b' => 'Imediato'],
                ['label' => 'Duração média', 'a' => '4 a 6 meses', 'b' => '6 a 18 meses'],
                ['label' => 'Tempo de sessão', 'a' => '~30 minutos', 'b' => '~40 minutos'],
            ],
        ],
        'num' => '02',
        'updated' => '2026-10-13',
        'name' => 'Toxina Botulínica',
        'concern' => ['label' => 'Rugas de expressão', 'desc' => 'Testa, pés de galinha e linhas entre as sobrancelhas.'],
        'card_desc' => 'Suaviza rugas e linhas de expressão com um resultado leve e natural — o famoso olhar descansado de quem dormiu bem.',
        'title' => 'Toxina Botulínica em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Toxina botulínica em Belo Horizonte com a Dra. Emily Beatriz. Suaviza rugas da testa, pés de galinha e linhas entre as sobrancelhas com resultado natural.',
        'eyebrow' => 'Rugas de Expressão',
        'h1' => 'Toxina Botulínica em Belo Horizonte',
        'hero_lead' => 'O tratamento mais procurado para suavizar rugas e linhas de expressão sem perder a naturalidade. Aplicado pela Dra. Emily Beatriz com técnica refinada, devolve ao rosto um aspecto leve, descansado e absolutamente seu.',
        'facts' => [
            ['label' => 'Resultado', 'value' => '3 a 15 dias'],
            ['label' => 'Duração', 'value' => '4 a 6 meses'],
            ['label' => 'Sessão', 'value' => '~30 minutos'],
            ['label' => 'Retorno', 'value' => 'Imediato'],
        ],
        'what_is_title' => 'O que é a toxina botulínica?',
        'what_is' => [
            'A toxina botulínica é uma substância que relaxa de forma temporária os músculos responsáveis pelas rugas de expressão. Ao suavizar a contração desses músculos, as linhas da testa, da sobrancelha e ao redor dos olhos (os famosos "pés de galinha") ficam visivelmente mais leves. Em microdoses, também ajuda a suavizar as linhas acima do lábio superior, o chamado "código de barras".',
            'Mais do que um tratamento antienvelhecimento, a toxina botulínica é uma forma de devolver ao rosto a expressão de tranquilidade. Quando feito com equilíbrio e por mãos experientes, ninguém percebe que você fez — apenas notam que você está com uma aparência mais descansada e serena.',
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
            ['q' => 'A toxina botulínica dói?', 'a' => 'O desconforto é mínimo. A aplicação é feita com agulhas finíssimas e a maioria dos pacientes descreve apenas uma leve picada. Não é necessário anestesia na maioria dos casos.'],
            ['q' => 'O resultado fica artificial?', 'a' => 'Não. Quando aplicada com técnica e equilíbrio, como faz a Dra. Emily em Belo Horizonte, a toxina botulínica preserva a sua expressão natural — o objetivo é suavizar, nunca "congelar" o rosto.'],
            ['q' => 'Quanto tempo dura o efeito da toxina botulínica?', 'a' => 'Em média de 4 a 6 meses, variando conforme o metabolismo de cada pessoa. Com a manutenção regular, os resultados tendem a durar cada vez mais.'],
            ['q' => 'Quando posso voltar às atividades?', 'a' => 'Imediatamente. Recomenda-se apenas evitar exercícios intensos, calor excessivo e deitar nas primeiras horas após a aplicação.'],
            ['q' => 'A toxina botulínica também trata bruxismo?', 'a' => 'Sim. Aplicada no músculo masseter, ela reduz a força com que os dentes são apertados ou rangidos, aliviando a dor e a tensão na mandíbula. É um uso terapêutico, com planejamento próprio, que a Dra. Emily realiza como cirurgiã-dentista.'],
        ],
    ],

    'toxina-botulinica-bruxismo' => [
        'num' => '10',
        'updated' => '2026-10-13',
        'name' => 'Toxina Botulínica para Bruxismo',
        'card_desc' => 'Alívio para quem range ou aperta os dentes: menos dor na mandíbula, menos dor de cabeça e mais proteção para os dentes.',
        'concern' => ['label' => 'Bruxismo', 'desc' => 'Ranger ou apertar os dentes, com dor na mandíbula ao acordar.'],
        'title' => 'Toxina Botulínica para Bruxismo em BH | Dra. Emily Beatriz',
        'meta_description' => 'Toxina botulínica para bruxismo em Belo Horizonte com a Dra. Emily Beatriz, cirurgiã-dentista. Alivia a dor na mandíbula e protege os dentes.',
        'eyebrow' => 'Bruxismo & Dor na Mandíbula',
        'h1' => 'Toxina Botulínica para Bruxismo em Belo Horizonte',
        'hero_lead' => 'Acordar com a mandíbula dolorida, dor de cabeça ou dentes desgastados são sinais clássicos de bruxismo. Aplicada no músculo certo por uma cirurgiã-dentista, a toxina botulínica reduz a força do apertamento e traz alívio já nas primeiras semanas.',
        'facts' => [
            ['label' => 'Resultado', 'value' => '1 a 4 semanas'],
            ['label' => 'Duração', 'value' => '4 a 6 meses'],
            ['label' => 'Sessão', 'value' => '~20 minutos'],
            ['label' => 'Retorno', 'value' => 'Imediato'],
        ],
        'what_is_title' => 'Como a toxina botulínica ajuda no bruxismo?',
        'what_is' => [
            'Bruxismo é o hábito de ranger ou apertar os dentes, muitas vezes durante o sono e sem que a pessoa perceba. Com o tempo, a força excessiva do músculo masseter causa dor na mandíbula e na região das têmporas, dores de cabeça ao acordar, desgaste e até fraturas nos dentes.',
            'A toxina botulínica, aplicada no masseter e em alguns casos no músculo temporal, relaxa parcialmente essa musculatura. O hábito pode continuar, mas a força do apertamento diminui — e é essa força que provoca a dor e o desgaste. Como efeito secundário, quem tem o masseter muito desenvolvido costuma notar o contorno do rosto mais afinado.',
            'Por ser cirurgiã-dentista, a Dra. Emily Beatriz avalia o bruxismo de forma completa em Belo Horizonte e indica, quando necessário, a combinação com placa miorrelaxante e outros cuidados. A toxina trata o sintoma muscular; a causa, muitas vezes ligada ao estresse e ao sono, também merece atenção.',
        ],
        'benefits' => [
            ['title' => 'Menos dor', 'desc' => 'Alívio da dor na mandíbula, nas têmporas e das dores de cabeça ao acordar.'],
            ['title' => 'Dentes protegidos', 'desc' => 'Menos força de apertamento significa menos desgaste, trincas e fraturas.'],
            ['title' => 'Sono mais tranquilo', 'desc' => 'Com a musculatura relaxada, muitos pacientes relatam acordar menos tensos.'],
            ['title' => 'Contorno mais suave', 'desc' => 'Em masseteres muito desenvolvidos, o rosto tende a ficar mais afinado.'],
        ],
        'steps' => [
            ['title' => 'Avaliação odontológica', 'desc' => 'A Dra. Emily examina a musculatura, os dentes e a articulação para confirmar o bruxismo e planejar a dose.'],
            ['title' => 'Aplicação', 'desc' => 'A toxina é aplicada com agulhas finas nos pontos do masseter e, quando indicado, do temporal, em cerca de 20 minutos.'],
            ['title' => 'Reavaliação', 'desc' => 'O efeito se instala em 1 a 4 semanas, e um retorno permite ajustar a dose se necessário.'],
        ],
        'faq' => [
            ['q' => 'A toxina botulínica cura o bruxismo?', 'a' => 'Não. Ela reduz a força da musculatura e, com isso, a dor e o desgaste dos dentes, mas o hábito pode continuar. Por isso a Dra. Emily avalia o caso como um todo e pode indicar a placa miorrelaxante e cuidados com a causa.'],
            ['q' => 'Quanto tempo dura o efeito no bruxismo?', 'a' => 'Em média de 4 a 6 meses. Com aplicações regulares, a musculatura tende a ficar menos forte e o intervalo entre as sessões pode aumentar.'],
            ['q' => 'Vou ter dificuldade para mastigar?', 'a' => 'Não. A dose é calculada para reduzir a força excessiva, não para paralisar o músculo. Nos primeiros dias, alimentos muito duros podem parecer um pouco mais cansativos de mastigar.'],
            ['q' => 'Substitui a placa de bruxismo?', 'a' => 'Não necessariamente. A placa protege os dentes do atrito durante a noite; a toxina reduz a força do músculo. Em muitos casos, os dois tratamentos se complementam.'],
        ],
    ],

    'preenchimento-labial' => [
        'num' => '03',
        'updated' => '2026-10-13',
        'related' => ['harmonizacao-labial', 'preenchimento-facial', 'toxina-botulinica', 'full-face'],
        'name' => 'Preenchimento Labial',
        'card_desc' => 'Lábios mais definidos, hidratados e harmônicos com ácido hialurônico — volume na medida certa, com resultado natural.',
        'title' => 'Preenchimento Labial em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Preenchimento labial com ácido hialurônico em Belo Horizonte com a Dra. Emily Beatriz. Lábios definidos, hidratados e naturais. Agende pelo WhatsApp.',
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
            'Com o passar dos anos, os lábios perdem volume, o contorno fica menos nítido e surgem linhas finas ao redor da boca. Nesses casos, o preenchimento é feito com mais delicadeza: o foco é redefinir o contorno labial e hidratar, devolvendo frescor sem aumentar o tamanho.',
        ],
        'benefits' => [
            ['title' => 'Contorno definido', 'desc' => 'Bordas mais nítidas e simétricas, corrigindo assimetrias de forma sutil.'],
            ['title' => 'Volume na medida', 'desc' => 'Mais preenchidos sem exageros — exatamente o que combina com o seu rosto.'],
            ['title' => 'Hidratação', 'desc' => 'O ácido hialurônico devolve viço e maciez aos lábios ressecados.'],
            ['title' => 'Resultado imediato', 'desc' => 'Você já sai do consultório vendo a diferença, com efeito completo em poucos dias.'],
        ],
        'steps' => [
            ['title' => 'Conversa & desenho', 'desc' => 'A Dra. Emily entende o que você deseja e desenha com você o formato ideal para o seu rosto.'],
            ['title' => 'Anestesia tópica', 'desc' => 'Um creme anestésico garante muito conforto durante todo o procedimento.'],
            ['title' => 'Aplicação', 'desc' => 'O ácido hialurônico é aplicado com precisão, modelando o volume e o contorno em cerca de 40 minutos.'],
        ],
        'faq' => [
            ['q' => 'O preenchimento labial fica natural?', 'a' => 'Sim. O resultado natural depende da técnica e do bom senso na quantidade de produto. A Dra. Emily prioriza a harmonia com o seu rosto, evitando o aspecto artificial.'],
            ['q' => 'Quanto tempo dura o preenchimento labial?', 'a' => 'Em média de 6 a 18 meses, dependendo do seu metabolismo e do volume aplicado. Depois, o produto é absorvido naturalmente pelo corpo.'],
            ['q' => 'Incha muito depois?', 'a' => 'É comum um leve inchaço nas primeiras 24 a 48 horas, que desaparece naturalmente. Em poucos dias os lábios assumem o resultado final.'],
            ['q' => 'Posso escolher o volume?', 'a' => 'Com certeza. O procedimento é totalmente personalizado — desde uma hidratação sutil até mais volume e definição, sempre respeitando a sua anatomia.'],
            ['q' => 'Preenchimento labial é indicado depois dos 40?', 'a' => 'Sim, e costuma fazer muita diferença. Nessa fase o objetivo não é aumentar, e sim devolver o contorno, a hidratação e o volume perdidos com o tempo, suavizando as linhas finas ao redor da boca.'],
        ],
    ],

    'preenchimento-facial' => [
        'num' => '11',
        'updated' => '2026-11-02',
        'related' => ['preenchimento-labial', 'preenchimento-de-olheiras', 'bigode-chines', 'bioestimulador-de-colageno'],
        'name' => 'Preenchimento Facial',
        'card_desc' => 'Ácido hialurônico para devolver volume e contorno às maçãs do rosto, mandíbula, queixo e sulcos, com resultado imediato.',
        'title' => 'Preenchimento Facial em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Preenchimento facial com ácido hialurônico em BH com a Dra. Emily Beatriz. Volume e contorno para maçãs do rosto, mandíbula, queixo e sulcos.',
        'eyebrow' => 'Volume & Contorno',
        'h1' => 'Preenchimento Facial em Belo Horizonte',
        'hero_lead' => 'Com o tempo, o rosto perde volume em pontos estratégicos e o contorno vai se desfazendo. O preenchimento facial com ácido hialurônico repõe esse suporte com precisão, devolvendo sustentação, definição e um aspecto descansado, com resultado imediato.',
        'facts' => [
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '12 a 18 meses'],
            ['label' => 'Sessão', 'value' => '~60 minutos'],
            ['label' => 'Retorno', 'value' => 'No mesmo dia'],
        ],
        'what_is_title' => 'O que é o preenchimento facial?',
        'what_is' => [
            'O preenchimento facial usa ácido hialurônico, uma substância que o próprio corpo produz, para repor volume e redesenhar o contorno do rosto. Os produtos variam em firmeza: os mais densos dão estrutura a ossos e ângulos, os mais suaves corrigem sulcos e regiões delicadas.',
            'As áreas mais tratadas são as maçãs do rosto (região malar), a mandíbula, o queixo, as têmporas, o sulco nasogeniano — conhecido como bigode chinês — e as olheiras fundas. Muitas vezes, tratar o malar já suaviza o bigode chinês, porque devolve a sustentação que estava faltando no terço médio.',
            'Em Belo Horizonte, a Dra. Emily Beatriz planeja o preenchimento a partir das proporções do seu rosto, com quantidades conservadoras. O ácido hialurônico é absorvido naturalmente com o tempo e, se necessário, pode ser dissolvido, o que dá ainda mais segurança ao tratamento.',
        ],
        'benefits' => [
            ['title' => 'Contorno redefinido', 'desc' => 'Mandíbula, queixo e maçãs do rosto com linhas mais nítidas e proporcionais.'],
            ['title' => 'Efeito de sustentação', 'desc' => 'O volume reposto nos pontos certos levanta o terço médio e suaviza sulcos.'],
            ['title' => 'Resultado imediato', 'desc' => 'A diferença aparece na hora, com o resultado final em poucos dias.'],
            ['title' => 'Reversível', 'desc' => 'O ácido hialurônico pode ser dissolvido se for preciso ajustar.'],
        ],
        'steps' => [
            ['title' => 'Análise facial', 'desc' => 'A Dra. Emily avalia proporções, perda de volume e a qualidade da pele para definir as áreas e o produto ideal.'],
            ['title' => 'Anestesia', 'desc' => 'Creme anestésico e produtos com anestésico incorporado deixam a aplicação confortável.'],
            ['title' => 'Aplicação precisa', 'desc' => 'O ácido hialurônico é aplicado com agulha ou cânula, modelando o contorno ponto a ponto.'],
        ],
        'faq' => [
            ['q' => 'Preenchimento facial deixa o rosto inchado ou artificial?', 'a' => 'Não, quando o planejamento respeita as proporções e a quantidade é conservadora. O aspecto artificial vem de excesso de produto ou de aplicação nos pontos errados, o que a Dra. Emily evita.'],
            ['q' => 'Quanto tempo dura o preenchimento facial?', 'a' => 'Em média de 12 a 18 meses, variando conforme a área tratada, o produto e o metabolismo. Regiões com menos movimento, como malar e queixo, tendem a durar mais.'],
            ['q' => 'Preenchimento resolve o bigode chinês?', 'a' => 'Ajuda bastante, mas raramente se resolve preenchendo só o sulco. O mais eficaz costuma ser repor o volume das maçãs do rosto, que sustenta a região, e às vezes combinar com bioestimulador.'],
            ['q' => 'Qual a diferença para o bioestimulador?', 'a' => 'O preenchimento repõe volume na hora, com ácido hialurônico. O bioestimulador faz a pele produzir colágeno e melhora a firmeza aos poucos. Os dois são frequentemente combinados.'],
        ],
    ],

    'preenchimento-de-olheiras' => [
        'num' => '12',
        'updated' => '2026-10-13',
        'related' => ['preenchimento-terco-medio', 'rejuvenescimento-com-preenchimento', 'preenchimento-facial', 'bioestimulador-de-colageno'],
        'name' => 'Preenchimento de Olheiras',
        'card_desc' => 'Ácido hialurônico na olheira funda para suavizar a sombra abaixo dos olhos e tirar o aspecto de cansaço.',
        'concern' => ['label' => 'Olheiras', 'desc' => 'Olheira funda que deixa o olhar cansado mesmo depois de dormir bem.'],
        'title' => 'Preenchimento de Olheiras em BH | Dra. Emily Beatriz',
        'meta_description' => 'Preenchimento de olheiras com ácido hialurônico em Belo Horizonte com a Dra. Emily Beatriz. Suaviza a olheira funda e o aspecto de cansaço.',
        'eyebrow' => 'Olhar Descansado',
        'h1' => 'Preenchimento de Olheiras em Belo Horizonte',
        'hero_lead' => 'Quando a olheira é funda, nenhum corretivo resolve: o que existe ali é uma depressão que cria sombra. O preenchimento de olheiras com ácido hialurônico suaviza esse vale abaixo dos olhos e devolve ao olhar um aspecto descansado.',
        'facts' => [
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '12 meses ou mais'],
            ['label' => 'Sessão', 'value' => '~40 minutos'],
            ['label' => 'Técnica', 'value' => 'Cânula'],
        ],
        'what_is_title' => 'Quando o preenchimento de olheiras é indicado?',
        'what_is' => [
            'Existem tipos diferentes de olheira. A olheira funda, ou estrutural, acontece quando a região abaixo dos olhos perde volume e forma um sulco que projeta sombra. É esse tipo que responde ao preenchimento com ácido hialurônico.',
            'Já a olheira escura por pigmentação ou por vasinhos aparentes não melhora só com preenchimento. Nesses casos, a Dra. Emily Beatriz indica outros caminhos, como cuidados com a pele, microagulhamento ou bioestimulador para melhorar a espessura da pele. Muitas vezes, a olheira tem mais de um componente e o tratamento é combinado.',
            'A região é delicada e pede técnica: em Belo Horizonte, a Dra. Emily usa cânula e um ácido hialurônico próprio para a área, em pequenas quantidades, para evitar inchaço e aspecto de bolsa.',
        ],
        'benefits' => [
            ['title' => 'Olhar descansado', 'desc' => 'A sombra abaixo dos olhos diminui e o rosto perde o aspecto de cansaço.'],
            ['title' => 'Resultado imediato', 'desc' => 'A melhora aparece na hora, com o resultado final após a acomodação do produto.'],
            ['title' => 'Mais segurança', 'desc' => 'Aplicação com cânula, que reduz hematomas e o risco na região.'],
            ['title' => 'Duradouro', 'desc' => 'Na região dos olhos, o ácido hialurônico costuma durar 12 meses ou mais.'],
        ],
        'steps' => [
            ['title' => 'Avaliação da olheira', 'desc' => 'A Dra. Emily identifica o tipo de olheira e confirma se o preenchimento é a melhor indicação para você.'],
            ['title' => 'Aplicação com cânula', 'desc' => 'Com anestesia local, o ácido hialurônico é distribuído em pequenas quantidades ao longo do sulco.'],
            ['title' => 'Retorno', 'desc' => 'Após cerca de 15 dias, a Dra. Emily avalia o resultado e faz ajustes finos, se necessário.'],
        ],
        'faq' => [
            ['q' => 'Preenchimento de olheiras resolve olheira escura?', 'a' => 'Depende do tipo. Ele resolve a olheira funda, causada por perda de volume. A olheira escura por pigmento ou vasinhos precisa de outros tratamentos, e por isso a avaliação vem primeiro.'],
            ['q' => 'O preenchimento de olheiras incha?', 'a' => 'Pode haver um leve inchaço e pequenos hematomas nos primeiros dias. O inchaço persistente está ligado a excesso de produto ou ao produto errado, e é por isso que a Dra. Emily trabalha com pouca quantidade e ácido hialurônico próprio para a região.'],
            ['q' => 'Quanto tempo dura?', 'a' => 'Em geral 12 meses ou mais, porque a região tem pouco movimento. A duração varia conforme o organismo e o produto utilizado.'],
            ['q' => 'Dói fazer preenchimento de olheiras?', 'a' => 'O desconforto é pequeno. A região é anestesiada e a cânula, por ter ponta arredondada, causa menos dor e menos hematomas que a agulha.'],
        ],
    ],

    'preenchimento-terco-medio' => [
        'num' => '16',
        'updated' => '2026-11-02',
        'parent' => 'preenchimento-facial',
        'related' => ['preenchimento-facial', 'preenchimento-de-olheiras', 'preenchimento-mandibula-e-queixo', 'rejuvenescimento-com-preenchimento'],
        'name' => 'Terço Médio e Suporte Facial',
        'card_desc' => 'Preenchimento malar, zigomático, fossa canina, olheiras e têmporas para devolver sustentação à parte central do rosto.',
        'title' => 'Preenchimento Malar e Terço Médio em BH | Dra. Emily Beatriz',
        'meta_description' => 'Preenchimento malar e do terço médio em Belo Horizonte com a Dra. Emily Beatriz. Maçãs do rosto, zigomático, olheiras e têmporas com sustentação natural.',
        'eyebrow' => 'Sustentação Facial',
        'h1' => 'Preenchimento do Terço Médio e Malar em Belo Horizonte',
        'hero_lead' => 'O terço médio é a base do rosto: é ali que as maçãs, a região abaixo dos olhos e a lateral da face sustentam tudo o que está abaixo. Quando essa estrutura é bem trabalhada, o rosto ganha projeção, leveza e um contorno mais elegante.',
        'facts' => [
            ['label' => 'Foco', 'value' => 'Sustentação'],
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '12 a 18 meses'],
            ['label' => 'Retorno', 'value' => 'No mesmo dia'],
        ],
        'what_is_title' => 'Por que tratar o terço médio primeiro?',
        'what_is' => [
            'O terço médio vai da linha dos olhos até a base do nariz. Ele funciona como a estrutura de apoio da face: as maçãs do rosto, o arco zigomático e as têmporas dão forma à lateral, enquanto a região próxima ao nariz sustenta o início do sulco nasogeniano.',
            'Por isso o planejamento costuma começar aqui. Com ácido hialurônico mais firme nos pontos de apoio, a Dra. Emily Beatriz cria projeção e devolve suporte aos tecidos, o que pode suavizar o aspecto de regiões vizinhas sem que seja preciso aplicar produto diretamente nelas.',
            'Em Belo Horizonte, cada área é definida depois da análise das proporções do seu rosto. Nem todo mundo precisa tratar as cinco regiões: o objetivo é escolher os pontos que realmente fazem diferença, com quantidades conservadoras.',
        ],
        'regions_title' => 'Regiões do terço médio',
        'regions' => [
            ['name' => 'Malar (maçãs do rosto)', 'desc' => 'Dá projeção à parte frontal das maçãs do rosto. É o principal ponto de sustentação do terço médio e costuma ser a primeira região planejada.'],
            ['name' => 'Zigomático', 'desc' => 'Trabalha o arco ósseo na lateral do rosto, que define a largura da face e o ângulo das maçãs. Um contorno lateral bem desenhado deixa o rosto mais estruturado.'],
            ['name' => 'Fossa canina', 'desc' => 'Pequena depressão ao lado da asa do nariz, de onde parte o bigode chinês. O preenchimento dá apoio à base do nariz e ao início do sulco.'],
            ['name' => 'Olheiras', 'desc' => 'Suaviza a transição entre a pálpebra inferior e a bochecha. Quando planejada junto com o malar, a região abaixo dos olhos fica mais uniforme e o olhar, mais descansado.'],
            ['name' => 'Têmporas', 'desc' => 'Completa a lateral do terço superior e médio. Preencher o afundamento das têmporas dá continuidade ao contorno e favorece um formato de rosto mais harmônico.'],
        ],
        'benefits' => [
            ['title' => 'Sustentação', 'desc' => 'Volume nos pontos de apoio certos para dar suporte aos tecidos do rosto.'],
            ['title' => 'Maçãs do rosto projetadas', 'desc' => 'Mais definição e pontos de luz, respeitando a sua anatomia.'],
            ['title' => 'Olhar mais descansado', 'desc' => 'A região abaixo dos olhos fica mais uniforme e o rosto perde o aspecto de cansaço.'],
            ['title' => 'Contorno harmônico', 'desc' => 'Têmporas e arco zigomático dão continuidade à lateral do rosto.'],
        ],
        'steps' => [
            ['title' => 'Análise do terço médio', 'desc' => 'A Dra. Emily avalia projeção, simetria e pontos de apoio para definir quais regiões entram no plano.'],
            ['title' => 'Escolha do produto', 'desc' => 'Cada região pede um ácido hialurônico com firmeza própria, dos mais densos no osso aos mais suaves perto dos olhos.'],
            ['title' => 'Aplicação & retorno', 'desc' => 'O preenchimento é feito com agulha ou cânula, com anestesia, e um retorno permite avaliar o resultado.'],
        ],
        'faq' => [
            ['q' => 'O que é preenchimento malar?', 'a' => 'É a aplicação de ácido hialurônico nas maçãs do rosto para dar projeção e sustentação. Além de valorizar essa região, ele ajuda a dar suporte às áreas logo abaixo.'],
            ['q' => 'Qual a diferença entre malar e zigomático?', 'a' => 'O malar é a parte frontal das maçãs do rosto. O zigomático é o arco ósseo que segue em direção à orelha, na lateral. Tratados em conjunto, definem a projeção e a largura do rosto.'],
            ['q' => 'Preenchimento malar deixa o rosto redondo?', 'a' => 'Não, quando o planejamento respeita as proporções. A Dra. Emily posiciona o produto nos pontos de apoio e usa quantidades conservadoras, para valorizar a estrutura sem arredondar a face.'],
            ['q' => 'Preenchimento no malar ajuda no bigode chinês?', 'a' => 'Muitas vezes, sim. Ao devolver sustentação ao terço médio, o sulco tende a suavizar. Em cada caso, a avaliação mostra se isso é suficiente ou se vale combinar com outro tratamento.'],
        ],
    ],

    'preenchimento-mandibula-e-queixo' => [
        'num' => '17',
        'updated' => '2026-11-02',
        'parent' => 'preenchimento-facial',
        'related' => ['preenchimento-facial', 'preenchimento-terco-inferior', 'rinomodelacao-e-refinamento-facial', 'enzima-para-papada'],
        'name' => 'Contorno e Definição Facial',
        'card_desc' => 'Preenchimento de mandíbula, ângulo mandibular, mento e região pré-jowl para um contorno mais nítido e proporcional.',
        'title' => 'Preenchimento de Mandíbula e Queixo em BH | Dra. Emily Beatriz',
        'meta_description' => 'Preenchimento de mandíbula e queixo em Belo Horizonte com a Dra. Emily Beatriz. Contorno definido no ângulo mandibular, mento e região pré-jowl.',
        'eyebrow' => 'Contorno & Definição',
        'h1' => 'Preenchimento de Mandíbula e Queixo em Belo Horizonte',
        'hero_lead' => 'Uma linha de mandíbula nítida e um queixo bem posicionado mudam a leitura do rosto inteiro. O preenchimento de contorno desenha esses limites com ácido hialurônico, dando definição e proporção ao perfil, sem cirurgia.',
        'facts' => [
            ['label' => 'Foco', 'value' => 'Definição'],
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '12 a 18 meses'],
            ['label' => 'Sessão', 'value' => '~60 minutos'],
        ],
        'what_is_title' => 'O que define o contorno do rosto?',
        'what_is' => [
            'O contorno facial é desenhado pela mandíbula, pelo ângulo que ela forma abaixo da orelha e pelo queixo, também chamado de mento. Quando esses pontos são pouco marcados, ou quando o queixo fica recuado em relação ao perfil, o rosto perde definição, mesmo em quem está no peso ideal.',
            'O preenchimento usa ácido hialurônico de maior firmeza, próprio para dar estrutura. Ele projeta o queixo, marca o ângulo mandibular e suaviza a pequena depressão da região pré-jowl, deixando a linha entre o rosto e o pescoço mais contínua.',
            'Em Belo Horizonte, a Dra. Emily Beatriz planeja o contorno de acordo com a anatomia e o que você deseja: um desenho mais suave ou mais marcado. No rosto masculino, por exemplo, o ângulo e o queixo costumam ser trabalhados de outra forma do que no feminino.',
        ],
        'regions_title' => 'Regiões do contorno facial',
        'regions' => [
            ['name' => 'Mandíbula', 'desc' => 'Define a linha que vai do queixo até a orelha. O preenchimento deixa essa borda mais nítida e separa melhor o rosto do pescoço.'],
            ['name' => 'Ângulo mandibular', 'desc' => 'Ponto abaixo da orelha onde a mandíbula faz a curva. Marcar esse ângulo dá estrutura ao terço inferior e mais presença ao contorno.'],
            ['name' => 'Mento (queixo)', 'desc' => 'Projeta e alonga o queixo, equilibrando o perfil com o nariz e os lábios. Muitas vezes também melhora a percepção da região abaixo do queixo.'],
            ['name' => 'Região pré-jowl', 'desc' => 'Depressão logo ao lado do queixo, que quebra a linha da mandíbula. O preenchimento devolve a continuidade do contorno.'],
        ],
        'benefits' => [
            ['title' => 'Linha da mandíbula nítida', 'desc' => 'Mais definição entre o rosto e o pescoço.'],
            ['title' => 'Perfil equilibrado', 'desc' => 'Queixo bem posicionado em relação ao nariz e aos lábios.'],
            ['title' => 'Planejamento sob medida', 'desc' => 'Desenho mais suave ou mais marcado, conforme o seu rosto e o seu desejo.'],
            ['title' => 'Sem cirurgia', 'desc' => 'Procedimento feito em consultório, com retorno à rotina no mesmo dia.'],
        ],
        'steps' => [
            ['title' => 'Análise do perfil', 'desc' => 'A Dra. Emily avalia o rosto de frente e de perfil, a proporção do queixo e a linha da mandíbula.'],
            ['title' => 'Desenho do contorno', 'desc' => 'Define-se com você o quanto de definição faz sentido e quais pontos entram no plano.'],
            ['title' => 'Aplicação precisa', 'desc' => 'O ácido hialurônico é aplicado com agulha ou cânula, modelando o contorno ponto a ponto.'],
        ],
        'faq' => [
            ['q' => 'Preenchimento de mandíbula afina o rosto?', 'a' => 'Ele não reduz o rosto, mas define a borda e cria sombra na medida certa, o que costuma dar a impressão de um contorno mais fino e estruturado.'],
            ['q' => 'Preenchimento de queixo ajuda na papada?', 'a' => 'Pode ajudar quando o queixo pouco projetado acentua a papada, porque melhora o ângulo entre o queixo e o pescoço. Se há gordura localizada ou flacidez, a avaliação indica o tratamento complementar.'],
            ['q' => 'O que é a região pré-jowl?', 'a' => 'É a pequena depressão que surge logo ao lado do queixo, antes do início da bochecha caída. Ela quebra a linha da mandíbula, e preenchê-la devolve um contorno mais contínuo.'],
            ['q' => 'Quanto tempo dura o preenchimento de mandíbula?', 'a' => 'Em média de 12 a 18 meses, variando conforme o produto, a área tratada e o metabolismo de cada pessoa.'],
        ],
    ],

    'preenchimento-terco-inferior' => [
        'num' => '18',
        'updated' => '2026-11-02',
        'parent' => 'preenchimento-facial',
        'related' => ['preenchimento-facial', 'bigode-chines', 'preenchimento-mandibula-e-queixo', 'harmonizacao-labial'],
        'name' => 'Terço Inferior e Rejuvenescimento',
        'card_desc' => 'Sulco nasogeniano, linhas de marionete, região pré-jowl, mento e contorno mandibular tratados para suavizar a parte de baixo do rosto.',
        'title' => 'Preenchimento do Terço Inferior em BH | Dra. Emily Beatriz',
        'meta_description' => 'Preenchimento do terço inferior em Belo Horizonte com a Dra. Emily Beatriz. Bigode chinês, linhas de marionete, pré-jowl, queixo e contorno mandibular.',
        'eyebrow' => 'Rejuvenescimento do Terço Inferior',
        'h1' => 'Preenchimento do Terço Inferior em Belo Horizonte',
        'hero_lead' => 'É na parte de baixo do rosto que o tempo costuma aparecer mais: sulcos mais marcados, cantos da boca para baixo e um contorno menos definido. O preenchimento do terço inferior suaviza esses sinais e devolve uma expressão mais leve.',
        'facts' => [
            ['label' => 'Foco', 'value' => 'Sulcos & contorno'],
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '12 a 18 meses'],
            ['label' => 'Retorno', 'value' => 'No mesmo dia'],
        ],
        'what_is_title' => 'O que muda no terço inferior com o tempo?',
        'what_is' => [
            'Com os anos, o rosto perde sustentação e os tecidos descem. Isso aprofunda o sulco nasogeniano, conhecido como bigode chinês, forma as linhas de marionete abaixo dos cantos da boca e cria pequenas depressões ao lado do queixo, que interrompem o contorno da mandíbula.',
            'O preenchimento atua nessas regiões de forma pontual, sempre olhando o rosto como um todo. Muitas vezes a Dra. Emily Beatriz começa pela sustentação do terço médio e só então faz ajustes no sulco, para que o resultado não fique pesado.',
            'Em Belo Horizonte, o plano do terço inferior é combinado conforme a sua avaliação. Quando a flacidez é o principal fator, o preenchimento pode ser associado a bioestimulador de colágeno ou fios de PDO.',
        ],
        'regions_title' => 'Regiões do terço inferior',
        'regions' => [
            ['name' => 'Sulco nasogeniano (bigode chinês)', 'desc' => 'Linha que vai da asa do nariz ao canto da boca. O preenchimento é feito em pequenas quantidades, como ajuste fino depois de avaliar a sustentação do terço médio.'],
            ['name' => 'Linhas de marionete', 'desc' => 'Sulcos que descem dos cantos da boca em direção ao queixo e dão aspecto triste ou bravo. O preenchimento suaviza a linha e ajuda a apoiar o canto da boca.'],
            ['name' => 'Região pré-jowl', 'desc' => 'Depressão ao lado do queixo que se torna mais visível com a descida dos tecidos. Preenchê-la reduz o aspecto de "buldogue" e alinha a mandíbula.'],
            ['name' => 'Mento', 'desc' => 'Com o tempo, o queixo pode perder projeção e ganhar aspecto enrugado. Repor essa base dá suporte ao terço inferior.'],
            ['name' => 'Contorno mandibular', 'desc' => 'Redesenha a linha da mandíbula quando ela perde nitidez, separando melhor o rosto do pescoço.'],
        ],
        'benefits' => [
            ['title' => 'Expressão mais leve', 'desc' => 'Sulcos suavizados e menos aspecto de cansaço, tristeza ou irritação.'],
            ['title' => 'Contorno recuperado', 'desc' => 'A linha da mandíbula volta a ficar mais contínua.'],
            ['title' => 'Resultado natural', 'desc' => 'Pequenas quantidades em cada ponto, sem aspecto pesado na região da boca.'],
            ['title' => 'Combinável', 'desc' => 'Pode ser associado a bioestimulador e fios de PDO quando há flacidez.'],
        ],
        'steps' => [
            ['title' => 'Avaliação do rosto', 'desc' => 'A Dra. Emily identifica o que marca o seu terço inferior: perda de volume, flacidez ou os dois.'],
            ['title' => 'Plano por etapas', 'desc' => 'Define-se a ordem das regiões, normalmente priorizando a sustentação antes do ajuste nos sulcos.'],
            ['title' => 'Aplicação & retorno', 'desc' => 'Com anestesia, o ácido hialurônico é aplicado ponto a ponto, com retorno para avaliar o resultado.'],
        ],
        'faq' => [
            ['q' => 'O que são linhas de marionete?', 'a' => 'São os sulcos que descem dos cantos da boca em direção ao queixo. Eles podem dar um aspecto triste ou bravo ao rosto, mesmo em repouso.'],
            ['q' => 'Preenchimento resolve o bigode chinês sozinho?', 'a' => 'Raramente. O mais eficaz costuma ser tratar a sustentação do terço médio e fazer apenas um ajuste fino no sulco. Dependendo do caso, o bioestimulador de colágeno complementa o tratamento.'],
            ['q' => 'O preenchimento trata a bochecha caída?', 'a' => 'Ele ajuda a disfarçar a transição, principalmente na região pré-jowl, mas não reposiciona a pele. Em flacidez mais evidente, a Dra. Emily indica combinar com bioestimulador ou fios de PDO e explica o que é realista no seu caso.'],
            ['q' => 'A região da boca fica pesada ou rígida?', 'a' => 'Não deve ficar. Por ser uma área de muito movimento, a Dra. Emily usa produtos adequados e pouca quantidade, para manter a expressão natural.'],
        ],
    ],

    'harmonizacao-labial' => [
        'num' => '19',
        'updated' => '2026-11-02',
        'parent' => 'preenchimento-facial',
        'related' => ['preenchimento-facial', 'preenchimento-labial', 'toxina-botulinica', 'preenchimento-terco-inferior'],
        'name' => 'Harmonização Labial e Perioral',
        'card_desc' => 'Lábios, código de barras, filtro labial, arco do cupido e comissuras trabalhados juntos para harmonizar toda a região da boca.',
        'title' => 'Harmonização Labial em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Harmonização labial em Belo Horizonte com a Dra. Emily Beatriz. Lábios, arco do cupido, filtro labial, código de barras e comissuras com resultado natural.',
        'eyebrow' => 'Lábios & Região Perioral',
        'h1' => 'Harmonização Labial e Perioral em Belo Horizonte',
        'hero_lead' => 'Uma boca bonita vai além do volume dos lábios. A harmonização labial olha para toda a região ao redor: o arco do cupido, o filtro, os cantos da boca e as linhas finas acima do lábio, para um resultado delicado e proporcional ao seu rosto.',
        'facts' => [
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '6 a 18 meses'],
            ['label' => 'Sessão', 'value' => '~40 minutos'],
            ['label' => 'Anestesia', 'value' => 'Tópica'],
        ],
        'what_is_title' => 'O que é a harmonização labial e perioral?',
        'what_is' => [
            'Enquanto o preenchimento labial foca o volume e a hidratação dos lábios, a harmonização labial e perioral considera também a região ao redor da boca, chamada de perioral. Isso inclui o filtro, as duas colunas entre o nariz e o lábio superior, o desenho do arco do cupido, os cantos da boca e as linhas finas conhecidas como código de barras.',
            'O ácido hialurônico é escolhido e aplicado de forma diferente em cada ponto: produtos mais macios para hidratar e suavizar linhas finas, com mais estrutura para desenhar contornos. Conforme o caso, a Dra. Emily Beatriz pode associar microdoses de toxina botulínica às linhas acima do lábio.',
            'Em Belo Horizonte, a harmonização labial é planejada com base nas proporções do seu rosto, com atenção ao sorriso e à fala. A meta é uma boca descansada e bonita, que continue sendo a sua.',
        ],
        'regions_title' => 'O que é tratado na região da boca',
        'regions' => [
            ['name' => 'Preenchimento labial', 'desc' => 'Devolve volume, hidratação e definição aos lábios, na medida certa para o seu rosto.'],
            ['name' => 'Código de barras', 'desc' => 'Linhas finas verticais acima do lábio superior, que marcam com o tempo. Pequenas quantidades de ácido hialurônico suavizam a região e melhoram a qualidade da pele.'],
            ['name' => 'Filtro labial', 'desc' => 'As duas colunas entre o nariz e o lábio superior. Quando bem definidas, deixam o lábio com aspecto mais jovem e proporcional.'],
            ['name' => 'Projeção e definição do arco do cupido', 'desc' => 'Desenha a curva central do lábio superior, um dos detalhes que mais dão delicadeza e personalidade à boca.'],
            ['name' => 'Comissuras labiais', 'desc' => 'Os cantos da boca podem cair com o tempo. Dar apoio a essa região deixa a expressão mais leve, mesmo em repouso.'],
        ],
        'benefits' => [
            ['title' => 'Boca em equilíbrio', 'desc' => 'Lábios e região ao redor planejados como um conjunto.'],
            ['title' => 'Contorno delicado', 'desc' => 'Arco do cupido e filtro mais definidos, sem exageros.'],
            ['title' => 'Linhas suavizadas', 'desc' => 'O código de barras fica menos aparente e a pele, mais hidratada.'],
            ['title' => 'Expressão mais leve', 'desc' => 'Cantos da boca com mais apoio, para um semblante mais descansado.'],
        ],
        'steps' => [
            ['title' => 'Conversa & desenho', 'desc' => 'A Dra. Emily entende o que incomoda você e analisa a boca em repouso, ao falar e ao sorrir.'],
            ['title' => 'Anestesia tópica', 'desc' => 'Um creme anestésico garante conforto durante todo o procedimento.'],
            ['title' => 'Aplicação delicada', 'desc' => 'O ácido hialurônico é aplicado com precisão, em pequenas quantidades, ponto a ponto.'],
        ],
        'faq' => [
            ['q' => 'Qual a diferença entre preenchimento labial e harmonização labial?', 'a' => 'O preenchimento labial trata os lábios. A harmonização labial e perioral é mais ampla e inclui também o filtro, o arco do cupido, as comissuras e as linhas ao redor da boca.'],
            ['q' => 'O que é o código de barras?', 'a' => 'São as linhas finas verticais que surgem acima do lábio superior. Elas podem ser suavizadas com ácido hialurônico, microdoses de toxina botulínica ou a combinação dos dois.'],
            ['q' => 'Dá para levantar os cantos da boca?', 'a' => 'Dá para dar apoio às comissuras e suavizar o aspecto caído. A avaliação mostra se o preenchimento é suficiente ou se vale associar a toxina botulínica ou tratar o terço inferior.'],
            ['q' => 'Quanto tempo dura a harmonização labial?', 'a' => 'Em média de 6 a 18 meses, dependendo do seu metabolismo, do produto e das regiões tratadas.'],
        ],
    ],

    'rejuvenescimento-com-preenchimento' => [
        'num' => '20',
        'updated' => '2026-11-02',
        'parent' => 'preenchimento-facial',
        'related' => ['preenchimento-facial', 'preenchimento-terco-medio', 'bioestimulador-de-colageno', 'flacidez-facial'],
        'name' => 'Rejuvenescimento e Reposição de Volume',
        'card_desc' => 'Reposição do volume perdido com o tempo ou o emagrecimento em têmporas, malar, zigomático, olheiras e fossa canina.',
        'title' => 'Rejuvenescimento com Preenchimento em BH | Dra. Emily Beatriz',
        'meta_description' => 'Rejuvenescimento com preenchimento em Belo Horizonte com a Dra. Emily Beatriz. Reposição de volume em têmporas, malar, olheiras e fossa canina.',
        'eyebrow' => 'Reposição de Volume',
        'h1' => 'Rejuvenescimento Facial com Preenchimento em Belo Horizonte',
        'hero_lead' => 'Às vezes o rosto parece mais cansado ou mais magro do que você se sente. Isso costuma ser perda de volume, que vem com o tempo ou com o emagrecimento. Repor esse volume com delicadeza devolve frescor sem mudar os seus traços.',
        'facts' => [
            ['label' => 'Foco', 'value' => 'Volume perdido'],
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '12 a 18 meses'],
            ['label' => 'Planejamento', 'value' => 'Por etapas'],
        ],
        'what_is_title' => 'Por que o rosto perde volume?',
        'what_is' => [
            'O envelhecimento do rosto não é só uma questão de rugas. Com o passar dos anos, as bolsas de gordura diminuem e mudam de lugar, e o osso da face também sofre remodelação. As têmporas afundam, as maçãs do rosto ficam mais planas e a região abaixo dos olhos ganha sombra.',
            'O emagrecimento acelera esse processo: quem perde peso rapidamente costuma notar o rosto mais fino e com aspecto abatido. Na menopausa, a perda de colágeno se soma à perda de volume e a mudança pode parecer repentina.',
            'A reposição não busca encher o rosto, e sim devolver, em pequenas quantidades, apenas o que foi perdido. Em Belo Horizonte, a Dra. Emily Beatriz usa ácido hialurônico nos pontos onde a falta de volume mais aparece e, quando a firmeza da pele também é uma queixa, pode combinar com bioestimulador de colágeno.',
        ],
        'regions_title' => 'Onde o volume costuma faltar',
        'regions' => [
            ['name' => 'Têmporas', 'desc' => 'Uma das primeiras regiões a afundar com o tempo ou o emagrecimento, deixando o rosto com aspecto magro. Repor o volume suaviza essa concavidade.'],
            ['name' => 'Malar', 'desc' => 'A gordura das maçãs do rosto diminui e desce, e o rosto fica mais plano. A reposição devolve curva e frescor à face.'],
            ['name' => 'Zigomático', 'desc' => 'Quando a lateral do rosto perde gordura, o osso fica mais marcado e a área logo abaixo parece cavada. Pequenas quantidades tornam essa transição mais suave.'],
            ['name' => 'Olheiras', 'desc' => 'Com a perda de volume, o vale abaixo dos olhos se aprofunda e projeta sombra. Em olheiras fundas, o ácido hialurônico suaviza esse aspecto de cansaço.'],
            ['name' => 'Fossa canina', 'desc' => 'A região ao lado do nariz perde apoio com os anos, o que marca mais o início do bigode chinês. Repor essa base traz um aspecto mais descansado.'],
        ],
        'benefits' => [
            ['title' => 'Aspecto de frescor', 'desc' => 'O rosto volta a parecer descansado e saudável.'],
            ['title' => 'Traços preservados', 'desc' => 'A reposição devolve o que foi perdido, sem mudar quem você é.'],
            ['title' => 'Menos aspecto abatido', 'desc' => 'Têmporas e maçãs do rosto com volume, úteis também depois do emagrecimento.'],
            ['title' => 'Plano gradual', 'desc' => 'O volume pode ser reposto por etapas, com ajustes a cada retorno.'],
        ],
        'steps' => [
            ['title' => 'Avaliação do volume', 'desc' => 'A Dra. Emily compara o seu rosto atual com a sua estrutura, se possível com fotos antigas, para ver o que mudou.'],
            ['title' => 'Definição das prioridades', 'desc' => 'Define-se quais regiões trazem mais benefício e se a firmeza da pele também precisa de tratamento.'],
            ['title' => 'Reposição por etapas', 'desc' => 'O ácido hialurônico é aplicado em pequenas quantidades, com retorno para avaliar e ajustar.'],
        ],
        'faq' => [
            ['q' => 'Preenchimento rejuvenesce o rosto?', 'a' => 'Ele trata um dos principais sinais do tempo, que é a perda de volume. Com isso, o rosto tende a parecer mais descansado. Rugas de expressão e flacidez costumam pedir outros tratamentos, que podem ser combinados.'],
            ['q' => 'Emagreci e meu rosto ficou abatido. O preenchimento ajuda?', 'a' => 'Ajuda de forma pontual, principalmente em têmporas e maçãs do rosto. O ideal é que o peso esteja estável, e nem todo o volume perdido precisa ser reposto: a avaliação define o que traz mais benefício.'],
            ['q' => 'Qual a diferença entre repor volume e estimular colágeno?', 'a' => 'O preenchimento repõe o volume na hora, com ácido hialurônico. O bioestimulador faz a pele produzir colágeno e melhora a firmeza aos poucos. Os dois se complementam em muitos planos de rejuvenescimento.'],
            ['q' => 'A partir de que idade posso fazer reposição de volume?', 'a' => 'Não existe idade certa, e sim indicação. Ela depende do que aparece no seu rosto, do seu histórico e do que você deseja, e é definida na avaliação.'],
        ],
    ],

    'rinomodelacao-e-refinamento-facial' => [
        'num' => '21',
        'updated' => '2026-11-02',
        'parent' => 'preenchimento-facial',
        'related' => ['preenchimento-facial', 'preenchimento-mandibula-e-queixo', 'harmonizacao-labial', 'harmonizacao-facial'],
        'name' => 'Refinamento Facial',
        'card_desc' => 'Rinomodelação, mento, ângulo mandibular e ajustes de assimetrias e depressões para detalhes que equilibram o rosto.',
        'title' => 'Rinomodelação em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Rinomodelação em Belo Horizonte com a Dra. Emily Beatriz. Refinamento do nariz, queixo e ângulo mandibular e ajuste de assimetrias, sem cirurgia.',
        'eyebrow' => 'Detalhes que Equilibram',
        'h1' => 'Rinomodelação e Refinamento Facial em Belo Horizonte',
        'hero_lead' => 'Pequenos detalhes podem mudar a harmonia de um rosto: o dorso do nariz, a ponta, o queixo ou uma assimetria que incomoda. O refinamento facial usa ácido hialurônico para fazer esses ajustes de forma precisa, sem cirurgia.',
        'facts' => [
            ['label' => 'Foco', 'value' => 'Ajustes finos'],
            ['label' => 'Resultado', 'value' => 'Imediato'],
            ['label' => 'Duração', 'value' => '12 a 18 meses'],
            ['label' => 'Cirurgia', 'value' => 'Não'],
        ],
        'what_is_title' => 'O que é o refinamento facial?',
        'what_is' => [
            'O refinamento facial reúne ajustes pontuais com ácido hialurônico para equilibrar o rosto. A rinomodelação é o mais conhecido: ela disfarça pequenas irregularidades do dorso do nariz e pode dar mais projeção e apoio à ponta. Queixo, ângulo mandibular e pequenas depressões também podem ser corrigidos, sempre pensando no perfil como um todo.',
            'É importante alinhar expectativas. A rinomodelação não diminui o nariz nem substitui a rinoplastia, e não trata problemas de respiração. O que ela faz é melhorar a percepção de formato, somando volume em pontos estratégicos, muitas vezes criando um nariz visualmente mais reto.',
            'O nariz é uma região delicada e com rica circulação, o que exige avaliação cuidadosa e conhecimento da anatomia. Em Belo Horizonte, a Dra. Emily Beatriz explica riscos, limites e cuidados antes de qualquer aplicação, e indica o caminho mais adequado para o seu caso, inclusive quando a resposta é não fazer.',
        ],
        'regions_title' => 'O que pode ser refinado',
        'regions' => [
            ['name' => 'Rinomodelação', 'desc' => 'Suaviza irregularidades do dorso e pode melhorar a projeção da ponta do nariz, sem cortes. Indicada para ajustes de formato, e não para reduzir tamanho.'],
            ['name' => 'Mento', 'desc' => 'Ajuste de projeção e formato do queixo, que costuma equilibrar o perfil junto com o nariz.'],
            ['name' => 'Ângulo mandibular', 'desc' => 'Pequena definição no ponto da curva da mandíbula, para dar estrutura e simetria ao contorno.'],
            ['name' => 'Ajustes de assimetrias e depressões faciais', 'desc' => 'Correção de diferenças entre os lados do rosto ou de pequenas depressões, com quantidades mínimas de produto, sempre conforme a causa identificada na avaliação.'],
        ],
        'benefits' => [
            ['title' => 'Perfil mais harmônico', 'desc' => 'Nariz, queixo e mandíbula planejados em conjunto.'],
            ['title' => 'Sem cortes', 'desc' => 'Procedimento em consultório, com retorno rápido à rotina.'],
            ['title' => 'Ajustes precisos', 'desc' => 'Pequenas quantidades de produto nos pontos que fazem diferença.'],
            ['title' => 'Reversível', 'desc' => 'O ácido hialurônico é absorvido com o tempo e pode ser dissolvido, se necessário.'],
        ],
        'steps' => [
            ['title' => 'Análise do perfil', 'desc' => 'A Dra. Emily avalia o rosto de frente e de perfil, identifica o que gera o desequilíbrio e verifica a sua indicação.'],
            ['title' => 'Conversa sobre expectativas', 'desc' => 'Antes de qualquer aplicação, você entende o que é possível, os riscos e os cuidados necessários.'],
            ['title' => 'Aplicação & retorno', 'desc' => 'O ácido hialurônico é aplicado com técnica e atenção à anatomia, com retorno para avaliar o resultado.'],
        ],
        'faq' => [
            ['q' => 'Rinomodelação afina ou diminui o nariz?', 'a' => 'Não diminui. Como o procedimento adiciona volume, ele não reduz o tamanho do nariz, mas pode criar a impressão de um dorso mais reto e de uma ponta mais projetada.'],
            ['q' => 'Rinomodelação substitui a rinoplastia?', 'a' => 'Não. São procedimentos diferentes. A rinomodelação é indicada para pequenos ajustes de formato. Mudanças maiores ou problemas respiratórios precisam de avaliação cirúrgica.'],
            ['q' => 'Rinomodelação tem riscos?', 'a' => 'Sim, como todo procedimento injetável. O nariz tem circulação delicada, e existe o risco de comprometimento vascular, que é raro, mas sério. Por isso a escolha do profissional e a avaliação prévia são essenciais, e a Dra. Emily explica todos os cuidados antes do procedimento.'],
            ['q' => 'Dá para corrigir assimetrias do rosto com preenchimento?', 'a' => 'Muitas assimetrias leves podem ser suavizadas. A avaliação identifica se a causa é de volume, de musculatura ou de estrutura óssea, porque cada uma pede um caminho diferente.'],
        ],
    ],

    'full-face' => [
        'comparison' => [
            'title' => 'Full Face ou harmonização facial: qual é a diferença?',
            'intro' => 'Full Face é uma forma de harmonização facial, não um tratamento à parte. A diferença está na amplitude: a harmonização pode tratar uma região específica, enquanto o Full Face planeja o rosto inteiro de uma só vez.',
            'columns' => ['Full Face', 'Harmonização facial'],
            'rows' => [
                ['label' => 'Abrangência', 'a' => 'Rosto completo: terços superior, médio e inferior avaliados juntos.', 'b' => 'Pode tratar apenas as regiões que o paciente deseja ajustar.'],
                ['label' => 'Planejamento', 'a' => 'Mapeamento facial completo antes de qualquer aplicação.', 'b' => 'Avaliação focada no objetivo trazido pelo paciente.'],
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
        'meta_description' => 'Full Face em Belo Horizonte com a Dra. Emily Beatriz. Harmonização facial completa, que trata todas as regiões do rosto de forma natural. Agende pelo WhatsApp.',
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
        'includes' => ['toxina-botulinica', 'preenchimento-labial', 'bioestimulador-de-colageno'],
        'faq' => [
            ['q' => 'Qual a diferença entre Full Face e harmonização facial?', 'a' => 'O Full Face é a forma mais completa de harmonização facial: trabalha o rosto inteiro de maneira integrada, enquanto uma harmonização pontual pode focar apenas em uma região específica.'],
            ['q' => 'O Full Face é feito em uma única sessão?', 'a' => 'Pode ser realizado em uma sessão mais longa ou dividido em etapas, dependendo do plano definido na avaliação e do seu conforto.'],
            ['q' => 'Fica com aparência artificial?', 'a' => 'Não. Justamente por trabalhar o rosto de forma equilibrada, o Full Face bem executado pela Dra. Emily entrega um resultado natural e harmonioso.'],
            ['q' => 'Para quem o Full Face é indicado?', 'a' => 'Para quem deseja um resultado mais completo e duradouro, ou para quem apresenta sinais de envelhecimento em diferentes regiões do rosto. A indicação é definida na avaliação.'],
        ],
    ],

    'bioestimulador-de-colageno' => [
        'num' => '05',
        'updated' => '2026-10-13',
        'name' => 'Bioestimulador de Colágeno',
        'card_desc' => 'Estimula o seu corpo a produzir colágeno, devolvendo firmeza, viço e qualidade à pele de forma progressiva e natural.',
        'title' => 'Bioestimulador de Colágeno em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Bioestimulador de colágeno em Belo Horizonte com a Dra. Emily Beatriz. Trata a flacidez e devolve firmeza e viço à pele, com resultado progressivo.',
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
            'É um dos tratamentos mais indicados para a flacidez facial a partir dos 40 anos e para a pele madura. Na menopausa, a queda dos hormônios acelera a perda de colágeno, e o bioestimulador ajuda a compensar esse processo, devolvendo firmeza ao contorno do rosto.',
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
            ['q' => 'Quais tipos de bioestimulador existem?', 'a' => 'Os mais usados são o ácido poli-L-láctico, que estimula colágeno de forma gradual ao longo de meses, e a hidroxiapatita de cálcio, que dá um pouco de sustentação imediata além do estímulo. A Dra. Emily escolhe o ativo conforme a sua pele, a região e o grau de flacidez.'],
            ['q' => 'Bioestimulador é indicado na menopausa?', 'a' => 'Sim. Na menopausa a produção de colágeno cai de forma mais acelerada, e a pele perde firmeza rapidamente. O bioestimulador é um dos tratamentos mais indicados nessa fase, muitas vezes combinado com fios de PDO ou preenchimento.'],
        ],
    ],

    'microagulhamento' => [
        'num' => '06',
        'updated' => '2026-09-08',
        'name' => 'Microagulhamento',
        'card_desc' => 'Micropunturas que estimulam a renovação da pele — textura mais lisa, poros menos aparentes e viço recuperado.',
        'title' => 'Microagulhamento em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Microagulhamento em Belo Horizonte com a Dra. Emily Beatriz. Melhora textura, poros, manchas e linhas finas renovando a pele. Agende pelo WhatsApp.',
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
            ['q' => 'Microagulhamento dói?', 'a' => 'Com o creme anestésico aplicado antes, a maioria dos pacientes descreve apenas uma sensação de calor ou leve arranhado. O desconforto é bem tolerado e passa rápido.'],
            ['q' => 'Quantas sessões são necessárias?', 'a' => 'O protocolo habitual é de 3 a 6 sessões, com intervalo em torno de 30 dias. O número exato depende da sua pele e do objetivo, e é definido na avaliação.'],
            ['q' => 'Como fica a pele depois?', 'a' => 'É normal a pele ficar avermelhada e sensível por 1 a 3 dias, parecida com uma leve queimadura de sol. Nesse período é importante usar protetor solar e seguir os cuidados orientados.'],
            ['q' => 'Posso fazer em qualquer época do ano?', 'a' => 'Sim, desde que a proteção solar seja rigorosa depois de cada sessão. Muitos pacientes preferem os meses de menor exposição ao sol para facilitar esse cuidado.'],
        ],
    ],

    'fios-de-pdo' => [
        'num' => '07',
        'updated' => '2026-10-13',
        'name' => 'Fios de PDO',
        'card_desc' => 'Sustentação sem cirurgia: fios bioabsorvíveis que reposicionam os tecidos e estimulam colágeno.',
        'title' => 'Fios de PDO em Belo Horizonte | Lifting sem Cirurgia | Dra. Emily Beatriz',
        'meta_description' => 'Fios de PDO em Belo Horizonte com a Dra. Emily Beatriz. Lifting sem cirurgia para a flacidez facial, com estímulo de colágeno e resultado natural.',
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
            ['q' => 'Fios de PDO tratam flacidez no rosto e no pescoço?', 'a' => 'Sim, em flacidez leve a moderada. Os fios reposicionam o contorno da mandíbula, as bochechas e a região da papada, e o colágeno estimulado melhora a firmeza da pele. Em flacidez acentuada, a Dra. Emily explica com franqueza quando a cirurgia é o caminho mais indicado.'],
        ],
    ],

    'enzima-para-papada' => [
        'num' => '13',
        'updated' => '2026-10-13',
        'name' => 'Enzima para Papada',
        'card_desc' => 'Aplicação de enzimas que ajudam a reduzir a gordura localizada abaixo do queixo, definindo o contorno sem cirurgia.',
        'concern' => ['label' => 'Papada', 'desc' => 'Gordura localizada abaixo do queixo que apaga o contorno do rosto.'],
        'title' => 'Enzima para Papada em Belo Horizonte | Dra. Emily Beatriz',
        'meta_description' => 'Enzima para papada em Belo Horizonte com a Dra. Emily Beatriz. Reduz a gordura localizada abaixo do queixo e define o contorno, sem cirurgia.',
        'eyebrow' => 'Papada sem Cirurgia',
        'h1' => 'Enzima para Papada em Belo Horizonte',
        'hero_lead' => 'A papada aparece até em quem está no peso ideal e costuma resistir à dieta e ao exercício. A aplicação de enzimas na região, conhecida como lipo enzimática de papada, ajuda a reduzir essa gordura localizada e a devolver a definição entre o rosto e o pescoço.',
        'facts' => [
            ['label' => 'Sessões', 'value' => 'Definidas na avaliação'],
            ['label' => 'Resultado', 'value' => 'Progressivo'],
            ['label' => 'Sessão', 'value' => '~30 minutos'],
            ['label' => 'Cirurgia', 'value' => 'Não'],
        ],
        'what_is_title' => 'Como funciona a enzima para papada?',
        'what_is' => [
            'A enzima para papada é uma aplicação injetável de substâncias que atuam sobre as células de gordura da região abaixo do queixo. O organismo elimina essa gordura aos poucos, e o contorno entre o queixo e o pescoço fica mais definido ao longo das semanas.',
            'O tratamento é indicado para gordura localizada leve a moderada. Quando a papada vem da flacidez da pele, e não da gordura, a enzima sozinha não resolve: nesses casos a Dra. Emily Beatriz combina ou substitui por bioestimulador de colágeno ou fios de PDO. Em muitos rostos, o queixo pouco projetado também acentua a papada, e o preenchimento do queixo ajuda a corrigir o ângulo.',
            'Em Belo Horizonte, a Dra. Emily avalia a origem da papada antes de indicar qualquer tratamento, para que você invista no que realmente vai trazer resultado.',
        ],
        'benefits' => [
            ['title' => 'Contorno definido', 'desc' => 'A linha entre o queixo e o pescoço fica mais nítida, afinando o terço inferior do rosto.'],
            ['title' => 'Sem cirurgia', 'desc' => 'Procedimento feito em consultório, sem cortes e sem internação.'],
            ['title' => 'Rotina mantida', 'desc' => 'Inchaço passageiro, sem necessidade de afastamento na maioria dos casos.'],
            ['title' => 'Combinável', 'desc' => 'Pode ser associada a bioestimulador, fios ou preenchimento de queixo quando há flacidez.'],
        ],
        'steps' => [
            ['title' => 'Avaliação da papada', 'desc' => 'A Dra. Emily identifica se a papada vem de gordura, de flacidez ou da posição do queixo, e define o plano.'],
            ['title' => 'Aplicação', 'desc' => 'As enzimas são aplicadas com agulhas finas na gordura abaixo do queixo, em uma sessão de cerca de 30 minutos.'],
            ['title' => 'Sessões & acompanhamento', 'desc' => 'O resultado aparece de forma progressiva, e as sessões seguintes são ajustadas conforme a resposta do seu organismo.'],
        ],
        'faq' => [
            ['q' => 'Enzima para papada funciona?', 'a' => 'Funciona bem para gordura localizada leve a moderada. Quando a papada é causada por flacidez da pele, o resultado da enzima sozinha é limitado, e por isso a avaliação define qual tratamento faz sentido no seu caso.'],
            ['q' => 'Quantas sessões são necessárias?', 'a' => 'Depende do volume de gordura e da resposta do seu organismo. Em geral são necessárias algumas sessões, com intervalo entre elas. O número é definido na avaliação e ajustado ao longo do tratamento.'],
            ['q' => 'Incha depois da aplicação?', 'a' => 'Sim, é esperado um inchaço na região nos primeiros dias, às vezes com sensibilidade ao toque. Ele faz parte da resposta ao tratamento e regride sozinho.'],
            ['q' => 'A gordura volta depois?', 'a' => 'As células de gordura tratadas são eliminadas, mas as que restam podem aumentar com o ganho de peso. Manter o peso estável ajuda a preservar o resultado.'],
        ],
    ],

    'bigode-chines' => [
        'num' => '14',
        'updated' => '2026-10-13',
        'kind' => 'concern',
        'treatments' => ['preenchimento-terco-inferior', 'preenchimento-facial', 'bioestimulador-de-colageno', 'fios-de-pdo'],
        'name' => 'Tratamento para Bigode Chinês',
        'card_desc' => 'Os sulcos entre o nariz e a boca tratados pela causa: reposição de volume, estímulo de colágeno e sustentação.',
        'concern' => ['label' => 'Bigode chinês', 'desc' => 'Sulcos entre o nariz e a boca que pesam a expressão.'],
        'title' => 'Bigode Chinês: Tratamento em BH | Dra. Emily Beatriz',
        'meta_description' => 'Tratamento para bigode chinês em Belo Horizonte com a Dra. Emily Beatriz. Suaviza o sulco nasogeniano e as linhas de marionete, sem cirurgia.',
        'eyebrow' => 'Sulco Nasogeniano',
        'h1' => 'Tratamento para Bigode Chinês em Belo Horizonte',
        'hero_lead' => 'O bigode chinês é uma das queixas mais comuns a partir dos 30 e poucos anos e uma das que mais pesam na expressão. O tratamento que funciona não preenche apenas o sulco: ele devolve a sustentação que o rosto perdeu, para que a linha suavize de forma natural.',
        'facts' => [
            ['label' => 'Causa', 'value' => 'Perda de volume'],
            ['label' => 'Abordagem', 'value' => 'Combinada'],
            ['label' => 'Cirurgia', 'value' => 'Não'],
            ['label' => 'Resultado', 'value' => 'Imediato e progressivo'],
        ],
        'what_is_title' => 'Por que o bigode chinês aparece?',
        'what_is' => [
            'O bigode chinês, ou sulco nasogeniano, é a linha que vai da asa do nariz ao canto da boca. Todo rosto tem esse sulco, mas com o tempo ele se aprofunda: as maçãs do rosto perdem volume, a pele perde colágeno e os tecidos descem, acumulando-se sobre a linha.',
            'Por isso, preencher só o sulco costuma deixar o rosto pesado sem resolver o problema. O tratamento mais eficaz combina reposição de volume nas maçãs do rosto com preenchimento facial, estímulo de colágeno com bioestimulador e, quando há flacidez, sustentação com fios de PDO. Só então, se ainda for necessário, um ajuste fino direto no sulco.',
            'O mesmo raciocínio vale para as linhas de marionete, que descem do canto da boca em direção ao queixo, e para o "código de barras", as linhas finas acima do lábio superior. Em Belo Horizonte, a Dra. Emily Beatriz avalia o rosto inteiro para tratar a causa, e não só a linha.',
        ],
        'benefits' => [
            ['title' => 'Expressão mais leve', 'desc' => 'O sulco suaviza e o rosto perde o aspecto cansado ou bravo.'],
            ['title' => 'Tratamento pela causa', 'desc' => 'Repor a sustentação do terço médio evita o rosto pesado de quem preenche só o sulco.'],
            ['title' => 'Sem cirurgia', 'desc' => 'Procedimentos feitos em consultório, com retorno rápido à rotina.'],
            ['title' => 'Resultado natural', 'desc' => 'Quantidades conservadoras e técnicas combinadas para manter a sua expressão.'],
        ],
        'steps' => [
            ['title' => 'Avaliação do rosto', 'desc' => 'A Dra. Emily identifica o que aprofunda o seu sulco: perda de volume, flacidez ou os dois.'],
            ['title' => 'Plano combinado', 'desc' => 'Define-se a combinação de preenchimento, bioestimulador e fios que faz sentido para você.'],
            ['title' => 'Aplicação & retorno', 'desc' => 'Os procedimentos são feitos em etapas, com retorno para avaliar e ajustar o resultado.'],
        ],
        'faq' => [
            ['q' => 'Bigode chinês tem tratamento sem cirurgia?', 'a' => 'Sim. Na maioria dos casos, a combinação de preenchimento facial, bioestimulador de colágeno e, quando necessário, fios de PDO suaviza bastante o sulco, sem cortes e com retorno rápido à rotina.'],
            ['q' => 'Qual é o melhor tratamento para bigode chinês?', 'a' => 'Não existe um único tratamento. O que dá mais resultado costuma ser repor o volume das maçãs do rosto, que sustentam a região, e estimular colágeno. O plano depende do que causa o seu sulco e é definido na avaliação.'],
            ['q' => 'Preencher o bigode chinês deixa o rosto pesado?', 'a' => 'Pode deixar, quando se aplica muito produto direto no sulco. Por isso a Dra. Emily trata primeiro a sustentação do terço médio e só faz ajustes pequenos no sulco, se ainda forem necessários.'],
            ['q' => 'A partir de que idade o bigode chinês aparece?', 'a' => 'É comum começar a incomodar a partir dos 30 a 35 anos e se acentuar depois dos 40, mas depende da genética, da estrutura óssea e de hábitos como exposição ao sol e tabagismo.'],
        ],
    ],

    'flacidez-facial' => [
        'num' => '15',
        'updated' => '2026-10-13',
        'kind' => 'concern',
        'treatments' => ['bioestimulador-de-colageno', 'fios-de-pdo', 'microagulhamento', 'full-face'],
        'name' => 'Tratamento para Flacidez Facial',
        'card_desc' => 'Firmeza de volta ao rosto sem cirurgia, com estímulo de colágeno, sustentação e melhora da qualidade da pele.',
        'concern' => ['label' => 'Flacidez', 'desc' => 'Contorno menos definido e pele com menos firmeza.'],
        'title' => 'Flacidez Facial: Tratamento em BH | Dra. Emily Beatriz',
        'meta_description' => 'Tratamento para flacidez facial em Belo Horizonte com a Dra. Emily Beatriz. Rejuvenescimento sem cirurgia para a pele madura, também na menopausa.',
        'eyebrow' => 'Rejuvenescimento Facial',
        'h1' => 'Tratamento para Flacidez Facial em Belo Horizonte',
        'hero_lead' => 'O contorno da mandíbula menos nítido, as bochechas mais baixas e a pele que já não tem a mesma firmeza: a flacidez facial é o sinal do tempo que mais muda o rosto depois dos 40. A boa notícia é que dá para tratá-la sem cirurgia, estimulando o próprio colágeno da pele.',
        'facts' => [
            ['label' => 'Causa', 'value' => 'Perda de colágeno'],
            ['label' => 'Abordagem', 'value' => 'Combinada'],
            ['label' => 'Cirurgia', 'value' => 'Não'],
            ['label' => 'Resultado', 'value' => 'Progressivo'],
        ],
        'what_is_title' => 'Por que a pele do rosto fica flácida?',
        'what_is' => [
            'A partir dos 25 anos, o corpo produz cada vez menos colágeno e elastina, as fibras que mantêm a pele firme. Ao mesmo tempo, o rosto perde gordura e osso em alguns pontos, e os tecidos começam a descer. O resultado é o contorno da mandíbula menos definido, as bochechas caídas, o bigode chinês mais marcado e a papada.',
            'Na menopausa, esse processo acelera: com a queda dos hormônios, a pele perde colágeno mais rapidamente e fica mais fina e seca. Por isso é comum sentir que o rosto mudou de repente nessa fase.',
            'O tratamento não cirúrgico combina técnicas: bioestimulador de colágeno para devolver firmeza, fios de PDO para reposicionar os tecidos, microagulhamento para melhorar a qualidade da pele e, quando há perda de volume, preenchimento. Em Belo Horizonte, a Dra. Emily Beatriz monta o plano conforme o grau de flacidez e é franca quando a cirurgia é a indicação mais adequada.',
        ],
        'benefits' => [
            ['title' => 'Mais firmeza', 'desc' => 'O colágeno estimulado devolve sustentação e elasticidade à pele.'],
            ['title' => 'Contorno redefinido', 'desc' => 'Mandíbula e bochechas reposicionadas, com efeito de lifting natural.'],
            ['title' => 'Pele mais bonita', 'desc' => 'Textura, viço e espessura da pele melhoram junto com a firmeza.'],
            ['title' => 'Sem cirurgia', 'desc' => 'Tratamentos em consultório, sem internação e com retorno rápido.'],
        ],
        'steps' => [
            ['title' => 'Avaliação da flacidez', 'desc' => 'A Dra. Emily avalia o grau de flacidez, a qualidade da pele e a perda de volume de cada região.'],
            ['title' => 'Protocolo combinado', 'desc' => 'Define-se a combinação de bioestimulador, fios, microagulhamento e preenchimento ideal para você.'],
            ['title' => 'Sessões & manutenção', 'desc' => 'O resultado é construído ao longo de semanas e mantido com sessões periódicas.'],
        ],
        'faq' => [
            ['q' => 'Qual o melhor tratamento para flacidez facial?', 'a' => 'Para flacidez leve a moderada, o bioestimulador de colágeno costuma ser a base do tratamento, muitas vezes combinado com fios de PDO e microagulhamento. A combinação ideal depende do grau de flacidez e é definida na avaliação.'],
            ['q' => 'Dá para tratar flacidez facial sem cirurgia?', 'a' => 'Sim, na maioria dos casos de flacidez leve a moderada. Quando a flacidez é acentuada, os tratamentos não cirúrgicos melhoram a pele mas não substituem um lifting cirúrgico, e a Dra. Emily explica isso com clareza na avaliação.'],
            ['q' => 'A flacidez piora na menopausa?', 'a' => 'Sim. Com a queda hormonal, a perda de colágeno acelera e a pele fica mais fina. Começar o estímulo de colágeno nessa fase ajuda a compensar a perda e a manter a firmeza.'],
            ['q' => 'Em quanto tempo vejo resultado?', 'a' => 'Os fios dão sustentação imediata. O bioestimulador e o microagulhamento têm resultado progressivo, que aparece em algumas semanas e continua melhorando por meses.'],
        ],
    ],

];
