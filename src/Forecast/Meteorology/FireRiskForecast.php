<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Forecast\FireRiskRecord;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Enums\FireRiskLevelEnum;
use Tlab\IpmaApi\Enums\ForecastFireRiskDayEnum;
use Tlab\IpmaApi\Utils;

class FireRiskForecast
{
    private const END_POINT = Endpoints::FIRE_RISK_FORECAST;

    /** @var list<FireRiskRecord> */
    private array $data;

    private DateTime $fileUpdatedAt;

    private DateTime $forecastDate;

    private DateTime $runDate;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(ForecastFireRiskDayEnum $day): self
    {
        $content = $this->apiConnector->fetchData(str_replace('{idDay}', (string)$day->value, self::END_POINT));
        $this->data = $this->map($content['local']);

        $this->fileUpdatedAt = new DateTime($content['fileDate']);
        $this->forecastDate = new DateTime($content['dataPrev']);
        $this->runDate = new DateTime($content['dataRun']);

        return $this;
    }

    public function filterByFireRiskLevel(FireRiskLevelEnum $fireRiskLevel): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(FireRiskRecord $r) => $r->fireRiskLevel === $fireRiskLevel->code()
        ));

        return $this;
    }

    public function filterByDico(string $dico): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(FireRiskRecord $r) => Utils::compareString($r->dico, $dico)
        ));

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(FireRiskRecord $r) => Utils::distance($r->latitude, $r->longitude, $latitude, $longitude) <= $radio
        ));

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): ?FireRiskRecord
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
        return $this->fileUpdatedAt;
    }

    public function getForecastDate(): DateTime
    {
        return $this->forecastDate;
    }

    public function getRunDate(): DateTime
    {
        return $this->runDate;
    }

    /**
     * @return list<FireRiskRecord>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<FireRiskRecord>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $out[] = new FireRiskRecord(
                dico: (string)$datum['dico'],
                fireRiskLevel: (int)$datum['data']['rcm'],
                latitude: (float)$datum['latitude'],
                longitude: (float)$datum['longitude'],
            );
        }

        return $out;
    }
}
