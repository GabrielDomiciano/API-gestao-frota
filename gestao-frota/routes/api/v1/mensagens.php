<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET Mensagem (LISTAGEM TODOS mensagens)
$obRouter->get('/api/v1/mensagens', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\Mensagem::getMensagens($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR Mensagem)
$obRouter->get('/api/v1/mensagens/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Mensagem::getMensagem($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO Mensagem (CADASTRAR)
$obRouter->post('/api/v1/mensagens', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR Mensagem
        return new Response(201, Api\Mensagem::setNewMensagem($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO Mensagem (ALTERAR)
$obRouter->put('/api/v1/mensagens/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR Mensagem
        return new Response(200, Api\Mensagem::setEditMensagem($request, $id), 'application/json');
    }
]);

//ROTA DELETE Mensagem (EXCLUIR)
$obRouter->delete('/api/v1/mensagens/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Mensagem::setDeleteMensagem($request, $id), 'application/json');
    }

]);