<?php

namespace Tlab\IpmaApi\Services;

use Tlab\IpmaApi\ApiConnector;

class SeaLocations
{
    private const END_POINT = 'https://api.ipma.pt/open-data/sea-locations.json';

    /**
     * @var array
     */
    private array $data;

    public function __construct(private readonly ApiConnector $apiConnector)
    {
        $this->data = $this->apiConnector->fetchData(self::END_POINT);
    }

    public function filterByIdRegiao(int $idRegiao): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($idRegiao) {
                return $element['idRegiao'] === $idRegiao;
            })
        );

        return $this;
    }

    public function filterByIdAreaAviso(string $idAreaAviso): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($idAreaAviso) {
                return $element['idAreaAviso'] === $idAreaAviso;
            })
        );

        return $this;
    }

    public function filterByGlobalIdLocal(int $globalIdLocal): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($globalIdLocal) {
                return $element['globalIdLocal'] === $globalIdLocal;
            })
        );

        return $this;
    }

    public function filterByIdLocal(int $idLocal): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($idLocal) {
                return $element['idLocal'] === $idLocal;
            })
        );

        return $this;
    }

    public function filterByLocal(string $local): self
    {
        $this->data = array_values(
            array_filter($this->data, function (array $element) use ($local) {
                return $element['local'] === $local;
            })
        );

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        //TODO

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): self
    {
        //TODO

        return $this;
    }
}
