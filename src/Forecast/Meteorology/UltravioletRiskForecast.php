<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;

class UltravioletRiskForecast
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/meteorology/uv/uv.json';

    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        $this->data = $this->map($content);

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

    public function get(): array
    {
        return $this->data;
    }

    private function map(array $data): array
    {
        $cleanData = [];
        foreach ($data as $datum) {
            $cleanData[] = [
                'globalIdLocal' => $datum['globalIdLocal'],
                'forecastDate' => $datum['data'],
                'uvIndex' => (float)$datum['iUv'],
                'timeInterval' => $datum['intervaloHora'], //the goal of this property is unclear
                'periodId' => $datum['idPeriodo'], //the goal of this property is unclear
            ];
        }

        return $cleanData;
    }
}
