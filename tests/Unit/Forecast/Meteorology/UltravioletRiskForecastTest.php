<?php

namespace Tlab\Tests\Forecast\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Forecast\Meteorology\UltravioletRiskForecast;
use PHPUnit\Framework\TestCase;

class UltravioletRiskForecastTest extends TestCase
{
    public function testFilterByUvIndex()
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/uv.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new UltravioletRiskForecast($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 2320100,
                    'forecastDate' => '2023-12-13',
                    'uvIndex' => 2.3,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
                [
                    'globalIdLocal' => 2320100,
                    'forecastDate' => '2023-12-14',
                    'uvIndex' => 2.4,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
                [
                    'globalIdLocal' => 1081525,
                    'forecastDate' => '2023-12-14',
                    'uvIndex' => 2.3,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
                [
                    'globalIdLocal' => 1080500,
                    'forecastDate' => '2023-12-14',
                    'uvIndex' => 2.3,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
            ],
            $fireRiskForecast->filterByUvIndex(2.3, 2.4)->get()
        );
    }

    public function testFilterByGlobalIdLocal()
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/uv.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new UltravioletRiskForecast($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 2320100,
                    'forecastDate' => '2023-12-13',
                    'uvIndex' => 2.3,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
                [
                    'globalIdLocal' => 2320100,
                    'forecastDate' => '2023-12-14',
                    'uvIndex' => 2.4,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
                [
                    'globalIdLocal' => 2320100,
                    'forecastDate' => '2023-12-15',
                    'uvIndex' => 2.6,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
                [
                    'globalIdLocal' => 2320100,
                    'forecastDate' => '2023-12-16',
                    'uvIndex' => 2.1,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
                [
                    'globalIdLocal' => 2320100,
                    'forecastDate' => '2023-12-17',
                    'uvIndex' => 2.6,
                    'timeInterval' => '',
                    'periodId' => 10,
                ],
            ],
            $fireRiskForecast->filterByGlobalIdLocal(2320100)->get()
        );
    }

    public function testFilterByDate()
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/uv.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $fireRiskForecast = new UltravioletRiskForecast($apiConnector);

        self::assertCount(30, $fireRiskForecast->filterByForecastDate('2023-12-13')->get());
    }
}
