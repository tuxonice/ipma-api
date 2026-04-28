<?php

declare(strict_types=1);

namespace Tlab\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tlab\IpmaApi\IpmaService;
use Tlab\IpmaApi\Service\DistrictsIslandsLocations;
use Tlab\IpmaApi\Service\SeaLocations;
use Tlab\IpmaApi\Service\WeatherStations;

class IpmaTest extends TestCase
{
    private Psr16Cache $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = new Psr16Cache(new ArrayAdapter());
    }

    public function testCreateDistrictsIslandsLocationsApi(): void
    {
        $districtsIslandsLocationsApi = IpmaService::createDistrictsIslandsLocationsApi($this->cache);
        $this->assertInstanceOf(DistrictsIslandsLocations::class, $districtsIslandsLocationsApi);
    }

    public function testCreateSeaLocationsApi(): void
    {
        $seaLocationsApi = IpmaService::createSeaLocationsApi($this->cache);
        $this->assertInstanceOf(SeaLocations::class, $seaLocationsApi);
    }

    public function testCreateWeatherStationsApi(): void
    {
        $weatherStationsApi = IpmaService::createWeatherStationsApi($this->cache);
        $this->assertInstanceOf(WeatherStations::class, $weatherStationsApi);
    }
}
