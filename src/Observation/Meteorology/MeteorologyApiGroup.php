<?php

namespace Tlab\IpmaApi\Observation\Meteorology;

use Tlab\IpmaApi\ApiConnector;

class MeteorologyApiGroup
{
    public function createWeatherStationObservation(): WeatherStationObservation
    {
        $apiConnector = new ApiConnector();

        return new WeatherStationObservation($apiConnector);
    }

    public function createWeatherStationObservationByHour(): WeatherStationObservationByHour
    {
        $apiConnector = new ApiConnector();

        return new WeatherStationObservationByHour($apiConnector);
    }
}
