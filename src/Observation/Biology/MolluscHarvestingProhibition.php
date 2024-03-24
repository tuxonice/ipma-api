<?php

namespace Tlab\IpmaApi\Observation\Biology;

use Tlab\IpmaApi\ApiConnector;

class MolluscHarvestingProhibition
{
    private const END_POINT = 'https://api.ipma.pt/open-data/observation/biology/bivalves/CI_SNMB.geojson';

    /**
     * @var array<mixed>
     */
    private array $data = [];

    private array $metaData = [];

    public function __construct(private readonly ApiConnector $apiConnector)
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

        foreach($this->data as $key => $datum) {
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

    public function get(): array
    {
        return $this->data;
    }



    private function extractCoords(mixed $representativePoint): array
    {
        $pattern = '/POINT \(([-+]?\d{1,3}\.\d+?) ([-+]?\d{1,3}\.\d+?)\)/';

        if (preg_match($pattern, $representativePoint, $matches)) {
            $latitude = $matches[2];
            $longitude = $matches[1];

            return [$latitude, $longitude];
        }

        return [null, null];
    }

    public function getMetaData(): array
    {
        return $this->metaData;
    }
}
