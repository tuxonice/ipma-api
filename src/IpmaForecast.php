<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByDay;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByLocation;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;
use Tlab\IpmaApi\Forecast\Meteorology\UltravioletRiskForecast;
use Tlab\IpmaApi\Forecast\Oceanography\SeaStateForecast;
use Tlab\IpmaApi\Forecast\Warnings\WeatherWarnings;

class IpmaForecast
{
    private static ?ApiConnectorInterface $defaultApiConnector = null;

    private static function resolveApiConnector(?ApiConnectorInterface $apiConnector): ApiConnectorInterface
    {
        if ($apiConnector !== null) {
            return $apiConnector;
        }

        return self::$defaultApiConnector ??= new ApiConnector();
    }

    public static function createDailyWeatherForecastByDayApi(
        ?ApiConnectorInterface $apiConnector = null
    ): DailyWeatherForecastByDay {
        return new DailyWeatherForecastByDay(self::resolveApiConnector($apiConnector));
    }

    public static function createDailyWeatherForecastByLocalApi(
        ?ApiConnectorInterface $apiConnector = null
    ): DailyWeatherForecastByLocation {
        return new DailyWeatherForecastByLocation(self::resolveApiConnector($apiConnector));
    }

    public static function createFireRiskForecastApi(
        ?ApiConnectorInterface $apiConnector = null
    ): FireRiskForecast {
        return new FireRiskForecast(self::resolveApiConnector($apiConnector));
    }

    public static function createUltravioletRiskForecastApi(
        ?ApiConnectorInterface $apiConnector = null
    ): UltravioletRiskForecast {
        return new UltravioletRiskForecast(self::resolveApiConnector($apiConnector));
    }

    public static function createSeaStateForecastApi(
        ?ApiConnectorInterface $apiConnector = null
    ): SeaStateForecast {
        return new SeaStateForecast(self::resolveApiConnector($apiConnector));
    }

    public static function createWeatherWarningsApi(
        ?ApiConnectorInterface $apiConnector = null
    ): WeatherWarnings {
        return new WeatherWarnings(self::resolveApiConnector($apiConnector));
    }
}
