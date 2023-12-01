<?php

namespace Tlab\Tests\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByDay;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;
use PHPUnit\Framework\TestCase;

class FireRiskForecastTest extends TestCase
{
    public function testFilterByDico(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertEquals(
            [
                [
                    'rcm' => 1,
                    'dico' => '1002',
                    'latitude' => 39.8222,
                    'longitude' => -8.3814,
                ],
            ],
            $fireRiskForecast->from(0)
                ->filterByDico('1002')
                ->get()
        );
    }

    public function testFilterByRcm(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertEquals(
            [
                [
                    'rcm' => 2,
                    'dico' => '0901',
                    'latitude' => 40.82,
                    'longitude' => -7.54,
                ],
            ],
            $fireRiskForecast->from(0)
                ->filterByRcm(2)
                ->get()
        );
    }


    public function testFindLocationsByDistance()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertEquals([
            [
                'rcm' => 1,
                'dico' => '0810',
                'latitude' => 37.03,
                'longitude' => -7.84,
            ],
            [
                'rcm' => 1,
                'dico' => '0812',
                'latitude' => 37.15,
                'longitude' => -7.89,
            ],
        ], $fireRiskForecast->from(0)
            ->findLocationsByDistance(37.101157, -7.831360, 10)->get());
    }

    public function testFindLocationByNearDistance()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new FireRiskForecast($apiConnector);

        self::assertEquals([
            'rcm' => 1,
            'dico' => '0812',
            'latitude' => 37.15,
            'longitude' => -7.89,
        ], $fireRiskForecast->from(0)->findLocationByNearDistance(37.101157, -7.831360));
    }

    public function testGetFileUpdatedAt()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
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
}
