<?php

namespace API\Loader;

use API\Exceptions\APIException;
use API\Traits\AutenticacaoAvancadaTrait;
use API\Traits\CacheTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Classe para carregamento e interação com APIs.
 */
class APIClient
{
    use AutenticacaoAvancadaTrait;
    use CacheTrait;

    protected $apiKey;
    protected $key_apiKey;

    protected $secretApiKey;
    protected $key_secretApiKey;

    protected $endpoint;
    protected $client;

    /**
     * Cria uma nova instância do cliente da API.
     *
     * @param string $endpoint O endpoint da API.
     */
    public function __construct(string $endpoint, array $key = null)
    {
        $this->endpoint = $endpoint;
        $this->client = new Client();
    }

    /**
     * Cria uma nova instância do Guzzle Client com as chaves de autenticação.
     *
     * @return Client
     */
    protected function createClient(): Client
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'X-Secret-Key' => $this->secretApiKey
        ];

        if (!empty($this->key_apiKey)) {
            $headers[$this->key_apiKey] = $this->apiKey;
        }

        if (!empty($this->key_secretApiKey)) {
            $headers[$this->key_secretApiKey] = $this->secretApiKey;
        }

        return new Client([
            'base_uri' => $this->endpoint,
            'headers' => $headers,
        ]);
    }

    /**
     * Faz uma requisição HTTP genérica para o endpoint especificado.
     *
     * @param string $method O método HTTP da requisição (GET, POST, PUT, DELETE, etc.).
     * @param string $path O caminho do endpoint específico.
     * @param array $data Os dados a serem enviados na requisição (opcional).
     * @return array Os dados da resposta da API.
     * @throws APIException Em caso de erro na requisição.
     */
    public function request(string $method, string $path, array $data = [], ?int $page = null, ?int $perPage = null): array
    {
        $client = $this->createClient();

        $url = $this->endpoint . $path;

        if ($page !== null && $perPage !== null) {
            $data['page'] = $page;
            $data['per_page'] = $perPage;
        }

        $options = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => $data,
        ];

        // Verificar se a autenticação avançada está habilitada
        if (!empty($this->apiKey)) {
            $options = $this->adicionarCabecalhoAutenticacao($options);
        }

        // Verificar se o cache está habilitado
        // $cachedResponse = $this->obterRespostaCache($cacheKey);
        // if ($cachedResponse !== null) {
        //     return $cachedResponse;
        // }
        // $this->armazenarRespostaCache($cacheKey, $response, $cacheTtl);

        try {
            $response = $client->request($method, $url, $options);
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

            if ($statusCode >= 400) {
                throw new APIException($responseData['message'], $statusCode);
            }

            return $responseData;
        } catch (\Exception $e) {
            throw new APIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Faz uma requisição GET para o endpoint especificado.
     *
     * @param string $path O caminho do endpoint específico.
     * @param array $data Os dados a serem enviados na requisição (opcional).
     * @return array Os dados da resposta da API.
     * @throws APIException Em caso de erro na requisição.
     */
    public function get(string $path, array $data = []): array
    {
        return $this->request('GET', $path, $data);
    }

    /**
     * Faz uma requisição GET para o endpoint especificado com suporte a paginação.
     *
     * @param string $path O caminho do endpoint específico.
     * @param int $perPage O número de resultados por página.
     * @param int $page A página a ser recuperada.
     * @return array Os dados da resposta da API.
     * @throws APIException Em caso de erro na requisição.
     */
    public function getWithPagination(string $path, array $data = [], int $perPage = 10, int $page = 1): array
    {
        $options = [
            'per_page' => $perPage,
            'page' => $page,

            'limit' => $perPage,
            'offset' => $page,
        ];

        $data = array_merge($data, $options);

        return $this->get($path, $data);
    }

    /**
     * Faz uma requisição POST para o endpoint especificado.
     *
     * @param string $path O caminho do endpoint específico.
     * @param array $data Os dados a serem enviados na requisição (opcional).
     * @return array Os dados da resposta da API.
     * @throws APIException Em caso de erro na requisição.
     */
    public function post(string $path, array $data = []): array
    {
        return $this->request('POST', $path, $data);
    }

    /**
     * Faz uma requisição PUT para o endpoint especificado.
     *
     * @param string $path O caminho do endpoint específico.
     * @param array $data Os dados a serem enviados na requisição (opcional).
     * @return array Os dados da resposta da API.
     * @throws APIException Em caso de erro na requisição.
     */
    public function put(string $path, array $data = []): array
    {
        return $this->request('PUT', $path, $data);
    }

    /**
     * Faz uma requisição DELETE para o endpoint especificado.
     *
     * @param string $path O caminho do endpoint específico.
     * @param array $data Os dados a serem enviados na requisição (opcional).
     * @return array Os dados da resposta da API.
     * @throws APIException Em caso de erro na requisição.
     */
    public function delete(string $path, array $data = []): array
    {
        return $this->request('DELETE', $path, $data);
    }
}
