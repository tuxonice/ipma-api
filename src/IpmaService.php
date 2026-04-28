<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use Psr\SimpleCache\CacheInterface;
use Tlab\IpmaApi\Service\DistrictsIslandsLocations;
use Tlab\IpmaApi\Service\SeaLocations;
use Tlab\IpmaApi\Service\WeatherStations;

class IpmaService
{
    public static function createDistrictsIslandsLocationsApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): DistrictsIslandsLocations {
        return new DistrictsIslandsLocations(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createSeaLocationsApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): SeaLocations {
        return new SeaLocations(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createWeatherStationsApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): WeatherStations {
        return new WeatherStations(new ApiConnector($cache, $ttlSeconds));
    }
}
