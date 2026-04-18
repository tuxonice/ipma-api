<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Service\DistrictLocation;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Utils;

class DistrictsIslandsLocations
{
    private const END_POINT = Endpoints::DISTRICTS_ISLANDS_LOCATIONS;

    /** @var list<DistrictLocation> */
    private array $data;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    public function query(): self
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        $this->data = $this->map($content['data']);

        return $this;
    }

    public function filterByIdRegion(int $idRegion): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(DistrictLocation $l) => $l->idRegion === $idRegion)
        );

        return $this;
    }

    public function filterByIdWarningArea(string $idWarningArea): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(DistrictLocation $l) => Utils::compareString($l->idWarningArea, $idWarningArea)
            )
        );

        return $this;
    }

    public function filterByIdMunicipality(int $idMunicipality): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(DistrictLocation $l) => $l->idMunicipality === $idMunicipality)
        );

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(DistrictLocation $l) => $l->globalIdLocal === $globalIdLocal)
        );

        return $this;
    }

    public function filterByIdDistrict(int $idDistrict): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(DistrictLocation $l) => $l->idDistrict === $idDistrict)
        );

        return $this;
    }

    public function filterByName(string $name, bool $strict = false): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(DistrictLocation $l) => Utils::compareString($l->name, $name, $strict))
        );

        return $this;
    }

    public function filterLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(DistrictLocation $l) => Utils::distance($l->latitude, $l->longitude, $latitude, $longitude) <= $radio
            )
        );

        return $this;
    }

    public function filterLocationByNearDistance(float $latitude, float $longitude): ?DistrictLocation
    {
        $nearest = null;
        $shortest = null;
        foreach ($this->data as $location) {
            $distance = Utils::distance($location->latitude, $location->longitude, $latitude, $longitude);
            if ($shortest === null || $distance < $shortest) {
                $shortest = $distance;
                $nearest = $location;
            }
        }

        return $nearest;
    }

    /**
     * @return list<DistrictLocation>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<DistrictLocation>
     */
    private function map(array $data): array
    {
        $out = [];
        foreach ($data as $datum) {
            $out[] = new DistrictLocation(
                globalIdLocal: (int)$datum['globalIdLocal'],
                name: (string)$datum['local'],
                idMunicipality: (int)$datum['idConcelho'],
                idDistrict: (int)$datum['idDistrito'],
                idRegion: (int)$datum['idRegiao'],
                idWarningArea: (string)$datum['idAreaAviso'],
                latitude: (float)$datum['latitude'],
                longitude: (float)$datum['longitude'],
            );
        }

        return $out;
    }
}
