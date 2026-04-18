<?php

declare(strict_types=1);

namespace Tlab\Tests;

use League\Csv\Reader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\CachedApiConnector;

class CachedApiConnectorTest extends TestCase
{
    public function testFetchDataIsCachedOnSecondCall(): void
    {
        $inner = new class implements ApiConnectorInterface {
            public int $calls = 0;

            public function fetchData(string $endPoint): array
            {
                $this->calls++;
                return ['value' => 42, 'endpoint' => $endPoint];
            }

            public function fetchCsv(string $endPoint): Reader
            {
                return Reader::fromString('');
            }
        };

        $cache = new Psr16Cache(new ArrayAdapter());
        $connector = new CachedApiConnector($inner, $cache, 60);

        $first = $connector->fetchData('https://api.ipma.pt/test.json');
        $second = $connector->fetchData('https://api.ipma.pt/test.json');

        $this->assertSame($first, $second);
        $this->assertSame(1, $inner->calls, 'Inner connector must be called only once');
    }

    public function testDifferentEndpointsUseDifferentCacheEntries(): void
    {
        $inner = new class implements ApiConnectorInterface {
            public int $calls = 0;

            public function fetchData(string $endPoint): array
            {
                $this->calls++;
                return ['endpoint' => $endPoint];
            }

            public function fetchCsv(string $endPoint): Reader
            {
                return Reader::fromString('');
            }
        };

        $cache = new Psr16Cache(new ArrayAdapter());
        $connector = new CachedApiConnector($inner, $cache, 60);

        $connector->fetchData('https://api.ipma.pt/a.json');
        $connector->fetchData('https://api.ipma.pt/b.json');

        $this->assertSame(2, $inner->calls);
    }

    public function testFetchCsvIsPassedThrough(): void
    {
        $inner = new class implements ApiConnectorInterface {
            public int $calls = 0;

            public function fetchData(string $endPoint): array
            {
                return [];
            }

            public function fetchCsv(string $endPoint): Reader
            {
                $this->calls++;
                return Reader::fromString("a,b\n1,2");
            }
        };

        $cache = new Psr16Cache(new ArrayAdapter());
        $connector = new CachedApiConnector($inner, $cache, 60);

        $connector->fetchCsv('https://api.ipma.pt/x.csv');
        $connector->fetchCsv('https://api.ipma.pt/x.csv');

        $this->assertSame(2, $inner->calls, 'CSV responses are not cached');
    }
}
