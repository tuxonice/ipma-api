<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Utils;

class SeaLocations
{
    private const END_POINT = 'https://api.ipma.pt/open-data/sea-locations.json';

    /**
     * @var array
     */
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
            array_filter($this->data, function (array $element) use ($idRegion) {
                return $element['idRegion'] === $idRegion;
            })
        );

        return $this;
    }

    public function filterByIdWarningArea(string $idWarningArea): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($idWarningArea) {
                return Utils::compareString($element['idWarningArea'], $idWarningArea);
            })
        );

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($globalIdLocal) {
                return $element['globalIdLocal'] === $globalIdLocal;
            })
        );

        return $this;
    }

    public function filterByIdLocal(int $idLocal): self
    {
        $this->data = array_values(
            array_filter($this->data, fn (array $element) => $element['idLocal'] === $idLocal)
        );

        return $this;
    }

    public function filterByName(string $name, bool $strict = false): self
    {
        $this->data = array_values(
            array_filter($this->data, fn (array $element) => Utils::compareString($element['name'], $name, $strict))
        );

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => Utils::distance(
                $element['latitude'],
                $element['longitude'],
                $latitude,
                $longitude
            ) <= $radio)
        );

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): array
    {
        $shortestDistanceData = [];
        $shortestDistance = null;
        foreach ($this->data as $datum) {
            $distance = Utils::distance($datum['latitude'], $datum['longitude'], $latitude, $longitude);

            if ($shortestDistance === null) {
                $shortestDistanceData = $datum;
                $shortestDistance = $distance;

                continue;
            }

            if ($shortestDistance > $distance) {
                $shortestDistance = $distance;
                $shortestDistanceData = $datum;
            }
        }

        return $shortestDistanceData;
    }

    public function get(): array
    {
        return $this->data;
    }

    private function map(array $data): array
    {
        $cleanData = [];
        foreach ($data as $datum) {
            $cleanData[] = [
                'globalIdLocal' => (int)$datum['globalIdLocal'],
                'name' => $datum['local'],
                'idLocal' => (int)$datum['idLocal'],
                'idRegion' => (int)$datum['idRegiao'],
                'idWarningArea' => $datum['idAreaAviso'],
                'latitude' => (float)$datum['latitude'],
                'longitude' => (float)$datum['longitude'],
            ];
        }

        return $cleanData;
    }
}
