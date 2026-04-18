<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Forecast;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class FireRiskRecord
{
    use ToArrayTrait;

    public function __construct(
        public readonly string $dico,
        public readonly int $fireRiskLevel,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
