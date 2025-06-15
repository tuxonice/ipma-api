<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

interface ApiConnectorInterface
{
    /**
     * @param string $endPoint
     *
     * @return array<mixed>
     */
    public function fetchData(string $endPoint): array;
}
