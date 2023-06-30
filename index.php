<?php

require_once __DIR__ . '/vendor/autoload.php';

use API\Loader\APIClient;
use API\Exceptions\APIException;

$apiClient = new APIClient('https://api.vhsys.com/v2');
$apiClient->setApiKey('AfJXgFCVQPgFEcZOSQSUbKJYFTUYJK', 'Access-Token');
$apiClient->setSecretApiKey('vLbhvV78Ax9MMGrndOJeOUCdkRKN6O', 'Secret-Access-Token');

try {
    $response = $apiClient->getWithPagination('/pedidos', ['status' => 'Em Aberto']);
    var_dump($response);
    
} catch (APIException $e) {
    echo 'Erro na requisição: ' . $e->getMessage();
}
