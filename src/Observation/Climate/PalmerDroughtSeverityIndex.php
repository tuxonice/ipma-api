<?php

namespace Tlab\IpmaApi\Observation\Climate;

use Tlab\IpmaApi\ApiConnectorInterface;

class PalmerDroughtSeverityIndex
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/climate/mpdsi/{district}/mpdsi-{DICO}-{municipality}.csv';

    /**
     * @var array<mixed>
     */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(string $district, string $municipality, string $dico): self
    {
        $url = str_replace('{district}', $district, self::END_POINT);
        $url = str_replace('{DICO}', $dico, $url);
        $url = str_replace('{municipality}', $municipality, $url);

        $csv = $this->apiConnector->fetchCsv($url);

        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            $this->data[] = $record;
        }

        return $this;
    }

    public function filterByDate(string $from, string $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    $element['date'] >= $from &&
                    $element['date'] <= $to
            )
        );

        return $this;
    }

    public function filterByMinimum(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['minimum'] >= $from &&
                    (float)$element['minimum'] <= $to
            )
        );

        return $this;
    }

    public function filterByMaximum(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['maximum'] >= $from &&
                    (float)$element['maximum'] <= $to
            )
        );

        return $this;
    }

    public function filterByRange(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['range'] >= $from &&
                    (float)$element['range'] <= $to
            )
        );

        return $this;
    }

    public function filterByMean(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['mean'] >= $from &&
                    (float)$element['mean'] <= $to
            )
        );

        return $this;
    }

    public function filterByStd(float $from, float $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) =>
                    (float)$element['std'] >= $from &&
                    (float)$element['std'] <= $to
            )
        );

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
