<?php

namespace App\Controller\Api;

use \App\Model\Entity\Motor as EntityMotor;
use \WilliamCosta\DatabaseManager\Pagination;

class Motor extends Api{
    /**
     * Método responsável por mostrar cada item do motor
     *
     */
    private static function getMotorItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityMotor::getMotors(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 500);
        $results = EntityMotor::getMotors(null, 'id ASC', $obPagination->getLimit());

        while($obMotor = $results->fetchObject(EntityMotor::class)){

            $itens[] =  [
                'id' => (int)$obMotor->id,
                'descricaoMotor' => $obMotor->descricaoMotor,
                'tipoMotor' => $obMotor->tipoMotor,
                'potenciaMotor' => $obMotor->potenciaMotor
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos os Motors
     *
     */
    public static function getMotors($request){
        return [
            'motors' => self::getMotorItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um Motor
     *
     */
    public static function getMotor($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA Motor
        $obMotor = EntityMotor::getMotorById($id);

        if (!$obMotor instanceof EntityMotor) {
            throw new \Exception("O Motor ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obMotor->id,
            'descricaoMotor' => $obMotor->descricaoMotor,
            'tipoMotor' => $obMotor->tipoMotor,
            'potenciaMotor' => $obMotor->potenciaMotor
        ];
    }

    public static function getCurrentMotor($request){
        //Motor ATUAL
        $obMotor = $request->Motor;
        return [
            'id' => (int)$obMotor->id,
            'descricaoMotor' => $obMotor->descricaoMotor,
            'tipoMotor' => $obMotor->tipoMotor,
            'potenciaMotor' => $obMotor->potenciaMotor
        ];
    }

    /**
     * Método responsável por adicionar novo Motor
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewMotor($request){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoMotor'])) {
            throw new \Exception("O campo 'descricao' é obrigatório", 400);
        }

        //CADASTRA NOVO Motor
        $obMotor = new EntityMotor;
        $obMotor->descricaoMotor = $postVars['descricaoMotor'];
        $obMotor->tipoMotor = $postVars['tipoMotor'];
        $obMotor->potenciaMotor = $postVars['potenciaMotor'];
        $obMotor->cadastrar();

        return [
            'id' => (int)$obMotor->id,
            'descricaoMotor' => $obMotor->descricaoMotor,
            'tipoMotor' => $obMotor->tipoMotor,
            'potenciaMotor' => $obMotor->potenciaMotor
        ];
    }

    /**
     * Método responsável por atualizar um Motor
     *
     * @param [type] $request
     * @param integer $id
     * @return array
     */
    public static function setEditMotor($request, $id){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoMotor'])) {
            throw new \Exception("Os campos 'descricao' e 'valor' são obrigatórios", 400);
        }

        //BUSCA Motor
        $obMotor = EntityMotor::getMotorById($id);

        //VALIDA Motor
        if (!$obMotor instanceof EntityMotor) {
            throw new \Exception("O Motor ". $id. " Não foi encontrado", 404);
        }

       //ATUALIZA Motor
       $obMotor->descricaoMotor = $postVars['descricaoMotor'];
       $obMotor->tipoMotor = $postVars['tipoMotor'];
       $obMotor->potenciaMotor = $postVars['potenciaMotor'];
        $obMotor->atualizar();

        return [
            'id' => (int)$obMotor->id,
            'descricaoMotor' => $obMotor->descricaoMotor,
            'tipoMotor' => $obMotor->tipoMotor,
            'potenciaMotor' => $obMotor->potenciaMotor
        ];
    }

    /**
     * Método responsável por excluir um Motor
     */
    public static function setDeleteMotor($request, $id){

        //BUSCA Motor NO BANCO
        $obMotor = EntityMotor::getMotorById($id);

        //VALIDA INSTANCIA
        if (!$obMotor instanceof EntityMotor) {
            throw new \Exception("O Motor ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR Motor
        $obMotor->excluir();

        return [
            'sucesso' => true
        ];
    }
}
