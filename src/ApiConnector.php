<?php

namespace Tlab\IpmaApi;

use Symfony\Component\HttpClient\HttpClient;

class ApiConnector
{
    /**
     * @param string $endPoint
     *
     * @return array<mixed>
     */
    public function fetchData(string $endPoint): array
    {
        $client = HttpClient::create();

        $response = $client->request(
            'GET',
            $endPoint
        );

        return $response->toArray();
    }
}
