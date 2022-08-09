<?php

namespace App\Controller\Api;
use \App\Communication\Email as CommunicationEmail;

class Email extends Api{
    public static function setEmail($address, $subject, $body){
        $obEmail = new CommunicationEmail;
        $sucesso = $obEmail->sendEmail($address, $subject, $body);

        return $sucesso ? 'Mensagem enviada com Sucesso!' : $obEmail->getError();
    }

    public static function setEmailAnexo($address, $subject, $body, $attachment){
        $obEmail = new CommunicationEmail;
        $sucesso = $obEmail->sendEmail($address, $subject, $body, $attachment);

        return $sucesso ? 'Mensagem enviada com Sucesso!' : $obEmail->getError();
    }
}