<?php

namespace Tlab\IpmaApi\Services;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Utils;

class DistrictsIslandsLocations
{
    private const END_POINT = 'https://api.ipma.pt/open-data/distrits-islands.json';

    /**
     * @var array
     */
    private array $data;

    public function __construct(private readonly ApiConnector $apiConnector)
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);

        $this->data = $content['data'];
    }

    public function filterByIdRegion(int $idRegion): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['idRegiao'] === $idRegion)
        );

        return $this;
    }

    public function filterByIdWarningArea(string $idWarningArea): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['idAreaAviso'] === $idWarningArea)
        );

        return $this;
    }

    public function filterByIdMunicipality(int $idMunicipality): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['idConcelho'] === $idMunicipality)
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
            array_filter($this->data, fn(array $element) => $element['idDistrito'] === $idDistrict)
        );

        return $this;
    }

    public function filterByLocal(string $local): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['local'] === $local)
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
}
