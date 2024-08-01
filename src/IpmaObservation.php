<?php

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use Tlab\IpmaApi\Observation\Climate\DailyEvapotranspirationReference;
use Tlab\IpmaApi\Observation\Climate\MaximumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\MinimumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\PalmerDroughtSeverityIndex;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservation;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservationByHour;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;

class IpmaObservation
{
    public static function createMolluscHarvestingProhibitionApi(): MolluscHarvestingProhibition
    {
        $apiConnector = new ApiConnector();

        return new MolluscHarvestingProhibition($apiConnector);
    }

    public static function createDailyEvapotranspirationReferenceApi(): DailyEvapotranspirationReference
    {
        $apiConnector = new ApiConnector();

        return new DailyEvapotranspirationReference($apiConnector);
    }

    public static function createMaximumDailyTemperatureApi(): MaximumDailyTemperature
    {
        $apiConnector = new ApiConnector();

        return new MaximumDailyTemperature($apiConnector);
    }

    public static function createMinimumDailyTemperatureApi(): MinimumDailyTemperature
    {
        $apiConnector = new ApiConnector();

        return new MinimumDailyTemperature($apiConnector);
    }

    public static function createPalmerDroughtSeverityIndexApi(): PalmerDroughtSeverityIndex
    {
        $apiConnector = new ApiConnector();

        return new PalmerDroughtSeverityIndex($apiConnector);
    }

    public static function createWeatherStationObservationApi(): WeatherStationObservation
    {
        $apiConnector = new ApiConnector();

        return new WeatherStationObservation($apiConnector);
    }

    public static function createWeatherStationObservationByHourApi(): WeatherStationObservationByHour
    {
        $apiConnector = new ApiConnector();

        return new WeatherStationObservationByHour($apiConnector);
    }

    public static function createSeismicInformationApi(): SeismicInformation
    {
        $apiConnector = new ApiConnector();

        return new SeismicInformation($apiConnector);
    }
}
