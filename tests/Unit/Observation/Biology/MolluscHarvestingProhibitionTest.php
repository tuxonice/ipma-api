<?php

namespace Tlab\Tests\Observation\Biology;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Observation\Biology\MolluscHarvestingProhibition;
use PHPUnit\Framework\TestCase;

class MolluscHarvestingProhibitionTest extends TestCase
{
    public function testFilterByName(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals(
            [
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Tavira – Vila Real Santo António',
                        'code' => 'L9',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-7.521726250000002 37.094826)',
                        'status' => 'OPEN',
                        'interdictions' => [
                            'open' => [
                                [
                                    'specie_c' => 'Canilha',
                                    'specie_s' => 'Bolinus brandaris',
                                    'classification' => 'NA',
                                ],
                                [
                                    'specie_c' => 'Pé-de-burrinho',
                                    'specie_s' => 'Chamelea gallina',
                                    'classification' => 'A*',
                                ],
                                [
                                    'specie_c' => 'Buzina',
                                    'specie_s' => 'Charonia rubicunda',
                                    'classification' => 'NA',
                                ],
                                [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'B',
                                ],
                                [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [],
                        ],
                        'coords' => [
                            'latitude' => '37.094826',
                            'longitude' => '-7.521726250000002',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Ria Formosa, Tavira',
                        'code' => 'TAV',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-7.673624507077854 37.08832)',
                        'status' => 'OPEN',
                        'interdictions' => [
                            'open' => [
                                [
                                    'specie_c' => 'Berbigão',
                                    'specie_s' => 'Cerastoderma edule',
                                    'classification' => 'C',
                                ],
                                [
                                    'specie_c' => 'Ostra-japonesa/gigante',
                                    'specie_s' => 'Magallana gigas',
                                    'classification' => 'B',
                                ],
                                [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                [
                                    'specie_c' => 'Amêijoa-boa',
                                    'specie_s' => 'Ruditapes decussatus',
                                    'classification' => 'C',
                                ],
                                [
                                    'specie_c' => 'Longueirão',
                                    'specie_s' => 'Solen marginatus',
                                    'classification' => 'C',
                                ],
                            ],
                            'close' => [],
                        ],
                        'coords' => [
                            'latitude' => '37.08832',
                            'longitude' => '-7.673624507077854',
                        ],
                    ],
                ],
            ],
            $molluscHarvestingProhibition
                ->from()
                ->filterByName('tavira')
                ->get()
        );
    }

