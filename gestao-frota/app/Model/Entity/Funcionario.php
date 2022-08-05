<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do Funcionario
 */
class Funcionario{
    //ID DO Funcionario
    public $id;
    public $nome;
    public $telefone;
    public $email;
    public $idEmpresa;
 
    /**
     * Método responsável por buscar todos os Funcionarios
     *
     */
    public static function getFuncionarios($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('funcionario'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar um Funcionario
     */
    public function cadastrar(){
        $this->id = (new Database('funcionario'))->insert([
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'idEmpresa' => $this->idEmpresa     
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações do Funcionario
     */
    public function atualizar(){
        return (new Database('funcionario'))->update('id = '.$this->id,[
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'idEmpresa' => $this->idEmpresa    
        ]);
    }

    /**
     * Método responsável por excluir um Funcionario
     *
     */
    public function excluir(){
        return (new Database('funcionario'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar um Funcionario através do ID
     *
     * 
     */
    public static function getFuncionarioById($id){
        return self::getFuncionarios('id = '.$id)->fetchObject(self::class);
    }

}