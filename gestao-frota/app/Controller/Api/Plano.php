<?php

namespace App\Controller\Api;

use \App\Model\Entity\Plano as EntityPlano;
use \WilliamCosta\DatabaseManager\Pagination;

class Plano extends Api{
    /**
     * Método responsável por mostrar cada item do plano
     *
     */
    private static function getPlanoItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityPlano::getPlanos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 500);
        $results = EntityPlano::getPlanos(null, 'id ASC', $obPagination->getLimit());

        while($obPlano = $results->fetchObject(EntityPlano::class)){

            $itens[] =  [
                'id' => (int)$obPlano->id,
                'descricaoPlano' => $obPlano->descricaoPlano,
                'valorPlano' => $obPlano->valorPlano,
                'detalhePlano' => $obPlano->detalhePlano
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos os planos
     *
     */
    public static function getPlanos($request){
        return [
            'planos' => self::getPlanoItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um PLANO
     *
     */
    public static function getPlano($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA PLANO
        $obPlano = EntityPlano::getPlanoById($id);

        if (!$obPlano instanceof EntityPlano) {
            throw new \Exception("O plano ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obPlano->id,
            'descricaoPlano' => $obPlano->descricaoPlano,
            'valorPlano' => $obPlano->valorPlano,
            'detalhePlano' => $obPlano->detalhePlano
        ];
    }

    public static function getCurrentPlano($request){
        //PLANO ATUAL
        $obPlano = $request->Plano;
        return [
            'id' => (int)$obPlano->id,
            'descricaoPlano' => $obPlano->descricaoPlano,
            'valorPlano' => $obPlano->valorPlano,
            'detalhePlano' => $obPlano->detalhePlano
        ];
    }

    /**
     * Método responsável por adicionar novo plano
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewPlano($request){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoPlano']) or !isset($postVars['valorPlano'])) {
            throw new \Exception("Os campos 'descricao' e 'valor' são obrigatórios", 400);
        }

        //CADASTRA NOVO PLANO
        $obPlano = new EntityPlano;
        $obPlano->descricaoPlano = $postVars['descricaoPlano'];
        $obPlano->valorPlano = $postVars['valorPlano'];
        $obPlano->detalhePlano = $postVars['detalhePlano'];
        $obPlano->cadastrar();

        return [
            'id' => (int)$obPlano->id,
            'descricaoPlano' => $obPlano->descricaoPlano,
            'valorPlano' => $obPlano->valorPlano,
            'detalhePlano' => $obPlano->detalhePlano
        ];
    }

    /**
     * Método responsável por atualizar um plano
     *
     * @param [type] $request
     * @param integer $id
     * @return array
     */
    public static function setEditPlano($request, $id){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoPlano']) or !isset($postVars['valorPlano'])) {
            throw new \Exception("Os campos 'descricao' e 'valor' são obrigatórios", 400);
        }

        //BUSCA PLANO
        $obPlano = EntityPlano::getPlanoById($id);

        //VALIDA PLANO
        if (!$obPlano instanceof EntityPlano) {
            throw new \Exception("O plano ". $id. " Não foi encontrado", 404);
        }

       //ATUALIZA PLANO
        $obPlano->descricaoPlano = $postVars['descricaoPlano'];
        $obPlano->valorPlano = $postVars['valorPlano'];
        $obPlano->detalhePlano = $postVars['detalhePlano'];
        $obPlano->atualizar();

        return [
            'id' => (int)$obPlano->id,
            'descricaoPlano' => $obPlano->descricaoPlano,
            'valorPlano' => $obPlano->valorPlano,
            'detalhePlano' => $obPlano->detalhePlano
        ];
    }

    /**
     * Método responsável por excluir um plano
     */
    public static function setDeletePlano($request, $id){

        //BUSCA PLANO NO BANCO
        $obPlano = EntityPlano::getPlanoById($id);

        //VALIDA INSTANCIA
        if (!$obPlano instanceof EntityPlano) {
            throw new \Exception("O plano ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR PLANO
        $obPlano->excluir();

        return [
            'sucesso' => true
        ];
    }
}
