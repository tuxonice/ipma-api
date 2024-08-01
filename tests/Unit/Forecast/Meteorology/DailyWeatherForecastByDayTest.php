<?php

namespace Tlab\Tests\Forecast\Meteorology;

use DateTime;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByDay;
use PHPUnit\Framework\TestCase;

class DailyWeatherForecastByDayTest extends TestCase
{
    public function testFilterByRainfallProbabilityRange()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 1121400,
                    'idWeatherType' => 10,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => 1,
                    'rainfallProb' => 88.0,
                    'minTemp' => 10.0,
                    'maxTemp' => 15.0,
                    'winDir' => 'SW',
                    'latitude' => 39.29,
                    'longitude' => -7.4200,
                ]
            ],
            $dailyWeatherForecastByDay->from(0)
                ->filterByRainfallProbabilityRange(85.0, 90.0)
                ->get()
        );
    }

    public function testFilterByRainIntensityClass()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 3470100,
                    'idWeatherType' => 6,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => 3,
                    'rainfallProb' => 40.0,
                    'minTemp' => 17.0,
                    'maxTemp' => 21.0,
                    'winDir' => 'SW',
                    'latitude' => 38.5363,
                    'longitude' => -28.6315,
                ],
            ],
            $dailyWeatherForecastByDay->from(0)
                ->filterByRainIntensityClass(3)
                ->get()
        );
    }

    public function testFilterByMinTemperatureRange()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 1020500,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 1.0,
                    'minTemp' => 11.0,
                    'maxTemp' => 18.0,
                    'winDir' => 'W',
                    'latitude' => 38.0200,
                    'longitude' => -7.8700,
                ],
                [
                    'globalIdLocal' => 1050200,
                    'idWeatherType' => 9,
                    'windSpeedClass' => 3,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 65.0,
                    'minTemp' => 10.0,
                    'maxTemp' => 17.0,
                    'winDir' => 'SW',
                    'latitude' => 39.8217,
                    'longitude' => -7.4957,
                ],
                [
                    'globalIdLocal' => 1070500,
                    'idWeatherType' => 4,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 7.0,
                    'minTemp' => 11.0,
                    'maxTemp' => 18.0,
                    'winDir' => 'SW',
                    'latitude' => 38.5701,
                    'longitude' => -7.9104,
                ],
                [
                    'globalIdLocal' => 1121400,
                    'idWeatherType' => 10,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => 1,
                    'rainfallProb' => 88.0,
                    'minTemp' => 10.0,
                    'maxTemp' => 15.0,
                    'winDir' => 'SW',
                    'latitude' => 39.2900,
                    'longitude' => -7.4200,
                ],
                [
                    'globalIdLocal' => 1182300,
                    'idWeatherType' => 9,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 100.0,
                    'minTemp' => 10.0,
                    'maxTemp' => 16.0,
                    'winDir' => 'S',
                    'latitude' => 40.6585,
                    'longitude' => -7.9120,
                ],

            ],
            $dailyWeatherForecastByDay->from(0)
                ->filterByMinTemperatureRange(10.0, 11.0)
                ->get()
        );
    }

    public function testFilterByMaxTemperatureRange()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 2320100,
                    'idWeatherType' => 2,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 0.0,
                    'minTemp' => 16.0,
                    'maxTemp' => 22.0,
                    'winDir' => 'E',
                    'latitude' => 33.0700,
                    'longitude' => -16.3400,
                ]
            ],
            $dailyWeatherForecastByDay->from(0)
                ->filterByMaxTemperatureRange(22.0, 23.0)
                ->get()
        );
    }

    public function testFilterByIdWeatherType()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 1020500,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 1.0,
                    'minTemp' => 11.0,
                    'maxTemp' => 18.0,
                    'winDir' => 'W',
                    'latitude' => 38.0200,
                    'longitude' => -7.8700,
                ],
                [
                    'globalIdLocal' => 1080500,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 0.0,
                    'minTemp' => 12.0,
                    'maxTemp' => 20.0,
                    'winDir' => 'SW',
                    'latitude' => 37.0146,
                    'longitude' => -7.9331,
                ],
                [
                    'globalIdLocal' => 1081505,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 0.0,
                    'minTemp' => 12.0,
                    'maxTemp' => 21.0,
                    'winDir' => 'SE',
                    'latitude' => 37.0168,
                    'longitude' => -8.9403,
                ],
                [
                    'globalIdLocal' => 1151300,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 27.0,
                    'minTemp' => 14.0,
                    'maxTemp' => 19.0,
                    'winDir' => 'SW',
                    'latitude' => 37.9560,
                    'longitude' => -8.8643,
                ],
            ],
            $dailyWeatherForecastByDay->from(0)
                ->filterByIdWeatherType(3)
                ->get()
        );
    }

    public function testFilterByWindDirection()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 1020500,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 1.0,
                    'minTemp' => 11.0,
                    'maxTemp' => 18.0,
                    'winDir' => 'W',
                    'latitude' => 38.0200,
                    'longitude' => -7.8700,
                ],
                [
                    'globalIdLocal' => 1171400,
                    'idWeatherType' => 9,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 100.0,
                    'minTemp' => 9.0,
                    'maxTemp' => 15.0,
                    'winDir' => 'W',
                    'latitude' => 41.3053,
                    'longitude' => -7.7440,
                ]
            ],
            $dailyWeatherForecastByDay->from(0)
                ->filterByWindDirection('w')
                ->get()
        );
    }

    public function testFilterByWindSpeedClass()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 1050200,
                    'idWeatherType' => 9,
                    'windSpeedClass' => 3,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 65.0,
                    'minTemp' => 10.0,
                    'maxTemp' => 17.0,
                    'winDir' => 'SW',
                    'latitude' => 39.8217,
                    'longitude' => -7.4957,
                ],
            ],
            $dailyWeatherForecastByDay->from(0)
                ->filterByWindSpeedClass(3)
                ->get()
        );
    }


    public function testFindLocationsByDistance()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame([
            [
                'globalIdLocal' => 1080500,
                'idWeatherType' => 3,
                'windSpeedClass' => 1,
                'rainfallIntensity' => null,
                'rainfallProb' => 0.0,
                'minTemp' => 12.0,
                'maxTemp' => 20.0,
                'winDir' => 'SW',
                'latitude' => 37.0146,
                'longitude' => -7.9331,
            ],
        ], $dailyWeatherForecastByDay->from(0)
            ->findLocationsByDistance(37.101157, -7.831360, 20)->get());
    }


    public function testFilterByGlobalIdLocal()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame(
            [
                [
                    'globalIdLocal' => 1050200,
                    'idWeatherType' => 9,
                    'windSpeedClass' => 3,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 65.0,
                    'minTemp' => 10.0,
                    'maxTemp' => 17.0,
                    'winDir' => 'SW',
                    'latitude' => 39.8217,
                    'longitude' => -7.4957,
                ],
            ],
            $dailyWeatherForecastByDay->from(0)
                ->filterByGlobalIdLocal(1050200)
                ->get()
        );
    }


    public function testFindLocationByNearDistance()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertSame([
            'globalIdLocal' => 1080500,
            'idWeatherType' => 3,
            'windSpeedClass' => 1,
            'rainfallIntensity' => null,
            'rainfallProb' => 0.0,
            'minTemp' => 12.0,
            'maxTemp' => 20.0,
            'winDir' => 'SW',
            'latitude' => 37.0146,
            'longitude' => -7.9331,

        ], $dailyWeatherForecastByDay->from(0)->findLocationByNearDistance(37.101157, -7.831360));
    }

    public function testGetFileUpdatedAt()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/hp-daily-forecast-day0.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByDay = new DailyWeatherForecastByDay($apiConnector);

        self::assertEquals(
            new DateTime('2023-12-09T16:31:05'),
            $dailyWeatherForecastByDay->from(0)->getFileUpdatedAt()
        );
    }
}
