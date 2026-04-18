<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use League\Csv\Reader;
use Psr\SimpleCache\CacheInterface;

/**
 * PSR-16 caching decorator for ApiConnectorInterface.
 *
 * Caches JSON responses fetched via fetchData(). CSV responses are passed
 * through because League\Csv\Reader cannot be reliably serialized; if CSV
 * caching is needed, prefer caching at a higher level (on the typed endpoint
 * result) or extend this decorator to fetch the raw CSV string directly.
 */
class CachedApiConnector implements ApiConnectorInterface
{
    public function __construct(
        private readonly ApiConnectorInterface $inner,
        private readonly CacheInterface $cache,
        private readonly int $ttlSeconds = 3600,
        private readonly string $keyPrefix = 'ipma_api.',
    ) {
    }

    /**
     * @param string $endPoint
     *
     * @return array<mixed>
     */
    public function fetchData(string $endPoint): array
    {
        $key = $this->cacheKey($endPoint);

        /** @var array<mixed>|null $cached */
        $cached = $this->cache->get($key);
        if (is_array($cached)) {
            return $cached;
        }

        $data = $this->inner->fetchData($endPoint);
        $this->cache->set($key, $data, $this->ttlSeconds);

        return $data;
    }

    public function fetchCsv(string $endPoint): Reader
    {
        return $this->inner->fetchCsv($endPoint);
    }

    private function cacheKey(string $endPoint): string
    {
        // PSR-16 forbids reserved characters in keys; hash to be safe.
        return $this->keyPrefix . hash('sha256', $endPoint);
    }
}
