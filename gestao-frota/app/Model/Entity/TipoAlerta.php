<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do ALERTA
 */
class TipoAlerta{
    //ID DO ALERTA
    public $id;
    //DESCRICAO ALERTA
    public $descricaoAlerta;
    //TIPO ALERTA
    public $tipoEnvio;
    //DETALHE ALERTA
    public $detalhes;
    //DATA
    public $data;

    /**
     * Método responsável por buscar todos os alertas
     *
     */
    public static function getAlertas($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('tipos_alertas'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar um alerta
     */
    public function cadastrar(){
        $this->id = (new Database('tipos_alertas'))->insert([
            'descricaoAlerta' => $this->descricaoAlerta,
            'tipoEnvio' => $this->tipoEnvio,
            'detalhes' => $this->detalhes,
            'data' => $this->data 
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações do alerta
     */
    public function atualizar(){
        return (new Database('tipos_alertas'))->update('id = '.$this->id,[
            'descricaoAlerta' => $this->descricaoAlerta,
            'tipoEnvio' => $this->tipoEnvio,
            'detalhes' => $this->detalhes,
            'data' => $this->data      
        ]);
    }

    /**
     * Método responsável por excluir um alerta
     *
     */
    public function excluir(){
        return (new Database('tipos_alertas'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar um alerta através pelo ID
     *
     * 
     */
    public static function getAlertaById($id){
        return self::getAlertas('id = '.$id)->fetchObject(self::class);
    }

}