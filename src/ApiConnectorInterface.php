<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use League\Csv\Reader;

interface ApiConnectorInterface
{
    /**
     * @param string $endPoint
     *
     * @return array<mixed>
     */
    public function fetchData(string $endPoint): array;

    /**
     * @param string $endPoint
     *
     * @return Reader
     */
    public function fetchCsv(string $endPoint): Reader;
}
