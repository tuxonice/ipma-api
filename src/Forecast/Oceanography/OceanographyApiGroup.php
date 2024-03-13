<?php

namespace Tlab\IpmaApi\Forecast\Oceanography;

use Tlab\IpmaApi\ApiConnector;

class OceanographyApiGroup
{
    public function createSeaStateForecastApi(): SeaStateForecast
    {
        $apiConnector = new ApiConnector();

        return new SeaStateForecast($apiConnector);
    }
}
