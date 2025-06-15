<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Enums;

enum ForecastDayEnum: int
{
    case TODAY = 0;

    case TOMORROW = 1;

    case DAY_AFTER_TOMORROW = 2;
}
