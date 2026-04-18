<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Service;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class SeaLocation
{
    use ToArrayTrait;

    public function __construct(
        public readonly int $globalIdLocal,
        public readonly string $name,
        public readonly int $idLocal,
        public readonly int $idRegion,
        public readonly string $idWarningArea,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
