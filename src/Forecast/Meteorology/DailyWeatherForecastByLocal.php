<?php

namespace Tlab\IpmaApi\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;

class DailyWeatherForecastByLocal
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/meteorology/cities/daily/{globalIdLocal}.json';

    /**
     * @var array<mixed>
     */
    private array $data;

    private DateTime $updateAt;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(int $globalIdLocal): self
    {
        $content = $this->apiConnector->fetchData(str_replace('{globalIdLocal}', (string)$globalIdLocal, self::END_POINT));
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

    public function filterByForecastDate(string $date): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => $element['forecastDate'] === $date)
        );

        return $this;
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
                'forecastDate' => $datum['forecastDate'],
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
