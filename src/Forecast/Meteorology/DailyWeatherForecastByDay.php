<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Forecast\DailyForecastByDayRecord;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Enums\ForecastDayEnum;
use Tlab\IpmaApi\Utils;

class DailyWeatherForecastByDay
{
    private const END_POINT = Endpoints::DAILY_WEATHER_FORECAST_BY_DAY;

    /** @var list<DailyForecastByDayRecord> */
    private array $data;

    private DateTime $updateAt;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(ForecastDayEnum $day): self
    {
        $content = $this->apiConnector->fetchData(str_replace('{idDay}', (string)$day->value, self::END_POINT));
        $this->updateAt = new DateTime($content['dataUpdate']);
        $this->data = $this->map($content['data']);

        return $this;
    }

    public function filterByRainfallProbabilityRange(float $minProbability, float $maxProbability): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => $r->rainfallProb >= $minProbability && $r->rainfallProb <= $maxProbability
        ));

        return $this;
    }

    public function filterByMinTemperatureRange(float $minValue, float $maxValue): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => $r->minTemp >= $minValue && $r->minTemp <= $maxValue
        ));

        return $this;
    }

    public function filterByMaxTemperatureRange(float $minValue, float $maxValue): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => $r->maxTemp >= $minValue && $r->maxTemp <= $maxValue
        ));

        return $this;
    }

    public function filterByWindDirection(string $value): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => strtolower($r->winDir) === strtolower($value)
        ));

        return $this;
    }

    public function filterByIdWeatherType(int $value): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => $r->idWeatherType === $value
        ));

        return $this;
    }

    public function filterByWindSpeedClass(int $value): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => $r->windSpeedClass === $value
        ));

        return $this;
    }

    public function filterByRainIntensityClass(int $value): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => $r->rainfallIntensity !== null && $r->rainfallIntensity === $value
        ));

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => $r->globalIdLocal === $globalIdLocal
        ));

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(DailyForecastByDayRecord $r) => Utils::distance($r->latitude, $r->longitude, $latitude, $longitude) <= $radio
        ));

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): ?DailyForecastByDayRecord
    {
        $nearest = null;
        $shortest = null;
        foreach ($this->data as $record) {
            $distance = Utils::distance($record->latitude, $record->longitude, $latitude, $longitude);
            if ($shortest === null || $distance < $shortest) {
                $shortest = $distance;
                $nearest = $record;
            }
        }

        return $nearest;
    }

    public function getFileUpdatedAt(): DateTime
    {
        return $this->updateAt;
    }

    /**
     * @return list<DailyForecastByDayRecord>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<DailyForecastByDayRecord>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $rainfallIntensity = $datum['classPrecInt'] ?? null;
            $out[] = new DailyForecastByDayRecord(
                globalIdLocal: (int)$datum['globalIdLocal'],
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
