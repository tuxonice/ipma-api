<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use Psr\SimpleCache\CacheInterface;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByLocation;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;
use Tlab\IpmaApi\Forecast\Meteorology\UltravioletRiskForecast;
use Tlab\IpmaApi\Forecast\Oceanography\SeaStateForecast;
use Tlab\IpmaApi\Forecast\Warnings\WeatherWarnings;

class IpmaForecast
{
    public static function createDailyWeatherForecastByLocalApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): DailyWeatherForecastByLocation {
        return new DailyWeatherForecastByLocation(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createFireRiskForecastApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): FireRiskForecast {
        return new FireRiskForecast(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createUltravioletRiskForecastApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): UltravioletRiskForecast {
        return new UltravioletRiskForecast(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createSeaStateForecastApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): SeaStateForecast {
        return new SeaStateForecast(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createWeatherWarningsApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): WeatherWarnings {
        return new WeatherWarnings(new ApiConnector($cache, $ttlSeconds));
    }
}
