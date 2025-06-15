<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Utils;

class WeatherStations
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/meteorology/stations/stations.json';

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

    public function filterById(int $idStation): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['id'] === $idStation)
        );

        return $this;
    }

    public function filterByName(string $name, bool $strict = false): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => Utils::compareString($element['name'], $name, $strict))
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
                'id' => (int)$datum['properties']['idEstacao'],
                'name' => $datum['properties']['localEstacao'],
                'latitude' => (float)$datum['geometry']['coordinates'][1],
                'longitude' => (float)$datum['geometry']['coordinates'][0],
            ];
        }

        return $cleanData;
    }
}
