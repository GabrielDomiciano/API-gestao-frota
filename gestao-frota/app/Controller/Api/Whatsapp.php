<?php

namespace App\Controller\Api;
use \App\Communication\Whatsapp as CommunicationWhatsapp;

class Whatsapp extends Api {
    public static function setWhatsapp($telefone, $message){
        $obWhatsapp = new CommunicationWhatsapp;
        $enviaWhats = $obWhatsapp->sendWhatsapp($telefone, $message);

        return true;
    }

}
