<?php

namespace Tlab\IpmaApi\Observation\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Meteorology\HourlyStationObservation;
use Tlab\IpmaApi\Endpoints;

class WeatherStationObservationByHour
{
    private const END_POINT = Endpoints::WEATHER_STATION_OBSERVATION_BY_HOUR;

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

    /** @var list<HourlyStationObservation> */
    private array $data = [];

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        foreach ($content['features'] as $stationData) {
            $this->data[] = $this->build(
                $stationData['properties'],
                (float)$stationData['geometry']['coordinates'][1],
                (float)$stationData['geometry']['coordinates'][0],
            );
        }
    }

    public function filterByWindSpeed(float $minSpeed, float $maxSpeed): self
    {
        return $this->filterFloat('intensidadeVentoKM', $minSpeed, $maxSpeed);
    }

    public function filterByTemperature(float $min, float $max): self
    {
        return $this->filterFloat('temperatura', $min, $max);
    }

    public function filterBySolarRadiation(float $min, float $max): self
    {
        return $this->filterFloat('radiacao', $min, $max);
    }

    public function filterByWindDirection(int $windDirection): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(HourlyStationObservation $o) => $o->idDireccVento === $windDirection)
        );

        return $this;
    }

    public function filterByRain(float $min, float $max): self
    {
        return $this->filterFloat('precAcumulada', $min, $max);
    }

    public function filterByWindSpeedMetersSecond(float $minSpeed, float $maxSpeed): self
    {
        return $this->filterFloat('intensidadeVento', $minSpeed, $maxSpeed);
    }

    public function filterByHumidity(int $min, int $max): self
    {
        return $this->filterFloat('humidade', (float)$min, (float)$max);
    }

    public function filterByAtmosphericPressure(int $min, int $max): self
    {
        return $this->filterFloat('pressao', (float)$min, (float)$max);
    }

    public function filterByIdStation(int $idStation): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(HourlyStationObservation $o) => $o->idEstacao === $idStation
            )
        );

        return $this;
    }

    /**
     * @return list<HourlyStationObservation>
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
                fn(HourlyStationObservation $o) => $o->$property !== null
                    && (float)$o->$property >= $min && (float)$o->$property <= $max
            )
        );

        return $this;
    }

    /**
     * @param array<string, mixed> $properties
     */
    private function build(array $properties, float $latitude, float $longitude): HourlyStationObservation
    {
        $clean = [];
        foreach (self::VALID_FIELDS as $field => $invalid) {
            if (!isset($properties[$field]) || $properties[$field] === $invalid) {
                $clean[$field] = null;
                continue;
            }
            $clean[$field] = $properties[$field];
        }

        return new HourlyStationObservation(
            time: $clean['time'],
            idEstacao: $clean['idEstacao'],
            localEstacao: $clean['localEstacao'],
            intensidadeVentoKM: $clean['intensidadeVentoKM'],
            temperatura: $clean['temperatura'],
            idDireccVento: $clean['idDireccVento'],
            descDirVento: $clean['descDirVento'],
            precAcumulada: $clean['precAcumulada'],
            intensidadeVento: $clean['intensidadeVento'],
            humidade: $clean['humidade'],
            pressao: $clean['pressao'],
            radiacao: $clean['radiacao'],
            latitude: $latitude,
            longitude: $longitude,
        );
    }
}
