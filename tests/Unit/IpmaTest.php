<?php

namespace Tlab\Tests;

use Tlab\IpmaApi\IpmaService;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\Service\DistrictsIslandsLocations;
use Tlab\IpmaApi\Service\SeaLocations;
use Tlab\IpmaApi\Service\WeatherStations;

class IpmaTest extends TestCase
{
    public function testCreateDistrictsIslandsLocationsApi(): void
    {
        $districtsIslandsLocationsApi = IpmaService::createDistrictsIslandsLocationsApi();
        $this->assertInstanceOf(DistrictsIslandsLocations::class, $districtsIslandsLocationsApi);
    }

    public function testCreateSeaLocationsApi(): void
    {
        $seaLocationsApi = IpmaService::createSeaLocationsApi();
        $this->assertInstanceOf(SeaLocations::class, $seaLocationsApi);
    }

    public function testCreateWeatherStationsApi(): void
    {
        $weatherStationsApi = IpmaService::createWeatherStationsApi();
        $this->assertInstanceOf(WeatherStations::class, $weatherStationsApi);
    }
}
