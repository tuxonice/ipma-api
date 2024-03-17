<?php

namespace Tlab\IpmaApi\Observation\Seismic;

use Tlab\IpmaApi\ApiConnector;

class SeismicApiGroup
{
    public function createSeismicInformation(): SeismicInformation
    {
        $apiConnector = new ApiConnector();

        return new SeismicInformation($apiConnector);
    }
}
