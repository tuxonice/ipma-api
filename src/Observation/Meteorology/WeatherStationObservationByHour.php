<?php

namespace Tlab\IpmaApi\Observation\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;

class WeatherStationObservationByHour
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/meteorology/stations/obs-surface.geojson';

    private const VALID_FIELDS = [
        'time' => '',
        'idEstacao' => '',
        'localEstacao' => '',
        'intensidadeVentoKM' => -99.0,
        'temperatura' => -99.0,
        'idDireccVento' => 0,
        'descDirVento' => -99.0,
        'precAcumulada' => -99.0,
        'intensidadeVento' => -99.0,
        'humidade' => -99.0,
        'pressao' => -99.0,
        'radiacao' => -99.0,
    ];

    /**
     * @var array<mixed>
     */
    private array $data = [];

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        foreach ($content['features'] as $stationData) {
            $this->data[] = array_merge($this->cleanData($stationData['properties']), [
                'latitude' => $stationData['geometry']['coordinates'][1],
                'longitude' => $stationData['geometry']['coordinates'][0],
            ]);
        }
    }

    public function filterByWindSpeed(float $minSpeed, float $maxSpeed): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['intensidadeVentoKM'] >= $minSpeed &&
                    (float)$element['intensidadeVentoKM'] <= $maxSpeed
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
                    (float)$element['temperatura'] >= $minTemperature &&
                    (float)$element['temperatura'] <= $maxTemperature
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
                    (float)$element['radiacao'] >= $min &&
                    (float)$element['radiacao'] <= $max
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
                    $element['idDireccVento'] === $windDirection
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
                    (float)$element['precAcumulada'] >= $min &&
                    (float)$element['precAcumulada'] <= $max
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
                    (float)$element['intensidadeVento'] >= $minSpeed &&
                    (float)$element['intensidadeVento'] <= $maxSpeed
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
                    (int)$element['humidade'] >= $min &&
                    (int)$element['humidade'] <= $max
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
                    (float)$element['pressao'] >= $min &&
                    (float)$element['pressao'] <= $max
            )
        );

        return $this;
    }

    public function filterByIdStation(int $idStation): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (int)$element['idEstacao'] === $idStation
            )
        );

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }

    private function cleanData(array $data): array
    {
        $cleanData = [];
        foreach (self::VALID_FIELDS as $validField => $invalidValue) {
            if (!isset($data[$validField]) || $data[$validField] === $invalidValue) {
                $cleanData[$validField] = null;

                continue;
            }
            $cleanData[$validField] = $data[$validField];
        }

        return $cleanData;
    }
}
