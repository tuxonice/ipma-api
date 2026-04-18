<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Service\WeatherStation;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Utils;

class WeatherStations
{
    private const END_POINT = Endpoints::WEATHER_STATIONS;

    /** @var list<WeatherStation> */
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
            array_filter($this->data, fn(WeatherStation $s) => $s->id === $idStation)
        );

        return $this;
    }

    public function filterByName(string $name, bool $strict = false): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(WeatherStation $s) => Utils::compareString($s->name, $name, $strict))
        );

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(WeatherStation $s) => Utils::distance($s->latitude, $s->longitude, $latitude, $longitude) <= $radio
            )
        );

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): ?WeatherStation
    {
        $nearest = null;
        $shortest = null;
        foreach ($this->data as $station) {
            $distance = Utils::distance($station->latitude, $station->longitude, $latitude, $longitude);
            if ($shortest === null || $distance < $shortest) {
                $shortest = $distance;
                $nearest = $station;
            }
        }

        return $nearest;
    }

    /**
     * @return list<WeatherStation>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<WeatherStation>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $out[] = new WeatherStation(
                id: (int)$datum['properties']['idEstacao'],
                name: (string)$datum['properties']['localEstacao'],
                latitude: (float)$datum['geometry']['coordinates'][1],
                longitude: (float)$datum['geometry']['coordinates'][0],
            );
        }

        return $out;
    }
}
