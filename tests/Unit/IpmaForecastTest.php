<?php

namespace Tlab\Tests;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByDay;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByLocation;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;
use Tlab\IpmaApi\Forecast\Meteorology\UltravioletRiskForecast;
use Tlab\IpmaApi\Forecast\Oceanography\SeaStateForecast;
use Tlab\IpmaApi\Forecast\Warnings\WeatherWarnings;
use Tlab\IpmaApi\IpmaForecast;

class IpmaForecastTest extends TestCase
{
    public function testCreateDailyWeatherForecastByDayApi(): void
    {
        $api = IpmaForecast::createDailyWeatherForecastByDayApi();
        $this->assertInstanceOf(DailyWeatherForecastByDay::class, $api);
    }

    public function testCreateDailyWeatherForecastByLocalApi(): void
    {
        $api = IpmaForecast::createDailyWeatherForecastByLocalApi();
        $this->assertInstanceOf(DailyWeatherForecastByLocation::class, $api);
    }

    public function testCreateFireRiskForecastApi(): void
    {
        $api = IpmaForecast::createFireRiskForecastApi();
        $this->assertInstanceOf(FireRiskForecast::class, $api);
    }

    public function testCreateUltravioletRiskForecastApi(): void
    {
        $api = IpmaForecast::createUltravioletRiskForecastApi();
        $this->assertInstanceOf(UltravioletRiskForecast::class, $api);
    }

    public function testCreateSeaStateForecastApi(): void
    {
        $api = IpmaForecast::createSeaStateForecastApi();
        $this->assertInstanceOf(SeaStateForecast::class, $api);
    }

    public function testCreateWeatherWarningsApi(): void
    {
        $api = IpmaForecast::createWeatherWarningsApi();
        $this->assertInstanceOf(WeatherWarnings::class, $api);
    }
}
