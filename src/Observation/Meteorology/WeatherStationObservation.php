<?php

namespace Tlab\IpmaApi\Observation\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Meteorology\DailyStationObservation;
use Tlab\IpmaApi\Endpoints;

class WeatherStationObservation
{
    private const END_POINT = Endpoints::WEATHER_STATION_OBSERVATION;

    private const VALID_FIELDS = [
        'windSpeed' => -99.0,
        'temperature' => -99.0,
        'accumulatedRain' => -99.0,
        'windIntensity' => -99.0,
        'humidity' => -99.0,
        'solarRadiation' => -99.0,
        'atmosphericPressure' => -99.0,
    ];

    /** @var list<DailyStationObservation> */
    private array $data = [];

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(int $idStation): self
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        foreach ($content as $date => $stationData) {
            foreach ($stationData as $stationId => $payload) {
                if ((int)$stationId === $idStation && $payload !== null) {
                    $this->data[] = $this->build((string)$date, $payload);
                }
            }
        }

        return $this;
    }

    public function filterByDate(string $from, string $to): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(DailyStationObservation $o) => $o->date >= $from && $o->date <= $to)
        );

        return $this;
    }

    public function filterByWindSpeed(float $minSpeed, float $maxSpeed): self
    {
        return $this->filterFloat('windSpeed', $minSpeed, $maxSpeed);
    }

    public function filterByTemperature(float $minTemperature, float $maxTemperature): self
    {
        return $this->filterFloat('temperature', $minTemperature, $maxTemperature);
    }

    public function filterBySolarRadiation(float $min, float $max): self
    {
        return $this->filterFloat('solarRadiation', $min, $max);
    }

    public function filterByWindDirection(int $windDirection): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(DailyStationObservation $o) => $o->idWindDirection === $windDirection)
        );

        return $this;
    }

    public function filterByRain(float $min, float $max): self
    {
        return $this->filterFloat('accumulatedRain', $min, $max);
    }

    public function filterByWindSpeedMetersSecond(float $minSpeed, float $maxSpeed): self
    {
        return $this->filterFloat('windIntensity', $minSpeed, $maxSpeed);
    }

    public function filterByHumidity(int $min, int $max): self
    {
        return $this->filterFloat('humidity', (float)$min, (float)$max);
    }

    public function filterByAtmosphericPressure(int $min, int $max): self
    {
        return $this->filterFloat('atmosphericPressure', (float)$min, (float)$max);
    }

    /**
     * @return list<DailyStationObservation>
     */
    public function get(): array
    {
        return $this->data;
    }

    private function filterFloat(string $property, float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(DailyStationObservation $o) => $o->$property !== null
                    && (float)$o->$property >= $min && (float)$o->$property <= $max
            )
        );

        return $this;
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function build(string $date, array $payload): DailyStationObservation
    {
        $mapped = [
            'windSpeed' => $payload['intensidadeVentoKM'],
            'temperature' => $payload['temperatura'],
            'solarRadiation' => $payload['radiacao'],
            'idWindDirection' => $payload['idDireccVento'],
            'accumulatedRain' => $payload['precAcumulada'],
            'windIntensity' => $payload['intensidadeVento'],
            'humidity' => $payload['humidade'],
            'atmosphericPressure' => $payload['pressao'],
        ];
        foreach (self::VALID_FIELDS as $field => $invalid) {
            if ($mapped[$field] === $invalid) {
                $mapped[$field] = null;
            }
        }

        return new DailyStationObservation(
            windSpeed: $mapped['windSpeed'] !== null ? (float)$mapped['windSpeed'] : null,
            temperature: $mapped['temperature'] !== null ? (float)$mapped['temperature'] : null,
            solarRadiation: $mapped['solarRadiation'] !== null ? (float)$mapped['solarRadiation'] : null,
            idWindDirection: $mapped['idWindDirection'] !== null ? (int)$mapped['idWindDirection'] : null,
            accumulatedRain: $mapped['accumulatedRain'] !== null ? (float)$mapped['accumulatedRain'] : null,
            windIntensity: $mapped['windIntensity'] !== null ? (float)$mapped['windIntensity'] : null,
            humidity: $mapped['humidity'] !== null ? (float)$mapped['humidity'] : null,
            atmosphericPressure: $mapped['atmosphericPressure'] !== null ? (float)$mapped['atmosphericPressure'] : null,
            date: $date,
        );
    }
}
