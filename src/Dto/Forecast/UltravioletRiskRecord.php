<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Forecast;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class UltravioletRiskRecord
{
    use ToArrayTrait;

    public function __construct(
        public readonly int $globalIdLocal,
        public readonly string $forecastDate,
        public readonly float $uvIndex,
        public readonly string $timeInterval,
        public readonly int $periodId,
    ) {
    }
}
