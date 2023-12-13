<?php

namespace Tlab\IpmaApi\Forecast\Meteorology;

use Tlab\IpmaApi\ApiConnector;

class UltravioletRiskForecast
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/meteorology/uv/uv.json';

    /**
     * @var array<mixed>
     */
    private array $data;

    public function __construct(private readonly ApiConnector $apiConnector)
    {
        $this->data = $this->apiConnector->fetchData(self::END_POINT);
    }

    public function filterByDate(string $date): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['data'] === $date
            )
        );

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['globalIdLocal'] === $globalIdLocal
            )
        );

        return $this;
    }

    public function filterByUvIndex(float $min, float $max): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    $element['iUv'] >= $min &&
                    $element['iUv'] <= $max
            )
        );

        return $this;
    }

    /**
     * Actually there is no information about the values of this property
     * @param string $interval
     *
     * @return $this
     */
    public function filterByTimeInterval(string $interval): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['intervaloHora'] == $interval
            )
        );

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
