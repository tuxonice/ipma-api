<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Forecast\DailyForecastByLocationRecord;
use Tlab\IpmaApi\Endpoints;

class DailyWeatherForecastByLocation
{
    private const END_POINT = Endpoints::DAILY_WEATHER_FORECAST_BY_LOCATION;

    /** @var list<DailyForecastByLocationRecord> */
    private array $data;

    private DateTime $updateAt;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(int $globalIdLocal): self
    {
        $content = $this->apiConnector->fetchData(
            str_replace('{globalIdLocal}', (string)$globalIdLocal, self::END_POINT)
        );
        $this->updateAt = new DateTime($content['dataUpdate']);
        $this->data = $this->map($content['data']);

        return $this;
    }

    public function filterByRainfallProbabilityRange(float $minProbability, float $maxProbability): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByLocationRecord $r) => $r->rainfallProb >= $minProbability && $r->rainfallProb <= $maxProbability
        ));

        return $this;
    }

    public function filterByMinTemperatureRange(float $minValue, float $maxValue): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByLocationRecord $r) => $r->minTemp >= $minValue && $r->minTemp <= $maxValue
        ));

        return $this;
    }

    public function filterByMaxTemperatureRange(float $minValue, float $maxValue): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByLocationRecord $r) => $r->maxTemp >= $minValue && $r->maxTemp <= $maxValue
        ));

        return $this;
    }

    public function filterByWindDirection(string $value): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByLocationRecord $r) => strtolower($r->winDir) === strtolower($value)
        ));

        return $this;
    }

    public function filterByIdWeatherType(int $value): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByLocationRecord $r) => $r->idWeatherType === $value
        ));

        return $this;
    }

    public function filterByWindSpeedClass(int $value): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByLocationRecord $r) => $r->windSpeedClass === $value
        ));

        return $this;
    }

    public function filterByRainIntensityClass(int $value): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByLocationRecord $r) => $r->rainfallIntensity !== null && $r->rainfallIntensity === $value
        ));

        return $this;
    }

    public function filterByForecastDate(string $date): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByLocationRecord $r) => $r->forecastDate === $date
        ));

        return $this;
    }

    public function getFileUpdatedAt(): DateTime
    {
        return $this->updateAt;
    }

    /**
     * @return list<DailyForecastByLocationRecord>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<DailyForecastByLocationRecord>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $rainfallIntensity = $datum['classPrecInt'] ?? null;
            $out[] = new DailyForecastByLocationRecord(
                forecastDate: (string)$datum['forecastDate'],
                idWeatherType: (int)$datum['idWeatherType'],
                windSpeedClass: (int)$datum['classWindSpeed'],
                rainfallIntensity: $rainfallIntensity !== null ? (int)$rainfallIntensity : null,
                rainfallProb: (float)$datum['precipitaProb'],
                minTemp: (float)$datum['tMin'],
                maxTemp: (float)$datum['tMax'],
                winDir: (string)$datum['predWindDir'],
                latitude: (float)$datum['latitude'],
                longitude: (float)$datum['longitude'],
            );
        }

        return $out;
    }
}
