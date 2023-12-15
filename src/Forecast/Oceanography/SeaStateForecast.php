<?php

namespace Tlab\IpmaApi\Forecast\Oceanography;

use DateTime;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Utils;

class SeaStateForecast
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/oceanography/daily/hp-daily-sea-forecast-day{idDay}.json';

    /**
     * @var array<mixed>
     */
    private array $data;

    private DateTime $updateAt;

    private DateTime $forecastDate;



    public function __construct(private readonly ApiConnector $apiConnector)
    {
    }

    public function from(int $idDay): self
    {
        $content = $this->apiConnector->fetchData(str_replace('{idDay}', (string)$idDay, self::END_POINT));
        $this->updateAt = new DateTime($content['dataUpdate']);
        $this->forecastDate = new DateTime($content['forecastDate']);
        $this->data = $content['data'];

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => (int)$element['globalIdLocal'] === $globalIdLocal
            )
        );

        return $this;
    }

    public function filterByWavePeriodMin(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['wavePeriodMin'] >= $min &&
                    (float)$element['wavePeriodMin'] <= $max
            )
        );

        return $this;
    }

    public function filterByWavePeriodMax(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['wavePeriodMax'] >= $min &&
                    (float)$element['wavePeriodMax'] <= $max
            )
        );

        return $this;
    }

    public function filterByWaveHighMin(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['waveHighMin'] >= $min &&
                    (float)$element['waveHighMin'] <= $max
            )
        );

        return $this;
    }

    public function filterByWaveHighMax(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['waveHighMax'] >= $min &&
                    (float)$element['waveHighMax'] <= $max
            )
        );

        return $this;
    }

    public function filterByTotalSeaMin(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['totalSeaMin'] >= $min &&
                    (float)$element['totalSeaMin'] <= $max
            )
        );

        return $this;
    }

    public function filterByTotalSeaMax(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['totalSeaMax'] >= $min &&
                    (float)$element['totalSeaMax'] <= $max
            )
        );

        return $this;
    }

    public function filterBySstMin(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['sstMin'] >= $min &&
                    (float)$element['sstMin'] <= $max
            )
        );

        return $this;
    }

    public function filterBySstMax(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['sstMax'] >= $min &&
                    (float)$element['sstMax'] <= $max
            )
        );

        return $this;
    }

    public function filterByPredWaveDir(string $predWaveDir): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    strtolower($element['predWaveDir']) === strtolower($predWaveDir)
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

    public function getUpdateAt(): DateTime
    {
        return $this->updateAt;
    }

    public function getForecastDate(): DateTime
    {
        return $this->forecastDate;
    }

    public function get(): array
    {
        return $this->data;
    }
}
