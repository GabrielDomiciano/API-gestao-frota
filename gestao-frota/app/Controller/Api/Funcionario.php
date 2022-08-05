<?php

namespace App\Controller\Api;

use \App\Model\Entity\Funcionario as EntityFuncionario;
use \WilliamCosta\DatabaseManager\Pagination;

class Funcionario extends Api{
    /**
     * Método responsável por mostrar cada item do Funcionario
     *
     */
    private static function getFuncionarioItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityFuncionario::getFuncionarios(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);
        $results = EntityFuncionario::getFuncionarios(null, 'id ASC', $obPagination->getLimit());

        while($obFuncionario = $results->fetchObject(EntityFuncionario::class)){

            $itens[] =  [
                'id' => (int)$obFuncionario->id,
                'nome' => $obFuncionario->nome,
                'telefone' => $obFuncionario->telefone,
                'email' => $obFuncionario->email,
                'idEmpresa' => $obFuncionario->idEmpresa
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos os Funcionarios
     *
     */
    public static function getFuncionarios($request){
        return [
            'funcionarios' => self::getFuncionarioItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um Funcionario
     *
     */
    public static function getFuncionario($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA Funcionario
        $obFuncionario = EntityFuncionario::getFuncionarioById($id);

        if (!$obFuncionario instanceof EntityFuncionario) {
            throw new \Exception("O Funcionario ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obFuncionario->id,
            'nome' => $obFuncionario->nome,
            'telefone' => $obFuncionario->telefone,
            'email' => $obFuncionario->email,
            'idEmpresa' => $obFuncionario->idEmpresa
        ];
    }

    public static function getCurrentFuncionario($request){
        //Funcionario ATUAL
        $obFuncionario = $request->Funcionario;
        return [
            'id' => (int)$obFuncionario->id,
            'nome' => $obFuncionario->nome,
            'telefone' => $obFuncionario->telefone,
            'email' => $obFuncionario->email,
            'idEmpresa' => $obFuncionario->idEmpresa
        ];
    }

    /**
     * Método responsável por adicionar novo Funcionario
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewFuncionario($request){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['nome']) or !isset($postVars['telefone'])) {
            throw new \Exception("Os campos 'descricao' e 'valor' são obrigatórios", 400);
        }

        //CADASTRA NOVO Funcionario
        $obFuncionario = new EntityFuncionario;
        $obFuncionario->nome = $postVars['nome'];
        $obFuncionario->telefone = $postVars['telefone'];
        $obFuncionario->email = $postVars['email'];
        $obFuncionario->idEmpresa = $postVars['idEmpresa'];
        $obFuncionario->cadastrar();

        return [
            'id' => (int)$obFuncionario->id,
            'nome' => $obFuncionario->nome,
            'telefone' => $obFuncionario->telefone,
            'email' => $obFuncionario->email,
            'idEmpresa' => $obFuncionario->idEmpresa
        ];
    }

    /**
     * Método responsável por atualizar um Funcionario
     *
     * @param [type] $request
     * @param integer $id
     * @return array
     */
    public static function setEditFuncionario($request, $id){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['nome']) or !isset($postVars['telefone'])) {
            throw new \Exception("Os campos 'descricao' e 'valor' são obrigatórios", 400);
        }

        //BUSCA Funcionario
        $obFuncionario = EntityFuncionario::getFuncionarioById($id);

        //VALIDA Funcionario
        if (!$obFuncionario instanceof EntityFuncionario) {
            throw new \Exception("O Funcionario ". $id. " Não foi encontrado", 404);
        }

       //ATUALIZA Funcionario
        $obFuncionario->nome = $postVars['nome'];
        $obFuncionario->telefone = $postVars['telefone'];
        $obFuncionario->email = $postVars['email'];
        $obFuncionario->idEmpresa = $postVars['idEmpresa'];
        $obFuncionario->atualizar();

        return [
            'id' => (int)$obFuncionario->id,
            'nome' => $obFuncionario->nome,
            'telefone' => $obFuncionario->telefone,
            'email' => $obFuncionario->email,
            'idEmpresa' => $obFuncionario->idEmpresa
        ];
    }

    /**
     * Método responsável por excluir um Funcionario
     */
    public static function setDeleteFuncionario($request, $id){

        //BUSCA Funcionario NO BANCO
        $obFuncionario = EntityFuncionario::getFuncionarioById($id);

        //VALIDA INSTANCIA
        if (!$obFuncionario instanceof EntityFuncionario) {
            throw new \Exception("O Funcionario ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR Funcionario
        $obFuncionario->excluir();

        return [
            'sucesso' => true
        ];
    }
}
