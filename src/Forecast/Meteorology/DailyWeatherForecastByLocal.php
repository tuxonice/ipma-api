<?php

namespace Tlab\IpmaApi\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Utils;

class DailyWeatherForecastByLocal
{
    private const END_POINT = 'https://api.ipma.pt/open-data/forecast/meteorology/cities/daily/{globalIdLocal}.json';

    /**
     * @var array<mixed>
     */
    private array $data;

    private DateTime $updateAt;

    public function __construct(private readonly ApiConnector $apiConnector)
    {
    }

    public function from(int $globalIdLocal): self
    {
        $content = $this->apiConnector->fetchData(str_replace('{globalIdLocal}', (string)$globalIdLocal, self::END_POINT));
        $this->updateAt = new DateTime($content['dataUpdate']);
        $this->data = $content['data'];

        return $this;
    }

    public function filterByRainfallProbabilityRange(float $minProbability, float $maxProbability): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['precipitaProb'] >= $minProbability &&
                    (float)$element['precipitaProb'] <= $maxProbability
            )
        );

        return $this;
    }

    public function filterByMinTemperatureRange(float $minValue, float $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['tMin'] >= $minValue &&
                    (float)$element['tMin'] <= $maxValue
            )
        );

        return $this;
    }

    public function filterByMaxTemperatureRange(float $minValue, float $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['tMax'] >= $minValue &&
                    (float)$element['tMax'] <= $maxValue
            )
        );

        return $this;
    }

    public function filterByWindDirection(string $value): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => strtolower($element['predWindDir']) === strtolower($value)
            )
        );

        return $this;
    }

    public function filterByIdWeatherType(int $value): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['idWeatherType'] === $value
            )
        );

        return $this;
    }

    public function filterByWindSpeedClass(int $value): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => $element['classWindSpeed'] === $value
            )
        );

        return $this;
    }

    public function filterByRainIntensityClass(int $value): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => isset($element['classPrecInt']) && $element['classPrecInt'] === $value
            )
        );

        return $this;
    }

    public function getFileUpdatedAt(): DateTime
    {
        return $this->updateAt;
    }

    public function get(): array
    {
        return $this->data;
    }
}
