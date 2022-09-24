<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET Monitoramento
$obRouter->get('/api/v1/monitoramentos', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\Monitoramento::getMonitoramentos($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR Monitoramento)
$obRouter->get('/api/v1/monitoramentos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Monitoramento::getMonitoramento($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO Monitoramento (CADASTRAR)
$obRouter->post('/api/v1/monitoramentos', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR Monitoramento
        return new Response(201, Api\Monitoramento::setNewMonitoramento($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO Monitoramento (ALTERAR)
$obRouter->put('/api/v1/monitoramentos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR Monitoramento
        return new Response(200, Api\Monitoramento::setEditMonitoramento($request, $id), 'application/json');
    }
]);

//ROTA DELETE Monitoramento (EXCLUIR)
$obRouter->delete('/api/v1/monitoramentos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Monitoramento::setDeleteMonitoramento($request, $id), 'application/json');
    }
]);

//ROTA GET Monitoramento PERSONALIZADO
$obRouter->get('/api/v1/monitoramentos-media/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Monitoramento::getMediaGasto($request, $id), 'application/json');
    }
]);