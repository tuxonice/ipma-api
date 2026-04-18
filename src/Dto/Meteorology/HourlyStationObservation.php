<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Meteorology;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class HourlyStationObservation
{
    use ToArrayTrait;

    public function __construct(
        public readonly ?string $time,
        public readonly ?int $idEstacao,
        public readonly ?string $localEstacao,
        public readonly ?float $intensidadeVentoKM,
        public readonly ?float $temperatura,
        public readonly ?int $idDireccVento,
        public readonly ?string $descDirVento,
        public readonly ?float $precAcumulada,
        public readonly ?float $intensidadeVento,
        public readonly ?float $humidade,
        public readonly ?float $pressao,
        public readonly ?float $radiacao,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
