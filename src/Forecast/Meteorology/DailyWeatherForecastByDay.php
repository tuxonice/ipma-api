<?php

namespace Tlab\IpmaApi\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Utils;

class DailyWeatherForecastByDay
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/meteorology/cities/daily/hp-daily-forecast-day{idDay}.json';

    /**
     * @var array<mixed>
     */
    private array $data;

    private DateTime $updateAt;

    public function __construct(private readonly ApiConnector $apiConnector)
    {
    }

    public function from(int $idDay): self
    {
        $content = $this->apiConnector->fetchData(str_replace('{idDay}', (string)$idDay, self::END_POINT));
        $this->updateAt = new DateTime($content['dataUpdate']);
        $this->data = $this->map($content['data']);

        return $this;
    }

    public function filterByRainfallProbabilityRange(float $minProbability, float $maxProbability): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['rainfallProb'] >= $minProbability &&
                    (float)$element['rainfallProb'] <= $maxProbability
            )
        );

        return $this;
    }

    public function filterByMinTemperatureRange(float $minValue, float $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['minTemp'] >= $minValue &&
                    (float)$element['minTemp'] <= $maxValue
            )
        );

        return $this;
    }

    public function filterByMaxTemperatureRange(float $minValue, float $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['maxTemp'] >= $minValue &&
                    (float)$element['maxTemp'] <= $maxValue
            )
        );

        return $this;
    }

    public function filterByWindDirection(string $value): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => strtolower($element['winDir']) === strtolower($value)
            )
        );

        return $this;
    }

    public function filterByIdWeatherType(int $value): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['idWeatherType'] === $value
            )
        );

        return $this;
    }

    public function filterByWindSpeedClass(int $value): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['windSpeedClass'] === $value
            )
        );

        return $this;
    }

    public function filterByRainIntensityClass(int $value): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => isset($element['rainfallIntensity']) && $element['rainfallIntensity'] === $value
            )
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

    public function getFileUpdatedAt(): DateTime
    {
        return $this->updateAt;
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
                'globalIdLocal' => (int)$datum['globalIdLocal'],
                'idWeatherType' => (int)$datum['idWeatherType'],
                'windSpeedClass' => (int)$datum['classWindSpeed'],
                'rainfallIntensity' => $datum['classPrecInt'] ?? null,
                'rainfallProb' => (float)$datum['precipitaProb'],
                'minTemp' => (float)$datum['tMin'],
                'maxTemp' => (float)$datum['tMax'],
                'winDir' => $datum['predWindDir'],
                'latitude' => (float)$datum['latitude'],
                'longitude' => (float)$datum['longitude'],
            ];
        }

        return $cleanData;
    }
}
