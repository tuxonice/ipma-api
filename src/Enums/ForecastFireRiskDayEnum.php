<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Enums;

enum ForecastFireRiskDayEnum: int
{
    case TODAY = 0;

    case TOMORROW = 1;
}
