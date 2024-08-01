<?php

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Utils;

class SeaLocations
{
    private const END_POINT = 'https://api.ipma.pt/open-data/sea-locations.json';

    /**
     * @var array
     */
    private array $data;

    public function __construct(private readonly ApiConnector $apiConnector)
    {
        $this->data = $this->map($this->apiConnector->fetchData(self::END_POINT));
    }

    public function filterByIdRegion(int $idRegiao): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($idRegiao) {
                return $element['idRegion'] === $idRegiao;
            })
        );

        return $this;
    }

    public function filterByIdWarningArea(string $idWarningArea): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($idWarningArea) {
                return strtolower($element['idWarningArea']) === strtolower($idWarningArea);
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
            array_filter($this->data, function (array $element) use ($idLocal) {
                return $element['idLocal'] === $idLocal;
            })
        );

        return $this;
    }

    public function filterByName(string $local): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($local) {
                return str_contains(strtolower($element['name']), strtolower($local));
            })
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
                'globalIdLocal' => $datum['globalIdLocal'],
                'name' => $datum['local'],
                'idLocal' => $datum['idLocal'],
                'idRegion' => $datum['idRegiao'],
                'idWarningArea' => $datum['idAreaAviso'],
                'latitude' => (float)$datum['latitude'],
                'longitude' => (float)$datum['longitude'],
            ];
        }

        return $cleanData;
    }
}
