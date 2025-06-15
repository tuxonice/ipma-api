<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Enums\FireRiskLevelEnum;
use Tlab\IpmaApi\Enums\ForecastFireRiskDayEnum;
use Tlab\IpmaApi\Utils;

class FireRiskForecast
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/meteorology/rcm/rcm-d{idDay}.json';

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
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['fireRiskLevel'] === $fireRiskLevel->code()
            )
        );

        return $this;
    }

    public function filterByDico(string $dico): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => Utils::compareString($element['dico'], $dico)
            )
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

    public function get(): array
    {
        return $this->data;
    }

    private function map(array $data): array
    {
        $cleanData = [];
        foreach ($data as $datum) {
            $cleanData[] = [
                'dico' => $datum['dico'],
                'fireRiskLevel' => (int)$datum['data']['rcm'],
                'latitude' => (float)$datum['latitude'],
                'longitude' => (float)$datum['longitude'],
            ];
        }

        return $cleanData;
    }
}
