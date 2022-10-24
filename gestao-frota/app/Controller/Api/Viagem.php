<?php

namespace App\Controller\Api;

use \App\Model\Entity\Viagem as EntityViagem;
use \WilliamCosta\DatabaseManager\Pagination;

class Viagem extends Api{
    /**
     * Método responsável por mostrar cada item da Viagem
     *
     */
    private static function getViagemItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityViagem::getViagens(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 500);
        $results = EntityViagem::getViagens(null, 'id ASC', $obPagination->getLimit());

        while($obViagem = $results->fetchObject(EntityViagem::class)){

            $itens[] =  [
                'id' => (int)$obViagem->id,
                'origem' => $obViagem->origem,
                'destino' => $obViagem->destino,
                'detalhe' => $obViagem->detalhe,
                'kmPercorrido' => $obViagem->kmPercorrido,
                'litrosGastos' => $obViagem->litrosGastos,
                'idVeiculo' => $obViagem->idVeiculo,
                'idFuncionario' => $obViagem->idFuncionario,
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todas as viagens
     *
     */
    public static function getViagens($request){
        return [
            'viagens' => self::getViagemItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar uma viagem
     *
     */
    public static function getViagem($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA VIAGEM
        $obViagem = EntityViagem::getViagemById($id);

        if (!$obViagem instanceof EntityViagem) {
            throw new \Exception("A Viagem ". $id. " Não foi encontrada", 404);
        }

        return [
            'id' => (int)$obViagem->id,
            'origem' => $obViagem->origem,
            'destino' => $obViagem->destino,
            'detalhe' => $obViagem->detalhe,
            'kmPercorrido' => $obViagem->kmPercorrido,
            'litrosGastos' => $obViagem->litrosGastos,
            'idVeiculo' => $obViagem->idVeiculo,
            'idFuncionario' => $obViagem->idFuncionario,
        ];
    }

    public static function getCurrentViagem($request){
        //VIAGEM ATUAL
        $obViagem = $request->Viagem;
        return [
            'id' => (int)$obViagem->id,
            'origem' => $obViagem->origem,
            'destino' => $obViagem->destino,
            'detalhe' => $obViagem->detalhe,
            'kmPercorrido' => $obViagem->kmPercorrido,
            'litrosGastos' => $obViagem->litrosGastos,
            'idVeiculo' => $obViagem->idVeiculo,
            'idFuncionario' => $obViagem->idFuncionario,
        ];
    }

    // -------------------------------------------------------- -------------------------------------------------------------
    /**
     * Método responsável por adicionar nova Viagem
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewViagem($request){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['origem']) or !isset($postVars['destino'])) {
            throw new \Exception("Os campos 'origem' e 'destino' são obrigatórios", 400);
        }

        //CADASTRA NOVO Viagem
        $obViagem = new EntityViagem;
        $obViagem->origem = $postVars['origem'];
        $obViagem->destino = $postVars['destino'];
        $obViagem->detalhe = $postVars['detalhe'];
        $obViagem->kmPercorrido = $postVars['kmPercorrido'];
        $obViagem->litrosGastos = $postVars['litrosGastos'];
        $obViagem->idVeiculo = $postVars['idVeiculo'];
        $obViagem->idFuncionario = $postVars['idFuncionario'];
       
        $obViagem->cadastrar();

        return [
            'id' => (int)$obViagem->id,
            'origem' => $obViagem->origem,
            'destino' => $obViagem->destino,
            'detalhe' => $obViagem->detalhe,
            'kmPercorrido' => $obViagem->kmPercorrido,
            'litrosGastos' => $obViagem->litrosGastos,
            'idVeiculo' => $obViagem->idVeiculo,
            'idFuncionario' => $obViagem->idFuncionario,
        ];
    }

    public static function setEditViagem($request, $id){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['origem']) or !isset($postVars['destino'])) {
            throw new \Exception("Os campos 'origem' e 'destino' são obrigatórios", 400);
        }

        //BUSCA VIAGEM
        $obViagem = EntityViagem::getViagemById($id);

        //VALIDA VIAGEM
        if (!$obViagem instanceof EntityViagem) {
            throw new \Exception("A viagem ". $id. " Não foi encontrada", 404);
        }

        //ATUALIZA VIAGEM
        $obViagem->origem = $postVars['origem'];
        $obViagem->destino = $postVars['destino'];
        $obViagem->detalhe = $postVars['detalhe'];
        $obViagem->kmPercorrido = $postVars['kmPercorrido'];
        $obViagem->litrosGastos = $postVars['litrosGastos'];
        $obViagem->idVeiculo = $postVars['idVeiculo'];
        $obViagem->idFuncionario = $postVars['idFuncionario'];
        $obViagem->atualizar();

        return [
            'id' => (int)$obViagem->id,
            'origem' => $obViagem->origem,
            'destino' => $obViagem->destino,
            'detalhe' => $obViagem->detalhe,
            'kmPercorrido' => $obViagem->kmPercorrido,
            'litrosGastos' => $obViagem->litrosGastos,
            'idVeiculo' => $obViagem->idVeiculo,
            'idFuncionario' => $obViagem->idFuncionario,
        ];
    }
    
    /**
     * Método responsável por excluir uma Viagem
     */
    public static function setDeleteViagem($request, $id){

        //BUSCA Viagem NO BANCO
        $obViagem = EntityViagem::getViagemById($id);

        //VALIDA INSTANCIA
        if (!$obViagem instanceof EntityViagem) {
            throw new \Exception("A viagem ". $id. " Não foi encontrada", 404);          
        }

        //EXCLUIR Viagem
        $obViagem->excluir();

        return [
            'sucesso' => 'Viagem excluída com sucesso'
        ];
    }
}