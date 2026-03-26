<?php

namespace Tlab\Tests;

use League\Csv\Reader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Tlab\IpmaApi\ApiConnector;

class ApiConnectorTest extends TestCase
{
    public function testFetchData(): void
    {
        $expectedData = [
            'owner' => 'IPMA',
            'country' => 'PT',
            'data' => ['test' => 'value']
        ];

        $mockResponse = new MockResponse(json_encode($expectedData));
        $httpClient = new MockHttpClient($mockResponse);

        $connector = new class ($httpClient) extends ApiConnector {
            private $client;

            public function __construct($client)
            {
                $this->client = $client;
            }

            public function fetchData(string $endPoint): array
            {
                $response = $this->client->request('GET', $endPoint);
                return $response->toArray();
            }
        };

        $result = $connector->fetchData('https://api.ipma.pt/test');

        $this->assertEquals($expectedData, $result);
    }

    public function testFetchCsv(): void
    {
        $csvContent = "date,value\n2024-01-01,10.5\n2024-01-02,11.2";

        $mockResponse = new MockResponse($csvContent);
        $httpClient = new MockHttpClient($mockResponse);

        $connector = new class ($httpClient) extends ApiConnector {
            private $client;

            public function __construct($client)
            {
                $this->client = $client;
            }

            public function fetchCsv(string $endPoint): Reader
            {
                $response = $this->client->request('GET', $endPoint);
                return Reader::fromString($response->getContent());
            }
        };

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
}
