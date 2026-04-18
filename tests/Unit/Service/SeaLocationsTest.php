<?php

declare(strict_types=1);

namespace Tlab\Tests\Service;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Service\SeaLocations;
use PHPUnit\Framework\TestCase;

class SeaLocationsTest extends TestCase
{
    private array $seaLocationsFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Services/sea-locations.json');
        $this->seaLocationsFixture = json_decode($contents, true);
    }

    private function createService(): SeaLocations
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->seaLocationsFixture);

        return new SeaLocations($apiConnector);
    }

    public function testFilterByIdRegion(): void
    {
        $seaLocations = $this->createService();

        self::assertSame(
            [
                [
                    'globalIdLocal' => 3420226,
                    'name' => 'Ponta Delgada, costa',
                    'idLocal' => 309,
                    'idRegion' => 3,
                    'idWarningArea' => 'AOR',
                    'latitude' => 37.68,
                    'longitude' => -25.67,

                ],
                [
                    'globalIdLocal' => 3470126,
                    'name' => 'Horta, costa',
                    'idLocal' => 310,
                    'idRegion' => 3,
                    'idWarningArea' => 'ACE',
                    'latitude' => 38.57,
                    'longitude' => -28.47,

                ],
                [
                    'globalIdLocal' => 3480226,
                    'name' => 'Santa Cruz das Flores, costa',
                    'idLocal' => 311,
                    'idRegion' => 3,
                    'idWarningArea' => 'ACE',
                    'latitude' => 39.45,
                    'longitude' => -31.13,
                ]
            ],
            array_map(fn ($d) => $d->toArray(), $seaLocations->query()->filterByIdRegion(3)->get())
        );
    }

    public function testFilterByIdWarningArea(): void
    {
        $seaLocations = $this->createService();

        self::assertSame(
            [
                [
                    'globalIdLocal' => 3470126,
                    'name' => 'Horta, costa',
                    'idLocal' => 310,
                    'idRegion' => 3,
                    'idWarningArea' => 'ACE',
                    'latitude' => 38.57,
                    'longitude' => -28.47,

                ],
                [
                    'globalIdLocal' => 3480226,
                    'name' => 'Santa Cruz das Flores, costa',
                    'idLocal' => 311,
                    'idRegion' => 3,
                    'idWarningArea' => 'ACE',
                    'latitude' => 39.45,
                    'longitude' => -31.13,
                ]
            ],
            array_map(fn ($d) => $d->toArray(), $seaLocations->query()->filterByIdWarningArea('ace')->get())
        );
    }

    public function testFilterByGlobalIdLocal(): void
    {
        $seaLocations = $this->createService();

        self::assertSame(
            [
                [
                    'globalIdLocal' => 3470126,
                    'name' => 'Horta, costa',
                    'idLocal' => 310,
                    'idRegion' => 3,
                    'idWarningArea' => 'ACE',
                    'latitude' => 38.57,
                    'longitude' => -28.47,
                ]
            ],
            array_map(fn ($d) => $d->toArray(), $seaLocations->query()->filterByGlobalIdLocal(3470126)->get())
        );
    }

    public function testFilterByIdLocal(): void
    {
        $seaLocations = $this->createService();

        self::assertSame(
            [
                [
                    'globalIdLocal' => 1130826,
                    'name' => 'Porto, costa',
                    'idLocal' => 301,
                    'idRegion' => 1,
                    'idWarningArea' => 'PTO',
                    'latitude' => 41.175,
                    'longitude' => -8.76,
                ]
            ],
            array_map(fn ($d) => $d->toArray(), $seaLocations->query()->filterByIdLocal(301)->get())
        );
    }

    public function testFilterByName(): void
    {
        $seaLocations = $this->createService();

        self::assertSame(
            [
                [
                    'globalIdLocal' => 1081526,
                    'name' => 'Sagres, costa',
                    'idLocal' => 305,
                    'idRegion' => 1,
                    'idWarningArea' => 'FAR',
                    'latitude' => 37.0,
                    'longitude' => -8.9383,
                ]
            ],
            array_map(fn ($d) => $d->toArray(), $seaLocations->query()->filterByName('Sagres')->get())
        );
    }

    public function testFindLocationsByDistance(): void
    {
        $seaLocations = $this->createService();

        self::assertSame([
            [
                'globalIdLocal' => 1080526,
                'name' => 'Faro, costa',
                'idLocal' => 306,
                'idRegion' => 1,
                'idWarningArea' => 'FAR',
                'latitude' => 37.0017,
                'longitude' => -8.0,
            ]
        ], array_map(fn ($d) => $d->toArray(), $seaLocations->query()->findLocationsByDistance(37.01, -8.1, 10)->get()));
    }

    public function testFindLocationByNearDistance(): void
    {
        $seaLocations = $this->createService();

        self::assertSame([
            'globalIdLocal' => 1151326,
            'name' => 'Sines, costa',
            'idLocal' => 304,
            'idRegion' => 1,
            'idWarningArea' => 'STB',
            'latitude' => 37.95,
            'longitude' => -8.8833,

        ], $seaLocations->query()->findLocationByNearDistance(37.721404, -8.290932)?->toArray());
    }
}
