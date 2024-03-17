<?php

namespace Tlab\Tests;

use Tlab\IpmaApi\Forecast\ForecastApiGroup;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByDay;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByLocal;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;
use Tlab\IpmaApi\Forecast\Meteorology\MeteorologyApiGroup;
use Tlab\IpmaApi\Forecast\Meteorology\UltravioletRiskForecast;
use Tlab\IpmaApi\Forecast\Oceanography\OceanographyApiGroup;
use Tlab\IpmaApi\Forecast\Oceanography\SeaStateForecast;
use Tlab\IpmaApi\Forecast\Warnings;
use Tlab\IpmaApi\Ipma;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\Observation\Biology\BiologyApiGroup;
use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use Tlab\IpmaApi\Observation\Climate\ClimateApiGroup;
use Tlab\IpmaApi\Observation\Climate\DailyEvapotranspirationReference;
use Tlab\IpmaApi\Observation\Climate\MaximumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\MinimumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\PalmerDroughtSeverityIndex;
use Tlab\IpmaApi\Observation\Meteorology\MeteorologyApiGroup as ObservationMeteorologyApiGroup;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservation;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservationByHour;
use Tlab\IpmaApi\Observation\ObservationApiGroup;
use Tlab\IpmaApi\Observation\Seismic\SeismicApiGroup;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;
use Tlab\IpmaApi\Services\DistrictsIslandsLocations;

class IpmaTest extends TestCase
{
    public function testCreateDistrictsIslandsLocationsApi(): void
    {
        $districtsIslandsLocationsApi = Ipma::createDistrictsIslandsLocationsApi();
        $this->assertInstanceOf(DistrictsIslandsLocations::class, $districtsIslandsLocationsApi);
    }

    public function testCreateWarningsApi(): void
    {
        $warningsApi = Ipma::createWarningsApi();
        $this->assertInstanceOf(Warnings::class, $warningsApi);
    }

    public function testCreateMeteorologyApiGroup(): void
    {
        $forecastApiGroup = Ipma::createForecastApiGroup();
        $meteorologyApiGroup = $forecastApiGroup->createMeteorologyApiGroup();
        $dailyWeatherForecastByDay = $meteorologyApiGroup->createDailyWeatherForecastByDayApi();
        $dailyWeatherForecastByLocal = $meteorologyApiGroup->createDailyWeatherForecastByLocal();
        $fireRiskForecast = $meteorologyApiGroup->createFireRiskForecast();
        $ultravioletRiskForecast = $meteorologyApiGroup->createUltravioletRiskForecast();

        $this->assertInstanceOf(ForecastApiGroup::class, $forecastApiGroup);
        $this->assertInstanceOf(MeteorologyApiGroup::class, $meteorologyApiGroup);
        $this->assertInstanceOf(DailyWeatherForecastByDay::class, $dailyWeatherForecastByDay);
        $this->assertInstanceOf(DailyWeatherForecastByLocal::class, $dailyWeatherForecastByLocal);
        $this->assertInstanceOf(FireRiskForecast::class, $fireRiskForecast);
        $this->assertInstanceOf(UltravioletRiskForecast::class, $ultravioletRiskForecast);
    }

    public function testCreateOceanographyApiGroup(): void
    {
        $forecastApiGroup = Ipma::createForecastApiGroup();
        $oceanographyApiGroup = $forecastApiGroup->createOceanographyApiGroup();
        $seaStateForecast = $oceanographyApiGroup->createSeaStateForecastApi();

        $this->assertInstanceOf(ForecastApiGroup::class, $forecastApiGroup);
        $this->assertInstanceOf(OceanographyApiGroup::class, $oceanographyApiGroup);
        $this->assertInstanceOf(SeaStateForecast::class, $seaStateForecast);
    }

    public function testCreateObservationApiGroup(): void
    {
        $observationApiGroup = Ipma::createObservationApiGroup();
        $biologyApiGroup = $observationApiGroup->createBiologyApiGroup();
        $molluscHarvestingProhibition = $biologyApiGroup->createMolluscHarvestingProhibition();

        $this->assertInstanceOf(ObservationApiGroup::class, $observationApiGroup);
        $this->assertInstanceOf(BiologyApiGroup::class, $biologyApiGroup);
        $this->assertInstanceOf(MolluscHarvestingProhibition::class, $molluscHarvestingProhibition);

        $climateApiGroup = $observationApiGroup->createClimateApiGroup();
        $dailyEvapotranspirationReference = $climateApiGroup->createDailyEvapotranspirationReference();
        $maximumDailyTemperature = $climateApiGroup->createMaximumDailyTemperature();
        $minimumDailyTemperature = $climateApiGroup->createMinimumDailyTemperature();
        $palmerDroughtSeverityIndex = $climateApiGroup->createPalmerDroughtSeverityIndex();

        $this->assertInstanceOf(ClimateApiGroup::class, $climateApiGroup);
        $this->assertInstanceOf(DailyEvapotranspirationReference::class, $dailyEvapotranspirationReference);
        $this->assertInstanceOf(MaximumDailyTemperature::class, $maximumDailyTemperature);
        $this->assertInstanceOf(MinimumDailyTemperature::class, $minimumDailyTemperature);
        $this->assertInstanceOf(PalmerDroughtSeverityIndex::class, $palmerDroughtSeverityIndex);

        $meteorologyApiGroup = $observationApiGroup->createMeteorologyApiGroup();
        $weatherStationObservation = $meteorologyApiGroup->createWeatherStationObservation();
        $weatherStationObservationByHour = $meteorologyApiGroup->createWeatherStationObservationByHour();

        $this->assertInstanceOf(ObservationMeteorologyApiGroup::class, $meteorologyApiGroup);
        $this->assertInstanceOf(WeatherStationObservation::class, $weatherStationObservation);
        $this->assertInstanceOf(WeatherStationObservationByHour::class, $weatherStationObservationByHour);

        $seismicApiGroup = $observationApiGroup->createSeismicApiGroup();
        $seismicInformation = $seismicApiGroup->createSeismicInformation();

        $this->assertInstanceOf(SeismicApiGroup::class, $seismicApiGroup);
        $this->assertInstanceOf(SeismicInformation::class, $seismicInformation);
    }
}
