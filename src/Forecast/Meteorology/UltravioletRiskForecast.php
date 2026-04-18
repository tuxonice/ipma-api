<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Forecast\UltravioletRiskRecord;
use Tlab\IpmaApi\Endpoints;

class UltravioletRiskForecast
{
    private const END_POINT = Endpoints::ULTRAVIOLET_RISK_FORECAST;

    /** @var list<UltravioletRiskRecord> */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        $mapped = $this->map($content);

        // Sometimes globalIdLocal is zero which looks like an upstream data error.
        $this->data = array_values(array_filter(
            $mapped,
            fn(UltravioletRiskRecord $r) => $r->globalIdLocal !== 0
        ));
    }

    public function filterByForecastDate(string $date): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(UltravioletRiskRecord $r) => $r->forecastDate === $date
        ));

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(UltravioletRiskRecord $r) => $r->globalIdLocal === $globalIdLocal
        ));

        return $this;
    }

    public function filterByUvIndex(float $min, float $max): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(UltravioletRiskRecord $r) => $r->uvIndex >= $min && $r->uvIndex <= $max
        ));

        return $this;
    }

    /**
     * @return list<UltravioletRiskRecord>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<UltravioletRiskRecord>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $out[] = new UltravioletRiskRecord(
                globalIdLocal: (int)$datum['globalIdLocal'],
                forecastDate: (string)$datum['data'],
                uvIndex: (float)$datum['iUv'],
                timeInterval: (string)$datum['intervaloHora'],
                periodId: (int)$datum['idPeriodo'],
            );
        }

        return $out;
    }
}
