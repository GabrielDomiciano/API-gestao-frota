<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET VIAGEM
$obRouter->get('/api/v1/viagens', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\Viagem::getViagens($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR VIAGEM)
$obRouter->get('/api/v1/viagens/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Viagem::getViagem($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO VIAGEM (CADASTRAR)
$obRouter->post('/api/v1/viagens', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR VIAGEM
        return new Response(201, Api\Viagem::setNewViagem($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO VIAGEM (ALTERAR)
$obRouter->put('/api/v1/viagens/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR VIAGEM
        return new Response(200, Api\Viagem::setEditViagem($request, $id), 'application/json');
    }
]);

//ROTA DELETE VIAGEM (EXCLUIR)
$obRouter->delete('/api/v1/viagens/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Viagem::setDeleteViagem($request, $id), 'application/json');
    }
]);