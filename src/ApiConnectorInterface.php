<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use League\Csv\Reader;
use Tlab\IpmaApi\Exception\IpmaApiException;

interface ApiConnectorInterface
{
    /**
     * @param string $endPoint
     *
     * @return array<mixed>
     * @throws IpmaApiException
     */
    public function fetchData(string $endPoint): array;

    /**
     * @param string $endPoint
     *
     * @return Reader
     * @throws IpmaApiException
     */
    public function fetchCsv(string $endPoint): Reader;
}
