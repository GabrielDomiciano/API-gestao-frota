<?php

namespace App\Controller\Api;

use \App\Model\Entity\Pagamento as EntityPagamento;
use \WilliamCosta\DatabaseManager\Pagination;

class Pagamento extends Api{
    /**
     * Método responsável por mostrar cada item do Pagamento
     *
     */
    private static function getPagamentoItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityPagamento::getPagamentos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 500);
        $results = EntityPagamento::getPagamentos(null, 'id ASC', $obPagination->getLimit());

        while($obPagamento = $results->fetchObject(EntityPagamento::class)){

            $itens[] =  [
                'id' => (int)$obPagamento->id,
                'descricao' => $obPagamento->descricao,
                'codigoTransacao' => $obPagamento->codigoTransacao,
                'tipo' => $obPagamento->tipo,
                'idPlano' => $obPagamento->idPlano,
                'idEmpresa' => $obPagamento->idEmpresa,
                'dataPagamento' => $obPagamento->dataPagamento,
                'valor' => $obPagamento->valor,
                'status' => $obPagamento->status,
                'dataVencimento' => $obPagamento->dataVencimento,
                'usuario' => $obPagamento->usuario
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos usuários
     *
     */
    public static function getPagamentos($request){
        return [
            'Pagamentos' => self::getPagamentoItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um usuário
     *
     */
    public static function getPagamento($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA Pagamento
        $obPagamento = EntityPagamento::getPagamentoById($id);

        if (!$obPagamento instanceof EntityPagamento) {
            throw new \Exception("O Pagamento ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obPagamento->id,
            'descricao' => $obPagamento->descricao,
            'codigoTransacao' => $obPagamento->codigoTransacao,
            'tipo' => $obPagamento->tipo,
            'idPlano' => $obPagamento->idPlano,
            'idEmpresa' => $obPagamento->idEmpresa,
            'dataPagamento' => $obPagamento->dataPagamento,
            'valor' => $obPagamento->valor,
            'status' => $obPagamento->status,
            'dataVencimento' => $obPagamento->dataVencimento,
            'usuario' => $obPagamento->usuario
        ];
    }

    // -------------------------------------------------------- -------------------------------------------------------------
    /**
     * Método responsável por adicionar novo Pagamento
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewPagamento($request){
        $postVars = $request->getPostVars();

        //CADASTRA NOVO Pagamento
        $obPagamento = new EntityPagamento;
        $obPagamento->descricao = $postVars['descricao'];
        $obPagamento->codigoTransacao = $postVars['codigoTransacao'];
        $obPagamento->tipo = $postVars['tipo'];
        $obPagamento->idPlano = $postVars['idPlano'];
        $obPagamento->idEmpresa = $postVars['idEmpresa'];
        $obPagamento->dataPagamento = $postVars['dataPagamento'];
        $obPagamento->valor = $postVars['valor'];
        $obPagamento->status = $postVars['status'];   
        $obPagamento->dataVencimento = $postVars['dataVencimento'];
        $obPagamento->usuario = $postVars['usuario'];    
        $obPagamento->cadastrar();

        return [
            'id' => (int)$obPagamento->id,
            'descricao' => $obPagamento->descricao,
            'codigoTransacao' => $obPagamento->codigoTransacao,
            'tipo' => $obPagamento->tipo,
            'idPlano' => $obPagamento->idPlano,
            'idEmpresa' => $obPagamento->idEmpresa,
            'dataPagamento' => $obPagamento->dataPagamento,
            'valor' => $obPagamento->valor,
            'status' => $obPagamento->status,
            'dataVencimento' => $obPagamento->dataVencimento,
            'usuario' => $obPagamento->usuario
        ];
    }

    public static function setEditPagamento($request, $id){
        $postVars = $request->getPostVars();

        //BUSCA PAGAMENTO
        $obPagamento = EntityPagamento::getPagamentoById($id);

        //VALIDA PAGAMENTO
        if (!$obPagamento instanceof EntityPagamento) {
            throw new \Exception("O PAGAMENTO ". $id. " Não foi encontrado", 404);
        }

        //ATUALIZA PAGAMENTO
        $obPagamento->descricao = $postVars['descricao'];
        $obPagamento->codigoTransacao = $postVars['codigoTransacao'];
        $obPagamento->tipo = $postVars['tipo'];
        $obPagamento->idPlano = $postVars['idPlano'];
        $obPagamento->idEmpresa = $postVars['idEmpresa'];
        $obPagamento->dataPagamento = $postVars['dataPagamento'];
        $obPagamento->valor = $postVars['valor'];
        $obPagamento->status = $postVars['status'];   
        $obPagamento->dataVencimento = $postVars['dataVencimento'];
        $obPagamento->usuario = $postVars['usuario']; 
        $obPagamento->atualizar();

        return [
            'id' => (int)$obPagamento->id,
            'descricao' => $obPagamento->descricao,
            'codigoTransacao' => $obPagamento->codigoTransacao,
            'tipo' => $obPagamento->tipo,
            'idPlano' => $obPagamento->idPlano,
            'idEmpresa' => $obPagamento->idEmpresa,
            'dataPagamento' => $obPagamento->dataPagamento,
            'valor' => $obPagamento->valor,
            'status' => $obPagamento->status,
            'dataVencimento' => $obPagamento->dataVencimento,
            'usuario' => $obPagamento->usuario
        ];
    }
    
    /**
     * Método responsável por excluir um Pagamento
     */
    public static function setDeletePagamento($request, $id){

        //BUSCA Pagamento NO BANCO
        $obPagamento = EntityPagamento::getPagamentoById($id);

        //VALIDA INSTANCIA
        if (!$obPagamento instanceof EntityPagamento) {
            throw new \Exception("O PAGAMENTO ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR Pagamento
        $obPagamento->excluir();

        return [
            'sucesso' => 'Pagamento excluído com sucesso'
        ];
    }
}