<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models da viagem
 */
class Viagem{
    //ID DA VIAGEM
    public $id;
    //ORIGEM VIAGEM
    public $origem;
    //DESTINO VIAGEM
    public $destino;
    //DETALHE VIAGEM
    public $detalhe;
    //KM PERCORRIDO
    public $kmPercorrido;
    //LITROS GASTOS
    public $litrosGastos;
    //CHAVE ESTRANGEIRA VEICULO VIAGEM
    public $idVeiculo;
    //CHAVE ESTRANGEIRA FUNCIONARIO VIAGEM
    public $idFuncionario;
    public $idEmpresa;


    /**
     * Método responsável por buscar todas as viagens
     *
     */
    public static function getViagens($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('viagem'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar uma viagem
     */
    public function cadastrar(){
        $this->id = (new Database('viagem'))->insert([
            'origem' => $this->origem,
            'destino' => $this->destino,
            'detalhe' => $this->detalhe,
            'kmPercorrido' => $this->kmPercorrido,
            'litrosGastos' => $this->litrosGastos,
            'idVeiculo' => $this->idVeiculo,
            'idFuncionario' => $this->idFuncionario,
            'idEmpresa' => $this->idEmpresa    
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações da viagem
     */
    public function atualizar(){
        return (new Database('viagem'))->update('id = '.$this->id,[
            'origem' => $this->origem,
            'destino' => $this->destino,
            'detalhe' => $this->detalhe,
            'kmPercorrido' => $this->kmPercorrido,
            'litrosGastos' => $this->litrosGastos,
            'idVeiculo' => $this->idVeiculo,
            'idFuncionario' => $this->idFuncionario,
            'idEmpresa' => $this->idEmpresa    
        ]);
    }

    /**
     * Método responsável por excluir uma viagem
     *
     */
    public function excluir(){
        return (new Database('viagem'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar uma viagem através pelo ID
     *
     * 
     */
    public static function getViagemById($id){
        return self::getViagens('id = '.$id)->fetchObject(self::class);
    }

}