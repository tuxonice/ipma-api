<?php

namespace Tlab\Tests;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\IpmaObservation;
use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use Tlab\IpmaApi\Observation\Climate\DailyEvapotranspirationReference;
use Tlab\IpmaApi\Observation\Climate\MaximumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\MinimumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\PalmerDroughtSeverityIndex;
use Tlab\IpmaApi\Observation\Climate\TotalDailyPrecipitation;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;

class IpmaObservationTest extends TestCase
{
    public function testCreateSeismicInformationApi(): void
    {
        $api = IpmaObservation::createSeismicInformationApi();
        $this->assertInstanceOf(SeismicInformation::class, $api);
    }

    public function testCreateMolluscHarvestingProhibitionApi(): void
    {
        $api = IpmaObservation::createMolluscHarvestingProhibitionApi();
        $this->assertInstanceOf(MolluscHarvestingProhibition::class, $api);
    }

    public function testCreateMaximumDailyTemperatureApi(): void
    {
        $api = IpmaObservation::createMaximumDailyTemperatureApi();
        $this->assertInstanceOf(MaximumDailyTemperature::class, $api);
    }

    public function testCreateMinimumDailyTemperatureApi(): void
    {
        $api = IpmaObservation::createMinimumDailyTemperatureApi();
        $this->assertInstanceOf(MinimumDailyTemperature::class, $api);
    }

    public function testCreatePalmerDroughtSeverityIndexApi(): void
    {
        $api = IpmaObservation::createPalmerDroughtSeverityIndexApi();
        $this->assertInstanceOf(PalmerDroughtSeverityIndex::class, $api);
    }

    public function testCreateTotalDailyPrecipitationApi(): void
    {
        $api = IpmaObservation::createTotalDailyPrecipitationApi();
        $this->assertInstanceOf(TotalDailyPrecipitation::class, $api);
    }

    public function testCreateDailyEvapotranspirationReferenceApi(): void
    {
        $api = IpmaObservation::createDailyEvapotranspirationReferenceApi();
        $this->assertInstanceOf(DailyEvapotranspirationReference::class, $api);
    }
}
