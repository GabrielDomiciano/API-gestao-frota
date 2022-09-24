<?php
namespace App\Payment;

use GuzzleHttp\Client;

$client = new \GuzzleHttp\Client();

$response = $client->request('POST', 'https://sandbox.api.pagseguro.com/charges', [
    'body' => '{"amount":
            {"value":1,"currency":"BRL"},
                "payment_method":{"card":{"holder":{"name":"JOAO SILVA"},"number":"1231121212","network_token":"12","exp_month":123,
                "exp_year":12,"security_code":"123","store":false},"type":"CREDIT_CARD","installments":1,"capture":true,
                "soft_descriptor":"Gestão Frota Corporation"}}',
    'headers' => [
        'Content-type' => 'application/json',
        'accept' => 'application/json',
    ],
]);

echo $response->getBody();
