<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET VEÍCULO (LISTAGEM TODOS RelatorioGastosS)
$obRouter->get('/api/v1/relatorios-gastos', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\RelatorioGastos::getRelatoriosGastos($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR VEÍCULO)
$obRouter->get('/api/v1/relatorios-gastos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\RelatorioGastos::getRelatorioGastos($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO VEÍCULO (CADASTRAR)
$obRouter->post('/api/v1/relatorios-gastos', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR VEÍCULO
        return new Response(201, Api\RelatorioGastos::setNewRelatorioGastos($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO VEÍCULO (ALTERAR)
$obRouter->put('/api/v1/relatorios-gastos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR VEÍCULO
        return new Response(200, Api\RelatorioGastos::setEditRelatorioGastos($request, $id), 'application/json');
    }
]);

//ROTA DELETE VEÍCULO (EXCLUIR)
$obRouter->delete('/api/v1/relatorios-gastos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\RelatorioGastos::setDeleteRelatorioGastos($request, $id), 'application/json');
    }
]);