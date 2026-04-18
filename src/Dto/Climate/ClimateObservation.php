<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Climate;

use Tlab\IpmaApi\Dto\ToArrayTrait;

final class ClimateObservation
{
    use ToArrayTrait;

    public function __construct(
        public readonly string $date,
        public readonly string $minimum,
        public readonly string $maximum,
        public readonly string $range,
        public readonly string $mean,
        public readonly string $std,
    ) {
    }

    /**
     * @param array<string, string> $record
     */
    public static function fromCsvRecord(array $record): self
    {
        return new self(
            date: (string)($record['date'] ?? ''),
            minimum: (string)($record['minimum'] ?? ''),
            maximum: (string)($record['maximum'] ?? ''),
            range: (string)($record['range'] ?? ''),
            mean: (string)($record['mean'] ?? ''),
            std: (string)($record['std'] ?? ''),
        );
    }
}
