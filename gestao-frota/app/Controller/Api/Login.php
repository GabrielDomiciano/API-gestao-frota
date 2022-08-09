<?php

namespace App\Controller\Api;

use \App\Model\Entity\User;
use \App\Session\Login as SessionLogin;

class Login extends Api{
    public static function getLogin($request, $errorMessage = null){
        return $errorMessage;
    }

    public static function setLogin($request){
        $postVars = $request->getPostVars();
        
        $email = $postVars['email'] ?? '';
        
        $senha = $postVars['senha'] ?? '';

        // busca usuario pelo email
        $obUser = User::getUserByEmail($email);
        if (!$obUser instanceof User) {
            return 'Email ou senha inválidos';
        }

        // verifica a senha do usuario
        if (!password_verify($senha, $obUser->senha)) {
            return 'Email ou senha inválidos';
        }

        // cria a sessao de login
        SessionLogin::login($obUser);

        // redireciona o usuario para a home (PRECISO VER A ROTA DO FRONT PRA COLOCAR AQUI)
        $request->getRouter()->redirect('/home');
    }
    /**
     * metodo reponsavel por deslogar usuario
     */
    public static function setLogout($request){
        // destroi a sessao de login
        SessionLogin::logout($obUser);

        // redireciona o usuario para a tela de login (PRECISO VER A ROTA DO FRONT PRA COLOCAR AQUI)
        //$request->getRouter()->redirect('/');
    }
}