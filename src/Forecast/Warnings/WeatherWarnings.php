<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Forecast\Warnings;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;

class WeatherWarnings
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/warnings/warnings_www.json';

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
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($idArea) {
                return $element['warningIdArea'] === $idArea;
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
                $startTime = new DateTime($element['startTime']);
                $endTime = new DateTime($element['endTime']);

                return $startTime >= $from && $endTime <= $to;
            })
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
                'text' => $datum['text'],
                'awarenessTypeName' => $datum['awarenessTypeName'],
                'warningIdArea' => $datum['idAreaAviso'],
                'startTime' => $datum['startTime'],
                'endTime' => $datum['endTime'],
                'awarenessLevelID' => $datum['awarenessLevelID'],
            ];
        }

        return $cleanData;
    }
}
