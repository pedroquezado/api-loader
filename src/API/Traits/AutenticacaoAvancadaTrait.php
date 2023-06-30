<?php

namespace API\Traits;

/**
 * Trait para autenticação avançada na API.
 */
trait AutenticacaoAvancadaTrait
{
    /**
     * Define a chave de acesso para autenticação na API.
     *
     * @param string $apiKey A chave de acesso à API.
     * @param string $title_key Caso o titlo da chave não seja padrão.
     * @return void
     */
    public function setApiKey(string $apiKey, string $title_key = null): void
    {
        $this->apiKey = $apiKey;

        if (!empty($title_key)) {
            $this->key_apiKey = $title_key;
        }
    }

    /**
     * Define a chave secreta de acesso à API.
     *
     * @param string $secretApiKey A chave secreta de acesso à API.
     * @param string $title_key Caso o titlo da chave não seja padrão.
     * @return void
     */
    public function setSecretApiKey(string $secretApiKey, string $title_key = null): void
    {
        $this->secretApiKey = $secretApiKey;

        if (!empty($title_key)) {
            $this->key_secretApiKey = $title_key;
        }
    }

    /**
     * Adiciona o cabeçalho de autenticação na requisição.
     *
     * @param array $options As opções de configuração da requisição.
     * @return array As opções de configuração atualizadas.
     */
    protected function adicionarCabecalhoAutenticacao(array $options): array
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->apiKey;
        return $options;
    }
}
