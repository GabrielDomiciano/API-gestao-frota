<?php

namespace App\Controller\Api;

use \App\Model\Entity\TipoAlerta as EntityAlerta;
use \WilliamCosta\DatabaseManager\Pagination;

class TipoAlerta extends Api{
    /**
     * Método responsável por mostrar cada item da Alerta
     *
     */
    private static function getAlertaItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityAlerta::getAlertas(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 500);
        $results = EntityAlerta::getAlertas(null, 'id ASC', $obPagination->getLimit());

        while($obAlerta = $results->fetchObject(EntityAlerta::class)){

            $itens[] =  [
                'id' => (int)$obAlerta->id,
                'descricaoAlerta' => $obAlerta->descricaoAlerta,
                'tipoEnvio' => $obAlerta->tipoEnvio,
                'detalhes' => $obAlerta->detalhes,
                'data' => $obAlerta->data
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos os alertas
     *
     */
    public static function getAlertas($request){
        return [
            'alertas' => self::getAlertaItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um Alerta
     *
     */
    public static function getAlerta($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA Alerta
        $obAlerta = EntityAlerta::getAlertaById($id);

        if (!$obAlerta instanceof EntityAlerta) {
            throw new \Exception("O Alerta ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obAlerta->id,
            'descricaoAlerta' => $obAlerta->descricaoAlerta,
            'tipoEnvio' => $obAlerta->tipoEnvio,
            'detalhes' => $obAlerta->detalhes,
            'data' => $obAlerta->data
        ];
    }


    // -------------------------------------------------------- -------------------------------------------------------------
    /**
     * Método responsável por adicionar nova Alerta
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewAlerta($request){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['tipoEnvio'])) {
            throw new \Exception("O campo 'tipoEnvio' é obrigatório", 400);
        }

        //CADASTRA NOVO Alerta
        $obAlerta = new EntityAlerta;
        $obAlerta->descricaoAlerta = $postVars['descricaoAlerta'];
        $obAlerta->tipoEnvio = $postVars['tipoEnvio'];
        $obAlerta->detalhes = $postVars['detalhes'];
        $obAlerta->data = $postVars['data'];
        
       
        $obAlerta->cadastrar();

        return [
            'id' => (int)$obAlerta->id,
            'descricaoAlerta' => $obAlerta->descricaoAlerta,
            'tipoEnvio' => $obAlerta->tipoEnvio,
            'detalhes' => $obAlerta->detalhes,
            'data' => $obAlerta->data
        ];
    }

    public static function setEditAlerta($request, $id){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['tipoEnvio'])) {
            throw new \Exception("O campo 'tipoEnvio' é obrigatório", 400);
        }

        //BUSCA Alerta
        $obAlerta = EntityAlerta::getAlertaById($id);

        //VALIDA Alerta
        if (!$obAlerta instanceof EntityAlerta) {
            throw new \Exception("O Alerta ". $id. " Não foi encontrado", 404);
        }

        //ATUALIZA Alerta
        $obAlerta->descricaoAlerta = $postVars['descricaoAlerta'];
        $obAlerta->tipoEnvio = $postVars['tipoEnvio'];
        $obAlerta->detalhes = $postVars['detalhes'];
        $obAlerta->data = $postVars['data'];
        $obAlerta->atualizar();

        return [
            'id' => (int)$obAlerta->id,
            'descricaoAlerta' => $obAlerta->descricaoAlerta,
            'tipoEnvio' => $obAlerta->tipoEnvio,
            'detalhes' => $obAlerta->detalhes,
            'data' => $obAlerta->data
        ];
    }
    
    /**
     * Método responsável por excluir uma Alerta
     */
    public static function setDeleteAlerta($request, $id){

        //BUSCA Alerta NO BANCO
        $obAlerta = EntityAlerta::getAlertaById($id);

        //VALIDA INSTANCIA
        if (!$obAlerta instanceof EntityAlerta) {
            throw new \Exception("O Alerta ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR Alerta
        $obAlerta->excluir();

        return [
            'sucesso' => 'Alerta excluído com sucesso'
        ];
    }
}