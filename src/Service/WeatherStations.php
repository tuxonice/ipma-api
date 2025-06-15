<?php

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Utils;

class WeatherStations
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/meteorology/stations/stations.json';

    /**
     * @var array
     */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);

        $this->data = array_map(fn(array $element) => [
            'id' => $element['properties']['idEstacao'],
            'name' => $element['properties']['localEstacao'],
            'latitude' => $element['geometry']['coordinates'][1],
            'longitude' => $element['geometry']['coordinates'][0],
        ], $content);
    }

    public function filterById(int $idStation): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['id'] === $idStation)
        );

        return $this;
    }

    public function filterByName(string $name): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => str_contains($element['name'], $name))
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
