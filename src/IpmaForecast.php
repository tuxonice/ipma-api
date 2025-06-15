<?php

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByDay;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByLocal;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;
use Tlab\IpmaApi\Forecast\Meteorology\UltravioletRiskForecast;
use Tlab\IpmaApi\Forecast\Oceanography\SeaStateForecast;
use Tlab\IpmaApi\Forecast\Warnings\WeatherWarnings;

class IpmaForecast
{
    public static function createDailyWeatherForecastByDayApi(): DailyWeatherForecastByDay
    {
        $apiConnector = new ApiConnector();

        return new DailyWeatherForecastByDay($apiConnector);
    }

    public static function createDailyWeatherForecastByLocalApi(): DailyWeatherForecastByLocal
    {
        $apiConnector = new ApiConnector();

        return new DailyWeatherForecastByLocal($apiConnector);
    }

    public static function createFireRiskForecastApi(): FireRiskForecast
    {
        $apiConnector = new ApiConnector();

        return new FireRiskForecast($apiConnector);
    }

    public static function createUltravioletRiskForecastApi(): UltravioletRiskForecast
    {
        $apiConnector = new ApiConnector();

        return new UltravioletRiskForecast($apiConnector);
    }

    public static function createSeaStateForecastApi(): SeaStateForecast
    {
        $apiConnector = new ApiConnector();

        return new SeaStateForecast($apiConnector);
    }

    public static function createWeatherWarningsApi(): WeatherWarnings
    {
        $apiConnector = new ApiConnector();

        return new WeatherWarnings($apiConnector);
    }
}
