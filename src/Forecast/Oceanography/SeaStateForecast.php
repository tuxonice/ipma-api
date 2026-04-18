<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Oceanography;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Forecast\SeaStateRecord;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Enums\SeaStateForecastDayEnum;
use Tlab\IpmaApi\Utils;

class SeaStateForecast
{
    private const END_POINT = Endpoints::SEA_STATE_FORECAST;

    /** @var list<SeaStateRecord> */
    private array $data;

    private DateTime $updateAt;

    private DateTime $forecastDate;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(SeaStateForecastDayEnum $day): self
    {
        $content = $this->apiConnector->fetchData(str_replace('{idDay}', (string)$day->value, self::END_POINT));
        $this->updateAt = new DateTime($content['dataUpdate']);
        $this->forecastDate = new DateTime($content['forecastDate']);
        $this->data = $this->map($content['data']);

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(SeaStateRecord $r) => $r->globalIdLocal === $globalIdLocal
        ));

        return $this;
    }

    public function filterByWavePeriodMin(float $min, float $max): self
    {
        return $this->filterFloat('wavePeriodMin', $min, $max);
    }

    public function filterByWavePeriodMax(float $min, float $max): self
    {
        return $this->filterFloat('wavePeriodMax', $min, $max);
    }

    public function filterByWaveHighMin(float $min, float $max): self
    {
        return $this->filterFloat('waveHighMin', $min, $max);
    }

    public function filterByWaveHighMax(float $min, float $max): self
    {
        return $this->filterFloat('waveHighMax', $min, $max);
    }

    public function filterByTotalSeaMin(float $min, float $max): self
    {
        return $this->filterFloat('totalSeaMin', $min, $max);
    }

    public function filterByTotalSeaMax(float $min, float $max): self
    {
        return $this->filterFloat('totalSeaMax', $min, $max);
    }

    public function filterBySstMin(float $min, float $max): self
    {
        return $this->filterFloat('sstMin', $min, $max);
    }

    public function filterBySstMax(float $min, float $max): self
    {
        return $this->filterFloat('sstMax', $min, $max);
    }

    public function filterByPredWaveDir(string $predWaveDir): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(SeaStateRecord $r) => Utils::compareString($r->predWaveDir, $predWaveDir)
        ));

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(SeaStateRecord $r) => Utils::distance($r->latitude, $r->longitude, $latitude, $longitude) <= $radio
        ));

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): ?SeaStateRecord
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

    public function getUpdateAt(): DateTime
    {
        return $this->updateAt;
    }

    public function getForecastDate(): DateTime
    {
        return $this->forecastDate;
    }

    /**
     * @return list<SeaStateRecord>
     */
    public function get(): array
    {
        return $this->data;
    }

    private function filterFloat(string $property, float $min, float $max): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(SeaStateRecord $r) => $r->$property >= $min && $r->$property <= $max
        ));

        return $this;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<SeaStateRecord>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $out[] = new SeaStateRecord(
                globalIdLocal: (int)$datum['globalIdLocal'],
                predWaveDir: (string)$datum['predWaveDir'],
                waveHighMin: (float)$datum['waveHighMin'],
                waveHighMax: (float)$datum['waveHighMax'],
                wavePeriodMin: (float)$datum['wavePeriodMin'],
                wavePeriodMax: (float)$datum['wavePeriodMax'],
                totalSeaMin: (float)$datum['totalSeaMin'],
                totalSeaMax: (float)$datum['totalSeaMax'],
                sstMin: (float)$datum['sstMin'],
                sstMax: (float)$datum['sstMax'],
                latitude: (float)$datum['latitude'],
                longitude: (float)$datum['longitude'],
            );
        }

        return $out;
    }
}
