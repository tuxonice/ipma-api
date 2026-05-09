<?php

declare(strict_types=1);

namespace Tlab\Tests\Service;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Service\MunicipalityAreas;

class MunicipalityAreasTest extends TestCase
{
    private array $districtsIslandsFixture;
    private string $testCsvPath;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $this->districtsIslandsFixture = json_decode($contents, true);
        $this->testCsvPath = dirname(__DIR__, 2) . '/Data/Services/dico.csv';
    }

    private function createService(): MunicipalityAreas
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->districtsIslandsFixture);

        return new MunicipalityAreas($apiConnector, $this->testCsvPath);
    }

    public function testFilterByDico(): void
    {
        $service = $this->createService();

        self::assertSame(
            [
                [
                    'dico' => '0105',
                    'nuts1' => 'Continente',
                    'nuts2' => 'Centro',
                    'nuts3' => 'Região de Aveiro',
                    'district' => 'Aveiro',
                    'municipality' => 'Aveiro',
                    'area' => 197.58,
                    'perimeter' => 77.0,
                    'altitudeMax' => 78,
                    'altitudeMin' => 0,
                    'location' => [
                        'globalIdLocal' => 1010500,
                        'name' => 'Aveiro',
                        'idMunicipality' => 5,
                        'idDistrict' => 1,
                        'idRegion' => 1,
                        'idWarningArea' => 'AVR',
                        'latitude' => 40.6413,
                        'longitude' => -8.6535,
                    ],
                ],
            ],
            array_map(fn($m) => $this->municipalityAreaToArray($m), $service->query()->filterByDico('0105')->get())
        );
    }

    public function testFilterByNuts1(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByNuts1('Madeira')->get();
        self::assertCount(2, $results);
        self::assertSame('Funchal', $results[0]->municipality);
        self::assertSame('Porto Santo', $results[1]->municipality);
    }

    public function testFilterByNuts2(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByNuts2('Alentejo')->get();
        self::assertGreaterThan(0, count($results));
        foreach ($results as $result) {
            self::assertSame('Alentejo', $result->nuts2);
        }
    }

    public function testFilterByNuts3(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByNuts3('Região de Aveiro')->get();
        self::assertCount(1, $results);
        self::assertSame('Aveiro', $results[0]->municipality);
    }

    public function testFilterByDistrict(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByDistrict('Faro')->get();
        self::assertCount(4, $results);
        self::assertSame('Faro', $results[0]->municipality);
        self::assertSame('Sagres', $results[1]->municipality);
    }

    public function testFilterByMunicipalityStrict(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByMunicipality('Aveiro', true)->get();
        self::assertCount(1, $results);
        self::assertSame('0105', $results[0]->dico);
    }

    public function testFilterByMunicipalityCaseInsensitive(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByMunicipality('aveiro', false)->get();
        self::assertCount(1, $results);
    }

    public function testFilterByMinArea(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByMinArea(500.0)->get();
        self::assertGreaterThan(0, count($results));
        foreach ($results as $result) {
            self::assertGreaterThanOrEqual(500.0, $result->area);
        }
    }

    public function testFilterByMaxArea(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByMaxArea(100.0)->get();
        self::assertGreaterThan(0, count($results));
        foreach ($results as $result) {
            self::assertLessThanOrEqual(100.0, $result->area);
        }
    }

    public function testFilterByAltitudeRange(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByAltitudeRange(0, 100)->get();
        self::assertGreaterThan(0, count($results));
        foreach ($results as $result) {
            self::assertGreaterThanOrEqual(0, $result->altitudeMin);
            self::assertLessThanOrEqual(100, $result->altitudeMax);
        }
    }

    public function testFilterByIdRegion(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByIdRegion(2)->get();
        self::assertCount(2, $results); // Funchal and Porto Santo
        self::assertSame('Funchal', $results[0]->municipality);
        self::assertSame('Porto Santo', $results[1]->municipality);
    }

    public function testFilterByIdDistrict(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByIdDistrict(8)->get();
        self::assertCount(4, $results); // Faro district municipalities
    }

    public function testFilterByIdMunicipality(): void
    {
        $service = $this->createService();

        $results = $service->query()->filterByIdMunicipality(5)->get();
        self::assertGreaterThan(0, count($results));
        foreach ($results as $result) {
            self::assertNotNull($result->location);
            self::assertSame(5, $result->location->idMunicipality);
        }
    }

    public function testGetReturnsAllData(): void
    {
        $service = $this->createService();

        $results = $service->query()->get();
        self::assertCount(34, $results); // All entries in test CSV (including header row count as data row)
    }

    public function testLocationIsNullForUnknownDico(): void
    {
        $service = $this->createService();

        // Query for a DICO that doesn't exist in the API response
        $results = $service->query()->filterByDico('9999')->get();
        self::assertCount(0, $results); // Not in our test data
    }

    public function testChainingFilters(): void
    {
        $service = $this->createService();

        $results = $service->query()
            ->filterByNuts1('Continente')
            ->filterByMinArea(1000.0)
            ->get();

        self::assertGreaterThan(0, count($results));
        foreach ($results as $result) {
            self::assertSame('Continente', $result->nuts1);
            self::assertGreaterThanOrEqual(1000.0, $result->area);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function municipalityAreaToArray(\Tlab\IpmaApi\Dto\Service\MunicipalityArea $area): array
    {
        return [
            'dico' => $area->dico,
            'nuts1' => $area->nuts1,
            'nuts2' => $area->nuts2,
            'nuts3' => $area->nuts3,
            'district' => $area->district,
            'municipality' => $area->municipality,
            'area' => $area->area,
            'perimeter' => $area->perimeter,
            'altitudeMax' => $area->altitudeMax,
            'altitudeMin' => $area->altitudeMin,
            'location' => $area->location?->toArray(),
        ];
    }
}
