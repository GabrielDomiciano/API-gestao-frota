<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET PLANO (LISTAGEM TODOS PLANOS)
$obRouter->get('/api/v1/planos', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\Plano::getPlanos($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR PLANO)
$obRouter->get('/api/v1/planos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Plano::getPlano($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO PLANO (CADASTRAR)
$obRouter->post('/api/v1/planos', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR PLANO
        return new Response(201, Api\Plano::setNewPlano($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO PLANO (ALTERAR)
$obRouter->put('/api/v1/planos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR PLANO
        return new Response(200, Api\Plano::setEditPlano($request, $id), 'application/json');
    }
]);

//ROTA DELETE PLANO (EXCLUIR)
$obRouter->delete('/api/v1/planos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Plano::setDeletePlano($request, $id), 'application/json');
    }
]);