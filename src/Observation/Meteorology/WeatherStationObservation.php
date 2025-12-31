<?php

namespace Tlab\IpmaApi\Observation\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;

class WeatherStationObservation
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/meteorology/stations/observations.json';

    private const VALID_FIELDS = [
        'windSpeed' => -99.0,
        'temperature' => -99.0,
        'accumulatedRain' => -99.0,
        'windIntensity' => -99.0,
        'humidity' => -99.0,
        'solarRadiation' => -99.0,
        'atmosphericPressure' => -99.0,
    ];

    private array $data = [];

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(int $idStation): self
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        foreach ($content as $date => $stationData) {
            foreach ($stationData as $stationId => $data) {
                if ((int)$stationId === $idStation && $data !== null) {
                    $this->data[] = array_merge($this->map($data), ['date' => $date]);
                }
            }
        }

        return $this;
    }

    public function filterByDate(string $from, string $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    $element['date'] >= $from &&
                    $element['date'] <= $to
            )
        );

        return $this;
    }

    public function filterByWindSpeed(float $minSpeed, float $maxSpeed): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['windSpeed'] >= $minSpeed &&
                    (float)$element['windSpeed'] <= $maxSpeed
            )
        );

        return $this;
    }

    public function filterByTemperature(float $minTemperature, float $maxTemperature): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['temperature'] >= $minTemperature &&
                    (float)$element['temperature'] <= $maxTemperature
            )
        );

        return $this;
    }

    public function filterBySolarRadiation(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['solarRadiation'] >= $min &&
                    (float)$element['solarRadiation'] <= $max
            )
        );

        return $this;
    }

    public function filterByWindDirection(int $windDirection): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    $element['idWindDirection'] === $windDirection
            )
        );

        return $this;
    }

    public function filterByRain(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['accumulatedRain'] >= $min &&
                    (float)$element['accumulatedRain'] <= $max
            )
        );

        return $this;
    }

    public function filterByWindSpeedMetersSecond(float $minSpeed, float $maxSpeed): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['windIntensity'] >= $minSpeed &&
                    (float)$element['windIntensity'] <= $maxSpeed
            )
        );

        return $this;
    }

    public function filterByHumidity(int $min, int $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (int)$element['humidity'] >= $min &&
                    (int)$element['humidity'] <= $max
            )
        );

        return $this;
    }

    public function filterByAtmosphericPressure(int $min, int $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['atmosphericPressure'] >= $min &&
                    (float)$element['atmosphericPressure'] <= $max
            )
        );

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }

    private function map(array $data): array
    {
        $data = [
            "windSpeed" => $data['intensidadeVentoKM'],
            "temperature" => $data['temperatura'],
            "solarRadiation" => $data['radiacao'],
            "idWindDirection" => $data['idDireccVento'],
            "accumulatedRain" => $data['precAcumulada'],
            "windIntensity" => $data['intensidadeVento'],
            "humidity" => $data['humidade'],
            "atmosphericPressure" => $data['pressao'],
        ];
        $cleanData = [];
        foreach ($data as $key => $datum) {
            if (in_array($key, array_keys(self::VALID_FIELDS)) && $datum === self::VALID_FIELDS[$key]) {
                $cleanData[$key] = null;

                continue;
            }

            $cleanData[$key] = $datum;
        }

        return $cleanData;
    }
}
