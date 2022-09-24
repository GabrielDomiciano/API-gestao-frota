<?php

use \App\Http\Response;
use \App\Http\Middleware;
use \App\Controller\Api;


//ROTA GERAÇÃO TOKEN 
$obRouter->post('/api/v1/login', [
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(201, Api\Login::generateToken($request), 'application/json');
    }
]);
