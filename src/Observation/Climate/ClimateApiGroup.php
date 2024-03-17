<?php

namespace Tlab\IpmaApi\Observation\Climate;

use Tlab\IpmaApi\ApiConnector;

class ClimateApiGroup
{
    public function createDailyEvapotranspirationReference(): DailyEvapotranspirationReference
    {
        $apiConnector = new ApiConnector();

        return new DailyEvapotranspirationReference($apiConnector);
    }

    public function createMaximumDailyTemperature(): MaximumDailyTemperature
    {
        $apiConnector = new ApiConnector();

        return new MaximumDailyTemperature($apiConnector);
    }

    public function createMinimumDailyTemperature(): MinimumDailyTemperature
    {
        $apiConnector = new ApiConnector();

        return new MinimumDailyTemperature($apiConnector);
    }

    public function createPalmerDroughtSeverityIndex(): PalmerDroughtSeverityIndex
    {
        $apiConnector = new ApiConnector();

        return new PalmerDroughtSeverityIndex($apiConnector);
    }
}
