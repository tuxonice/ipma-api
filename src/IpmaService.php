<?php

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Service\DistrictsIslandsLocations;
use Tlab\IpmaApi\Service\SeaLocations;
use Tlab\IpmaApi\Service\WeatherStations;

class IpmaService
{
    public static function createDistrictsIslandsLocationsApi(): DistrictsIslandsLocations
    {
        $apiConnector = new ApiConnector();

        return new DistrictsIslandsLocations($apiConnector);
    }

    public static function createSeaLocationsApi(): SeaLocations
    {
        $apiConnector = new ApiConnector();

        return new SeaLocations($apiConnector);
    }

    public static function createWeatherStationsApi(): WeatherStations
    {
        $apiConnector = new ApiConnector();

        return new WeatherStations($apiConnector);
    }
}
