<?php

namespace Tlab\IpmaApi\Observation\Seismic;

use DateTime;
use Exception;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Enums\SeismicInformationAreaEnum;
use Tlab\IpmaApi\Utils;

class SeismicInformation
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/seismic/{idArea}.json';

    private array $data = [];

    private DateTime $lastSeismicActivityDate;

    private DateTime $updateDate;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    /**
     * @param SeismicInformationAreaEnum $area
     * @return $this
     * @throws Exception
     */
    public function from(SeismicInformationAreaEnum $area): self
    {
        $url = str_replace('{idArea}', (string)$area->value, self::END_POINT);
        $content = $this->apiConnector->fetchData($url);

        $this->updateDate = new DateTime($content['updateDate']);
        $this->lastSeismicActivityDate = new DateTime($content['lastSismicActivityDate']);
        $this->data = $this->map($content['data']);

        return $this;
    }

    public function filterByDepth(int $minValue, int $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (int)$element['depth'] >= $minValue &&
                    (int)$element['depth'] <= $maxValue
            )
        );

        return $this;
    }

    public function filterByTime(string $from, string $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    $element['time'] >= $from &&
                    $element['time'] <= $to
            )
        );

        return $this;
    }

    public function filterByMagnitude(float $minValue, float $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['magnitude'] >= $minValue &&
                    (float)$element['magnitude'] <= $maxValue
            )
        );

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => Utils::distance(
                (float)$element['latitude'],
                (float)$element['longitude'],
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
            $distance = Utils::distance((float)$datum['latitude'], (float)$datum['longitude'], $latitude, $longitude);

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

    public function getLastSeismicActivityDate(): DateTime
    {
        return $this->lastSeismicActivityDate;
    }

    public function getUpdateDate(): DateTime
    {
        return $this->updateDate;
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
                "seismId" => $datum['sismoId'],
                "googleMapRef" => $datum['googlemapref'],
                "degree" => $datum['degree'],
                "magType" => $datum['magType'],
                "magnitude" => (float)$datum['magnitud'],
                "depth" => (int)$datum['depth'],
                "tensorRef" => $datum['tensorRef'],
                "shakeMapId" => $datum['shakemapid'],
                "shakeMapRef" => $datum['shakemapref'],
                "location" => $datum['local'],
                "regionName" => $datum['obsRegion'],
                "latitude" => (float)$datum['lat'],
                "longitude" => (float)$datum['lon'],
                "source" => $datum['source'],
                "sensed" => $datum['sensed'],
                "time" => $datum['time'],
                "updateDate" => $datum['dataUpdate'],
            ];
        }

        return $cleanData;
    }
}
