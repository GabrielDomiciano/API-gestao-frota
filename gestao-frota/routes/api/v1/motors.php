<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET MOTOR (LISTAGEM TODOS MOTORES)
$obRouter->get('/api/v1/motors', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\Motor::getMotors($request), 'application/json');
    }
]);

//ROTA GET MOTOR (POR MOTOR)
$obRouter->get('/api/v1/motors/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Motor::getMotor($request, $id), 'application/json');
    }
]);

//ROTA POST CADASTRO MOTOR (CADASTRAR)
$obRouter->post('/api/v1/motors', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        //RETORNA O MÉTODO RESPONSÁVEL POR CADASTRAR MOTOR
        return new Response(201, Api\Motor::setNewMotor($request), 'application/json');
    }
]);

//ROTA PUT CADASTRO MOTOR (ALTERAR)
$obRouter->put('/api/v1/motors/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        //RETORNA O MÉTODO RESPONSÁVEL POR ATUALIZAR MOTOR
        return new Response(200, Api\Motor::setEditMotor($request, $id), 'application/json');
    }
]);

//ROTA DELETE MOTOR (EXCLUIR)
$obRouter->delete('/api/v1/motors/{id}', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Motor::setDeleteMotor($request, $id), 'application/json');
    }
]);