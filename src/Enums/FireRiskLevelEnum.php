<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Enums;

enum FireRiskLevelEnum
{
    case LOW_RISK;

    case MODERATE_RISK;

    case HIGH_RISK;

    case VERY_HIGH_RISK;

    case MAXIMUM_RISK;

    public function code(): int
    {
        return match ($this) {
            FireRiskLevelEnum::LOW_RISK => 1,
            FireRiskLevelEnum::MODERATE_RISK => 2,
            FireRiskLevelEnum::HIGH_RISK => 3,
            FireRiskLevelEnum::VERY_HIGH_RISK => 4,
            FireRiskLevelEnum::MAXIMUM_RISK => 5,
        };
    }
}
