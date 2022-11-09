<?php

namespace App\Controller\Api;
use \App\Communication\Email as CommunicationEmail;

class Email extends Api{
    /**
     * Método responsável por enviar email sem anexo
     *
     * @return string
     */
    public static function setEmail($address, $subject, $body){
        $obEmail = new CommunicationEmail;
        $sucesso = $obEmail->sendEmail($address, $subject, $body);

        //RETORNA MENSAGEM DE SUCESSO
        return $sucesso ? 'Mensagem enviada com Sucesso!' : $obEmail->getError();
    }

    /**
     * Método responsável por enviar email com anexo
     *
     * @return string
     */
    public static function setEmailAnexo($address, $subject, $body, $attachment){
        $obEmail = new CommunicationEmail;
        $sucesso = $obEmail->sendEmail($address, $subject, $body, $attachment);

        //RETORNA MENSAGEM DE SUCESSO
        return $sucesso ? 'Mensagem enviada com Sucesso!' : $obEmail->getError();
    }
}