<?php

namespace Tlab\IpmaApi\Observation\Biology;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Biology\MolluscFeature;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Utils;

class MolluscHarvestingProhibition
{
    private const END_POINT = Endpoints::MOLLUSC_HARVESTING_PROHIBITION;

    private const OPEN = 'open';
    private const CLOSE = 'CLOSE';

    /** @var list<MolluscFeature> */
    private array $data = [];

    /** @var array<string, mixed> */
    private array $metaData = [];

    private ?string $interdictionType = null;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(): self
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);

        $this->metaData = [
            "type" => $content['type'],
            "crs" => $content['crs'],
            "snmb_reference" => $content['snmb_reference'],
            "cd_decision" => $content['cd_decision'],
            "publication_date" => $content['publication_date'],
            "bulletin_name" => $content['bulletin_name'],
            "owner" => $content['owner'],
            "project" => $content['project'],
        ];

        $features = [];
        foreach ($content['features'] as $feature) {
            unset($feature['geometry']);

            $representativePoint = $feature['properties']['representative_point'] ?? '';
            [$latitude, $longitude] = $this->extractCoords($representativePoint);
            $feature['properties']['coords'] = [
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];

            $features[] = MolluscFeature::fromFeature($feature);
        }
        $this->data = $features;

        return $this;
    }

    public function filterByName(string $name): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(MolluscFeature $f) => str_contains(strtolower($f->name), strtolower($name))
        ));

        return $this;
    }

    public function filterByCode(string $code): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(MolluscFeature $f) => str_contains(strtolower($f->code), strtolower($code))
        ));

        return $this;
    }

    public function filterByZoneType(string $zoneType): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(MolluscFeature $f) => str_contains(strtolower($f->zoneType), strtolower($zoneType))
        ));

        return $this;
    }

    public function filterByRegionName(string $regionName): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(MolluscFeature $f) => str_contains(strtolower($f->regionName), strtolower($regionName))
        ));

        return $this;
    }

    public function filterByStatus(string $status): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(MolluscFeature $f) => str_contains(strtolower($f->status), strtolower($status))
        ));

        return $this;
    }

    public function filterByOpen(): self
    {
        $this->interdictionType = self::OPEN;

        return $this;
    }

    public function filterByClose(): self
    {
        $this->interdictionType = self::CLOSE;

        return $this;
    }

    public function filterByScientificName(string $scientificName): self
    {
        return $this->filterInterdiction('specie_s', $scientificName);
    }

    public function filterByCommonName(string $commonName): self
    {
        return $this->filterInterdiction('specie_c', $commonName);
    }

    public function filterByClassification(string $classification): self
    {
        return $this->filterInterdiction('classification', $classification);
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(MolluscFeature $f) => Utils::distance($f->latitude, $f->longitude, $latitude, $longitude) <= $radio
        ));

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): ?MolluscFeature
    {
        $nearest = null;
        $shortest = null;
        foreach ($this->data as $feature) {
            $distance = Utils::distance($feature->latitude, $feature->longitude, $latitude, $longitude);
            if ($shortest === null || $distance < $shortest) {
                $shortest = $distance;
                $nearest = $feature;
            }
        }

        return $nearest;
    }

    /**
     * @return list<MolluscFeature>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @return array<string, mixed>
     */
    public function getMetaData(): array
    {
        return $this->metaData;
    }

    private function filterInterdiction(string $key, string $needle): self
    {
        $filtered = [];
        foreach ($this->data as $feature) {
            $raw = $feature->raw();
            $interdictions = $raw['properties']['interdictions'] ?? ['open' => [], 'close' => []];

            $candidates = match ($this->interdictionType) {
                self::OPEN => $interdictions['open'] ?? [],
                self::CLOSE => $interdictions['close'] ?? [],
                default => array_merge($interdictions['open'] ?? [], $interdictions['close'] ?? []),
            };

            foreach ($candidates as $interdiction) {
                if (($interdiction[$key] ?? null) === $needle) {
                    $filtered[] = $feature;
                    break;
                }
            }
        }
        $this->data = $filtered;

        return $this;
    }

    /**
     * @return array{0: float|null, 1: float|null}
     */
    private function extractCoords(mixed $representativePoint): array
    {
        $pattern = '/POINT \(([-+]?\d{1,3}\.\d+?) ([-+]?\d{1,3}\.\d+?)\)/';

        if (is_string($representativePoint) && preg_match($pattern, $representativePoint, $matches)) {
            return [(float)$matches[2], (float)$matches[1]];
        }

        return [null, null];
    }
}
