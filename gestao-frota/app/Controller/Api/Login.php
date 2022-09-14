<?php

namespace App\Controller\Api;

use \App\Model\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends Api{
    
    public static function generateToken($request){
        // post vars
        $postVars = $request->getPostVars();
        if (!isset($postVars['email']) or !isset($postVars['senha'])) {
            throw new \Exception("Os campos 'email' e 'senha' são obrigatorios", 400);      
        }

        // busca usuario pelo email
        $obUser = User::getUserByEmail($postVars['email']);
        if (!$obUser instanceof User) {
            throw new \Exception("Usuário ou senha Inválido! ", 400);      
        }

        //valida senha usuario
        if (!password_verify($postVars['senha'],$obUser->senha)) {
            throw new \Exception("Usuário ou senha Inválido! ", 400);      
        }

        // payload
        $payload = [
            'email' => $obUser->email
        ];

        $token = JWT::encode($payload, getenv('JWT_KEY'), 'HS256');

        return [
            'token' => $token
        ];

    }
}