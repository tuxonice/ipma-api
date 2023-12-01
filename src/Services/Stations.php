<?php

namespace Tlab\IpmaApi\Services;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Utils;

class Stations
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/meteorology/stations/stations.json';

    /**
     * @var array
     */
    private array $data;

    public function __construct(private readonly ApiConnector $apiConnector)
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);

        $this->data = array_map(fn(array $element) => [
            'idEstacao' => $element['properties']['idEstacao'],
            'localEstacao' => $element['properties']['localEstacao'],
            'latitude' => $element['geometry']['coordinates'][1],
            'longitude' => $element['geometry']['coordinates'][0],
        ], $content);
    }

    public function filterByIdStation(int $idStation): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['idEstacao'] === $idStation)
        );

        return $this;
    }

    public function filterByStationLocation(string $locationName): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => str_contains($element['localEstacao'], $locationName))
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
