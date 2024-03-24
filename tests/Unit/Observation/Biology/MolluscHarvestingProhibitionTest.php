<?php

namespace Tlab\Tests\Observation\Biology;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use PHPUnit\Framework\TestCase;

class MolluscHarvestingProhibitionTest extends TestCase
{

    public function testSomething(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        $molluscHarvestingProhibition->from();
    }
}
