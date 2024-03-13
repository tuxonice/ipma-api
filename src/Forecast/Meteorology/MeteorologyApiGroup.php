<?php

namespace Tlab\IpmaApi\Forecast\Meteorology;

use Tlab\IpmaApi\ApiConnector;

class MeteorologyApiGroup
{
    public function createDailyWeatherForecastByDayApi(): DailyWeatherForecastByDay
    {
        $apiConnector = new ApiConnector();

        return new DailyWeatherForecastByDay($apiConnector);
    }

    public function createDailyWeatherForecastByLocal(): DailyWeatherForecastByLocal
    {
        $apiConnector = new ApiConnector();

        return new DailyWeatherForecastByLocal($apiConnector);
    }

    public function createFireRiskForecast(): FireRiskForecast
    {
        $apiConnector = new ApiConnector();

        return new FireRiskForecast($apiConnector);
    }

    public function createUltravioletRiskForecast(): UltravioletRiskForecast
    {
        $apiConnector = new ApiConnector();

        return new UltravioletRiskForecast($apiConnector);
    }
}
