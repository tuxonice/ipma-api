<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Service;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class DistrictLocation
{
    use ToArrayTrait;

    public function __construct(
        public readonly int $globalIdLocal,
        public readonly string $name,
        public readonly int $idMunicipality,
        public readonly int $idDistrict,
        public readonly int $idRegion,
        public readonly string $idWarningArea,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
