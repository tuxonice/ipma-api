<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto\Biology;

/**
 * Mollusc harvesting prohibition feature.
 *
 * The underlying data is a deeply nested GeoJSON feature with properties,
 * interdictions, species and classifications. The DTO exposes stable public
 * accessors for the fields used for filtering and surface access while still
 * letting advanced consumers reach the full raw structure via {@see raw()}
 * or {@see toArray()} for round-tripping/serialization.
 */
final class MolluscFeature
{
    /**
     * @param array<string, mixed> $raw Full original feature array.
     */
    public function __construct(
        public readonly string $type,
        public readonly string $id,
        public readonly string $name,
        public readonly string $code,
        public readonly string $zoneType,
        public readonly string $regionName,
        public readonly string $status,
        public readonly float $latitude,
        public readonly float $longitude,
        private readonly array $raw,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function raw(): array
    {
        return $this->raw;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }

    /**
     * @param array<string, mixed> $feature
     */
    public static function fromFeature(array $feature): self
    {
        $props = $feature['properties'] ?? [];
        $coords = $props['coords'] ?? ['latitude' => 0.0, 'longitude' => 0.0];

        return new self(
            type: (string)($feature['type'] ?? ''),
            id: (string)($feature['id'] ?? ''),
            name: (string)($props['name'] ?? ''),
            code: (string)($props['code'] ?? ''),
            zoneType: (string)($props['zone_type'] ?? ''),
            regionName: (string)($props['region_name'] ?? ''),
            status: (string)($props['status'] ?? ''),
            latitude: (float)($coords['latitude'] ?? 0.0),
            longitude: (float)($coords['longitude'] ?? 0.0),
            raw: $feature,
        );
    }
}
