<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do Empresa
 */
class Empresa{
    public $id;
    public $descricaoEmpresa;
    public $cnpjEmpresa;
    public $localizacaoEmpresa;
    public $qtdFuncionarioEmpresa;
    public $ativo;

 
    /**
     * Método responsável por buscar todos os Empresas
     *
     */
    public static function getEmpresas($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('empresa'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar um Empresa
     */
    public function cadastrar(){
        $this->id = (new Database('empresa'))->insert([
            'descricaoEmpresa' => $this->descricaoEmpresa,
            'cnpjEmpresa' => $this->cnpjEmpresa,
            'localizacaoEmpresa' => $this->localizacaoEmpresa,
            'qtdFuncionarioEmpresa' => $this->qtdFuncionarioEmpresa,
            'ativo' => $this->ativo
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações do Empresa
     */
    public function atualizar(){
        return (new Database('empresa'))->update('id = '.$this->id,[
            'descricaoEmpresa' => $this->descricaoEmpresa,
            'cnpjEmpresa' => $this->cnpjEmpresa,
            'localizacaoEmpresa' => $this->localizacaoEmpresa,
            'qtdFuncionarioEmpresa' => $this->qtdFuncionarioEmpresa,
            'ativo' => $this->ativo     
        ]);
    }

    /**
     * Método responsável por excluir um Empresa
     *
     */
    public function excluir(){
        return (new Database('empresa'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar um Empresa através do ID
     *
     * 
     */
    public static function getEmpresaById($id){
        return self::getEmpresas('id = '.$id)->fetchObject(self::class);
    }

}