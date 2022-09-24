<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os relatorios de gastos
 */
class RelatorioGastos{
    public $id;
    public $gastosDiarios;
    public $gastosSemanais;
    public $gastosMensais;
    public $gastosAnuais; 
    public $mediaVeiculo;
    public $qtdviagens;
    public $kmRodado;
    public $dataHora;
    public $idUsuario;
    public $idVeiculo;
    public $idFuncionario;

    /**
     * Método responsável por buscar todos os relatorios de gastos
     *
     */
    public static function getRelatoriosGastos($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('relatorio_gastos'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar relatorio de gastos
     *
     * @return boolean
     */
    public function cadastrar(){
        $this->id = (new Database('relatorio_gastos'))->insert([
            'gastosDiarios' => $this->gastosDiarios,
            'gastosSemanais' => $this->gastosSemanais,
            'gastosMensais' => $this->gastosMensais,
            'gastosAnuais' => $this->gastosAnuais,
            'mediaVeiculo' => $this->mediaVeiculo,
            'qtdViagens' => $this->qtdViagens,
            'kmRodado' => $this->kmRodado,
            'dataHora' => $this->dataHora,
            'idUsuario' => $this->idUsuario,
            'idVeiculo' => $this->idVeiculo,
            'idFuncionario' => $this->idFuncionario
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar o cadastro de um relatorio
     *
     * @return array
     */
    public function atualizar(){
        return (new Database('relatorio_gastos'))->update('id = '.$this->id,[
            'gastosDiarios' => $this->gastosDiarios,
            'gastosSemanais' => $this->gastosSemanais,
            'gastosMensais' => $this->gastosMensais,
            'gastosAnuais' => $this->gastosAnuais,
            'mediaVeiculo' => $this->mediaVeiculo,
            'qtdViagens' => $this->qtdViagens,
            'kmRodado' => $this->kmRodado,
            'dataHora' => $this->dataHora,
            'idUsuario' => $this->idUsuario,
            'idVeiculo' => $this->idVeiculo,
            'idFuncionario' => $this->idFuncionario
        ]);
    }

    /**
     * Método responsável por excluir um relatorio de gastos
     *
     */
    public function excluir(){
        return (new Database('relatorio_gastos'))->delete('id = '.$this->id);
    }
    
    /**
     * Método responsável por buscar um relatorio através pelo ID
     *
     * 
     */
    public static function getRelatorioGastosById($id){
        return self::getRelatoriosGastos('id = '.$id)->fetchObject(self::class);
    }
}