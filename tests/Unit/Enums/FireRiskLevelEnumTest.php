<?php

namespace Tlab\Tests\Enums;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\Enums\FireRiskLevelEnum;

class FireRiskLevelEnumTest extends TestCase
{
    public function testLowRiskCode(): void
    {
        $this->assertEquals(1, FireRiskLevelEnum::LOW_RISK->code());
    }

    public function testModerateRiskCode(): void
    {
        $this->assertEquals(2, FireRiskLevelEnum::MODERATE_RISK->code());
    }

    public function testHighRiskCode(): void
    {
        $this->assertEquals(3, FireRiskLevelEnum::HIGH_RISK->code());
    }

    public function testVeryHighRiskCode(): void
    {
        $this->assertEquals(4, FireRiskLevelEnum::VERY_HIGH_RISK->code());
    }

    public function testMaximumRiskCode(): void
    {
        $this->assertEquals(5, FireRiskLevelEnum::MAXIMUM_RISK->code());
    }
}
