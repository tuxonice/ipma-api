<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Forecast;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class SeaStateRecord
{
    use ToArrayTrait;

    public function __construct(
        public readonly int $globalIdLocal,
        public readonly string $predWaveDir,
        public readonly float $waveHighMin,
        public readonly float $waveHighMax,
        public readonly float $wavePeriodMin,
        public readonly float $wavePeriodMax,
        public readonly float $totalSeaMin,
        public readonly float $totalSeaMax,
        public readonly float $sstMin,
        public readonly float $sstMax,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
