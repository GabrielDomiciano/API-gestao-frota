<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET Funcionario (LISTAGEM TODOS FuncionarioS)
$obRouter->get('/api/v1/funcionarios', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\Funcionario::getFuncionarios($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR Funcionario)
$obRouter->get('/api/v1/funcionarios/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Funcionario::getFuncionario($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO Funcionario (CADASTRAR)
$obRouter->post('/api/v1/funcionarios', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR Funcionario
        return new Response(201, Api\Funcionario::setNewFuncionario($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO Funcionario (ALTERAR)
$obRouter->put('/api/v1/funcionarios/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR Funcionario
        return new Response(200, Api\Funcionario::setEditFuncionario($request, $id), 'application/json');
    }
]);

//ROTA DELETE Funcionario (EXCLUIR)
$obRouter->delete('/api/v1/funcionarios/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Funcionario::setDeleteFuncionario($request, $id), 'application/json');
    }
]);