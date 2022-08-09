<?php

use \App\Http\Response;
use \App\Controller\Api;

$obRouter->get('/api/v1/login',[
    'middlewares' => [
        'api',
        'required-logout'
    ],
    function($request){
        return new Response(200, Api\Login::getLogin($request), 'application/json');
    }
]);

$obRouter->post('/api/v1/login',[
    'middlewares' => [
        'api',
        'required-logout'
    ],
    function($request){
        return new Response(200, Api\Login::setLogin($request), 'application/json');
    }
]);

// rota logout
$obRouter->get('/api/v1/logout',[
    'middlewares' => [
        'api',
        'required-login'
    ],
    function($request){
        return new Response(200, Api\Login::setLogout($request), 'application/json');
    }
]);