    public function testFilterByCode(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals(
            [
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Matosinhos',
                        'code' => 'L2',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Norte',
                        'representative_point' => 'POINT (-8.862641815298508 41.100897)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                [
                                    'specie_c' => 'Ouriço-do-mar',
                                    'specie_s' => 'Paracentrotus lividus',
                                    'classification' => 'NA',
                                ],
                                [
                                    'specie_c' => 'Lapa',
                                    'specie_s' => 'Patella spp.',
                                    'classification' => 'NA',
                                ],
                                [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [
                                [
                                    'specie_c' => 'Telina',
                                    'specie_s' => 'Arcopagia crassa',
                                    'classification' => 'B',

                                ],
                                [
                                    'specie_c' => 'Amêijoa-relógio',
                                    'specie_s' => 'Dosinia exoleta',
                                    'classification' => 'B',
                                ],
                                [
                                    'specie_c' => 'Castanhola',
                                    'specie_s' => 'Glycymeris glycymeris',
                                    'classification' => 'B',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => '41.100897',
                            'longitude' => '-8.862641815298508',
                        ],
                    ],
                ],
            ],
            $molluscHarvestingProhibition
                ->from()
                ->filterByCode('L2')
                ->get()
        );
    }

    public function testFilterByZoneType(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals(
            [
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Viana',
                        'code' => 'L1',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Norte',
                        'representative_point' => 'POINT (-8.977014780777537 41.5689535)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Ouriço-do-mar',
                                    'specie_s' => 'Paracentrotus lividus',
                                    'classification' => 'NA',
                                ],
                                2 => [
                                    'specie_c' => 'Lapa',
                                    'specie_s' => 'Patella spp.',
                                    'classification' => 'NA',
                                ],
                                3 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B*',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Amêijoa-relógio',
                                    'specie_s' => 'Dosinia exoleta',
                                    'classification' => 'B*',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 41.5689535,
                            'longitude' => '-8.977014780777537',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Matosinhos',
                        'code' => 'L2',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Norte',
                        'representative_point' => 'POINT (-8.862641815298508 41.100897)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Ouriço-do-mar',
                                    'specie_s' => 'Paracentrotus lividus',
                                    'classification' => 'NA',
                                ],
                                2 => [
                                    'specie_c' => 'Lapa',
                                    'specie_s' => 'Patella spp.',
                                    'classification' => 'NA',
                                ],
                                3 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Telina',
                                    'specie_s' => 'Arcopagia crassa',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Amêijoa-relógio',
                                    'specie_s' => 'Dosinia exoleta',
                                    'classification' => 'B',
                                ],
                                2 => [
                                    'specie_c' => 'Castanhola',
                                    'specie_s' => 'Glycymeris glycymeris',
                                    'classification' => 'B',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 41.100897,
                            'longitude' => '-8.862641815298508',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Aveiro',
                        'code' => 'L3',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Centro',
                        'representative_point' => 'POINT (-8.930170633269361 40.688082)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Longueirão-direito',
                                    'specie_s' => 'Ensis spp.',
                                    'classification' => 'B',
                                ],
                                2 => [
                                    'specie_c' => 'Castanhola',
                                    'specie_s' => 'Glycymeris glycymeris',
                                    'classification' => 'B',
                                ],
                                3 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 40.688082,
                            'longitude' => '-8.930170633269361',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Figueira da Foz - Nazaré',
                        'code' => 'L4',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Centro',
                        'representative_point' => 'POINT (-9.085773530279692 39.952783)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'B',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 39.952783,
                            'longitude' => '-9.085773530279692',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Peniche - Cabo Raso',
                        'code' => 'L5a',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Lisboa e Vale do Tejo',
                        'representative_point' => 'POINT (-9.58233137911316 39.0836251951967)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Ouriço-do-mar',
                                    'specie_s' => 'Paracentrotus lividus',
                                    'classification' => 'NA',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Lapa',
                                    'specie_s' => 'Patella spp.',
                                    'classification' => 'NA',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => '39.0836251951967',
                            'longitude' => '-9.58233137911316',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Cabo Raso - Lagoa de Albufeira',
                        'code' => 'L5b',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Lisboa e Vale do Tejo',
                        'representative_point' => 'POINT (-9.347112535358338 38.61588422197934)',
                        'status' => 'OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'B*',
                                ],
                                1 => [
                                    'specie_c' => 'Longueirão-direito',
                                    'specie_s' => 'Ensis spp.',
                                    'classification' => 'B*',
                                ],
                                2 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                3 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B*',
                                ],
                            ],
                            'close' => [
                            ],
                        ],
                        'coords' => [
                            'latitude' => '38.61588422197934',
                            'longitude' => '-9.347112535358338',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Setúbal - Sines',
                        'code' => 'L6',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Alentejo',
                        'representative_point' => 'POINT (-8.900576082635506 37.98662950000001)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Berbigão',
                                    'specie_s' => 'Cerastoderma edule',
                                    'classification' => 'B*',
                                ],
                                1 => [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'A*',
                                ],
                                2 => [
                                    'specie_c' => 'Longueirão-direito',
                                    'specie_s' => 'Ensis spp.',
                                    'classification' => 'A*',
                                ],
                                3 => [
                                    'specie_c' => 'Berbigão-lustroso',
                                    'specie_s' => 'Laevicardium crassum',
                                    'classification' => 'B*',
                                ],
                                4 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B*',
                                ],
                                5 => [
                                    'specie_c' => 'Ouriço-do-mar',
                                    'specie_s' => 'Paracentrotus lividus',
                                    'classification' => 'NA',
                                ],
                                6 => [
                                    'specie_c' => 'Amêijoa-boa',
                                    'specie_s' => 'Ruditapes decussatus',
                                    'classification' => 'B*',
                                ],
                                7 => [
                                    'specie_c' => 'Longueirão',
                                    'specie_s' => 'Solen marginatus',
                                    'classification' => 'B',
                                ],
                                8 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B*',
                                ],
                                9 => [
                                    'specie_c' => 'Amêijoa-macha',
                                    'specie_s' => 'Venerupis corrugata',
                                    'classification' => 'B*',
                                ],
                                10 => [
                                    'specie_c' => 'Ameijola',
                                    'specie_s' => 'Callista chione',
                                    'classification' => 'A*',
                                ],
                                11 => [
                                    'specie_c' => 'Pé-de-burrico',
                                    'specie_s' => 'Venus casina',
                                    'classification' => 'B*',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Lapa',
                                    'specie_s' => 'Patella spp.',
                                    'classification' => 'NA',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => '37.98662950000001',
                            'longitude' => '-8.900576082635506',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Aljezur - S. Vicente',
                        'code' => 'L7a',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-8.932552870930232 37.212677)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Ouriço-do-mar',
                                    'specie_s' => 'Paracentrotus lividus',
                                    'classification' => 'NA',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Lapa',
                                    'specie_s' => 'Patella spp.',
                                    'classification' => 'NA',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.212677,
                            'longitude' => '-8.932552870930232',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Offshore',
                        'code' => 'L7b',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-8.886655238428849 37.0213)',
                        'status' => 'CLOSE',
                        'interdictions' => [
                            'open' => [
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Ostra-japonesa/gigante',
                                    'specie_s' => 'Magallana gigas',
                                    'classification' => 'NC',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.0213,
                            'longitude' => '-8.886655238428849',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral São Vicente -Lagos',
                        'code' => 'L7c1',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-8.821188249999999 37.0179765)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Buzina',
                                    'specie_s' => 'Charonia rubicunda',
                                    'classification' => 'NA',
                                ],
                                1 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'A',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Lapa',
                                    'specie_s' => 'Patella spp.',
                                    'classification' => 'NA',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.0179765,
                            'longitude' => '-8.821188249999999',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Lagos -Albufeira',
                        'code' => 'L7c2',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-8.419930254632641 37.0283005)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'B*',
                                ],
                                1 => [
                                    'specie_c' => 'Amêijoa-macha',
                                    'specie_s' => 'Venerupis corrugata',
                                    'classification' => 'A*',
                                ],
                                2 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'A',
                                ],
                                3 => [
                                    'specie_c' => 'Pé-de-burrinho',
                                    'specie_s' => 'Chamelea gallina',
                                    'classification' => 'B*',
                                ],
                                4 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B*',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Canilha',
                                    'specie_s' => 'Bolinus brandaris',
                                    'classification' => 'NA',
                                ],
                                1 => [
                                    'specie_c' => 'Buzina',
                                    'specie_s' => 'Charonia rubicunda',
                                    'classification' => 'NA',
                                ],
                                2 => [
                                    'specie_c' => 'Zamburinha',
                                    'specie_s' => 'Mimachlamys varia',
                                    'classification' => 'A*',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.0283005,
                            'longitude' => '-8.419930254632641',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Faro - Olhão',
                        'code' => 'L8',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-8.051781360377781 36.9964035)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Pé-de-burrinho',
                                    'specie_s' => 'Chamelea gallina',
                                    'classification' => 'A*',
                                ],
                                1 => [
                                    'specie_c' => 'Buzina',
                                    'specie_s' => 'Charonia rubicunda',
                                    'classification' => 'NA',
                                ],
                                2 => [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'B',
                                ],
                                3 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 36.9964035,
                            'longitude' => '-8.051781360377781',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Tavira – Vila Real Santo António',
                        'code' => 'L9',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-7.521726250000002 37.094826)',
                        'status' => 'OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Canilha',
                                    'specie_s' => 'Bolinus brandaris',
                                    'classification' => 'NA',
                                ],
                                1 => [
                                    'specie_c' => 'Pé-de-burrinho',
                                    'specie_s' => 'Chamelea gallina',
                                    'classification' => 'A*',
                                ],
                                2 => [
                                    'specie_c' => 'Buzina',
                                    'specie_s' => 'Charonia rubicunda',
                                    'classification' => 'NA',
                                ],
                                3 => [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'B',
                                ],
                                4 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.094826,
                            'longitude' => '-7.521726250000002',
                        ],
                    ],
                ],
            ],
            $molluscHarvestingProhibition
                ->from()
                ->filterByZoneType('LITORAL')
                ->get()
        );
    }

    public function testFilterByRegionName(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals(
            [
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Setúbal - Sines',
                        'code' => 'L6',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Alentejo',
                        'representative_point' => 'POINT (-8.900576082635506 37.98662950000001)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Berbigão',
                                    'specie_s' => 'Cerastoderma edule',
                                    'classification' => 'B*',
                                ],
                                1 => [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'A*',
                                ],
                                2 => [
                                    'specie_c' => 'Longueirão-direito',
                                    'specie_s' => 'Ensis spp.',
                                    'classification' => 'A*',
                                ],
                                3 => [
                                    'specie_c' => 'Berbigão-lustroso',
                                    'specie_s' => 'Laevicardium crassum',
                                    'classification' => 'B*',
                                ],
                                4 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B*',
                                ],
                                5 => [
                                    'specie_c' => 'Ouriço-do-mar',
                                    'specie_s' => 'Paracentrotus lividus',
                                    'classification' => 'NA',
                                ],
                                6 => [
                                    'specie_c' => 'Amêijoa-boa',
                                    'specie_s' => 'Ruditapes decussatus',
                                    'classification' => 'B*',
                                ],
                                7 => [
                                    'specie_c' => 'Longueirão',
                                    'specie_s' => 'Solen marginatus',
                                    'classification' => 'B',
                                ],
                                8 => [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B*',
                                ],
                                9 => [
                                    'specie_c' => 'Amêijoa-macha',
                                    'specie_s' => 'Venerupis corrugata',
                                    'classification' => 'B*',
                                ],
                                10 => [
                                    'specie_c' => 'Ameijola',
                                    'specie_s' => 'Callista chione',
                                    'classification' => 'A*',
                                ],
                                11 => [
                                    'specie_c' => 'Pé-de-burrico',
                                    'specie_s' => 'Venus casina',
                                    'classification' => 'B*',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Lapa',
                                    'specie_s' => 'Patella spp.',
                                    'classification' => 'NA',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => '37.98662950000001',
                            'longitude' => '-8.900576082635506',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Estuário do Rio Mira',
                        'code' => 'EMR',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Alentejo',
                        'representative_point' => 'POINT (-8.727057634344792 37.68105)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Pé-de-burro',
                                    'specie_s' => 'Venus verrucosa',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Ostra-portuguesa',
                                    'specie_s' => 'Magallana angulata',
                                    'classification' => 'A',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.68105,
                            'longitude' => '-8.727057634344792',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Estuário do Sado, Esteiro da Marateca',
                        'code' => 'ESD1',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Alentejo',
                        'representative_point' => 'POINT (-8.744430767078104 38.47799)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Ostra-portuguesa',
                                    'specie_s' => 'Magallana angulata',
                                    'classification' => 'B',
                                ],
                                1 => [
                                    'specie_c' => 'Ostra-plana',
                                    'specie_s' => 'Ostrea edulis',
                                    'classification' => 'B',
                                ],
                                2 => [
                                    'specie_c' => 'Longueirão',
                                    'specie_s' => 'Solen marginatus',
                                    'classification' => 'B*',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Amêijoa-japonesa',
                                    'specie_s' => 'Ruditapes philippinarum',
                                    'classification' => 'Proibida',
                                ],
                                1 => [
                                    'specie_c' => 'Lambujinha',
                                    'specie_s' => 'Scrobicularia plana',
                                    'classification' => 'Proibida',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 38.47799,
                            'longitude' => '-8.744430767078104',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Estuário do Sado, Canal de Alcácer',
                        'code' => 'ESD2',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Alentejo',
                        'representative_point' => 'POINT (-8.677896605616471 38.419448)',
                        'status' => 'PARTIAL_OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Amêijoa-boa',
                                    'specie_s' => 'Ruditapes decussatus',
                                    'classification' => 'B*',
                                ],
                                1 => [
                                    'specie_c' => 'Amêijoa-japonesa',
                                    'specie_s' => 'Ruditapes philippinarum',
                                    'classification' => 'B',
                                ],
                                2 => [
                                    'specie_c' => 'Lambujinha',
                                    'specie_s' => 'Scrobicularia plana',
                                    'classification' => 'C',
                                ],
                                3 => [
                                    'specie_c' => 'Longueirão',
                                    'specie_s' => 'Solen marginatus',
                                    'classification' => 'C*',
                                ],
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Ostra-portuguesa',
                                    'specie_s' => 'Magallana angulata',
                                    'classification' => 'Proibida',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 38.419448,
                            'longitude' => '-8.677896605616471',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Lagoa de Albufeira',
                        'code' => 'LAL',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Alentejo',
                        'representative_point' => 'POINT (-9.168712154478733 38.515405)',
                        'status' => 'OPEN',
                        'interdictions' => [
                            'open' => [
                                0 => [
                                    'specie_c' => 'Berbigão',
                                    'specie_s' => 'Cerastoderma edule',
                                    'classification' => 'B*',
                                ],
                                1 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                2 => [
                                    'specie_c' => 'Amêijoa-boa',
                                    'specie_s' => 'Ruditapes decussatus',
                                    'classification' => 'B*',
                                ],
                                3 => [
                                    'specie_c' => 'Amêijoa-japonesa',
                                    'specie_s' => 'Ruditapes philippinarum',
                                    'classification' => 'B*',
                                ],
                                4 => [
                                    'specie_c' => 'Amêijoa-macha',
                                    'specie_s' => 'Venerupis corrugata',
                                    'classification' => 'B*',
                                ],
                            ],
                            'close' => [
                            ],
                        ],
                        'coords' => [
                            'latitude' => 38.515405,
                            'longitude' => '-9.168712154478733',
                        ],
                    ],
                ],
            ],
            $molluscHarvestingProhibition
                ->from()
                ->filterByRegionName('Alentejo')
                ->get()
        );
    }

    public function testFilterByStatus(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals(
            [
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Offshore',
                        'code' => 'L7b',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-8.886655238428849 37.0213)',
                        'status' => 'CLOSE',
                        'interdictions' => [
                            'open' => [
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Ostra-japonesa/gigante',
                                    'specie_s' => 'Magallana gigas',
                                    'classification' => 'NC',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.0213,
                            'longitude' => '-8.886655238428849',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Ria Formosa, Olhão',
                        'code' => 'OLH3',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-7.838339836466027 37.017785)',
                        'status' => 'CLOSE',
                        'interdictions' => [
                            'open' => [
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Berbigão',
                                    'specie_s' => 'Cerastoderma edule',
                                    'classification' => 'Proibida',
                                ],
                                1 => [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'Proibida',
                                ],
                                2 => [
                                    'specie_c' => 'Amêijoa-boa',
                                    'specie_s' => 'Ruditapes decussatus',
                                    'classification' => 'Proibida',
                                ],
                                3 => [
                                    'specie_c' => 'Longueirão',
                                    'specie_s' => 'Solen marginatus',
                                    'classification' => 'Proibida',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.017785,
                            'longitude' => '-7.838339836466027',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Rio Arade, Parchal',
                        'code' => 'POR3',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-8.523680708995476 37.1399214129854)',
                        'status' => 'CLOSE',
                        'interdictions' => [
                            'open' => [
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Ostra-japonesa/gigante',
                                    'specie_s' => 'Magallana gigas',
                                    'classification' => 'NC',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => '37.1399214129854',
                            'longitude' => '-8.523680708995476',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Ria Formosa, Cacela',
                        'code' => 'VT',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-7.541484999999986 37.156175)',
                        'status' => 'CLOSE',
                        'interdictions' => [
                            'open' => [
                            ],
                            'close' => [
                                0 => [
                                    'specie_c' => 'Ostra-japonesa/gigante',
                                    'specie_s' => 'Magallana gigas',
                                    'classification' => 'NC',
                                ],
                            ],
                        ],
                        'coords' => [
                            'latitude' => 37.156175,
                            'longitude' => '-7.541484999999986',
                        ],
                    ],
                ],
            ],
            $molluscHarvestingProhibition
                ->from()
                ->filterByStatus('CLOSE')
                ->get()
        );
    }

    public function testFilterByCommonName(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::exactly(2))
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals([
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Litoral Matosinhos',
                    'code' => 'L2',
                    'zone_type' => 'LITORAL',
                    'region_name' => 'Norte',
                    'representative_point' => 'POINT (-8.862641815298508 41.100897)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Ouriço-do-mar',
                                'specie_s' => 'Paracentrotus lividus',
                                'classification' => 'NA',
                            ],
                            [
                                'specie_c' => 'Lapa',
                                'specie_s' => 'Patella spp.',
                                'classification' => 'NA',
                            ],
                            [
                                'specie_c' => 'Amêijoa-branca',
                                'specie_s' => 'Spisula solida',
                                'classification' => 'B',
                            ],
                        ],
                        'close' => [
                            [
                                'specie_c' => 'Telina',
                                'specie_s' => 'Arcopagia crassa',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Amêijoa-relógio',
                                'specie_s' => 'Dosinia exoleta',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Castanhola',
                                'specie_s' => 'Glycymeris glycymeris',
                                'classification' => 'B',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => '41.100897',
                        'longitude' => '-8.862641815298508',
                    ],

                ],
            ],
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Litoral Aveiro',
                    'code' => 'L3',
                    'zone_type' => 'LITORAL',
                    'region_name' => 'Centro',
                    'representative_point' => 'POINT (-8.930170633269361 40.688082)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            [
                                'specie_c' => 'Amêijoa-branca',
                                'specie_s' => 'Spisula solida',
                                'classification' => 'B',
                            ],
                        ],
                        'close' => [
                            [
                                'specie_c' => 'Conquilha',
                                'specie_s' => 'Donax trunculus',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Longueirão-direito',
                                'specie_s' => 'Ensis spp.',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Castanhola',
                                'specie_s' => 'Glycymeris glycymeris',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => 40.688082,
                        'longitude' => -8.930170633269361,
                    ],

                ],
            ],
        ], $molluscHarvestingProhibition
            ->from()
            ->filterByCommonName('Castanhola')
            ->get());

        self::assertEquals([
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Litoral Matosinhos',
                    'code' => 'L2',
                    'zone_type' => 'LITORAL',
                    'region_name' => 'Norte',
                    'representative_point' => 'POINT (-8.862641815298508 41.100897)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Ouriço-do-mar',
                                'specie_s' => 'Paracentrotus lividus',
                                'classification' => 'NA',
                            ],
                            [
                                'specie_c' => 'Lapa',
                                'specie_s' => 'Patella spp.',
                                'classification' => 'NA',
                            ],
                            [
                                'specie_c' => 'Amêijoa-branca',
                                'specie_s' => 'Spisula solida',
                                'classification' => 'B',
                            ],
                        ],
                        'close' => [
                            [
                                'specie_c' => 'Telina',
                                'specie_s' => 'Arcopagia crassa',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Amêijoa-relógio',
                                'specie_s' => 'Dosinia exoleta',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Castanhola',
                                'specie_s' => 'Glycymeris glycymeris',
                                'classification' => 'B',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => 41.100897,
                        'longitude' => -8.862641815298508,
                    ],

                ],
            ],
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Litoral Aveiro',
                    'code' => 'L3',
                    'zone_type' => 'LITORAL',
                    'region_name' => 'Centro',
                    'representative_point' => 'POINT (-8.930170633269361 40.688082)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            [
                                'specie_c' => 'Amêijoa-branca',
                                'specie_s' => 'Spisula solida',
                                'classification' => 'B',
                            ],
                        ],
                        'close' => [
                            [
                                'specie_c' => 'Conquilha',
                                'specie_s' => 'Donax trunculus',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Longueirão-direito',
                                'specie_s' => 'Ensis spp.',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Castanhola',
                                'specie_s' => 'Glycymeris glycymeris',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => 40.688082,
                        'longitude' => -8.930170633269361,
                    ],

                ],
            ],
        ], $molluscHarvestingProhibition
            ->from()
            ->filterByClose()
            ->filterByCommonName('Castanhola')
            ->get());
    }

    public function testFilterByScientificName(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::exactly(2))
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals([
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Litoral Matosinhos',
                    'code' => 'L2',
                    'zone_type' => 'LITORAL',
                    'region_name' => 'Norte',
                    'representative_point' => 'POINT (-8.862641815298508 41.100897)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Ouriço-do-mar',
                                'specie_s' => 'Paracentrotus lividus',
                                'classification' => 'NA',
                            ],
                            [
                                'specie_c' => 'Lapa',
                                'specie_s' => 'Patella spp.',
                                'classification' => 'NA',
                            ],
                            [
                                'specie_c' => 'Amêijoa-branca',
                                'specie_s' => 'Spisula solida',
                                'classification' => 'B',
                            ],
                        ],
                        'close' => [
                            [
                                'specie_c' => 'Telina',
                                'specie_s' => 'Arcopagia crassa',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Amêijoa-relógio',
                                'specie_s' => 'Dosinia exoleta',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Castanhola',
                                'specie_s' => 'Glycymeris glycymeris',
                                'classification' => 'B',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => '41.100897',
                        'longitude' => -8.862641815298508,
                    ],

                ],
            ],
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Litoral Aveiro',
                    'code' => 'L3',
                    'zone_type' => 'LITORAL',
                    'region_name' => 'Centro',
                    'representative_point' => 'POINT (-8.930170633269361 40.688082)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            [
                                'specie_c' => 'Amêijoa-branca',
                                'specie_s' => 'Spisula solida',
                                'classification' => 'B',
                            ],
                        ],
                        'close' => [
                            [
                                'specie_c' => 'Conquilha',
                                'specie_s' => 'Donax trunculus',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Longueirão-direito',
                                'specie_s' => 'Ensis spp.',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Castanhola',
                                'specie_s' => 'Glycymeris glycymeris',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => '40.688082',
                        'longitude' => -8.930170633269361,
                    ],

                ],
            ],
        ], $molluscHarvestingProhibition
            ->from()
            ->filterByScientificName('Glycymeris glycymeris')
            ->get());

        self::assertEquals([
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Litoral Matosinhos',
                    'code' => 'L2',
                    'zone_type' => 'LITORAL',
                    'region_name' => 'Norte',
                    'representative_point' => 'POINT (-8.862641815298508 41.100897)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Ouriço-do-mar',
                                'specie_s' => 'Paracentrotus lividus',
                                'classification' => 'NA',
                            ],
                            [
                                'specie_c' => 'Lapa',
                                'specie_s' => 'Patella spp.',
                                'classification' => 'NA',
                            ],
                            [
                                'specie_c' => 'Amêijoa-branca',
                                'specie_s' => 'Spisula solida',
                                'classification' => 'B',
                            ],
                        ],
                        'close' => [
                            [
                                'specie_c' => 'Telina',
                                'specie_s' => 'Arcopagia crassa',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Amêijoa-relógio',
                                'specie_s' => 'Dosinia exoleta',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Castanhola',
                                'specie_s' => 'Glycymeris glycymeris',
                                'classification' => 'B',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => '41.100897',
                        'longitude' => -8.862641815298508,
                    ],

                ],
            ],
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Litoral Aveiro',
                    'code' => 'L3',
                    'zone_type' => 'LITORAL',
                    'region_name' => 'Centro',
                    'representative_point' => 'POINT (-8.930170633269361 40.688082)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            [
                                'specie_c' => 'Amêijoa-branca',
                                'specie_s' => 'Spisula solida',
                                'classification' => 'B',
                            ],
                        ],
                        'close' => [
                            [
                                'specie_c' => 'Conquilha',
                                'specie_s' => 'Donax trunculus',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Longueirão-direito',
                                'specie_s' => 'Ensis spp.',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Castanhola',
                                'specie_s' => 'Glycymeris glycymeris',
                                'classification' => 'B',
                            ],
                            [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => '40.688082',
                        'longitude' => -8.930170633269361,
                    ],
                ],
            ],
        ], $molluscHarvestingProhibition
            ->from()
            ->filterByClose()
            ->filterByScientificName('Glycymeris glycymeris')
            ->get());
    }

    public function testFilterByClassification(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::exactly(2))
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertCount(31, $molluscHarvestingProhibition
            ->from()
            ->filterByClassification('B')
            ->get());

        self::assertCount(5, $molluscHarvestingProhibition
            ->from()
            ->filterByClose()
            ->filterByClassification('B')
            ->get());
    }

    public function testFindLocationsByDistance(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals([
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Ria Formosa, Olhão',
                    'code' => 'OLH1',
                    'zone_type' => 'EST_LAG',
                    'region_name' => 'Algarve',
                    'representative_point' => 'POINT (-7.780593100230414 37.0329705)',
                    'status' => 'OPEN',
                    'interdictions' => [
                        'open' => [
                            0 => [
                                'specie_c' => 'Ostra-japonesa/gigante',
                                'specie_s' => 'Magallana gigas',
                                'classification' => 'B*',
                            ],
                            1 => [
                                'specie_c' => 'Amêijoa-boa',
                                'specie_s' => 'Ruditapes decussatus',
                                'classification' => 'B*',
                            ],
                        ],
                        'close' => [
                        ],
                    ],
                    'coords' => [
                        'latitude' => 37.0329705,
                        'longitude' => -7.780593100230414,
                    ],
                ],
            ],
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Ria Formosa, Olhão',
                    'code' => 'OLH2',
                    'zone_type' => 'EST_LAG',
                    'region_name' => 'Algarve',
                    'representative_point' => 'POINT (-7.807078279953917 37.028698)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            0 => [
                                'specie_c' => 'Taralhão',
                                'specie_s' => 'Lutraria lutaria',
                                'classification' => 'B*',
                            ],
                            1 => [
                                'specie_c' => 'Ostra-japonesa/gigante',
                                'specie_s' => 'Magallana gigas',
                                'classification' => 'B',
                            ],
                            2 => [
                                'specie_c' => 'Búzio',
                                'specie_s' => 'Murex trunculus',
                                'classification' => 'NA',
                            ],
                            3 => [
                                'specie_c' => 'Berbigão',
                                'specie_s' => 'Cerastoderma edule',
                                'classification' => 'B*',
                            ],
                            4 => [
                                'specie_c' => 'Amêijoa-cão',
                                'specie_s' => 'Polititapes aureus',
                                'classification' => 'B*',
                            ],
                            5 => [
                                'specie_c' => 'Amêijoa-boa',
                                'specie_s' => 'Ruditapes decussatus',
                                'classification' => 'B',
                            ],
                            6 => [
                                'specie_c' => 'Longueirão',
                                'specie_s' => 'Solen marginatus',
                                'classification' => 'B*',
                            ],
                            7 => [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B*',
                            ],
                        ],
                        'close' => [
                            0 => [
                                'specie_c' => 'Amêijoa-macha',
                                'specie_s' => 'Venerupis corrugata',
                                'classification' => 'B*',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => 37.028698,
                        'longitude' => -7.807078279953917,
                    ],
                ],
            ],

            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Ria Formosa, Olhão',
                    'code' => 'OLH3',
                    'zone_type' => 'EST_LAG',
                    'region_name' => 'Algarve',
                    'representative_point' => 'POINT (-7.838339836466027 37.017785)',
                    'status' => 'CLOSE',
                    'interdictions' => [
                        'open' => [
                        ],
                        'close' => [
                            0 => [
                                'specie_c' => 'Berbigão',
                                'specie_s' => 'Cerastoderma edule',
                                'classification' => 'Proibida',
                            ],
                            1 => [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'Proibida',
                            ],
                            2 => [
                                'specie_c' => 'Amêijoa-boa',
                                'specie_s' => 'Ruditapes decussatus',
                                'classification' => 'Proibida',
                            ],
                            3 => [
                                'specie_c' => 'Longueirão',
                                'specie_s' => 'Solen marginatus',
                                'classification' => 'Proibida',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => 37.017785,
                        'longitude' => -7.838339836466027,
                    ],
                ],
            ],
        ], $molluscHarvestingProhibition
            ->from()
            ->findLocationsByDistance(37.101157, -7.831360, 10)
            ->get());
    }

    public function testFindLocationsByNearDistance(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Biology/CI_SNMB.geojson');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $molluscHarvestingProhibition = new MolluscHarvestingProhibition($apiConnector);

        self::assertEquals(
            [
                'type' => 'Feature',
                'properties' => [
                    'name' => 'Ria Formosa, Olhão',
                    'code' => 'OLH2',
                    'zone_type' => 'EST_LAG',
                    'region_name' => 'Algarve',
                    'representative_point' => 'POINT (-7.807078279953917 37.028698)',
                    'status' => 'PARTIAL_OPEN',
                    'interdictions' => [
                        'open' => [
                            0 => [
                                'specie_c' => 'Taralhão',
                                'specie_s' => 'Lutraria lutaria',
                                'classification' => 'B*',
                            ],
                            1 => [
                                'specie_c' => 'Ostra-japonesa/gigante',
                                'specie_s' => 'Magallana gigas',
                                'classification' => 'B',
                            ],
                            2 => [
                                'specie_c' => 'Búzio',
                                'specie_s' => 'Murex trunculus',
                                'classification' => 'NA',
                            ],
                            3 => [
                                'specie_c' => 'Berbigão',
                                'specie_s' => 'Cerastoderma edule',
                                'classification' => 'B*',
                            ],
                            4 => [
                                'specie_c' => 'Amêijoa-cão',
                                'specie_s' => 'Polititapes aureus',
                                'classification' => 'B*',
                            ],
                            5 => [
                                'specie_c' => 'Amêijoa-boa',
                                'specie_s' => 'Ruditapes decussatus',
                                'classification' => 'B',
                            ],
                            6 => [
                                'specie_c' => 'Longueirão',
                                'specie_s' => 'Solen marginatus',
                                'classification' => 'B*',
                            ],
                            7 => [
                                'specie_c' => 'Mexilhão',
                                'specie_s' => 'Mytilus spp.',
                                'classification' => 'B*',
                            ],
                        ],
                        'close' => [
                            0 => [
                                'specie_c' => 'Amêijoa-macha',
                                'specie_s' => 'Venerupis corrugata',
                                'classification' => 'B*',
                            ],
                        ],
                    ],
                    'coords' => [
                        'latitude' => 37.028698,
                        'longitude' => -7.807078279953917,
                    ],
                ],
            ],
            $molluscHarvestingProhibition
            ->from()
            ->findLocationByNearDistance(37.101157, -7.831360)
        );
    }
}
