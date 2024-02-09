<?php

namespace Tlab\IpmaApi\Observation\Seismic;

use DateTime;
use Exception;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Utils;

class SeismicInformation
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/seismic/{idArea}.json';

    /**
     * @var array<mixed>
     */
    private array $data = [];

    private DateTime $lastSismicActivityDate;

    private DateTime $updateDate;

    public function __construct(private readonly ApiConnector $apiConnector)
    {
    }

    /**
     * @param string $idArea
     *
     * @return $this
     * @throws Exception
     */
    public function from(string $idArea): self
    {
        $url = str_replace('{idArea}', $idArea, self::END_POINT);
        $content = $this->apiConnector->fetchData($url);

        $this->updateDate = new DateTime($content['updateDate']);
        $this->lastSismicActivityDate = new DateTime($content['lastSismicActivityDate']);
        $this->data = $content['data'];

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

    public function filterByMagnitud(float $minValue, float $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['magnitud'] >= $minValue &&
                    (float)$element['magnitud'] <= $maxValue
            )
        );

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => Utils::distance(
                (float)$element['lat'],
                (float)$element['lon'],
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
            $distance = Utils::distance((float)$datum['lat'], (float)$datum['lon'], $latitude, $longitude);

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

    public function getLastSismicActivityDate(): DateTime
    {
        return $this->lastSismicActivityDate;
    }

    public function getUpdateDate(): DateTime
    {
        return $this->updateDate;
    }

    public function get(): array
    {
        return $this->data;
    }
}
