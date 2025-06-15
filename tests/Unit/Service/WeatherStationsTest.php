<?php

declare(strict_types=1);

namespace Tlab\Tests\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Service\WeatherStations;
use PHPUnit\Framework\TestCase;

class WeatherStationsTest extends TestCase
{
    private array $stationsFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/stations.json');
        $this->stationsFixture = json_decode($contents, true);
    }

    private function createService(): WeatherStations
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->stationsFixture);

        return new WeatherStations($apiConnector);
    }

    public function testFilterByIdStation(): void
    {
        $stations = $this->createService();

        self::assertSame([
            [
                'id' => 1210974,
                'name' => 'Madeira, Pico do Areeiro',
                'latitude' => 32.735107,
                'longitude' => -16.928271,
            ]
        ], $stations->query()->filterById(1210974)->get());
    }

    public function testFilterByName(): void
    {
        $stations = $this->createService();

        self::assertSame([
            [
                'id' => 1210520,
                'name' => 'Ilhas selvagens',
                'latitude' => 30.140595,
                'longitude' => -15.869153,
            ]
        ], $stations->query()->filterByName('selvagens')->get());
    }

    public function testFindLocationsByDistance(): void
    {
        $stations = $this->createService();

        self::assertSame([
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
        ], $stations->query()->findLocationsByDistance(37.101157, -7.831360, 20)->get());
    }

    public function testFindLocationByNearDistance(): void
    {
        $stations = $this->createService();

        self::assertSame([
            'id' => 1210881,
            'name' => 'Olhão, EPPO',
            'latitude' => 37.033,
            'longitude' => -7.821,
        ], $stations->query()->findLocationByNearDistance(37.101157, -7.831360));
    }
}
