<?php

namespace Tlab\IpmaApi\Forecast;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;

class WeatherWarnings
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/warnings/warnings_www.json';

    /**
     * @var array<mixed>
     */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
        $this->data = $this->apiConnector->fetchData(self::END_POINT);
    }

    public function filterByWarningIdArea(string $idArea): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($idArea) {
                return $element['idAreaAviso'] === $idArea;
            })
        );

        return $this;
    }

    public function filterByAwarenessTypeName(string $awarenessTypeName): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($awarenessTypeName) {
                return $element['awarenessTypeName'] === $awarenessTypeName;
            })
        );

        return $this;
    }

    public function filterByAwarenessLevelId(string $awarenessLevelId): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($awarenessLevelId) {
                return $element['awarenessLevelID'] === $awarenessLevelId;
            })
        );

        return $this;
    }

    public function filterByTimeRange(DateTime $from, DateTime $to): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($from, $to) {
                return $element['startTime'] >= $from && $element['endTime'] <= $to;
            })
        );

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
