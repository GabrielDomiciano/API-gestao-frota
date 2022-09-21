<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models da Monitoramento
 */
class Monitoramento{
    //ID DA Monitoramento
    public $id;
    public $mediaKmDia;
    public $mediaGastoKm;
    public $emiteAlerta;
    public $kmUltimaRevisao;
    public $configMsg;
    public $periodo;
    public $mensagem;
    public $dataHora;
    public $idViagem;
    public $idTipoAlerta; 
    public $idUsuario;

    /**
     * Método responsável por buscar todas os monitoramentos
     *
     */
    public static function getMonitoramentos($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('monitoramento_alertas'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar uma Monitoramento
     */
    public function cadastrar(){
        $this->id = (new Database('monitoramento_alertas'))->insert([
            'mediaKmDia' => $this->mediaKmDia,
            'mediaGastoKm' => $this->mediaGastoKm,
            'emiteAlerta' => $this->emiteAlerta,
            'kmUltimaRevisao' => $this->kmUltimaRevisao,
            'configMsg' => $this->configMsg,
            'periodo' => $this->periodo,
            'mensagem' => $this->mensagem,
            'dataHora' => $this->dataHora,     
            'idViagem' => $this->idViagem,     
            'idTipoAlerta' => $this->idTipoAlerta,     
            'idUsuario' => $this->idUsuario
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações da Monitoramento
     */
    public function atualizar(){
        return (new Database('monitoramento_alertas'))->update('id = '.$this->id,[
            'mediaKmDia' => $this->mediaKmDia,
            'mediaGastoKm' => $this->mediaGastoKm,
            'emiteAlerta' => $this->emiteAlerta,
            'kmUltimaRevisao' => $this->kmUltimaRevisao,
            'configMsg' => $this->configMsg,
            'periodo' => $this->periodo,
            'mensagem' => $this->mensagem,
            'dataHora' => $this->dataHora,     
            'idViagem' => $this->idViagem,     
            'idTipoAlerta' => $this->idTipoAlerta,     
            'idUsuario' => $this->idUsuario     
        ]);
    }

    /**
     * Método responsável por excluir uma Monitoramento
     *
     */
    public function excluir(){
        return (new Database('monitoramento_alertas'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar uma Monitoramento através pelo ID
     *
     * 
     */
    public static function getMonitoramentoById($id){
        return self::getMonitoramentos('id = '.$id)->fetchObject(self::class);
    }

}