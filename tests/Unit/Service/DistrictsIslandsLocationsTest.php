<?php

declare(strict_types=1);

namespace Tlab\Tests\Service;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Service\DistrictsIslandsLocations;

class DistrictsIslandsLocationsTest extends TestCase
{
    private array $districtsIslandsFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $this->districtsIslandsFixture = json_decode($contents, true);
    }

    private function createService(): DistrictsIslandsLocations
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->districtsIslandsFixture);

        return new DistrictsIslandsLocations($apiConnector);
    }

    public function testFilterByIdRegion(): void
    {
        $districtLocations = $this->createService();

        self::assertSame(
            [
                [
                    'globalIdLocal' => 2310300,
                    'name' => 'Funchal',
                    'idMunicipality' => 3,
                    'idDistrict' => 31,
                    'idRegion' => 2,
                    'idWarningArea' => 'MCS',
                    'latitude' => 32.6485,
                    'longitude' => -16.9084,
                ],
                [
                    'globalIdLocal' => 2320100,
                    'name' => 'Porto Santo',
                    'idMunicipality' => 1,
                    'idDistrict' => 32,
                    'idRegion' => 2,
                    'idWarningArea' => 'MPS',
                    'latitude' => 33.0700,
                    'longitude' => -16.3400,
                ],
            ],
            $districtLocations
                ->query()
                ->filterByIdRegion(2)
                ->get()
        );
    }

    public function testFilterByIdWarningArea(): void
    {
        $districtLocations = $this->createService();

        self::assertSame([
            [
                'globalIdLocal' => 1080500,
                'name' => 'Faro',
                'idMunicipality' => 5,
                'idDistrict' => 8,
                'idRegion' => 1,
                'idWarningArea' => 'FAR',
                'latitude' => 37.0146,
                'longitude' => -7.9331,
            ],
            [
                'globalIdLocal' => 1081505,
                'name' => 'Sagres',
                'idMunicipality' => 15,
                'idDistrict' => 8,
                'idRegion' => 1,
                'idWarningArea' => 'FAR',
                'latitude' => 37.0168,
                'longitude' => -8.9403,
            ],
            [
                'globalIdLocal' => 1081100,
                'name' => 'Portimão',
                'idMunicipality' => 11,
                'idDistrict' => 8,
                'idRegion' => 1,
                'idWarningArea' => 'FAR',
                'latitude' => 37.1500,
                'longitude' => -8.5200,
            ],
            [
                'globalIdLocal' => 1080800,
                'name' => 'Loulé',
                'idMunicipality' => 8,
                'idDistrict' => 8,
                'idRegion' => 1,
                'idWarningArea' => 'FAR',
                'latitude' => 37.1397,
                'longitude' => -8.0202,
            ],
        ], $districtLocations
            ->query()
            ->filterByIdWarningArea('FAR')
            ->get());
    }

    public function testFilterByIdMunicipality(): void
    {
        $districtLocations = $this->createService();

        self::assertSame([
            [
                'globalIdLocal' => 1010500,
                'name' => 'Aveiro',
                'idMunicipality' => 5,
                'idDistrict' => 1,
                'idRegion' => 1,
                'idWarningArea' => 'AVR',
                'latitude' => 40.6413,
                'longitude' => -8.6535,
            ],
            [
                'globalIdLocal' => 1020500,
                'name' => 'Beja',
                'idMunicipality' => 5,
                'idDistrict' => 2,
                'idRegion' => 1,
                'idWarningArea' => 'BJA',
                'latitude' => 38.0200,
                'longitude' => -7.8700,
            ],
            [
                'globalIdLocal' => 1070500,
                'name' => 'Évora',
                'idMunicipality' => 5,
                'idDistrict' => 7,
                'idRegion' => 1,
                'idWarningArea' => 'EVR',
                'latitude' => 38.5701,
                'longitude' => -7.9104,
            ],
            [
                'globalIdLocal' => 1080500,
                'name' => 'Faro',
                'idMunicipality' => 5,
                'idDistrict' => 8,
                'idRegion' => 1,
                'idWarningArea' => 'FAR',
                'latitude' => 37.0146,
                'longitude' => -7.9331,
            ],
        ], $districtLocations
            ->query()
            ->filterByIdMunicipality(5)
            ->get());
    }

    public function testFilterByGlobalIdLocal(): void
    {
        $districtLocations = $this->createService();

        self::assertSame([
            [
                'globalIdLocal' => 1060300,
                'name' => 'Coimbra',
                'idMunicipality' => 3,
                'idDistrict' => 6,
                'idRegion' => 1,
                'idWarningArea' => 'CBR',
                'latitude' => 40.2081,
                'longitude' => -8.4194,
            ],
        ], $districtLocations
            ->query()
            ->filterByGlobalIdLocal(1060300)
            ->get());
    }

    public function testFilterByIdDistrict(): void
    {
        $districtLocations = $this->createService();

        self::assertSame([
            [
                'globalIdLocal' => 1110600,
                'name' => 'Lisboa',
                'idMunicipality' => 6,
                'idDistrict' => 11,
                'idRegion' => 1,
                'idWarningArea' => 'LSB',
                'latitude' => 38.7660,
                'longitude' => -9.1286,
            ]
        ], $districtLocations
            ->query()
            ->filterByIdDistrict(11)
            ->get());
    }

    public function testFilterByName(): void
    {
        $districtLocations = $this->createService();

        self::assertSame([
            [
                'globalIdLocal' => 1131200,
                'name' => 'Porto',
                'idMunicipality' => 12,
                'idDistrict' => 13,
                'idRegion' => 1,
                'idWarningArea' => 'PTO',
                'latitude' => 41.158,
                'longitude' => -8.6294,
            ]
        ], $districtLocations
            ->query()
            ->filterByName('porto', true)
            ->get());
    }

    public function testFindLocationsByDistance(): void
    {
        $districtLocations = $this->createService();

        self::assertSame([
            [
                'globalIdLocal' => 1160900,
                'name' => 'Viana do Castelo',
                'idMunicipality' => 9,
                'idDistrict' => 16,
                'idRegion' => 1,
                'idWarningArea' => 'VCT',
                'latitude' => 41.6952,
                'longitude' => -8.8365
            ]
        ], $districtLocations
            ->query()
            ->filterLocationsByDistance(41.6952, -8.8365, 2)
            ->get());
    }

    public function testFindLocationByNearDistance(): void
    {
        $districtLocations = $this->createService();

        self::assertSame([
            'globalIdLocal' => 1020500,
            'name' => 'Beja',
            'idMunicipality' => 5,
            'idDistrict' => 2,
            'idRegion' => 1,
            'idWarningArea' => 'BJA',
            'latitude' => 38.0200,
            'longitude' => -7.8700,
        ], $districtLocations
            ->query()
            ->filterLocationByNearDistance(37.721404, -8.290932));
    }
}
