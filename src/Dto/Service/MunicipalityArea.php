<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Service;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class MunicipalityArea
{
    use ToArrayTrait;

    public function __construct(
        public readonly string $dico,
        public readonly string $nuts1,
        public readonly string $nuts2,
        public readonly string $nuts3,
        public readonly string $district,
        public readonly string $municipality,
        public readonly float $area,
        public readonly float $perimeter,
        public readonly int $altitudeMax,
        public readonly int $altitudeMin,
        public readonly ?DistrictLocation $location = null,
    ) {
    }
}
