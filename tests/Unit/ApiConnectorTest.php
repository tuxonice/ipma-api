<?php

declare(strict_types=1);

namespace Tlab\Tests;

use League\Csv\Reader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Tlab\IpmaApi\ApiConnector;

class ApiConnectorTest extends TestCase
{
    private Psr16Cache $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = new Psr16Cache(new ArrayAdapter());
    }

    public function testFetchData(): void
    {
        $expectedData = [
            'owner' => 'IPMA',
            'country' => 'PT',
            'data' => ['test' => 'value']
        ];

        $httpClient = new MockHttpClient(new MockResponse(json_encode($expectedData)));
        $connector = new ApiConnector($this->cache, client: $httpClient);

        $result = $connector->fetchData('https://api.ipma.pt/test');

        $this->assertEquals($expectedData, $result);
    }

    public function testFetchDataIsCachedOnSecondCall(): void
    {
        $calls = 0;
        $httpClient = new MockHttpClient(function () use (&$calls) {
            $calls++;
            return new MockResponse(json_encode(['value' => 42]));
        });

        $connector = new ApiConnector($this->cache, ttlSeconds: 60, client: $httpClient);

        $first = $connector->fetchData('https://api.ipma.pt/test.json');
        $second = $connector->fetchData('https://api.ipma.pt/test.json');

        $this->assertSame($first, $second);
        $this->assertSame(1, $calls, 'HTTP must be called only once; second call served from cache');
    }

    public function testDifferentEndpointsUseDifferentCacheEntries(): void
    {
        $calls = 0;
        $httpClient = new MockHttpClient(function (string $method, string $url) use (&$calls) {
            $calls++;
            return new MockResponse(json_encode(['endpoint' => $url]));
        });

        $connector = new ApiConnector($this->cache, ttlSeconds: 60, client: $httpClient);

        $connector->fetchData('https://api.ipma.pt/a.json');
        $connector->fetchData('https://api.ipma.pt/b.json');

        $this->assertSame(2, $calls);
    }

    public function testFetchCsv(): void
    {
        $csvContent = "date,value\n2024-01-01,10.5\n2024-01-02,11.2";
        $httpClient = new MockHttpClient(new MockResponse($csvContent));
        $connector = new ApiConnector($this->cache, client: $httpClient);

        $result = $connector->fetchCsv('https://api.ipma.pt/test.csv');

        $this->assertInstanceOf(Reader::class, $result);

        $result->setHeaderOffset(0);
        $records = [];
        foreach ($result->getRecords() as $record) {
            $records[] = $record;
        }

        $this->assertCount(2, $records);
        $this->assertEquals('10.5', $records[0]['value']);
        $this->assertEquals('11.2', $records[1]['value']);
    }

    public function testFetchCsvIsCachedOnSecondCall(): void
    {
        $calls = 0;
        $httpClient = new MockHttpClient(function () use (&$calls) {
            $calls++;
            return new MockResponse("a,b\n1,2");
        });

        $connector = new ApiConnector($this->cache, ttlSeconds: 60, client: $httpClient);

        $first = $connector->fetchCsv('https://api.ipma.pt/x.csv');
        $second = $connector->fetchCsv('https://api.ipma.pt/x.csv');

        $this->assertSame(1, $calls, 'HTTP must be called only once; second call served from cache');
        $this->assertInstanceOf(Reader::class, $first);
        $this->assertInstanceOf(Reader::class, $second);
    }
}
