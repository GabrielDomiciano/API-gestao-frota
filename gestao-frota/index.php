<?php
require __DIR__.'/includes/app.php';

use \App\Http\Router;
$obRouter = new Router(URL);

// inclui rotas da api
include __DIR__.'/routes/api.php';

//inclui as crons
if(isset($_GET['cron'])){
    include __DIR__.'/cron/empresa/atualizar-status.php';
}

// imprime o response da rota
$obRouter->run()
         ->sendResponse();
