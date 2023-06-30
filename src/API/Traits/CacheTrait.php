<?php

namespace API\Traits;

use Psr\SimpleCache\CacheInterface;

/**
 * Trait para cache de requisições da API.
 */
trait CacheTrait
{
    protected $cache;

    /**
     * Define a instância do cache a ser usada para armazenar as respostas das requisições.
     *
     * @param CacheInterface $cache A instância do cache.
     * @return void
     */
    public function setCache(CacheInterface $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * Verifica se uma resposta de requisição está em cache e retorna-a, se disponível.
     *
     * @param string $cacheKey A chave de cache para a resposta.
     * @return array|null Os dados da resposta em cache ou null se não encontrado.
     */
    private function getCachedResponse(string $cacheKey): ?array
    {
        if ($this->cache && $this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        return null;
    }

    /**
     * Armazena uma resposta de requisição em cache.
     *
     * @param string $cacheKey A chave de cache para a resposta.
     * @param array $response Os dados da resposta a serem armazenados em cache.
     * @param int $ttl O tempo de vida do cache em segundos (opcional).
     * @return void
     */
    private function cacheResponse(string $cacheKey, array $response, int $ttl = 3600): void
    {
        if ($this->cache) {
            $this->cache->set($cacheKey, $response, $ttl);
        }
    }

    /**
     * Verifica se uma resposta de requisição está em cache e retorna-a, se disponível.
     *
     * @param string $cacheKey A chave de cache para a resposta.
     * @return array|null Os dados da resposta em cache ou null se não encontrado.
     */
    protected function obterRespostaCache(string $cacheKey): ?array
    {
        if ($this->cache && $this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        return null;
    }

    /**
     * Armazena uma resposta de requisição em cache.
     *
     * @param string $cacheKey A chave de cache para a resposta.
     * @param array $response Os dados da resposta a serem armazenados em cache.
     * @param int $ttl O tempo de vida do cache em segundos (opcional).
     * @return void
     */
    protected function armazenarRespostaCache(string $cacheKey, array $response, int $ttl = 3600): void
    {
        if ($this->cache) {
            $this->cache->set($cacheKey, $response, $ttl);
        }
    }
}
