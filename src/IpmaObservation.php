<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use Tlab\IpmaApi\Observation\Climate\MaximumDailyTemperature;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;

class IpmaObservation
{
    public static function createSeismicInformationApi(): SeismicInformation
    {
        $apiConnector = new ApiConnector();

        return new SeismicInformation($apiConnector);
    }

    public static function createMolluscHarvestingProhibitionApi(): MolluscHarvestingProhibition
    {
        $apiConnector = new ApiConnector();

        return new MolluscHarvestingProhibition($apiConnector);
    }

    public static function createMaximumDailyTemperatureApi(): MaximumDailyTemperature
    {
        $apiConnector = new ApiConnector();

        return new MaximumDailyTemperature($apiConnector);
    }
}
