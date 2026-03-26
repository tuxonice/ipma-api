<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use Tlab\IpmaApi\Observation\Climate\DailyEvapotranspirationReference;
use Tlab\IpmaApi\Observation\Climate\MaximumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\MinimumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\PalmerDroughtSeverityIndex;
use Tlab\IpmaApi\Observation\Climate\TotalDailyPrecipitation;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;

class IpmaObservation
{
    public static function createSeismicInformationApi(): SeismicInformation
    {
        $apiConnector = new ApiConnector();

        return new SeismicInformation($apiConnector);
    }

    public static function createMolluscHarvestingProhibitionApi(): MolluscHarvestingProhibition
    {
        $apiConnector = new ApiConnector();

        return new MolluscHarvestingProhibition($apiConnector);
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

    public static function createTotalDailyPrecipitationApi(): TotalDailyPrecipitation
    {
        $apiConnector = new ApiConnector();

        return new TotalDailyPrecipitation($apiConnector);
    }

    public static function createDailyEvapotranspirationReferenceApi(): DailyEvapotranspirationReference
    {
        $apiConnector = new ApiConnector();

        return new DailyEvapotranspirationReference($apiConnector);
    }
}
