<?php

namespace App\Communication;

use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    /**
     * Credenciais de acesso ao email
     */
    const HOST = 'smtp.gmail.com';
    const USER = 'gestao.frota.tcc@gmail.com';
    const PASS = 'dptkorcjvwhotyzg';
    const SECURE = 'TLS';
    const PORT = 587;
    const CHARSET = 'UTF-8';

    /**
     * Dados do Remetente
     */
    const FROM_EMAIL = 'gestao.frota.tcc@gmail.com';
    const FROM_NAME = 'Equipe Gestão Frota';

    /**
     * Mensagem de erro do envio
     *
     * @var string
     */
    private $error;

    /**
     * Método responsável por Retornar o erro de envio
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Método responsável por fazer o envio do email
     *
     * @param  string/array $address DESTINATÁRIO DO EMAIL
     * @param  string $subject ASSUNTO DO EMAIL
     * @param  string $body CORPO DA MENSAGEM
     * @param  string/array $attachments [OPCIONAL] ANEXOS DO EMAIL
     * @param  string/array $ccs [OPCIONAL] CÓPIAS VISIVEIS DO EMAIL
     * @param  string/array $bccs [OPCIONAL] CÓPIAS OCULTAS DO EMAIL
     * @return boolean
     */
    public function sendEmail($addresses, $subject, $body, $attachments = [], $ccs = [], $bccs = [])
    {
        //LIMPAR A MENSAGEM DE ERRO
        $this->error = '';

        //INSTANCIA DE PHPMAILER
        $obMail = new PHPMailer(true);
        try {
            //CREDENCIAIS DE ACESSO AO SMTP
            $obMail->isSMTP(true);
            $obMail->Host = self::HOST;
            $obMail->SMTPAuth = true;
            $obMail->Username = self::USER;
            $obMail->Password = self::PASS;
            $obMail->SMTPSecure = self::SECURE;
            $obMail->Port = self::PORT;
            $obMail->CharSet = self::CHARSET;

            //REMETENTE 
            $obMail->setFrom(self::FROM_EMAIL, self::FROM_NAME);

            //DESTINÁTARIOS
            $addresses = is_array($addresses) ? $addresses : [$addresses]; //CONVERTE VÁRIAVEL EM ARRAY
            foreach ($addresses as $address) {
                $obMail->addAddress($address);
            }
            //ANEXO
            $attachments = is_array($attachments) ? $attachments : [$attachments]; //CONVERTE VÁRIAVEL EM ARRAY
            foreach ($attachments as $attachment) {
                $obMail->addAttachment($attachment);
            }
            //CÓPIA
            $ccs = is_array($ccs) ? $ccs : [$ccs]; //CONVERTE VÁRIAVEL EM ARRAY
            foreach ($ccs as $cc) {
                $obMail->addCC($cc);
            }         
            //CÓPIA OCULTA
            $bccs = is_array($bccs) ? $bccs : [$bccs]; //CONVERTE VÁRIAVEL EM ARRAY
            foreach ($bccs as $bcc) {
                $obMail->addBCC($bcc);
            }

            //CONTEÚDO DO EMAIL
            $obMail->isHTML(true);
            $obMail->Subject = $subject;
            $obMail->Body = $body;

            //EXECUTA A MENSAGEM
            return $obMail->send();
            
        } catch (PHPMailerException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

}
