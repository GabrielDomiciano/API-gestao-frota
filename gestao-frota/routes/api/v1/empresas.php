<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET Empresa (LISTAGEM TODOS EmpresaS)
$obRouter->get('/api/v1/empresas', [
    'middlewares' => [
        'api',
    ],
    function($request){
        return new Response(200, Api\Empresa::getEmpresas($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR Empresa)
$obRouter->get('/api/v1/empresas/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\Empresa::getEmpresa($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO Empresa (CADASTRAR)
$obRouter->post('/api/v1/empresas', [
    'middlewares' => [
        'api'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR Empresa
        return new Response(201, Api\Empresa::setNewEmpresa($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO Empresa (ALTERAR)
$obRouter->put('/api/v1/empresas/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR Empresa
        return new Response(200, Api\Empresa::setEditEmpresa($request, $id), 'application/json');
    }
]);

//ROTA DELETE Empresa (EXCLUIR)
$obRouter->delete('/api/v1/empresas/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\Empresa::setDeleteEmpresa($request, $id), 'application/json');
    }
]);