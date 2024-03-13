<?php

namespace Tlab\IpmaApi\Forecast;

use Tlab\IpmaApi\Forecast\Meteorology\MeteorologyApiGroup;
use Tlab\IpmaApi\Forecast\Oceanography\OceanographyApiGroup;

class ForecastApiGroup
{
    public function createMeteorologyApiGroup(): MeteorologyApiGroup
    {
            return new MeteorologyApiGroup();
    }

    public function createOceanographyApiGroup(): OceanographyApiGroup
    {
        return new OceanographyApiGroup();
    }
}
