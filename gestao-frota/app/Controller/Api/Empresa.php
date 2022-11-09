<?php

namespace App\Controller\Api;

use \App\Model\Entity\Empresa as EntityEmpresa;
use \WilliamCosta\DatabaseManager\Pagination;

class Empresa extends Api{
    /**
     * Método responsável por mostrar cada item do Empresa
     *
     */
    private static function getEmpresaItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityEmpresa::getEmpresas(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 500);
        $results = EntityEmpresa::getEmpresas(null, 'id ASC', $obPagination->getLimit());

        while($obEmpresa = $results->fetchObject(EntityEmpresa::class)){

            $itens[] =  [
                'id' => (int)$obEmpresa->id,
                'descricaoEmpresa' => $obEmpresa->descricaoEmpresa,
                'cnpjEmpresa' => $obEmpresa->cnpjEmpresa,
                'localizacaoEmpresa' => $obEmpresa->localizacaoEmpresa,
                'qtdFuncionarioEmpresa' => $obEmpresa->qtdFuncionarioEmpresa,
                'idStatus' =>  $obEmpresa->idStatus
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos os Empresas
     *
     */
    public static function getEmpresas($request){
        return [
            'empresas' => self::getEmpresaItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um Empresa
     *
     */
    public static function getEmpresa($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA Empresa
        $obEmpresa = EntityEmpresa::getEmpresaById($id);

        if (!$obEmpresa instanceof EntityEmpresa) {
            throw new \Exception("A Empresa ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obEmpresa->id,
            'descricaoEmpresa' => $obEmpresa->descricaoEmpresa,
            'cnpjEmpresa' => $obEmpresa->cnpjEmpresa,
            'localizacaoEmpresa' => $obEmpresa->localizacaoEmpresa,
            'qtdFuncionarioEmpresa' => $obEmpresa->qtdFuncionarioEmpresa,
            'idStatus' =>  $obEmpresa->idStatus
        ];
    }

    public static function getCurrentEmpresa($request){
        //Empresa ATUAL
        $obEmpresa = $request->Empresa;
        return [
            'id' => (int)$obEmpresa->id,
            'descricaoEmpresa' => $obEmpresa->descricaoEmpresa,
            'cnpjEmpresa' => $obEmpresa->cnpjEmpresa,
            'localizacaoEmpresa' => $obEmpresa->localizacaoEmpresa,
            'qtdFuncionarioEmpresa' => $obEmpresa->qtdFuncionarioEmpresa,
            'idStatus' =>  $obEmpresa->idStatus
        ];
    }

    /**
     * Método responsável por adicionar novo Empresa
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewEmpresa($request){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoEmpresa']) or !isset($postVars['cnpjEmpresa'])) {
            throw new \Exception("Os campos 'descricao' e 'cnpj' são obrigatórios", 400);
        }

        //CADASTRA NOVO Empresa
        $obEmpresa = new EntityEmpresa;
        $obEmpresa->descricaoEmpresa = $postVars['descricaoEmpresa'];
        $obEmpresa->cnpjEmpresa = $postVars['cnpjEmpresa'];
        $obEmpresa->localizacaoEmpresa = $postVars['localizacaoEmpresa'];
        $obEmpresa->qtdFuncionarioEmpresa = $postVars['qtdFuncionarioEmpresa'];
        //SETO O STATUS DA EMPRESA COMO PENDENTE (PRECISA DO ADMIN APROVAR A EMPRESA)
        // 3 = PENDENTE
        $obEmpresa->idStatus = 3;
        $obEmpresa->cadastrar();

        return [
            'id' => (int)$obEmpresa->id,
            'descricaoEmpresa' => $obEmpresa->descricaoEmpresa,
            'cnpjEmpresa' => $obEmpresa->cnpjEmpresa,
            'localizacaoEmpresa' => $obEmpresa->localizacaoEmpresa,
            'qtdFuncionarioEmpresa' => $obEmpresa->qtdFuncionarioEmpresa,
            'idStatus' =>  $obEmpresa->idStatus
        ];
    }

    /**
     * Método responsável por atualizar um Empresa
     *
     * @param [type] $request
     * @param integer $id
     * @return array
     */
    public static function setEditEmpresa($request, $id){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoEmpresa']) or !isset($postVars['cnpjEmpresa'])) {
            throw new \Exception("Os campos 'descricao', 'cnpj' e 'idStatus' são obrigatórios", 400);
        }

        //BUSCA Empresa
        $obEmpresa = EntityEmpresa::getEmpresaById($id);

        //VALIDA Empresa
        if (!$obEmpresa instanceof EntityEmpresa) {
            throw new \Exception("A Empresa ". $id. " Não foi encontrada", 404);
        }

       //ATUALIZA Empresa
        $obEmpresa->descricaoEmpresa = $postVars['descricaoEmpresa'];
        $obEmpresa->cnpjEmpresa = $postVars['cnpjEmpresa'];
        $obEmpresa->localizacaoEmpresa = $postVars['localizacaoEmpresa'];
        $obEmpresa->qtdFuncionarioEmpresa = $postVars['qtdFuncionarioEmpresa'];
        $obEmpresa->atualizar();

        return [
            'id' => (int)$obEmpresa->id,
            'descricaoEmpresa' => $obEmpresa->descricaoEmpresa,
            'cnpjEmpresa' => $obEmpresa->cnpjEmpresa,
            'localizacaoEmpresa' => $obEmpresa->localizacaoEmpresa,
            'qtdFuncionarioEmpresa' => $obEmpresa->qtdFuncionarioEmpresa,
            'idStatus' =>  $obEmpresa->idStatus
        ];
    }

    /**
     * Método responsável por excluir um Empresa
     */
    public static function setDeleteEmpresa($request, $id){

        //BUSCA Empresa NO BANCO
        $obEmpresa = EntityEmpresa::getEmpresaById($id);

        //VALIDA INSTANCIA
        if (!$obEmpresa instanceof EntityEmpresa) {
            throw new \Exception("A Empresa ". $id. " Não foi encontrada", 404);          
        }

        //EXCLUIR Empresa
        $obEmpresa->excluir();

        return [
            'sucesso' => true
        ];
    }

    /**
     * Método responsável por atualizar Status de 1 usuário
     * [ADMIN]
     *
     * @param [type] $request
     * @param integer $id
     * @return integer
     */
    public static function atualizarStatus($request, $id) {
         $postVars = $request->getPostVars();
         //BUSCA Empresa NO BANCO
         $obEmpresa = EntityEmpresa::getEmpresaById($id);

         //VALIDA INSTANCIA
        if (!$obEmpresa instanceof EntityEmpresa) {
            throw new \Exception("A Empresa ". $id. " Não foi encontrado", 404);          
        }

        //VERIFICA SE O CAMPO NÃO VEM NULO OU COM NOME ERRADO
        if($postVars['idStatus'] > 0 ) {
            $obEmpresa->idStatus = $postVars['idStatus'];
            $obEmpresa->alterarStatus();
        }
        else{
            throw new \Exception("Por favor, insira um ID ou Parâmetro válido", 404);
        }

        //RETORNA O STATUS
         return [
            'idStatus' =>  $obEmpresa->idStatus
        ];
    }
}
