<?php

namespace App\Controller\Api;

use \App\Model\Entity\Monitoramento as EntityMonitoramento;
use \WilliamCosta\DatabaseManager\Pagination;


class Monitoramento extends Api{
    /**
     * Método responsável por mostrar cada item da Monitoramento
     *
     */
    private static function getMonitoramentoItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityMonitoramento::getMonitoramentos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 500);
        $results = EntityMonitoramento::getMonitoramentos(null, 'id ASC', $obPagination->getLimit());

        while($obMonitoramento = $results->fetchObject(EntityMonitoramento::class)){

            $itens[] =  [
                'id' => (int)$obMonitoramento->id,
                'mediaKmDia' => $obMonitoramento->mediaKmDia,
                'mediaGastoKm' => $obMonitoramento->mediaGastoKm,
                'emiteAlerta' => $obMonitoramento->emiteAlerta,
                'kmUltimaRevisao' => $obMonitoramento->kmUltimaRevisao,
                'configMsg' => $obMonitoramento->configMsg,
                'periodo' => $obMonitoramento->periodo,
                'mensagem' => $obMonitoramento->mensagem,
                'dataHora' => $obMonitoramento->dataHora,
                'idUsuario' => $obMonitoramento->idUsuario,
                'idViagem' => $obMonitoramento->idViagem,
                'idTipoAlerta' => $obMonitoramento->idTipoAlerta
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todas as Monitoramentos
     *
     */
    public static function getMonitoramentos($request){
        return [
            'monitoramentos' => self::getMonitoramentoItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar uma Monitoramento
     *
     */
    public static function getMonitoramento($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA Monitoramento
        $obMonitoramento = EntityMonitoramento::getMonitoramentoById($id);

        if (!$obMonitoramento instanceof EntityMonitoramento) {
            throw new \Exception("O Monitoramento ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obMonitoramento->id,
            'mediaKmDia' => $obMonitoramento->mediaKmDia,
            'mediaGastoKm' => $obMonitoramento->mediaGastoKm,
            'emiteAlerta' => $obMonitoramento->emiteAlerta,
            'kmUltimaRevisao' => $obMonitoramento->kmUltimaRevisao,
            'configMsg' => $obMonitoramento->configMsg,
            'periodo' => $obMonitoramento->periodo,
            'mensagem' => $obMonitoramento->mensagem,
            'dataHora' => $obMonitoramento->dataHora,
            'idUsuario' => $obMonitoramento->idUsuario,
            'idViagem' => $obMonitoramento->idViagem,
            'idTipoAlerta' => $obMonitoramento->idTipoAlerta
        ];
    }

    public static function getCurrentMonitoramento($request){
        //Monitoramento ATUAL
        $obMonitoramento = $request->Monitoramento;
        return [
            'id' => (int)$obMonitoramento->id,
            'mediaKmDia' => $obMonitoramento->mediaKmDia,
            'mediaGastoKm' => $obMonitoramento->mediaGastoKm,
            'emiteAlerta' => $obMonitoramento->emiteAlerta,
            'kmUltimaRevisao' => $obMonitoramento->kmUltimaRevisao,
            'configMsg' => $obMonitoramento->configMsg,
            'periodo' => $obMonitoramento->periodo,
            'mensagem' => $obMonitoramento->mensagem,
            'dataHora' => $obMonitoramento->dataHora,
            'idUsuario' => $obMonitoramento->idUsuario,
            'idViagem' => $obMonitoramento->idViagem,
            'idTipoAlerta' => $obMonitoramento->idTipoAlerta
        ];
    }

    // -------------------------------------------------------- -------------------------------------------------------------
    /**
     * Método responsável por adicionar nova Monitoramento
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewMonitoramento($request){
        $postVars = $request->getPostVars();

        //CADASTRA NOVO MONITORAMENTO
        $obMonitoramento = new EntityMonitoramento;
        $obMonitoramento->mediaKmDia = $postVars['mediaKmDia'];
        $obMonitoramento->mediaGastoKm = $postVars['mediaGastoKm'];
        $obMonitoramento->emiteAlerta = $postVars['emiteAlerta'];
        $obMonitoramento->kmUltimaRevisao = $postVars['kmUltimaRevisao'];
        $obMonitoramento->configMsg = $postVars['configMsg'];
        $obMonitoramento->periodo = $postVars['periodo'];
        $obMonitoramento->mensagem = $postVars['mensagem'];
        $obMonitoramento->dataHora = $postVars['dataHora'];
        $obMonitoramento->idUsuario = $postVars['idUsuario'];
        $obMonitoramento->idViagem = $postVars['idViagem'];
        $obMonitoramento->idTipoAlerta = $postVars['idTipoAlerta'];

       
        $obMonitoramento->cadastrar();

        return [
            'id' => (int)$obMonitoramento->id,
            'mediaKmDia' => $obMonitoramento->mediaKmDia,
            'mediaGastoKm' => $obMonitoramento->mediaGastoKm,
            'emiteAlerta' => $obMonitoramento->emiteAlerta,
            'kmUltimaRevisao' => $obMonitoramento->kmUltimaRevisao,
            'configMsg' => $obMonitoramento->configMsg,
            'periodo' => $obMonitoramento->periodo,
            'mensagem' => $obMonitoramento->mensagem,
            'dataHora' => $obMonitoramento->dataHora,
            'idUsuario' => $obMonitoramento->idUsuario,
            'idViagem' => $obMonitoramento->idViagem,
            'idTipoAlerta' => $obMonitoramento->idTipoAlerta,
        ];
    }

    public static function setEditMonitoramento($request, $id){
        $postVars = $request->getPostVars();

        //BUSCA Monitoramento
        $obMonitoramento = EntityMonitoramento::getMonitoramentoById($id);

        //VALIDA Monitoramento
        if (!$obMonitoramento instanceof EntityMonitoramento) {
            throw new \Exception("O Monitoramento ". $id. " Não foi encontrado", 404);
        }

        //ATUALIZA Monitoramento
        $obMonitoramento->mediaKmDia = $postVars['mediaKmDia'];
        $obMonitoramento->mediaGastoKm = $postVars['mediaGastoKm'];
        $obMonitoramento->emiteAlerta = $postVars['emiteAlerta'];
        $obMonitoramento->kmUltimaRevisao = $postVars['kmUltimaRevisao'];
        $obMonitoramento->configMsg = $postVars['configMsg'];
        $obMonitoramento->periodo = $postVars['periodo'];
        $obMonitoramento->mensagem = $postVars['mensagem'];
        $obMonitoramento->dataHora = $postVars['dataHora'];
        $obMonitoramento->idUsuario = $postVars['idUsuario'];
        $obMonitoramento->idViagem = $postVars['idViagem'];
        $obMonitoramento->idTipoAlerta = $postVars['idTipoAlerta'];
        $obMonitoramento->atualizar();

        return [
            'id' => (int)$obMonitoramento->id,
            'mediaKmDia' => $obMonitoramento->mediaKmDia,
            'mediaGastoKm' => $obMonitoramento->mediaGastoKm,
            'emiteAlerta' => $obMonitoramento->emiteAlerta,
            'kmUltimaRevisao' => $obMonitoramento->kmUltimaRevisao,
            'configMsg' => $obMonitoramento->configMsg,
            'periodo' => $obMonitoramento->periodo,
            'mensagem' => $obMonitoramento->mensagem,
            'dataHora' => $obMonitoramento->dataHora,
            'idUsuario' => $obMonitoramento->idUsuario,
            'idViagem' => $obMonitoramento->idViagem,
            'idTipoAlerta' => $obMonitoramento->idTipoAlerta,
        ];
    }
    
    /**
     * Método responsável por excluir uma Monitoramento
     */
    public static function setDeleteMonitoramento($request, $id){

        //BUSCA Monitoramento NO BANCO
        $obMonitoramento = EntityMonitoramento::getMonitoramentoById($id);

        //VALIDA INSTANCIA
        if (!$obMonitoramento instanceof EntityMonitoramento) {
            throw new \Exception("O Monitoramento ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR Monitoramento
        $obMonitoramento->excluir();

        return [
            'sucesso' => 'Monitoramento excluído com sucesso'
        ];
    }

    public static function getMediaGasto($request, $id) {
        $results = EntityMonitoramento::getMediaGasto($id);
        $obMonitoramento = $results->fetchObject(EntityMonitoramento::class);

        return [
            'mediaGasto' => $obMonitoramento->mediaGasto,
            'mediaKmDia' => $obMonitoramento->mediaKmDia,
            'idVeiculo' => $obMonitoramento->idVeiculo,
            'descricaoVeiculo' => $obMonitoramento->descricaoVeiculo,
        ];
    }
}