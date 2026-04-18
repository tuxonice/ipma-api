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
    private static ?ApiConnectorInterface $defaultApiConnector = null;

    private static function resolveApiConnector(?ApiConnectorInterface $apiConnector): ApiConnectorInterface
    {
        if ($apiConnector !== null) {
            return $apiConnector;
        }

        return self::$defaultApiConnector ??= new ApiConnector();
    }

    public static function createSeismicInformationApi(
        ?ApiConnectorInterface $apiConnector = null
    ): SeismicInformation {
        return new SeismicInformation(self::resolveApiConnector($apiConnector));
    }

    public static function createMolluscHarvestingProhibitionApi(
        ?ApiConnectorInterface $apiConnector = null
    ): MolluscHarvestingProhibition {
        return new MolluscHarvestingProhibition(self::resolveApiConnector($apiConnector));
    }

    public static function createMaximumDailyTemperatureApi(
        ?ApiConnectorInterface $apiConnector = null
    ): MaximumDailyTemperature {
        return new MaximumDailyTemperature(self::resolveApiConnector($apiConnector));
    }

    public static function createMinimumDailyTemperatureApi(
        ?ApiConnectorInterface $apiConnector = null
    ): MinimumDailyTemperature {
        return new MinimumDailyTemperature(self::resolveApiConnector($apiConnector));
    }

    public static function createPalmerDroughtSeverityIndexApi(
        ?ApiConnectorInterface $apiConnector = null
    ): PalmerDroughtSeverityIndex {
        return new PalmerDroughtSeverityIndex(self::resolveApiConnector($apiConnector));
    }

    public static function createTotalDailyPrecipitationApi(
        ?ApiConnectorInterface $apiConnector = null
    ): TotalDailyPrecipitation {
        return new TotalDailyPrecipitation(self::resolveApiConnector($apiConnector));
    }

    public static function createDailyEvapotranspirationReferenceApi(
        ?ApiConnectorInterface $apiConnector = null
    ): DailyEvapotranspirationReference {
        return new DailyEvapotranspirationReference(self::resolveApiConnector($apiConnector));
    }
}
