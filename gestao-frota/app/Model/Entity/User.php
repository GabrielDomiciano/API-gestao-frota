<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do usuário
 */
class User{
    //ID DO USUÁRIO
    public $id;
    //NOME DO USUÁRIO
    public $nome;
    //APELIDO DO USUÁRIO
    public $apelido;
    //TELEFONE DO USUÁRIO
    public $telefone;
    //EMAIL DO USUÁRIO
    public $email;
    //SENHA DO USUÁRIO
    public $senha; 

    /**
     * Método responsável por buscar um usuário através do email
     *
     */
    public static function getUserByEmail($email){
        return (new Database('usuario'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar todos os usuários
     *
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('usuario'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar um usuário
     */
    public function cadastrar(){
        $this->id = (new Database('usuario'))->insert([
            'nome' => $this->nome,
            'apelido' => $this->apelido,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'senha' => $this->senha,
            'idEmpresa' => $this->idEmpresa     
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações do usuário
     */
    public function atualizar(){
        return (new Database('usuario'))->update('id = '.$this->id,[
            'nome' => $this->nome,
            'apelido' => $this->apelido,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'senha' => $this->senha ,
            'idEmpresa' => $this->idEmpresa   
        ]);
    }

    /**
     * Método responsável por excluir um usuário
     *
     */
    public function excluir(){
        return (new Database('usuario'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar um usuário através pelo ID
     *
     * 
     */
    public static function getUserById($id){
        return self::getUsers('id = '.$id)->fetchObject(self::class);
    }

}