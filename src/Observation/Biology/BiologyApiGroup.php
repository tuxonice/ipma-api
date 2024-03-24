<?php

namespace Tlab\IpmaApi\Observation\Biology;

use Tlab\IpmaApi\ApiConnector;

class BiologyApiGroup
{
    public function createMolluscHarvestingProhibition(): MolluscHarvestingProhibition
    {
        $apiConnector = new ApiConnector();

        return new MolluscHarvestingProhibition($apiConnector);
    }
}
