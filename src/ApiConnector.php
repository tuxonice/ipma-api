<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use League\Csv\Reader;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Tlab\IpmaApi\Exception\IpmaApiException;
use Tlab\IpmaApi\Exception\IpmaDecodingException;
use Tlab\IpmaApi\Exception\IpmaResponseException;
use Tlab\IpmaApi\Exception\IpmaTransportException;

class ApiConnector implements ApiConnectorInterface
{
    private HttpClientInterface $client;

    public function __construct(?HttpClientInterface $client = null)
    {
        $this->client = $client ?? HttpClient::create();
    }

    /**
     * @param string $endPoint
     *
     * @return array<mixed>
     * @throws IpmaApiException
     */
    public function fetchData(string $endPoint): array
    {
        try {
            $response = $this->client->request('GET', $endPoint);

            return $response->toArray();
        } catch (DecodingExceptionInterface $e) {
            throw new IpmaDecodingException(
                sprintf('Failed to decode response body from "%s".', $endPoint),
                0,
                $e
            );
        } catch (HttpExceptionInterface $e) {
            throw new IpmaResponseException(
                sprintf('Unexpected HTTP response from "%s".', $endPoint),
                0,
                $e
            );
        } catch (TransportExceptionInterface $e) {
            throw new IpmaTransportException(
                sprintf('Transport error while calling "%s".', $endPoint),
                0,
                $e
            );
        }
    }

    /**
     * @param string $endPoint
     *
     * @return Reader
     * @throws IpmaApiException
     */
    public function fetchCsv(string $endPoint): Reader
    {
        try {
            $response = $this->client->request('GET', $endPoint);

            return Reader::fromString($response->getContent());
        } catch (HttpExceptionInterface $e) {
            throw new IpmaResponseException(
                sprintf('Unexpected HTTP response from "%s".', $endPoint),
                0,
                $e
            );
        } catch (TransportExceptionInterface $e) {
            throw new IpmaTransportException(
                sprintf('Transport error while calling "%s".', $endPoint),
                0,
                $e
            );
        }
    }
}
