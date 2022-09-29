<?php

namespace App\Controller\Api;

use \App\Model\Entity\Mensagem as EntityMensagem;
use \WilliamCosta\DatabaseManager\Pagination;

class Mensagem extends Api{
    /**
     * Método responsável por mostrar cada item do Mensagem
     *
     */
    private static function getMensagemItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityMensagem::getMensagens(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);
        $results = EntityMensagem::getMensagens(null, 'id ASC', $obPagination->getLimit());

        while($obMensagem = $results->fetchObject(EntityMensagem::class)){

            $itens[] =  [
                'id' => (int)$obMensagem->id,
                'telefone' => $obMensagem->telefone,
                'email' => $obMensagem->email,
                'mensagem' => $obMensagem->mensagem,
                'idEmpresa' => $obMensagem->idEmpresa,
                'idFuncionario' => $obMensagem->idFuncionario,
                'data' => $obMensagem->data
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos os Mensagems
     *
     */
    public static function getMensagens($request){
        return [
            'Mensagens' => self::getMensagemItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um Mensagem
     *
     */
    public static function getMensagem($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA Mensagem
        $obMensagem = EntityMensagem::getMensagemById($id);

        if (!$obMensagem instanceof EntityMensagem) {
            throw new \Exception("A Mensagem ". $id. " Não foi encontrada", 404);
        }

        return [
            'id' => (int)$obMensagem->id,
            'telefone' => $obMensagem->telefone,
            'email' => $obMensagem->email,
            'mensagem' => $obMensagem->mensagem,
            'idEmpresa' => $obMensagem->idEmpresa,
            'idFuncionario' => $obMensagem->idFuncionario,
            'data' => $obMensagem->data
        ];
    }

    /**
     * Método responsável por adicionar novo Mensagem
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewMensagem($request){
        $postVars = $request->getPostVars();

        //CADASTRA NOVO Mensagem
        $obMensagem = new EntityMensagem;
        $obMensagem->telefone = $postVars['telefone'];
        $obMensagem->email = $postVars['email'];
        $obMensagem->mensagem = $postVars['mensagem'];
        $obMensagem->idEmpresa = $postVars['idEmpresa'];
        $obMensagem->idFuncionario = $postVars['idFuncionario'];
        $obMensagem->data = date('Y/m/d H:i');
        $obMensagem->cadastrar();

        $obMensagem->data = date('d/m/Y H:i');
        
        if (!empty($obMensagem->mensagem)) {
            //MONTA O EMAIL PARA ENVIO
            $address = $obMensagem->email;
            $subject = 'Equipe Gestão Frota';
            $body = $obMensagem->mensagem;
            Email::setEmail($address, $subject, $body);
        }

        if (!empty($obMensagem->telefone)) {
            $telephone = $obMensagem->telefone;
            $message =  $obMensagem->mensagem;
            Whatsapp::setWhatsapp($telephone, $message);
        }

        return [
            'id' => (int)$obMensagem->id,
            'telefone' => $obMensagem->telefone,
            'email' => $obMensagem->email,
            'mensagem' => $obMensagem->mensagem,
            'idEmpresa' => $obMensagem->idEmpresa,
            'idFuncionario' => $obMensagem->idFuncionario,
            'data' => $obMensagem->data
        ];
    }

    /**
     * Método responsável por excluir um Mensagem
     */
    public static function setDeleteMensagem($request, $id){

        //BUSCA Mensagem NO BANCO
        $obMensagem = EntityMensagem::getMensagemById($id);

        //VALIDA INSTANCIA
        if (!$obMensagem instanceof EntityMensagem) {
            throw new \Exception("A Mensagem ". $id. " Não foi encontrada", 404);          
        }

        //EXCLUIR Mensagem
        $obMensagem->excluir();

        return [
            'sucesso' => true
        ];
    }
}
