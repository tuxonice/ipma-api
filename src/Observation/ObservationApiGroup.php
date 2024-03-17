<?php

namespace Tlab\IpmaApi\Observation;

use Tlab\IpmaApi\Observation\Biology\BiologyApiGroup;
use Tlab\IpmaApi\Observation\Climate\ClimateApiGroup;
use Tlab\IpmaApi\Observation\Meteorology\MeteorologyApiGroup;
use Tlab\IpmaApi\Observation\Seismic\SeismicApiGroup;

class ObservationApiGroup
{
    public function createBiologyApiGroup(): BiologyApiGroup
    {
        return new BiologyApiGroup();
    }

    public function createClimateApiGroup(): ClimateApiGroup
    {
        return new ClimateApiGroup();
    }

    public function createMeteorologyApiGroup(): MeteorologyApiGroup
    {
        return new MeteorologyApiGroup();
    }

    public function createSeismicApiGroup(): SeismicApiGroup
    {
        return new SeismicApiGroup();
    }
}
