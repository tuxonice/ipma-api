<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Warnings;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Forecast\WeatherWarning;
use Tlab\IpmaApi\Endpoints;

class WeatherWarnings
{
    private const END_POINT = Endpoints::WEATHER_WARNINGS;

    /** @var list<WeatherWarning> */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function query(): self
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        $this->data = $this->map($content);

        return $this;
    }

    public function filterByWarningIdArea(string $idArea): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(WeatherWarning $w) => $w->warningIdArea === $idArea
        ));

        return $this;
    }

    public function filterByAwarenessTypeName(string $awarenessTypeName): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(WeatherWarning $w) => $w->awarenessTypeName === $awarenessTypeName
        ));

        return $this;
    }

    public function filterByAwarenessLevelId(string $awarenessLevelId): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            fn(WeatherWarning $w) => $w->awarenessLevelID === $awarenessLevelId
        ));

        return $this;
    }

    public function filterByTimeRange(DateTime $from, DateTime $to): self
    {
        $this->data = array_values(array_filter(
            $this->data,
            function (WeatherWarning $w) use ($from, $to) {
                $startTime = new DateTime($w->startTime);
                $endTime = new DateTime($w->endTime);

                return $startTime >= $from && $endTime <= $to;
            }
        ));

        return $this;
    }

    /**
     * @return list<WeatherWarning>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<WeatherWarning>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $out[] = new WeatherWarning(
                text: (string)$datum['text'],
                awarenessTypeName: (string)$datum['awarenessTypeName'],
                warningIdArea: (string)$datum['idAreaAviso'],
                startTime: (string)$datum['startTime'],
                endTime: (string)$datum['endTime'],
                awarenessLevelID: (string)$datum['awarenessLevelID'],
            );
        }

        return $out;
    }
}
