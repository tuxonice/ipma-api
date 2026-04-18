<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Service\SeaLocation;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Utils;

class SeaLocations
{
    private const END_POINT = Endpoints::SEA_LOCATIONS;

    /** @var list<SeaLocation> */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function query(): self
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        $this->data = $this->map($content);

        return $this;
    }

    public function filterByIdRegion(int $idRegion): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(SeaLocation $l) => $l->idRegion === $idRegion)
        );

        return $this;
    }

    public function filterByIdWarningArea(string $idWarningArea): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(SeaLocation $l) => Utils::compareString($l->idWarningArea, $idWarningArea))
        );

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(SeaLocation $l) => $l->globalIdLocal === $globalIdLocal)
        );

        return $this;
    }

    public function filterByIdLocal(int $idLocal): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(SeaLocation $l) => $l->idLocal === $idLocal)
        );

        return $this;
    }

    public function filterByName(string $name, bool $strict = false): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(SeaLocation $l) => Utils::compareString($l->name, $name, $strict))
        );

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(SeaLocation $l) => Utils::distance($l->latitude, $l->longitude, $latitude, $longitude) <= $radio
            )
        );

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): ?SeaLocation
    {
        $nearest = null;
        $shortest = null;
        foreach ($this->data as $location) {
            $distance = Utils::distance($location->latitude, $location->longitude, $latitude, $longitude);
            if ($shortest === null || $distance < $shortest) {
                $shortest = $distance;
                $nearest = $location;
            }
        }

        return $nearest;
    }

    /**
     * @return list<SeaLocation>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<SeaLocation>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $out[] = new SeaLocation(
                globalIdLocal: (int)$datum['globalIdLocal'],
                name: (string)$datum['local'],
                idLocal: (int)$datum['idLocal'],
                idRegion: (int)$datum['idRegiao'],
                idWarningArea: (string)$datum['idAreaAviso'],
                latitude: (float)$datum['latitude'],
                longitude: (float)$datum['longitude'],
            );
        }

        return $out;
    }
}
