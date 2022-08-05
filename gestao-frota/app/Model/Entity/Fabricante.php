<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do Fabricante
 */
class Fabricante{
    //ID DO Fabricante
    public $id;
    public $descricaoFabricante;
    public $taxaManutencao;
    public $percSeguranca;
 
    /**
     * Método responsável por buscar todos os Fabricantes
     *
     */
    public static function getFabricantes($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('fabricante'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar um Fabricante
     */
    public function cadastrar(){
        $this->id = (new Database('fabricante'))->insert([
            'descricaoFabricante' => $this->descricaoFabricante,
            'taxaManutencao' => $this->taxaManutencao,
            'percSeguranca' => $this->percSeguranca     
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações do Fabricante
     */
    public function atualizar(){
        return (new Database('fabricante'))->update('id = '.$this->id,[
            'descricaoFabricante' => $this->descricaoFabricante,
            'taxaManutencao' => $this->taxaManutencao,
            'percSeguranca' => $this->percSeguranca    
        ]);
    }

    /**
     * Método responsável por excluir um Fabricante
     *
     */
    public function excluir(){
        return (new Database('fabricante'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar um Fabricante através do ID
     *
     * 
     */
    public static function getFabricanteById($id){
        return self::getFabricantes('id = '.$id)->fetchObject(self::class);
    }

}