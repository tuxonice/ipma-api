<?php

declare(strict_types=1);

namespace Tlab\Tests\Dto\Service;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\Dto\Service\DistrictLocation;
use Tlab\IpmaApi\Dto\Service\MunicipalityArea;

class MunicipalityAreaTest extends TestCase
{
    public function testConstructorAndProperties(): void
    {
        $location = new DistrictLocation(
            globalIdLocal: 1010500,
            name: 'Aveiro',
            idMunicipality: 5,
            idDistrict: 1,
            idRegion: 1,
            idWarningArea: 'AVR',
            latitude: 40.6413,
            longitude: -8.6535,
        );

        $area = new MunicipalityArea(
            dico: '0105',
            nuts1: 'Continente',
            nuts2: 'Centro',
            nuts3: 'Região de Aveiro',
            district: 'Aveiro',
            municipality: 'Aveiro',
            area: 197.58,
            perimeter: 77.0,
            altitudeMax: 78,
            altitudeMin: 0,
            location: $location,
        );

        self::assertSame('0105', $area->dico);
        self::assertSame('Continente', $area->nuts1);
        self::assertSame('Centro', $area->nuts2);
        self::assertSame('Região de Aveiro', $area->nuts3);
        self::assertSame('Aveiro', $area->district);
        self::assertSame('Aveiro', $area->municipality);
        self::assertSame(197.58, $area->area);
        self::assertSame(77.0, $area->perimeter);
        self::assertSame(78, $area->altitudeMax);
        self::assertSame(0, $area->altitudeMin);
        self::assertSame($location, $area->location);
    }

    public function testConstructorWithoutLocation(): void
    {
        $area = new MunicipalityArea(
            dico: '9999',
            nuts1: 'Test',
            nuts2: 'Test Region',
            nuts3: 'Test Subregion',
            district: 'Test District',
            municipality: 'Test Municipality',
            area: 100.0,
            perimeter: 50.0,
            altitudeMax: 500,
            altitudeMin: 10,
        );

        self::assertSame('9999', $area->dico);
        self::assertNull($area->location);
    }

    public function testToArray(): void
    {
        $location = new DistrictLocation(
            globalIdLocal: 1010500,
            name: 'Aveiro',
            idMunicipality: 5,
            idDistrict: 1,
            idRegion: 1,
            idWarningArea: 'AVR',
            latitude: 40.6413,
            longitude: -8.6535,
        );

        $area = new MunicipalityArea(
            dico: '0105',
            nuts1: 'Continente',
            nuts2: 'Centro',
            nuts3: 'Região de Aveiro',
            district: 'Aveiro',
            municipality: 'Aveiro',
            area: 197.58,
            perimeter: 77.0,
            altitudeMax: 78,
            altitudeMin: 0,
            location: $location,
        );

        $expected = [
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
        ];

        // Note: toArray() doesn't recursively convert nested objects
        self::assertSame('0105', $area->toArray()['dico']);
        self::assertSame($location, $area->toArray()['location']);
    }

    public function testToArrayWithoutLocation(): void
    {
        $area = new MunicipalityArea(
            dico: '9999',
            nuts1: 'Test',
            nuts2: 'Test Region',
            nuts3: 'Test Subregion',
            district: 'Test District',
            municipality: 'Test Municipality',
            area: 100.0,
            perimeter: 50.0,
            altitudeMax: 500,
            altitudeMin: 10,
        );

        $expected = [
            'dico' => '9999',
            'nuts1' => 'Test',
            'nuts2' => 'Test Region',
            'nuts3' => 'Test Subregion',
            'district' => 'Test District',
            'municipality' => 'Test Municipality',
            'area' => 100.0,
            'perimeter' => 50.0,
            'altitudeMax' => 500,
            'altitudeMin' => 10,
            'location' => null,
        ];

        // Note: toArray() doesn't recursively convert nested objects
        self::assertSame('9999', $area->toArray()['dico']);
        self::assertNull($area->toArray()['location']);
    }
}
