<?php

namespace Tlab\IpmaApi\Observation\Biology;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Utils;

class MolluscHarvestingProhibition
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/biology/bivalves/CI_SNMB.geojson';

    private const OPEN = 'open';

    private const CLOSE = 'CLOSE';

    /**
     * @var array<mixed>
     */
    private array $data = [];

    private array $metaData = [];

    private ?string $interdictionType = null;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function from(): self
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);

        $this->metaData = [
            "type" => $content['type'],
            "crs" => $content['crs'],
            "snmb_reference" => $content['snmb_reference'],
            "cd_decision" => $content['cd_decision'],
            "publication_date" => $content['publication_date'],
            "bulletin_name" => $content['bulletin_name'],
            "owner" => $content['owner'],
            "project" => $content['project'],
        ];

        $this->data = $content['features'];

        foreach ($this->data as $key => $datum) {
            unset($this->data[$key]['geometry']);

            $representativePoint = $this->data[$key]['properties']['representative_point'];

            [$latitude, $longitude] = $this->extractCoords($representativePoint);

            $this->data[$key]['properties']['coords'] = [
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];
        }

        return $this;
    }

    public function filterByName(string $name): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => str_contains(strtolower($element['properties']['name']), strtolower($name))
            )
        );

        return $this;
    }

    public function filterByCode(string $code): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => str_contains(strtolower($element['properties']['code']), strtolower($code))
            )
        );


        return $this;
    }

    public function filterByZoneType(string $zoneType): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => str_contains(strtolower($element['properties']['zone_type']), strtolower($zoneType))
            )
        );

        return $this;
    }

    public function filterByRegionName(string $regionName): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => str_contains(strtolower($element['properties']['region_name']), strtolower($regionName))
            )
        );

        return $this;
    }

    public function filterByStatus(string $status): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (array $element) => str_contains(strtolower($element['properties']['status']), strtolower($status))
            )
        );

        return $this;
    }

    public function filterByOpen(): self
    {
        $this->interdictionType = self::OPEN;

        return $this;
    }

    public function filterByClose(): self
    {
        $this->interdictionType = self::CLOSE;

        return $this;
    }

    public function filterByScientificName(string $scientificName): self
    {
        $filteredData = [];
        foreach ($this->data as $datum) {
            if ($this->interdictionType === null) {
                $interdictionTypes = array_merge(
                    $datum['properties']['interdictions']['open'],
                    $datum['properties']['interdictions']['close']
                );

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['specie_s'] === $scientificName) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }

            if ($this->interdictionType === self::OPEN) {
                $interdictionTypes = $datum['properties']['interdictions']['open'];

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['specie_s'] === $scientificName) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }

            if ($this->interdictionType === self::CLOSE) {
                $interdictionTypes = $datum['properties']['interdictions']['close'];

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['specie_s'] === $scientificName) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }
        }

        $this->data = $filteredData;

        return $this;
    }

    public function filterByCommonName(string $commonName): self
    {
        $filteredData = [];
        foreach ($this->data as $datum) {
            if ($this->interdictionType === null) {
                $interdictionTypes = array_merge(
                    $datum['properties']['interdictions']['open'],
                    $datum['properties']['interdictions']['close']
                );

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['specie_c'] === $commonName) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }

            if ($this->interdictionType === self::OPEN) {
                $interdictionTypes = $datum['properties']['interdictions']['open'];

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['specie_c'] === $commonName) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }

            if ($this->interdictionType === self::CLOSE) {
                $interdictionTypes = $datum['properties']['interdictions']['close'];

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['specie_c'] === $commonName) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }
        }

        $this->data = $filteredData;

        return $this;
    }

    public function filterByClassification(string $classification): self
    {
        $filteredData = [];
        foreach ($this->data as $datum) {
            if ($this->interdictionType === null) {
                $interdictionTypes = array_merge(
                    $datum['properties']['interdictions']['open'],
                    $datum['properties']['interdictions']['close']
                );

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['classification'] === $classification) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }

            if ($this->interdictionType === self::OPEN) {
                $interdictionTypes = $datum['properties']['interdictions']['open'];

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['classification'] === $classification) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }

            if ($this->interdictionType === self::CLOSE) {
                $interdictionTypes = $datum['properties']['interdictions']['close'];

                foreach ($interdictionTypes as $interdictionType) {
                    if ($interdictionType['classification'] === $classification) {
                        $filteredData[] = $datum;

                        break;
                    }
                }
            }
        }

        $this->data = $filteredData;

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(array $element) => Utils::distance(
                $element['properties']['coords']['latitude'],
                $element['properties']['coords']['longitude'],
                $latitude,
                $longitude
            ) <= $radio)
        );

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): array
    {
        $shortestDistanceData = [];
        $shortestDistance = null;
        foreach ($this->data as $datum) {
            $distance = Utils::distance(
                $datum['properties']['coords']['latitude'],
                $datum['properties']['coords']['longitude'],
                $latitude,
                $longitude
            );

            if ($shortestDistance === null) {
                $shortestDistanceData = $datum;
                $shortestDistance = $distance;

                continue;
            }

            if ($shortestDistance > $distance) {
                $shortestDistance = $distance;
                $shortestDistanceData = $datum;
            }
        }

        return $shortestDistanceData;
    }

    public function get(): array
    {
        return $this->data;
    }



    private function extractCoords(mixed $representativePoint): array
    {
        $pattern = '/POINT \(([-+]?\d{1,3}\.\d+?) ([-+]?\d{1,3}\.\d+?)\)/';

        if (preg_match($pattern, $representativePoint, $matches)) {
            $latitude = (float)$matches[2];
            $longitude = (float)$matches[1];

            return [$latitude, $longitude];
        }

        return [null, null];
    }

    public function getMetaData(): array
    {
        return $this->metaData;
    }
}
