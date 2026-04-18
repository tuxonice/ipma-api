<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Meteorology;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class DailyStationObservation
{
    use ToArrayTrait;

    public function __construct(
        public readonly ?float $windSpeed,
        public readonly ?float $temperature,
        public readonly ?float $solarRadiation,
        public readonly ?int $idWindDirection,
        public readonly ?float $accumulatedRain,
        public readonly ?float $windIntensity,
        public readonly ?float $humidity,
        public readonly ?float $atmosphericPressure,
        public readonly string $date,
    ) {
    }
}
