<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do plano
 */
class Plano{
    //ID DO PLANO
    public $id;
    //DESC DO PLANO
    public $descricaoPlano;
    //VALOR DO PLANO
    public $valorPlano;
    //DETALHE DO PLANO
    public $detalhePlano;
 
    /**
     * Método responsável por buscar todos os planos
     *
     */
    public static function getPlanos($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('planos'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar um plano
     */
    public function cadastrar(){
        $this->id = (new Database('planos'))->insert([
            'descricaoPlano' => $this->descricaoPlano,
            'valorPlano' => $this->valorPlano,
            'detalhePlano' => $this->detalhePlano     
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações do plano
     */
    public function atualizar(){
        return (new Database('planos'))->update('id = '.$this->id,[
            'descricaoPlano' => $this->descricaoPlano,
            'valorPlano' => $this->valorPlano,
            'detalhePlano' => $this->detalhePlano    
        ]);
    }

    /**
     * Método responsável por excluir um plano
     *
     */
    public function excluir(){
        return (new Database('planos'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar um plano através do ID
     *
     * 
     */
    public static function getPlanoById($id){
        return self::getPlanos('id = '.$id)->fetchObject(self::class);
    }

}