<?php

namespace App\Controller\Api;

use \App\Model\Entity\Veiculo as EntityVeiculo;
use \WilliamCosta\DatabaseManager\Pagination;

class Veiculo extends Api{
    /**
     * Método responsável por mostrar cada item do veiculo
     *
     */
    private static function getVeiculoItems($request, &$obPagination){
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityVeiculo::getVeiculos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);
        $results = EntityVeiculo::getVeiculos(null, 'id ASC', $obPagination->getLimit());

        while($obVeiculo = $results->fetchObject(EntityVeiculo::class)){

            $itens[] =  [
                'id' => (int)$obVeiculo->id,
                'descricaoVeiculo' => $obVeiculo->descricaoVeiculo,
                'tipoVeiculo' => $obVeiculo->tipoVeiculo,
                'qtdRodas' => $obVeiculo->qtdRodas,
                'modeloVeiculo' => $obVeiculo->modeloVeiculo,
                'ano' => $obVeiculo->ano,
                'estado' => $obVeiculo->estado,
                'idFabricante' => $obVeiculo->idFabricante,
                'idEmpresa' => $obVeiculo->idEmpresa,
                'idTipoMotor' => $obVeiculo->idTipoMotor
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por mostrar todos usuários
     *
     */
    public static function getVeiculos($request){
        return [
            'veiculos' => self::getVeiculoItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por pegar um usuário
     *
     */
    public static function getVeiculo($request, $id){
        //VALIDA O ID
        if (!is_numeric($id)) {
            throw new \Exception("O id". $id. " Não é valido", 404);
        }

        //BUSCA VEICULO
        $obVeiculo = EntityVeiculo::getVeiculoById($id);

        if (!$obVeiculo instanceof EntityVeiculo) {
            throw new \Exception("O veiculo ". $id. " Não foi encontrado", 404);
        }

        return [
            'id' => (int)$obVeiculo->id,
            'descricaoVeiculo' => $obVeiculo->descricaoVeiculo,
            'tipoVeiculo' => $obVeiculo->tipoVeiculo,
            'qtdRodas' => $obVeiculo->qtdRodas,
            'modeloVeiculo' => $obVeiculo->modeloVeiculo,
            'ano' => $obVeiculo->ano,
            'estado' => $obVeiculo->estado,
            'idFabricante' => $obVeiculo->idFabricante,
            'idEmpresa' => $obVeiculo->idEmpresa,
            'idTipoMotor' => $obVeiculo->idTipoMotor
        ];
    }

    public static function getCurrentVeiculo($request){
        //USUÁRIO ATUAL
        $obVeiculo = $request->veiculo;
        return [
            'id' => (int)$obVeiculo->id,
            'descricaoVeiculo' => $obVeiculo->descricaoVeiculo,
            'tipoVeiculo' => $obVeiculo->tipoVeiculo,
            'qtdRodas' => $obVeiculo->qtdRodas,
            'modeloVeiculo' => $obVeiculo->modeloVeiculo,
            'ano' => $obVeiculo->ano,
            'estado' => $obVeiculo->estado,
            'idFabricante' => $obVeiculo->idFabricante,
            'idEmpresa' => $obVeiculo->idEmpresa,
            'idTipoMotor' => $obVeiculo->idTipoMotor
        ];
    }

    // -------------------------------------------------------- -------------------------------------------------------------
    /**
     * Método responsável por adicionar novo veiculo
     *
     * @param [type] $request
     * @return array
     */
    public static function setNewVeiculo($request){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoVeiculo']) or !isset($postVars['ano'])) {
            throw new \Exception("Os campos 'descrição' e 'ano' são obrigatórios", 400);
        }

        //CADASTRA NOVO VEICULO
        $obVeiculo = new EntityVeiculo;
        $obVeiculo->descricaoVeiculo = $postVars['descricaoVeiculo'];
        $obVeiculo->tipoVeiculo = $postVars['tipoVeiculo'];
        $obVeiculo->qtdRodas = $postVars['qtdRodas'];
        $obVeiculo->modeloVeiculo = $postVars['modeloVeiculo'];
        $obVeiculo->ano = $postVars['ano'];
        $obVeiculo->estado = $postVars['estado'];
        $obVeiculo->idFabricante = $postVars['idFabricante'];
        $obVeiculo->idEmpresa = $postVars['idEmpresa'];   
        $obVeiculo->idTipoMotor = $postVars['idTipoMotor'];
        
       
        $obVeiculo->cadastrar();

        return [
            'id' => (int)$obVeiculo->id,
            'descricaoVeiculo' => $obVeiculo->descricaoVeiculo,
            'tipoVeiculo' => $obVeiculo->tipoVeiculo,
            'qtdRodas' => $obVeiculo->qtdRodas,
            'modeloVeiculo' => $obVeiculo->modeloVeiculo,
            'ano' => $obVeiculo->ano,
            'estado' => $obVeiculo->estado,
            'idFabricante' => $obVeiculo->idFabricante,
            'idEmpresa' => $obVeiculo->idEmpresa,
            'idTipoMotor' => $obVeiculo->idTipoMotor
        ];
    }

    public static function setEditVeiculo($request, $id){
        $postVars = $request->getPostVars();

        //VALIDA CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['descricaoVeiculo']) or !isset($postVars['ano'])) {
            throw new \Exception("Os campos 'descrição' e 'ano' são obrigatórios", 400);
        }

        //BUSCA VEÍCULO
        $obVeiculo = EntityVeiculo::getVeiculoById($id);

        //VALIDA VEÍCULO
        if (!$obVeiculo instanceof EntityVeiculo) {
            throw new \Exception("O veículo ". $id. " Não foi encontrado", 404);
        }

        //ATUALIZA VEÍCULO
        $obVeiculo->descricaoVeiculo = $postVars['descricaoVeiculo'];
        $obVeiculo->tipoVeiculo = $postVars['tipoVeiculo'];
        $obVeiculo->qtdRodas = $postVars['qtdRodas'];
        $obVeiculo->modeloVeiculo = $postVars['modeloVeiculo'];
        $obVeiculo->ano = $postVars['ano'];
        $obVeiculo->estado = $postVars['estado'];
        $obVeiculo->idFabricante = $postVars['idFabricante'];
        $obVeiculo->idEmpresa = $postVars['idEmpresa'];   
        $obVeiculo->idTipoMotor = $postVars['idTipoMotor'];
        $obVeiculo->atualizar();

        return [
            'id' => (int)$obVeiculo->id,
            'descricaoVeiculo' => $obVeiculo->descricaoVeiculo,
            'tipoVeiculo' => $obVeiculo->tipoVeiculo,
            'qtdRodas' => $obVeiculo->qtdRodas,
            'modeloVeiculo' => $obVeiculo->modeloVeiculo,
            'ano' => $obVeiculo->ano,
            'estado' => $obVeiculo->estado,
            'idFabricante' => $obVeiculo->idFabricante,
            'idEmpresa' => $obVeiculo->idEmpresa,
            'idTipoMotor' => $obVeiculo->idTipoMotor
        ];
    }
    
    /**
     * Método responsável por excluir um veiculo
     */
    public static function setDeleteVeiculo($request, $id){

        //BUSCA VEICULO NO BANCO
        $obVeiculo = EntityVeiculo::getVeiculoById($id);

        //VALIDA INSTANCIA
        if (!$obVeiculo instanceof EntityVeiculo) {
            throw new \Exception("O veículo ". $id. " Não foi encontrado", 404);          
        }

        //EXCLUIR VEICULO
        $obVeiculo->excluir();

        return [
            'sucesso' => 'Veículo excluído com sucesso'
        ];
    }
}