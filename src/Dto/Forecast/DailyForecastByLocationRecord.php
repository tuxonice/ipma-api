<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Forecast;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class DailyForecastByLocationRecord
{
    use ToArrayTrait;

    public function __construct(
        public readonly string $forecastDate,
        public readonly int $idWeatherType,
        public readonly int $windSpeedClass,
        public readonly ?int $rainfallIntensity,
        public readonly float $rainfallProb,
        public readonly float $minTemp,
        public readonly float $maxTemp,
        public readonly string $winDir,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
