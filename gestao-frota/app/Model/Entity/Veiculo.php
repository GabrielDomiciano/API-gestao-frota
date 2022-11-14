<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os veiculos
 */
class Veiculo{
    public $id;
    public $descricaoVeiculo;
    public $tipoVeiculo;
    public $qtdRodas;
    public $modeloVeiculo; 
    public $ano;
    //ESTADO DO VEÍCULO (CONDIÇÕES)
    public $estado;
    public $idFabricante;
    public $idEmpresa;
    public $idTipoMotor;

    /**
     * Método responsável por buscar todos os veículos
     *
     */
    public static function getVeiculos($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('veiculo'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar veículos
     *
     * @return boolean
     */
    public function cadastrar(){
        $this->id = (new Database('veiculo'))->insert([
            'descricaoVeiculo' => $this->descricaoVeiculo,
            'tipoVeiculo' => $this->tipoVeiculo,
            'qtdRodas' => $this->qtdRodas,
            'modeloVeiculo' => $this->modeloVeiculo,
            'ano' => $this->ano,
            'estado' => $this->estado,
            'idFabricante' => $this->idFabricante,
            'idEmpresa' => $this->idEmpresa,
            'idTipoMotor' => $this->idTipoMotor
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar o cadastro de um veiculo
     *
     * @return array
     */
    public function atualizar(){
        return (new Database('veiculo'))->update('id = '.$this->id,[
            'descricaoVeiculo' => $this->descricaoVeiculo,
            'tipoVeiculo' => $this->tipoVeiculo,
            'qtdRodas' => $this->qtdRodas,
            'modeloVeiculo' => $this->modeloVeiculo,
            'ano' => $this->ano,
            'estado' => $this->estado,
            'idFabricante' => $this->idFabricante,
            'idEmpresa' => $this->idEmpresa,
            'idTipoMotor' => $this->idTipoMotor
        ]);
    }

    /**
     * Método responsável por excluir um veículo
     *
     */
    public function excluir(){
        return (new Database('veiculo'))->delete('id = '.$this->id);
    }
    
    /**
     * Método responsável por buscar um veículo através pelo ID
     *
     * 
     */
    public static function getVeiculoById($id){
        return self::getVeiculos('id = '.$id)->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar um veículo através pelo ID
     *
     * 
     */
    public static function getVeiculoByIdPorEmpresa($id){
        return self::getVeiculos('idEmpresa = '.$id)->fetchObject(self::class);
    }
}