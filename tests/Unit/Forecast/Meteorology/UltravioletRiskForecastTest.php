<?php

namespace Tlab\Tests\Forecast\Meteorology;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Forecast\Meteorology\UltravioletRiskForecast;
use PHPUnit\Framework\TestCase;

class UltravioletRiskForecastTest extends TestCase
{
    public function testFilterByUvIndex()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/uv.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new UltravioletRiskForecast($apiConnector);

        self::assertEquals(
            [
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-13',
                    'globalIdLocal' => 2320100,
                    'iUv' => '2.3',
                ],
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-14',
                    'globalIdLocal' => 2320100,
                    'iUv' => '2.4',

                ],
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-14',
                    'globalIdLocal' => 1081525,
                    'iUv' => '2.3',

                ],
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-14',
                    'globalIdLocal' => 1080500,
                    'iUv' => '2.3',
                ],
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-14',
                    'globalIdLocal' => 0,
                    'iUv' => '2.3',
                ],
            ],
            $fireRiskForecast->filterByUvIndex(2.3, 2.4)->get()
        );
    }

    public function testFilterByGlobalIdLocal()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/uv.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new UltravioletRiskForecast($apiConnector);

        self::assertEquals(
            [
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-13',
                    'globalIdLocal' => 2320100,
                    'iUv' => '2.3',
                ],
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-14',
                    'globalIdLocal' => 2320100,
                    'iUv' => '2.4',

                ],
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-15',
                    'globalIdLocal' => 2320100,
                    'iUv' => '2.6',
                ],
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-16',
                    'globalIdLocal' => 2320100,
                    'iUv' => '2.1',
                ],
                [
                    'idPeriodo' => 10,
                    'intervaloHora' => '',
                    'data' => '2023-12-17',
                    'globalIdLocal' => 2320100,
                    'iUv' => '2.6',
                ],
            ],
            $fireRiskForecast->filterByGlobalIdLocal(2320100)->get()
        );
    }

    public function testFilterByDate()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/uv.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new UltravioletRiskForecast($apiConnector);

        self::assertCount(40, $fireRiskForecast->filterByDate('2023-12-13')->get());
    }
}
