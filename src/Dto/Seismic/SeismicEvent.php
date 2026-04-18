<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Seismic;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class SeismicEvent
{
    use ToArrayTrait;

    public function __construct(
        public readonly string $seismId,
        public readonly string $googleMapRef,
        public readonly ?string $degree,
        public readonly string $magType,
        public readonly float $magnitude,
        public readonly int $depth,
        public readonly string $tensorRef,
        public readonly string $shakeMapId,
        public readonly string $shakeMapRef,
        public readonly ?string $location,
        public readonly string $regionName,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $source,
        public readonly ?string $sensed,
        public readonly string $time,
        public readonly string $updateDate,
    ) {
    }
}
