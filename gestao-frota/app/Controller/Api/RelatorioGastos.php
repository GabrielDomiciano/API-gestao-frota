<?php

namespace App\Controller\Api;

use \App\Model\Entity\RelatorioGastos as EntityRelatorioGastos;
use \WilliamCosta\DatabaseManager\Pagination;

class RelatorioGastos extends Api{
    /**
     * Método responsável por mostrar cada item do relatorio
     *
     */
    private static function getRelatorioGastosItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityRelatorioGastos::getRelatoriosGastos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);
        $results = EntityRelatorioGastos::getRelatoriosGastos(null, 'id ASC', $obPagination->getLimit());

        while($obRelatorioGastos = $results->fetchObject(EntityRelatorioGastos::class)){

            $itens[] =  [
                'gastosDiarios' => $obRelatorioGastos->gastosDiarios,
                'gastosSemanais' => $obRelatorioGastos->gastosSemanais,
                'gastosMensais' => $obRelatorioGastos->gastosMensais,
                'gastosAnuais' => $obRelatorioGastos->gastosAnuais,
                'mediaVeiculo' => $obRelatorioGastos->mediaVeiculo,
                'qtdViagens' => $obRelatorioGastos->qtdViagens,
                'kmRodado' => $obRelatorioGastos->kmRodado,
                'dataHora' => $obRelatorioGastos->dataHora,
                'idUsuario' => $obRelatorioGastos->idUsuario,
                'idVeiculo' => $obRelatorioGastos->idVeiculo,
                'idFuncionario' => $obRelatorioGastos->idFuncionario
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos relatorios de gastos
     *
     */
    public static function getRelatoriosGastos($request){
        return [
            'relatorios' => self::getRelatorioGastosItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um usuário
     *
     */
    public static function getRelatorioGastos($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA VEICULO
        $obRelatorioGastos = EntityRelatorioGastos::getRelatorioGastosById($id);

        if (!$obRelatorioGastos instanceof EntityRelatorioGastos) {
            throw new \Exception("O relatório de gastos ". $id. " Não foi encontrado", 404);
        }

        return [
            'gastosDiarios' => $obRelatorioGastos->gastosDiarios,
            'gastosSemanais' => $obRelatorioGastos->gastosSemanais,
            'gastosMensais' => $obRelatorioGastos->gastosMensais,
            'gastosAnuais' => $obRelatorioGastos->gastosAnuais,
            'mediaVeiculo' => $obRelatorioGastos->mediaVeiculo,
            'qtdViagens' => $obRelatorioGastos->qtdViagens,
            'kmRodado' => $obRelatorioGastos->kmRodado,
            'dataHora' => $obRelatorioGastos->dataHora,
            'idUsuario' => $obRelatorioGastos->idUsuario,
            'idVeiculo' => $obRelatorioGastos->idVeiculo,
            'idFuncionario' => $obRelatorioGastos->idFuncionario
        ];
    }


    // -------------------------------------------------------- -------------------------------------------------------------
    /**
     * Método responsável por adicionar novo veiculo
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewRelatorioGastos($request){
        $postVars = $request->getPostVars();

        //CADASTRA NOVO RELATORIO
        $obRelatorioGastos = new EntityRelatorioGastos;
        $obRelatorioGastos->gastosDiarios = $postVars['gastosDiarios'];
        $obRelatorioGastos->gastosSemanais = $postVars['gastosSemanais'];
        $obRelatorioGastos->gastosMensais = $postVars['gastosMensais'];
        $obRelatorioGastos->gastosAnuais = $postVars['gastosAnuais'];
        $obRelatorioGastos->mediaVeiculo = $postVars['mediaVeiculo'];
        $obRelatorioGastos->qtdViagens = $postVars['qtdViagens'];
        $obRelatorioGastos->kmRodado = $postVars['kmRodado'];
        $obRelatorioGastos->dataHora = $postVars['dataHora'];   
        $obRelatorioGastos->idUsuario = $postVars['idUsuario'];
        $obRelatorioGastos->idVeiculo = $postVars['idVeiculo'];
        $obRelatorioGastos->idFuncionario = $postVars['idFuncionario'];

       
        $obRelatorioGastos->cadastrar();

        return [
            'gastosDiarios' => $obRelatorioGastos->gastosDiarios,
            'gastosSemanais' => $obRelatorioGastos->gastosSemanais,
            'gastosMensais' => $obRelatorioGastos->gastosMensais,
            'gastosAnuais' => $obRelatorioGastos->gastosAnuais,
            'mediaVeiculo' => $obRelatorioGastos->mediaVeiculo,
            'qtdViagens' => $obRelatorioGastos->qtdViagens,
            'kmRodado' => $obRelatorioGastos->kmRodado,
            'dataHora' => $obRelatorioGastos->dataHora,
            'idUsuario' => $obRelatorioGastos->idUsuario,
            'idVeiculo' => $obRelatorioGastos->idVeiculo,
            'idFuncionario' => $obRelatorioGastos->idFuncionario
        ];
    }

    public static function setEditRelatorioGastos($request, $id){
        $postVars = $request->getPostVars();

        //BUSCA VEÍCULO
        $obRelatorioGastos = EntityRelatorioGastos::getRelatorioGastosById($id);

        //VALIDA VEÍCULO
        if (!$obRelatorioGastos instanceof EntityRelatorioGastos) {
            throw new \Exception("O relatório de gastos ". $id. " Não foi encontrado", 404);
        }

        //ATUALIZA VEÍCULO
        $obRelatorioGastos->gastosDiarios = $postVars['gastosDiarios'];
        $obRelatorioGastos->gastosSemanais = $postVars['gastosSemanais'];
        $obRelatorioGastos->gastosMensais = $postVars['gastosMensais'];
        $obRelatorioGastos->gastosAnuais = $postVars['gastosAnuais'];
        $obRelatorioGastos->mediaVeiculo = $postVars['mediaVeiculo'];
        $obRelatorioGastos->qtdViagens = $postVars['qtdViagens'];
        $obRelatorioGastos->kmRodado = $postVars['kmRodado'];
        $obRelatorioGastos->dataHora = $postVars['dataHora'];   
        $obRelatorioGastos->idUsuario = $postVars['idUsuario'];
        $obRelatorioGastos->idVeiculo = $postVars['idVeiculo'];
        $obRelatorioGastos->idFuncionario = $postVars['idFuncionario'];
        $obRelatorioGastos->atualizar();

        return [
            'gastosDiarios' => $obRelatorioGastos->gastosDiarios,
            'gastosSemanais' => $obRelatorioGastos->gastosSemanais,
            'gastosMensais' => $obRelatorioGastos->gastosMensais,
            'gastosAnuais' => $obRelatorioGastos->gastosAnuais,
            'mediaVeiculo' => $obRelatorioGastos->mediaVeiculo,
            'qtdViagens' => $obRelatorioGastos->qtdViagens,
            'kmRodado' => $obRelatorioGastos->kmRodado,
            'dataHora' => $obRelatorioGastos->dataHora,
            'idUsuario' => $obRelatorioGastos->idUsuario,
            'idVeiculo' => $obRelatorioGastos->idVeiculo,
            'idFuncionario' => $obRelatorioGastos->idFuncionario
        ];
    }
    
    /**
     * Método responsável por excluir um veiculo
     */
    public static function setDeleteRelatorioGastos($request, $id){

        //BUSCA VEICULO NO BANCO
        $obRelatorioGastos = EntityRelatorioGastos::getRelatorioGastosById($id);

        //VALIDA INSTANCIA
        if (!$obRelatorioGastos instanceof EntityRelatorioGastos) {
            throw new \Exception("O relatório de gastos ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR VEICULO
        $obRelatorioGastos->excluir();

        return [
            'sucesso' => 'Relatório de Gastos excluído com sucesso'
        ];
    }
}