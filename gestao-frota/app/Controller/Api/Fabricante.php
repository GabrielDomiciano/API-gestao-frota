<?php

namespace App\Controller\Api;

use \App\Model\Entity\Fabricante as EntityFabricante;
use \WilliamCosta\DatabaseManager\Pagination;

class Fabricante extends Api{
    /**
     * Método responsável por mostrar cada item do Fabricante
     *
     */
    private static function getFabricanteItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityFabricante::getFabricantes(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);
        $results = EntityFabricante::getFabricantes(null, 'id ASC', $obPagination->getLimit());

        while($obFabricante = $results->fetchObject(EntityFabricante::class)){

            $itens[] =  [
                'id' => (int)$obFabricante->id,
                'descricaoFabricante' => $obFabricante->descricaoFabricante,
                'taxaManutencao' => $obFabricante->taxaManutencao,
                'percSeguranca' => $obFabricante->percSeguranca
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos os Fabricantes
     *
     */
    public static function getFabricantes($request){
        return [
            'fabricantes' => self::getFabricanteItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um Fabricante
     *
     */
    public static function getFabricante($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA Fabricante
        $obFabricante = EntityFabricante::getFabricanteById($id);

        if (!$obFabricante instanceof EntityFabricante) {
            throw new \Exception("O Fabricante ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obFabricante->id,
            'descricaoFabricante' => $obFabricante->descricaoFabricante,
            'taxaManutencao' => $obFabricante->taxaManutencao,
            'percSeguranca' => $obFabricante->percSeguranca
        ];
    }

    public static function getCurrentFabricante($request){
        //Fabricante ATUAL
        $obFabricante = $request->Fabricante;
        return [
            'id' => (int)$obFabricante->id,
            'descricaoFabricante' => $obFabricante->descricaoFabricante,
            'taxaManutencao' => $obFabricante->taxaManutencao,
            'percSeguranca' => $obFabricante->percSeguranca
        ];
    }

    /**
     * Método responsável por adicionar novo Fabricante
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewFabricante($request){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoFabricante']) or !isset($postVars['taxaManutencao'])) {
            throw new \Exception("Os campos 'descricao' e 'valor' são obrigatórios", 400);
        }

        //CADASTRA NOVO Fabricante
        $obFabricante = new EntityFabricante;
        $obFabricante->descricaoFabricante = $postVars['descricaoFabricante'];
        $obFabricante->taxaManutencao = $postVars['taxaManutencao'];
        $obFabricante->percSeguranca = $postVars['percSeguranca'];
        $obFabricante->cadastrar();

        return [
            'id' => (int)$obFabricante->id,
            'descricaoFabricante' => $obFabricante->descricaoFabricante,
            'taxaManutencao' => $obFabricante->taxaManutencao,
            'percSeguranca' => $obFabricante->percSeguranca
        ];
    }

    /**
     * Método responsável por atualizar um Fabricante
     *
     * @param [type] $request
     * @param integer $id
     * @return array
     */
    public static function setEditFabricante($request, $id){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoFabricante']) or !isset($postVars['taxaManutencao'])) {
            throw new \Exception("Os campos 'descricao' e 'valor' são obrigatórios", 400);
        }

        //BUSCA Fabricante
        $obFabricante = EntityFabricante::getFabricanteById($id);

        //VALIDA Fabricante
        if (!$obFabricante instanceof EntityFabricante) {
            throw new \Exception("O Fabricante ". $id. " Não foi encontrado", 404);
        }

       //ATUALIZA Fabricante
        $obFabricante->descricaoFabricante = $postVars['descricaoFabricante'];
        $obFabricante->taxaManutencao = $postVars['taxaManutencao'];
        $obFabricante->percSeguranca = $postVars['percSeguranca'];
        $obFabricante->atualizar();

        return [
            'id' => (int)$obFabricante->id,
            'descricaoFabricante' => $obFabricante->descricaoFabricante,
            'taxaManutencao' => $obFabricante->taxaManutencao,
            'percSeguranca' => $obFabricante->percSeguranca
        ];
    }

    /**
     * Método responsável por excluir um Fabricante
     */
    public static function setDeleteFabricante($request, $id){

        //BUSCA Fabricante NO BANCO
        $obFabricante = EntityFabricante::getFabricanteById($id);

        //VALIDA INSTANCIA
        if (!$obFabricante instanceof EntityFabricante) {
            throw new \Exception("O Fabricante ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR Fabricante
        $obFabricante->excluir();

        return [
            'sucesso' => true
        ];
    }
}
