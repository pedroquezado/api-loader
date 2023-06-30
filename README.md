# api-loader - PedroQuezado

[![Maintainer](http://img.shields.io/badge/maintainer-@pedroquezado-blue.svg?style=flat-square)](https://github.com/pedroquezado)
[![Source Code](http://img.shields.io/badge/source-pedroquezado/api-loader-blue.svg?style=flat-square)](https://github.com/pedroquezado/api-loader)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/pedroquezado/api-loader.svg?style=flat-square)](https://packagist.org/packages/pedroquezado/api-loader)
[![Latest Version](https://img.shields.io/github/release/pedroquezado/api-loader.svg?style=flat-square)](https://github.com/pedroquezado/api-loader/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/pedroquezado/api-loader.svg?style=flat-square)](https://scrutinizer-ci.com/g/pedroquezado/api-loader)
[![Quality Score](https://img.shields.io/scrutinizer/g/pedroquezado/api-loader.svg?style=flat-square)](https://scrutinizer-ci.com/g/pedroquezado/api-loader)
[![Total Downloads](https://img.shields.io/packagist/dt/pedroquezado/api-loader.svg?style=flat-square)](https://packagist.org/packages/pedroquezado/api-loader)

## About API-Loader

# API Client Library

A library for interacting with various APIs.

## Descrição

Esta biblioteca fornece uma interface conveniente para se comunicar com várias APIs. Ela oferece métodos para executar solicitações HTTP, autenticar-se nas APIs e realizar várias ações, como recuperar dados, criar, atualizar e excluir recursos.

## Instalação

Para começar a usar a biblioteca, siga as etapas abaixo:

1. Clone este repositório para o seu ambiente local.
2. Execute o comando `composer require pedroquezado/api-loader` para instalar as dependências.

## Configuração

Antes de poder usar a biblioteca, você precisará configurar suas chaves de acesso à API.

### Configurando as chaves de acesso

A classe `APIClient` oferece dois métodos para configurar as chaves de acesso:

#### setApiKey(apiKey, [titleKey])

Configura a chave de acesso à API.

- `apiKey` (string): A chave de acesso à API.
- `titleKey` (string, opcional): O título do cabeçalho a ser usado ao enviar a chave de acesso (padrão: "Access-Token").

Exemplo:

```php
$apiClient->setApiKey('SEU_ACCESS_TOKEN', 'nomear_ApiKey');
```

#### setSecretApiKey(secretApiKey, [titleKey])

Configura a chave de acesso secreta.

- `secretApiKey` (string): A chave de acesso secreta.
- `titleKey` (string, opcional): O título do cabeçalho a ser usado ao enviar a chave de acesso secreta (padrão: "Secret-Access-Token").

Exemplo:

```php
$apiClient->setSecretApiKey('SUA_SECRET_ACCESS_TOKEN', 'nomear_SecretApiKey');
```

## Métodos de Ações
A classe `APIClient` fornece os seguintes métodos para interagir com as APIs:

### get(path, [params])
Realiza uma solicitação GET para o caminho especificado.

- `path` (string): O caminho da API para a solicitação.
- `params` (array, opcional): Parâmetros de consulta para incluir na solicitação (padrão: []).

Exemplo:
```php
$response = $apiClient->get('/produtos', ['categoria' => 'eletrônicos']);
```

### getWithPagination(path, [params])
Realiza uma solicitação GET para o caminho especificado, com suporte a paginação.

- `path` (string): O caminho da API para a solicitação.
- `params` (array, opcional): Parâmetros de consulta para incluir na solicitação (padrão: []).
Exemplo:

```php
$response = $apiClient->getWithPagination('/pedidos', ['status' => 'Em Aberto']);
```

### post(path, data)
Realiza uma solicitação POST para o caminho especificado com os dados fornecidos.

- `path` (string): O caminho da API para a solicitação.
- `data` (array): Os dados a serem enviados na solicitação.
Exemplo:

```php
$response = $apiClient->post('/produtos', ['nome' => 'Produto A', 'preco' => 100]);
```

### put(path, data)
Realiza uma solicitação PUT para o caminho especificado com os dados fornecidos.

- `path` (string): O caminho da API para a solicitação.
- `data` (array): Os dados a serem enviados na solicitação.
Exemplo:

```php
$response = $apiClient->put('/produtos/1', ['preco' => 120]);
```

### delete(path)
Realiza uma solicitação DELETE para o caminho especificado.

- `path` (string): O caminho da API para a solicitação.
Exemplo:

```php
$response = $apiClient->delete('/produtos/1');
```

# Exemplo de Uso
Aqui está um exemplo de código que demonstra o uso da biblioteca:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use API\Loader\APIClient;
use API\Exceptions\APIException;

// Configuração da API
$apiEndpoint = 'https://{api_address}/{version}';
$apiKey = 'SUA_API_KEY';
$apiSecretKey = 'SUA_SECRET_API_KEY';

// Criação do cliente da API
$apiClient = new APIClient($apiEndpoint);
$apiClient->setApiKey($apiKey, 'nomear_ApiKey');
$apiClient->setSecretApiKey($apiSecretKey, 'nomear_SecretApiKey');

try {
    // Leitura de dados
    $response = $apiClient->get('/produtos', ['categoria' => 'eletrônicos']);
    var_dump($response);

    // Inserção de dados
    $data = [
        'nome' => 'Produto A',
        'preco' => 100,
    ];
    $response = $apiClient->post('/produtos', $data);
    var_dump($response);

    // Edição de dados
    $productId = 1;
    $data = [
        'preco' => 120,
    ];
    $response = $apiClient->put('/produtos/' . $productId, $data);
    var_dump($response);

    // Remoção de dados
    $productId = 1;
    $response = $apiClient->delete('/produtos/' . $productId);
    var_dump($response);

} catch (APIException $e) {
    echo 'Erro na requisição: ' . $e->getMessage();
}
```


Lembre-se de substituir {api_address} pelo endereço real da API e {version} pela versão específica da API que você está usando. Além disso, substitua SUA_API_KEY e SUA_SECRET_API_KEY pelas suas chaves de acesso válidas.

## Contributing
Contributions are welcome! If you would like to contribute to the **PedroQuezado Api-Loader**, feel free to open an issue or submit a pull request. We appreciate your feedback and contributions to make this project even better.

License
This project is licensed under the MIT License.
