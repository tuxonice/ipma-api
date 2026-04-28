<?php

declare(strict_types=1);

namespace Tlab\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByLocation;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;
use Tlab\IpmaApi\Forecast\Meteorology\UltravioletRiskForecast;
use Tlab\IpmaApi\Forecast\Oceanography\SeaStateForecast;
use Tlab\IpmaApi\Forecast\Warnings\WeatherWarnings;
use Tlab\IpmaApi\IpmaForecast;

class IpmaForecastTest extends TestCase
{
    private Psr16Cache $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = new Psr16Cache(new ArrayAdapter());
    }

    public function testCreateDailyWeatherForecastByLocalApi(): void
    {
        $api = IpmaForecast::createDailyWeatherForecastByLocalApi($this->cache);
        $this->assertInstanceOf(DailyWeatherForecastByLocation::class, $api);
    }

    public function testCreateFireRiskForecastApi(): void
    {
        $api = IpmaForecast::createFireRiskForecastApi($this->cache);
        $this->assertInstanceOf(FireRiskForecast::class, $api);
    }

    public function testCreateUltravioletRiskForecastApi(): void
    {
        $api = IpmaForecast::createUltravioletRiskForecastApi($this->cache);
        $this->assertInstanceOf(UltravioletRiskForecast::class, $api);
    }

    public function testCreateSeaStateForecastApi(): void
    {
        $api = IpmaForecast::createSeaStateForecastApi($this->cache);
        $this->assertInstanceOf(SeaStateForecast::class, $api);
    }

    public function testCreateWeatherWarningsApi(): void
    {
        $api = IpmaForecast::createWeatherWarningsApi($this->cache);
        $this->assertInstanceOf(WeatherWarnings::class, $api);
    }
}
