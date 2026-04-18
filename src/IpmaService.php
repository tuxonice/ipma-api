<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Service\DistrictsIslandsLocations;
use Tlab\IpmaApi\Service\SeaLocations;
use Tlab\IpmaApi\Service\WeatherStations;

class IpmaService
{
    private static ?ApiConnectorInterface $defaultApiConnector = null;

    private static function resolveApiConnector(?ApiConnectorInterface $apiConnector): ApiConnectorInterface
    {
        if ($apiConnector !== null) {
            return $apiConnector;
        }

        return self::$defaultApiConnector ??= new ApiConnector();
    }

    public static function createDistrictsIslandsLocationsApi(
        ?ApiConnectorInterface $apiConnector = null
    ): DistrictsIslandsLocations {
        return new DistrictsIslandsLocations(self::resolveApiConnector($apiConnector));
    }

    public static function createSeaLocationsApi(
        ?ApiConnectorInterface $apiConnector = null
    ): SeaLocations {
        return new SeaLocations(self::resolveApiConnector($apiConnector));
    }

    public static function createWeatherStationsApi(
        ?ApiConnectorInterface $apiConnector = null
    ): WeatherStations {
        return new WeatherStations(self::resolveApiConnector($apiConnector));
    }
}
