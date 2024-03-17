<?php

namespace Tlab\IpmaApi\Observation\Biology;

class BiologyApiGroup
{
    public function createMolluscHarvestingProhibition(): MolluscHarvestingProhibition
    {
        return new MolluscHarvestingProhibition();
    }
}
