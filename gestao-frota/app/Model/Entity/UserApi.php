<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do usuário
 */
class UserApi{
    //ID DO USUÁRIO
    public $id;
    //NOME DO USUÁRIO PRA API
    public $nome;
    //SENHA DO USUÁRIO
    public $senha;

    /**
     * Método responsável por buscar um usuário através do nome
     *
     */
    public static function getUserApiByNome($nome){
        return (new Database('user_api'))->select('nome = "'.$nome.'"')->fetchObject(self::class);
    }
}