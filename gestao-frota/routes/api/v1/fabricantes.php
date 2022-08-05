<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET Fabricante (LISTAGEM TODOS FabricanteS)
$obRouter->get('/api/v1/fabricantes', [
    'middlewares' => [
        'api',
    ],
    function($request){
        return new Response(200, Api\Fabricante::getFabricantes($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR Fabricante)
$obRouter->get('/api/v1/fabricantes/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\Fabricante::getFabricante($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO Fabricante (CADASTRAR)
$obRouter->post('/api/v1/fabricantes', [
    'middlewares' => [
        'api'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR Fabricante
        return new Response(201, Api\Fabricante::setNewFabricante($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO Fabricante (ALTERAR)
$obRouter->put('/api/v1/fabricantes/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR Fabricante
        return new Response(200, Api\Fabricante::setEditFabricante($request, $id), 'application/json');
    }
]);

//ROTA DELETE Fabricante (EXCLUIR)
$obRouter->delete('/api/v1/fabricantes/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\Fabricante::setDeleteFabricante($request, $id), 'application/json');
    }
]);