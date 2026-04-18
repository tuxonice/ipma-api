<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Service;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class WeatherStation
{
    use ToArrayTrait;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
