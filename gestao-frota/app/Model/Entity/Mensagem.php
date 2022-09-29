<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do Mensagem
 */
class Mensagem{
    //ID DO Mensagem
    public $id;
    public $telefone;
    public $email;
    public $mensagem;
    public $idEmpresa;
    public $idFuncionario;
    public $data;
 
    /**
     * Método responsável por buscar todos os Mensagems
     *
     */
    public static function getMensagens($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('funcionario_alerta'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar um Mensagem
     */
    public function cadastrar(){
        $this->id = (new Database('funcionario_alerta'))->insert([
            'telefone' => $this->telefone,
            'email' => $this->email,
            'mensagem' => $this->mensagem,
            'idEmpresa' => $this->idEmpresa,
            'idFuncionario' => $this->idFuncionario,
            'data' => $this->data
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações do Mensagem
     */
    public function atualizar(){
        return (new Database('funcionario_alerta'))->update('id = '.$this->id,[
            'telefone' => $this->telefone,
            'email' => $this->email,
            'mensagem' => $this->mensagem,
            'idEmpresa' => $this->idEmpresa,
            'idFuncionario' => $this->idFuncionario,
            'data' => $this->data   
        ]);
    }

    /**
     * Método responsável por excluir um Mensagem
     *
     */
    public function excluir(){
        return (new Database('funcionario_alerta'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar um Mensagem através do ID
     *
     * 
     */
    public static function getMensagemById($id){
        return self::getMensagens('id = '.$id)->fetchObject(self::class);
    }

}