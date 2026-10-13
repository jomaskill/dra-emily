<?php

namespace App\Support;

/**
 * Monta os links de WhatsApp do site.
 *
 * Cada botão envia uma mensagem pronta que diz de onde a paciente veio
 * (procedimento, resultado, artigo ou seção), para a equipe saber o contexto
 * da conversa sem precisar perguntar.
 */
class WhatsApp
{
    /**
     * Acrescentado no navegador ao fim da mensagem quando a visita veio de
     * anúncio do Google, para separar as conversas do tráfego pago.
     */
    public const GOOGLE_ADS_MARKER = '(via anúncio do Google)';

    /**
     * Link wa.me com a mensagem já preenchida.
     */
    public static function url(string $message): string
    {
        return 'https://wa.me/'.config('clinic.whatsapp').'?text='.rawurlencode($message);
    }

    /**
     * Mensagem do card de antes e depois: cita o procedimento e o caso.
     *
     * @param  array{procedure: string, title: string}  $case
     */
    public static function forResult(array $case): string
    {
        $procedureName = config('procedures.'.$case['procedure'].'.name');

        $subject = $procedureName
            ? $procedureName.' ("'.$case['title'].'")'
            : '"'.$case['title'].'"';

        return self::url('Olá! Vi no site o resultado de '.$subject.' e quero saber se consigo algo parecido.');
    }
}
