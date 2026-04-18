<?php

namespace Tlab\IpmaApi\Observation\Climate;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Climate\ClimateObservation;
use Tlab\IpmaApi\Endpoints;

class MaximumDailyTemperature
{
    private const END_POINT = Endpoints::MAXIMUM_DAILY_TEMPERATURE;

    /** @var list<ClimateObservation> */
    private array $data = [];

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(string $district, string $municipality, string $dico): self
    {
        $url = str_replace(
            ['{district}', '{DICO}', '{municipality}'],
            [$district, $dico, $municipality],
            self::END_POINT
        );

        $csv = $this->apiConnector->fetchCsv($url);
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            $this->data[] = ClimateObservation::fromCsvRecord($record);
        }

        return $this;
    }

    public function filterByDate(string $from, string $to): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(ClimateObservation $o) => $o->date >= $from && $o->date <= $to)
        );

        return $this;
    }

    public function filterByMinimum(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(ClimateObservation $o) => (float)$o->minimum >= $from && (float)$o->minimum <= $to
            )
        );

        return $this;
    }

    public function filterByMaximum(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(ClimateObservation $o) => (float)$o->maximum >= $from && (float)$o->maximum <= $to
            )
        );

        return $this;
    }

    public function filterByRange(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(ClimateObservation $o) => (float)$o->range >= $from && (float)$o->range <= $to
            )
        );

        return $this;
    }

    public function filterByMean(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(ClimateObservation $o) => (float)$o->mean >= $from && (float)$o->mean <= $to
            )
        );

        return $this;
    }

    public function filterByStd(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(ClimateObservation $o) => (float)$o->std >= $from && (float)$o->std <= $to
            )
        );

        return $this;
    }

    /**
     * @return list<ClimateObservation>
     */
    public function get(): array
    {
        return $this->data;
    }
}
