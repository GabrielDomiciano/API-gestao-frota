<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os Pagamentos
 */
class Pagamento{
    public $id;
    public $descricao;
    public $codigoTransacao;
    public $tipo;
    public $idPlano; 
    public $idEmpresa;
    public $dataPagamento;
    public $valor;
    public $status;
    public $dataVencimento;
    public $usuario;


    /**
     * Método responsável por buscar todos os veículos
     *
     */
    public static function getPagamentos($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('pagamento'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar veículos
     *
     * @return boolean
     */
    public function cadastrar(){
        $this->id = (new Database('pagamento'))->insert([
            'descricao' => $this->descricao,
            'codigoTransacao' => $this->codigoTransacao,
            'tipo' => $this->tipo,
            'idPlano' => $this->idPlano,
            'idEmpresa' => $this->idEmpresa,
            'dataPagamento' => $this->dataPagamento,
            'valor' => $this->valor,
            'status' => $this->status,
            'dataVencimento' => $this->dataVencimento,
            'usuario' => $this->usuario

        ]);
        return true;
    }

    /**
     * Método responsável por atualizar o cadastro de um Pagamento
     *
     * @return array
     */
    public function atualizar(){
        return (new Database('pagamento'))->update('id = '.$this->id,[
            'descricao' => $this->descricao,
            'codigoTransacao' => $this->codigoTransacao,
            'tipo' => $this->tipo,
            'idPlano' => $this->idPlano,
            'idEmpresa' => $this->idEmpresa,
            'dataPagamento' => $this->dataPagamento,
            'valor' => $this->valor,
            'status' => $this->status,
            'dataVencimento' => $this->dataVencimento,
            'usuario' => $this->usuario
        ]);
    }

    /**
     * Método responsável por excluir um veículo
     *
     */
    public function excluir(){
        return (new Database('pagamento'))->delete('id = '.$this->id);
    }
    
    /**
     * Método responsável por buscar um veículo através pelo ID
     *
     * 
     */
    public static function getPagamentoById($id){
        return self::getPagamentos('id = '.$id)->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar um veículo através pelo ID
     *
     * 
     */
    public static function getPagamentoByIdEmpresa($id){
        return self::getPagamentos('idEmpresa = '.$id)->fetchObject(self::class);
    }
}