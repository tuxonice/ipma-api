<?php

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Forecast\ForecastApiGroup;
use Tlab\IpmaApi\Forecast\Warnings;
use Tlab\IpmaApi\Services\DistrictsIslandsLocations;

class Ipma
{
    public static function createDistrictsIslandsLocationsApi(): DistrictsIslandsLocations
    {
        $apiConnector = new ApiConnector();

        return new DistrictsIslandsLocations($apiConnector);
    }

    public static function createWarningsApi(): Warnings
    {
        $apiConnector = new ApiConnector();

        return new Warnings($apiConnector);
    }

    public static function createForecastApiGroup(): ForecastApiGroup
    {
        return new ForecastApiGroup();
    }
}
