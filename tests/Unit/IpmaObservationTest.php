<?php

declare(strict_types=1);

namespace Tlab\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tlab\IpmaApi\IpmaObservation;
use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use Tlab\IpmaApi\Observation\Climate\DailyEvapotranspirationReference;
use Tlab\IpmaApi\Observation\Climate\MaximumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\MinimumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\PalmerDroughtSeverityIndex;
use Tlab\IpmaApi\Observation\Climate\TotalDailyPrecipitation;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservation;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;

class IpmaObservationTest extends TestCase
{
    private Psr16Cache $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = new Psr16Cache(new ArrayAdapter());
    }

    public function testCreateSeismicInformationApi(): void
    {
        $api = IpmaObservation::createSeismicInformationApi($this->cache);
        $this->assertInstanceOf(SeismicInformation::class, $api);
    }

    public function testCreateMolluscHarvestingProhibitionApi(): void
    {
        $api = IpmaObservation::createMolluscHarvestingProhibitionApi($this->cache);
        $this->assertInstanceOf(MolluscHarvestingProhibition::class, $api);
    }

    public function testCreateMaximumDailyTemperatureApi(): void
    {
        $api = IpmaObservation::createMaximumDailyTemperatureApi($this->cache);
        $this->assertInstanceOf(MaximumDailyTemperature::class, $api);
    }

    public function testCreateMinimumDailyTemperatureApi(): void
    {
        $api = IpmaObservation::createMinimumDailyTemperatureApi($this->cache);
        $this->assertInstanceOf(MinimumDailyTemperature::class, $api);
    }

    public function testCreatePalmerDroughtSeverityIndexApi(): void
    {
        $api = IpmaObservation::createPalmerDroughtSeverityIndexApi($this->cache);
        $this->assertInstanceOf(PalmerDroughtSeverityIndex::class, $api);
    }

    public function testCreateTotalDailyPrecipitationApi(): void
    {
        $api = IpmaObservation::createTotalDailyPrecipitationApi($this->cache);
        $this->assertInstanceOf(TotalDailyPrecipitation::class, $api);
    }

    public function testCreateDailyEvapotranspirationReferenceApi(): void
    {
        $api = IpmaObservation::createDailyEvapotranspirationReferenceApi($this->cache);
        $this->assertInstanceOf(DailyEvapotranspirationReference::class, $api);
    }

    public function testCreateWeatherStationObservationApi(): void
    {
        $api = IpmaObservation::createWeatherStationObservationApi($this->cache);
        $this->assertInstanceOf(WeatherStationObservation::class, $api);
    }
}
