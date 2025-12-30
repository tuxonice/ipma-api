<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;

class IpmaObservation
{
    public static function createSeismicInformationApi(): SeismicInformation
    {
        $apiConnector = new ApiConnector();

        return new SeismicInformation($apiConnector);
    }
}
