<?php

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Utils;

class DistrictsIslandsLocations
{
    private const END_POINT = 'https://api.ipma.pt/open-data/distrits-islands.json';

    /**
     * @var array
     */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);

        $this->data = $this->map($content['data']);
    }

    public function filterByIdRegion(int $idRegion): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['idRegion'] === $idRegion)
        );

        return $this;
    }

    public function filterByIdWarningArea(string $idWarningArea): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['idWarningArea'] === $idWarningArea)
        );

        return $this;
    }

    public function filterByIdMunicipality(int $idMunicipality): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['idMunicipality'] === $idMunicipality)
        );

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['globalIdLocal'] === $globalIdLocal)
        );

        return $this;
    }

    public function filterByIdDistrict(int $idDistrict): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['idDistrict'] === $idDistrict)
        );

        return $this;
    }

    public function filterByName(string $name): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['name'] === $name)
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
                'idMunicipality' => $datum['idConcelho'],
                'idDistrict' => $datum['idDistrito'],
                'idRegion' => $datum['idRegiao'],
                'idWarningArea' => $datum['idAreaAviso'],
                'latitude' => (float)$datum['latitude'],
                'longitude' => (float)$datum['longitude'],
            ];
        }

        return $cleanData;
    }
}
