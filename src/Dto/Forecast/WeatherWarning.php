<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Forecast;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class WeatherWarning
{
    use ToArrayTrait;

    public function __construct(
        public readonly string $text,
        public readonly string $awarenessTypeName,
        public readonly string $warningIdArea,
        public readonly string $startTime,
        public readonly string $endTime,
        public readonly string $awarenessLevelID,
    ) {
    }
}
