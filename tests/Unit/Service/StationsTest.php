<?php

namespace Unit\Tlab\Tests\Services;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Service\WeatherStations;
use PHPUnit\Framework\TestCase;

class StationsTest extends TestCase
{
    public function testFilterByIdStation(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/stations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $stations = new WeatherStations($apiConnector);

        self::assertEquals([
            [
                'id' => 1210974,
                'name' => 'Madeira, Pico do Areeiro',
                'latitude' => 32.735107,
                'longitude' => -16.928271,
            ]
        ], $stations->filterById(1210974)->get());
    }

    public function testFilterByName(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/stations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $stations = new WeatherStations($apiConnector);

        self::assertEquals([
            [
                'id' => 1210520,
                'name' => 'Ilhas selvagens',
                'latitude' => 30.140595,
                'longitude' => -15.869153,
            ]
        ], $stations->filterByName('selvagens')->get());
    }

    public function testFindLocationsByDistance(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/stations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $stations = new WeatherStations($apiConnector);

        self::assertEquals([
            [
                'id' => 1210881,
                'name' => 'Olhão, EPPO',
                'latitude' => 37.033,
                'longitude' => -7.821,
            ],
            [
                'id' => 1210883,
                'name' => 'Tavira',
                'latitude' => 37.12166968,
                'longitude' => -7.62050375,
            ],
            [
                'id' => 1200554,
                'name' => 'Faro (Aeródromo)',
                'latitude' => 37.016579,
                'longitude' => -7.971953,
            ],
        ], $stations->findLocationsByDistance(37.101157, -7.831360, 20)->get());
    }

    public function testFindLocationByNearDistance(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/stations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $stations = new WeatherStations($apiConnector);

        self::assertEquals([
            'id' => 1210881,
            'name' => 'Olhão, EPPO',
            'latitude' => 37.033,
            'longitude' => -7.821,
        ], $stations->findLocationByNearDistance(37.101157, -7.831360));
    }
}
