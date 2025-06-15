<?php

namespace Tlab\Tests\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskLevel;

class FireRiskForecastTest extends TestCase
{
    public function testFilterByDico(): void
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertSame(
            [
                [
                    'dico' => '1002',
                    'fireRiskLevel' => 1,
                    'latitude' => 39.8222,
                    'longitude' => -8.3814,
                ],
            ],
            $fireRiskForecast->from(0)
                ->filterByDico('1002')
                ->get()
        );
    }

    public function testFilterByFireRiskLevel(): void
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertSame(
            [
                [
                    'dico' => '0901',
                    'fireRiskLevel' => 2,
                    'latitude' => 40.82,
                    'longitude' => -7.54,
                ],
            ],
            $fireRiskForecast->from(0)
                ->filterByFireRiskLevel(FireRiskLevel::MODERATE_RISK)
                ->get()
        );
    }

    public function testFindLocationsByDistance()
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertSame([
            [
                'dico' => '0810',
                'fireRiskLevel' => 1,
                'latitude' => 37.03,
                'longitude' => -7.84,
            ],
            [
                'dico' => '0812',
                'fireRiskLevel' => 1,
                'latitude' => 37.15,
                'longitude' => -7.89,
            ],
        ], $fireRiskForecast->from(0)
            ->findLocationsByDistance(37.101157, -7.831360, 10)->get());
    }

    public function testFindLocationByNearDistance()
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertEquals([
            'dico' => '0812',
            'fireRiskLevel' => 1,
            'latitude' => 37.15,
            'longitude' => -7.89,
        ], $fireRiskForecast->from(0)->findLocationByNearDistance(37.101157, -7.831360));
    }

    public function testGetFileUpdatedAt()
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertEquals(
            new DateTime('2023-12-09T00:05:02'),
            $fireRiskForecast->from(0)->getFileUpdatedAt()
        );
    }

    public function testGetForecastDate()
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertEquals(
            new DateTime('2023-12-09T00:00:00'),
            $fireRiskForecast->from(0)->getForecastDate()
        );
    }

    public function testGetRunDate()
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertEquals(
            new DateTime('2023-12-08T00:00:00'),
            $fireRiskForecast->from(0)->getRunDate()
        );
    }
}
