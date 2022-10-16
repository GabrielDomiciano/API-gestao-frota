<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET VEÍCULO (LISTAGEM TODOS PagamentoS)
$obRouter->get('/api/v1/pagamentos', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\Pagamento::getPagamentos($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR VEÍCULO)
$obRouter->get('/api/v1/pagamentos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Pagamento::getPagamento($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO VEÍCULO (CADASTRAR)
$obRouter->post('/api/v1/pagamentos', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR VEÍCULO
        return new Response(201, Api\Pagamento::setNewPagamento($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO VEÍCULO (ALTERAR)
$obRouter->put('/api/v1/pagamentos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR VEÍCULO
        return new Response(200, Api\Pagamento::setEditPagamento($request, $id), 'application/json');
    }
]);

//ROTA DELETE VEÍCULO (EXCLUIR)
$obRouter->delete('/api/v1/pagamentos/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Pagamento::setDeletePagamento($request, $id), 'application/json');
    }
]);