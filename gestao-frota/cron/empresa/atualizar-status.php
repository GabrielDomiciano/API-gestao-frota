<?php

//INCLUDES
use \App\Model\Entity\Pagamento as EntityPagamento;
use \App\Model\Entity\Empresa as EntityEmpresa;


//GET DOS PAGAMENTOS
$results = EntityPagamento::getPagamentos(null, 'id ASC', null);

while($obPagamento = $results->fetchObject(EntityPagamento::class)){

    $itensPagamento[] =  [
        'id' => (int)$obPagamento->id,
        'descricao' => $obPagamento->descricao,
        'codigoTransacao' => $obPagamento->codigoTransacao,
        'tipo' => $obPagamento->tipo,
        'idPlano' => $obPagamento->idPlano,
        'idEmpresa' => $obPagamento->idEmpresa,
        'dataPagamento' => $obPagamento->dataPagamento,
        'valor' => $obPagamento->valor,
        'status' => $obPagamento->status,
        'dataVencimento' => $obPagamento->dataVencimento,
        'usuario' => $obPagamento->usuario
    ];

    $agora = date('Y-m-d H:i:s');
    
    if($obPagamento->dataVencimento < $agora) {
        //BUSCA EMPRESA NO BANCO
        $obEmpresa = EntityEmpresa::getEmpresaById($obPagamento->idEmpresa);
        
        //VALIDA INSTANCIA
        if (!$obEmpresa instanceof EntityEmpresa) {
            throw new \Exception("A Empresa ". $id. " Não foi encontrada", 404);          
        }   
        $obEmpresa->idStatus = 3;
        $obEmpresa->alterarStatus();
    }
}

echo("Sucesso"); exit;

