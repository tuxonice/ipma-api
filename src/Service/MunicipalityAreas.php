<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Service\DistrictLocation;
use Tlab\IpmaApi\Dto\Service\MunicipalityArea;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Utils;

class MunicipalityAreas
{
    private const DEFAULT_CSV_FILE = __DIR__ . '/../Data/dico.csv';
    private const END_POINT = Endpoints::DISTRICTS_ISLANDS_LOCATIONS;

    /** @var list<MunicipalityArea> */
    private array $data;

    /** @var array<string, DistrictLocation> */
    private array $locationsMap;

    private readonly string $csvFile;

    public function __construct(
        private readonly ApiConnectorInterface $apiConnector,
        ?string $csvFile = null,
    ) {
        $this->csvFile = $csvFile ?? self::DEFAULT_CSV_FILE;
    }

    public function query(): self
    {
        $content = $this->apiConnector->fetchData(self::END_POINT);
        $this->locationsMap = $this->buildLocationsMap($content['data']);
        $this->data = $this->loadCsvData();

        return $this;
    }

    public function filterByDico(string $dico): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(MunicipalityArea $m) => $m->dico === $dico)
        );

        return $this;
    }

    public function filterByNuts1(string $designation): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => Utils::compareString($m->nuts1, $designation)
            )
        );

        return $this;
    }

    public function filterByNuts2(string $designation): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => Utils::compareString($m->nuts2, $designation)
            )
        );

        return $this;
    }

    public function filterByNuts3(string $designation): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => Utils::compareString($m->nuts3, $designation)
            )
        );

        return $this;
    }

    public function filterByDistrict(string $designation): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => Utils::compareString($m->district, $designation)
            )
        );

        return $this;
    }

    public function filterByMunicipality(string $designation, bool $strict = false): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => Utils::compareString($m->municipality, $designation, $strict)
            )
        );

        return $this;
    }

    public function filterByMinArea(float $minArea): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(MunicipalityArea $m) => $m->area >= $minArea)
        );

        return $this;
    }

    public function filterByMaxArea(float $maxArea): self
    {
        $this->data = array_values(
            array_filter($this->data, fn(MunicipalityArea $m) => $m->area <= $maxArea)
        );

        return $this;
    }

    public function filterByAltitudeRange(int $minAltitude, int $maxAltitude): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => $m->altitudeMin >= $minAltitude && $m->altitudeMax <= $maxAltitude
            )
        );

        return $this;
    }

    public function filterByIdRegion(int $idRegion): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => $m->location !== null && $m->location->idRegion === $idRegion
            )
        );

        return $this;
    }

    public function filterByIdDistrict(int $idDistrict): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => $m->location !== null && $m->location->idDistrict === $idDistrict
            )
        );

        return $this;
    }

    public function filterByIdMunicipality(int $idMunicipality): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn(MunicipalityArea $m) => $m->location !== null && $m->location->idMunicipality === $idMunicipality
            )
        );

        return $this;
    }

    /**
     * @return list<MunicipalityArea>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return array<string, DistrictLocation>
     */
    private function buildLocationsMap(array $data): array
    {
        $map = [];
        foreach ($data as $datum) {
            $idConcelho = (string) $datum['idConcelho'];
            $idDistrito = (string) $datum['idDistrito'];
            $dico = str_pad($idDistrito, 2, '0', STR_PAD_LEFT) . str_pad($idConcelho, 2, '0', STR_PAD_LEFT);

            $map[$dico] = new DistrictLocation(
                globalIdLocal: (int) $datum['globalIdLocal'],
                name: (string) $datum['local'],
                idMunicipality: (int) $datum['idConcelho'],
                idDistrict: (int) $datum['idDistrito'],
                idRegion: (int) $datum['idRegiao'],
                idWarningArea: (string) $datum['idAreaAviso'],
                latitude: (float) $datum['latitude'],
                longitude: (float) $datum['longitude'],
            );
        }

        return $map;
    }

    /**
     * @return list<MunicipalityArea>
     */
    private function loadCsvData(): array
    {
        $out = [];
        $handle = fopen($this->csvFile, 'r');
        if ($handle === false) {
            throw new \RuntimeException('Unable to open CSV file: ' . $this->csvFile);
        }

        $headers = fgetcsv($handle);
        if ($headers === false) {
            fclose($handle);
            throw new \RuntimeException('Unable to read CSV headers');
        }

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($headers, $row);
            if ($data === false) {
                continue;
            }

            $dico = trim($data['dico'], '"');
            $location = $this->locationsMap[$dico] ?? null;

            $out[] = new MunicipalityArea(
                dico: $dico,
                nuts1: $data['nuts1'],
                nuts2: $data['nuts2'],
                nuts3: $data['nuts3'],
                district: $data['district'],
                municipality: $data['municipality'],
                area: (float) str_replace(',', '.', $data['area']),
                perimeter: (float) str_replace(',', '.', $data['perimeter']),
                altitudeMax: (int) $data['altitudeMax'],
                altitudeMin: (int) $data['altitudeMin'],
                location: $location,
            );
        }

        fclose($handle);

        return $out;
    }
}
