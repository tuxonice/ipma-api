<?php

namespace Tlab\IpmaApi\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Utils;

class FireRiskForecast
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/meteorology/rcm/rcm-d{idDay}.json';

    /**
     * @var array<mixed>
     */
    private array $data;

    private DateTime $fileUpdatedAt;

    private DateTime $forecastDate;

    private DateTime $runDate;


    public function __construct(private readonly ApiConnector $apiConnector)
    {
    }

    public function from(int $idDay): self
    {
        $content = $this->apiConnector->fetchData(str_replace('{idDay}', (string)$idDay, self::END_POINT));
        $this->data = array_values(array_map(fn(array $element) => [
            'dico' => $element['dico'],
            'fireRiskLevel' => $element['data']['rcm'],
            'latitude' => $element['latitude'],
            'longitude' => $element['longitude'],
        ], $content['local']));

        $this->fileUpdatedAt = new DateTime($content['fileDate']);
        $this->forecastDate = new DateTime($content['dataPrev']);
        $this->runDate = new DateTime($content['dataRun']);

        return $this;
    }

    public function filterByFireRiskLevel(FireRiskLevel $fireRiskLevel): self
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
                fn (array $element) => $element['dico'] === $dico
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
}
