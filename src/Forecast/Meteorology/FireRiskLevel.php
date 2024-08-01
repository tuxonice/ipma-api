<?php

namespace Tlab\IpmaApi\Forecast\Meteorology;

enum FireRiskLevel
{
    case LOW_RISK;

    case MODERATE_RISK;

    case HIGH_RISK;

    case VERY_HIGH_RISK;

    case MAXIMUM_RISK;

    public function code(): int
    {
        return match ($this) {
            FireRiskLevel::LOW_RISK => 1,
            FireRiskLevel::MODERATE_RISK => 2,
            FireRiskLevel::HIGH_RISK => 3,
            FireRiskLevel::VERY_HIGH_RISK => 4,
            FireRiskLevel::MAXIMUM_RISK => 5,
        };
    }
}
