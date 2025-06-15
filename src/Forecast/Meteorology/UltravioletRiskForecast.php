<?php

namespace Tlab\IpmaApi\Forecast\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;

class UltravioletRiskForecast
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/meteorology/uv/uv.json';

    /**
     * @var array<mixed>
     */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
        $this->data = $this->apiConnector->fetchData(self::END_POINT);
        $this->data = array_values(array_map(fn(array $element) => [
            'globalIdLocal' => $element['globalIdLocal'],
            'forecastDate' => $element['data'],
            'uvIndex' => (float)$element['iUv'],
            'timeInterval' => $element['intervaloHora'],
            'periodId' => $element['idPeriodo'],
        ], $this->data));

        //Sometimes globalIdLocal is zero what make me think that's an error
        $this->data = array_filter($this->data, function (array $element) {
            return $element['globalIdLocal'] !== 0;
        });
    }

    public function filterByForecastDate(string $date): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['forecastDate'] === $date
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
                    $element['uvIndex'] >= $min &&
                    $element['uvIndex'] <= $max
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
                fn (array $element) => $element['timeInterval'] == $interval
            )
        );

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
