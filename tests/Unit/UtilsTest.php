<?php

namespace Tlab\Tests;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\Utils;

class UtilsTest extends TestCase
{
    public function testDistanceCalculation(): void
    {
        self::assertEquals(295.49, Utils::distance(
            37.033,
            -7.821,
            39.38,
            -9.40737778
        ));
    }
}
