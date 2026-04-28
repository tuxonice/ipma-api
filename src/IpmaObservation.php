<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

use Psr\SimpleCache\CacheInterface;
use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use Tlab\IpmaApi\Observation\Climate\DailyEvapotranspirationReference;
use Tlab\IpmaApi\Observation\Climate\MaximumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\MinimumDailyTemperature;
use Tlab\IpmaApi\Observation\Climate\PalmerDroughtSeverityIndex;
use Tlab\IpmaApi\Observation\Climate\TotalDailyPrecipitation;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservation;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;

class IpmaObservation
{
    public static function createSeismicInformationApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): SeismicInformation {
        return new SeismicInformation(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createMolluscHarvestingProhibitionApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): MolluscHarvestingProhibition {
        return new MolluscHarvestingProhibition(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createMaximumDailyTemperatureApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): MaximumDailyTemperature {
        return new MaximumDailyTemperature(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createMinimumDailyTemperatureApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): MinimumDailyTemperature {
        return new MinimumDailyTemperature(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createPalmerDroughtSeverityIndexApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): PalmerDroughtSeverityIndex {
        return new PalmerDroughtSeverityIndex(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createTotalDailyPrecipitationApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): TotalDailyPrecipitation {
        return new TotalDailyPrecipitation(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createDailyEvapotranspirationReferenceApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): DailyEvapotranspirationReference {
        return new DailyEvapotranspirationReference(new ApiConnector($cache, $ttlSeconds));
    }

    public static function createWeatherStationObservationApi(
        CacheInterface $cache,
        int $ttlSeconds = 3600,
    ): WeatherStationObservation {
        return new WeatherStationObservation(new ApiConnector($cache, $ttlSeconds));
    }
}
