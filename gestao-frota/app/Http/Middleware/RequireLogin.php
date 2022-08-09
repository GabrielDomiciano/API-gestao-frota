<?php

namespace App\Http\Middleware;
use \App\Session\Login as SessionLogin;

class RequirLogin{
    public function handle($request, $next){
        // verifica se o usuario esta logado
        if (!SessionLogin::isLogged()) {
            $request->getRouter()->redirect(''); //PRECISO VER A ROTA DO FRONT PRA ADICIONAR AQUI
        }
        // continua a execução
        return $next($request);
    }
}