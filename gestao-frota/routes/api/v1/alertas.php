<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET ALERTA
$obRouter->get('/api/v1/alertas', [
    'middlewares' => [
        'api',
    ],
    function($request){
        return new Response(200, Api\TipoAlerta::getAlertas($request), 'application/json');
    }
]);

//ROTA GET USUARIO (POR ALERTA)
$obRouter->get('/api/v1/alertas/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\TipoAlerta::getAlerta($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO ALERTA (CADASTRAR)
$obRouter->post('/api/v1/alertas', [
    'middlewares' => [
        'api'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR ALERTA
        return new Response(201, Api\TipoAlerta::setNewAlerta($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO ALERTA (ALTERAR)
$obRouter->put('/api/v1/alertas/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR ALERTA
        return new Response(200, Api\TipoAlerta::setEditAlerta($request, $id), 'application/json');
    }
]);

//ROTA DELETE ALERTA (EXCLUIR)
$obRouter->delete('/api/v1/alertas/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\TipoAlerta::setDeleteAlerta($request, $id), 'application/json');
    }
]);