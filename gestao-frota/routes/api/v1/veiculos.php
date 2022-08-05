<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET VEÍCULO (LISTAGEM TODOS VEICULOS)
$obRouter->get('/api/v1/veiculos', [
    'middlewares' => [
        'api',
    ],
    function($request){
        return new Response(200, Api\Veiculo::getVeiculos($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR VEÍCULO)
$obRouter->get('/api/v1/veiculos/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\Veiculo::getVeiculo($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO VEÍCULO (CADASTRAR)
$obRouter->post('/api/v1/veiculos', [
    'middlewares' => [
        'api'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR VEÍCULO
        return new Response(201, Api\Veiculo::setNewVeiculo($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO VEÍCULO (ALTERAR)
$obRouter->put('/api/v1/veiculos/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR VEÍCULO
        return new Response(200, Api\Veiculo::setEditVeiculo($request, $id), 'application/json');
    }
]);

//ROTA DELETE VEÍCULO (EXCLUIR)
$obRouter->delete('/api/v1/veiculos/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\Veiculo::setDeleteVeiculo($request, $id), 'application/json');
    }
]);