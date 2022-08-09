<?php
namespace App\Session;

class Login{
    /**
     * metodo responsavel por iniciar a sessão
     */
    private static function init(){
        // verifica se a sessão nao esta ativa
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * metodo responsavel por criar o login do ususario
     */
    public static function login($obUser){
        self::init();

        $_SESSION['usuario'] = [
            'id' => $obUser->id,
            'nome' => $obUser->nome,
            'email' => $obUser->email
        ];

        return true;
    }

    public static function isLogged(){
        self::init();

        return isset($_SESSION['usuario']['id']);
    }

    public static function logout(){
        self::init();

        //desloga o usuario
        unset($_SESSION['usuario']);

        return true;
    }
}