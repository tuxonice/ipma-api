<?php

namespace Tlab\IpmaApi;

use League\Csv\AbstractCsv;
use League\Csv\Reader;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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

    /**
     * @param string $endPoint
     *
     * @return Reader
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function fetchCsv(string $endPoint): Reader
    {
        $client = HttpClient::create();

        $response = $client->request(
            'GET',
            $endPoint
        );

        return Reader::createFromString($response->getContent());
    }
}
