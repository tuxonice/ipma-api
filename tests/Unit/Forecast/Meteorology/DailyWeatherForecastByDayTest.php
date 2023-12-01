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

        self::assertEquals(
            [
                [
                    'precipitaProb' => '88.0',
                    'tMin' => 10,
                    'tMax' => 15,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 10,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.4200',
                    'classPrecInt' => 1,
                    'globalIdLocal' => 1121400,
                    'latitude' => '39.2900',

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

        self::assertEquals(
            [
                [
                    'precipitaProb' => '40.0',
                    'tMin' => 17,
                    'tMax' => 21,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 6,
                    'classWindSpeed' => 2,
                    'longitude' => '-28.6315',
                    'classPrecInt' => 3,
                    'globalIdLocal' => 3470100,
                    'latitude' => '38.5363',

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

        self::assertEquals(
            [
                [
                    'precipitaProb' => '1.0',
                    'tMin' => 11,
                    'tMax' => 18,
                    'predWindDir' => 'W',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'globalIdLocal' => 1020500,
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '65.0',
                    'tMin' => 10,
                    'tMax' => 17,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 9,
                    'classWindSpeed' => 3,
                    'longitude' => '-7.4957',
                    'classPrecInt' => 2,
                    'globalIdLocal' => 1050200,
                    'latitude' => '39.8217',
                ],
                [
                    'precipitaProb' => '7.0',
                    'tMin' => 11,
                    'tMax' => 18,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 4,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.9104',
                    'globalIdLocal' => 1070500,
                    'latitude' => '38.5701',
                ],
                [
                    'precipitaProb' => '88.0',
                    'tMin' => 10,
                    'tMax' => 15,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 10,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.4200',
                    'classPrecInt' => 1,
                    'globalIdLocal' => 1121400,
                    'latitude' => '39.2900',
                ],
                [
                    'precipitaProb' => '100.0',
                    'tMin' => 10,
                    'tMax' => 16,
                    'predWindDir' => 'S',
                    'idWeatherType' => 9,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.9120',
                    'classPrecInt' => 2,
                    'globalIdLocal' => 1182300,
                    'latitude' => '40.6585',
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

        self::assertEquals(
            [
                [
                    'precipitaProb' => '0.0',
                    'tMin' => 16,
                    'tMax' => 22,
                    'predWindDir' => 'E',
                    'idWeatherType' => 2,
                    'classWindSpeed' => 1,
                    'longitude' => '-16.3400',
                    'globalIdLocal' => 2320100,
                    'latitude' => '33.0700',

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

        self::assertEquals(
            [
                [
                    'precipitaProb' => '1.0',
                    'tMin' => 11,
                    'tMax' => 18,
                    'predWindDir' => 'W',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'globalIdLocal' => 1020500,
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '0.0',
                    'tMin' => 12,
                    'tMax' => 20,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.9331',
                    'globalIdLocal' => 1080500,
                    'latitude' => '37.0146',
                ],
                [
                    'precipitaProb' => '0.0',
                    'tMin' => 12,
                    'tMax' => 21,
                    'predWindDir' => 'SE',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-8.9403',
                    'globalIdLocal' => 1081505,
                    'latitude' => '37.0168',
                ],
                [
                    'precipitaProb' => '27.0',
                    'tMin' => 14,
                    'tMax' => 19,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 2,
                    'longitude' => '-8.8643',
                    'globalIdLocal' => 1151300,
                    'latitude' => '37.9560',
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

        self::assertEquals(
            [
                [
                    'precipitaProb' => '1.0',
                    'tMin' => 11,
                    'tMax' => 18,
                    'predWindDir' => 'W',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'globalIdLocal' => 1020500,
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '100.0',
                    'tMin' => 9,
                    'tMax' => 15,
                    'predWindDir' => 'W',
                    'idWeatherType' => 9,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.7440',
                    'classPrecInt' => 2,
                    'globalIdLocal' => 1171400,
                    'latitude' => '41.3053',
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

        self::assertEquals(
            [
                [
                    'precipitaProb' => '65.0',
                    'tMin' => 10,
                    'tMax' => 17,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 9,
                    'classWindSpeed' => 3,
                    'longitude' => '-7.4957',
                    'classPrecInt' => 2,
                    'globalIdLocal' => 1050200,
                    'latitude' => '39.8217',
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

        self::assertEquals([
            [
                'precipitaProb' => '0.0',
                'tMin' => 12,
                'tMax' => 20,
                'predWindDir' => 'SW',
                'idWeatherType' => 3,
                'classWindSpeed' => 1,
                'longitude' => '-7.9331',
                'globalIdLocal' => 1080500,
                'latitude' => '37.0146',
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

        self::assertEquals(
            [
                [
                    'precipitaProb' => '65.0',
                    'tMin' => 10,
                    'tMax' => 17,
                    'predWindDir' => 'SW',
                    'idWeatherType' => 9,
                    'classWindSpeed' => 3,
                    'longitude' => '-7.4957',
                    'classPrecInt' => 2,
                    'globalIdLocal' => 1050200,
                    'latitude' => '39.8217',
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

        self::assertEquals([
            'precipitaProb' => '0.0',
            'tMin' => 12,
            'tMax' => 20,
            'predWindDir' => 'SW',
            'idWeatherType' => 3,
            'classWindSpeed' => 1,
            'longitude' => '-7.9331',
            'globalIdLocal' => 1080500,
            'latitude' => '37.0146',
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
