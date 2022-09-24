<?php
use \App\Http\Response;
use \App\Controller\Api;

//ROTA GET Fabricante (LISTAGEM TODOS FabricanteS)
$obRouter->post('/api/v1/emails', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(200, Api\Email::setEmail($request), 'application/json');
    }
]);