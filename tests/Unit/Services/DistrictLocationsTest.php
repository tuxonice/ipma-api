<?php

namespace Unit\Tlab\Tests\Unit\Tlab\Services;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Services\DistrictsIslandsLocations;

class DistrictLocationsTest extends TestCase
{
    public function testFilterByIdRegiao(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $districtLocations = new DistrictsIslandsLocations($apiConnector);

        self::assertEquals(
            [
                [
                    'idRegiao' => 2,
                    'idAreaAviso' => 'MCS',
                    'idConcelho' => 3,
                    'globalIdLocal' => 2310300,
                    'latitude' => '32.6485',
                    'idDistrito' => 31,
                    'local' => 'Funchal',
                    'longitude' => '-16.9084',
                ],
                [
                    'idRegiao' => 2,
                    'idAreaAviso' => 'MPS',
                    'idConcelho' => 1,
                    'globalIdLocal' => 2320100,
                    'latitude' => '33.0700',
                    'idDistrito' => 32,
                    'local' => 'Porto Santo',
                    'longitude' => '-16.3400',
                ],
            ],
            $districtLocations->filterByIdRegion(2)->get()
        );
    }

    public function testFilterByIdAreaAviso(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $districtLocations = new DistrictsIslandsLocations($apiConnector);

        self::assertEquals([
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'FAR',
                'idConcelho' => 5,
                'globalIdLocal' => 1080500,
                'latitude' => '37.0146',
                'idDistrito' => 8,
                'local' => 'Faro',
                'longitude' => '-7.9331',
            ],
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'FAR',
                'globalIdLocal' => 1081505,
                'idConcelho' => 15,
                'latitude' => '37.0168',
                'idDistrito' => 8,
                'local' => 'Sagres',
                'longitude' => '-8.9403',
            ],
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'FAR',
                'globalIdLocal' => 1081100,
                'idConcelho' => 11,
                'latitude' => '37.1500',
                'idDistrito' => 8,
                'local' => 'Portimão',
                'longitude' => '-8.5200',
            ],
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'FAR',
                'globalIdLocal' => 1080800,
                'idConcelho' => 8,
                'latitude' => '37.1397',
                'idDistrito' => 8,
                'local' => 'Loulé',
                'longitude' => '-8.0202',
            ],
        ], $districtLocations->filterByIdWarningArea('FAR')->get());
    }

    public function testFilterByIdConcelho(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $districtLocations = new DistrictsIslandsLocations($apiConnector);

        self::assertEquals([
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'AVR',
                'idConcelho' => 5,
                'globalIdLocal' => 1010500,
                'latitude' => '40.6413',
                'idDistrito' => 1,
                'local' => 'Aveiro',
                'longitude' => '-8.6535',
            ],
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'BJA',
                'idConcelho' => 5,
                'globalIdLocal' => 1020500,
                'latitude' => '38.0200',
                'idDistrito' => 2,
                'local' => 'Beja',
                'longitude' => '-7.8700',
            ],
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'EVR',
                'idConcelho' => 5,
                'globalIdLocal' => 1070500,
                'latitude' => '38.5701',
                'idDistrito' => 7,
                'local' => 'Évora',
                'longitude' => '-7.9104',
            ],
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'FAR',
                'idConcelho' => 5,
                'globalIdLocal' => 1080500,
                'latitude' => '37.0146',
                'idDistrito' => 8,
                'local' => 'Faro',
                'longitude' => '-7.9331',
            ],
        ], $districtLocations->filterByIdMunicipality(5)->get());
    }

    public function testFilterByGlobalIdLocal(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $districtLocations = new DistrictsIslandsLocations($apiConnector);

        self::assertEquals([
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'CBR',
                'idConcelho' => 3,
                'globalIdLocal' => 1060300,
                'latitude' => '40.2081',
                'idDistrito' => 6,
                'local' => 'Coimbra',
                'longitude' => '-8.4194',
            ],
        ], $districtLocations->filterByGlobalIdLocal(1060300)->get());
    }

    public function testFilterByIdDistrito(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $districtLocations = new DistrictsIslandsLocations($apiConnector);

        self::assertEquals([
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'LSB',
                'globalIdLocal' => 1110600,
                'idConcelho' => 6,
                'latitude' => '38.7660',
                'idDistrito' => 11,
                'local' => 'Lisboa',
                'longitude' => '-9.1286',
            ]
        ], $districtLocations->filterByIdDistrict(11)->get());
    }

    public function testFilterByLocal(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $districtLocations = new DistrictsIslandsLocations($apiConnector);

        self::assertEquals([
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'STB',
                'globalIdLocal' => 1151300,
                'idConcelho' => 13,
                'latitude' => '37.9560',
                'idDistrito' => 15,
                'local' => 'Sines',
                'longitude' => '-8.8643',
            ]
        ], $districtLocations->filterByLocal('Sines')->get());
    }

    public function testFindLocationsByDistance(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $districtLocations = new DistrictsIslandsLocations($apiConnector);

        self::assertEquals([
            [
                'idRegiao' => 1,
                'idAreaAviso' => 'VCT',
                'idConcelho' => 9,
                'globalIdLocal' => 1160900,
                'latitude' => '41.6952',
                'idDistrito' => 16,
                'local' => 'Viana do Castelo',
                'longitude' => '-8.8365'
            ]
        ], $districtLocations->findLocationsByDistance(41.6952, -8.8365, 2)->get());
    }

    public function testFindLocationByNearDistance(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/distrits-islands.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $districtLocations = new DistrictsIslandsLocations($apiConnector);

        self::assertEquals([
            'idRegiao' => 1,
            'idAreaAviso' => 'BJA',
            'idConcelho' => 5,
            'globalIdLocal' => 1020500,
            'latitude' => '38.0200',
            'idDistrito' => 2,
            'local' => 'Beja',
            'longitude' => '-7.8700',
        ], $districtLocations->findLocationByNearDistance(37.721404, -8.290932));
    }
}
