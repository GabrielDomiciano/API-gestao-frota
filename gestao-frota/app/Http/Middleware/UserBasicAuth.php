<?php
namespace App\Http\Middleware;
use \App\Model\Entity\UserApi;


class UserBasicAuth{

    private function getBasicAuthUser(){
        if (!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }

        // busca o usuario pelo email    
        $obUserApi = UserApi::getUserApiByNome($_SERVER['PHP_AUTH_USER']);

        if (!$obUserApi instanceof UserApi) {
            return false;
        }
       
        return password_verify($_SERVER['PHP_AUTH_PW'], $obUserApi->senha) ? $obUserApi : false;
    }

    private function basicAuth($request){
        // verifica o usuario recebido
        if ($obUserApi = $this->getBasicAuthUser()) {
            $request->userApi = $obUserApi;
            return true;
        }

        // emite o erro de senha inválida
        throw new \Exception("Credenciais Inválidas", 403);
        
    }

    public function handle($request, $next) {
        $this->basicAuth($request);

        return $next($request);
    }
}