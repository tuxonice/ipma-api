<?php

namespace Tlab\Tests\Forecast\Meteorology;

use DateTime;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByLocal;

class DailyWeatherForecastByLocalTest extends TestCase
{
    public function testFilterByRainfallProbabilityRange(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertEquals(
            [
                [
                    'precipitaProb' => '88.0',
                    'tMin' => '10.6',
                    'tMax' => '15.7',
                    'predWindDir' => 'NW',
                    'idWeatherType' => 6,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-08',
                    'classPrecInt' => 2,
                    'latitude' => '38.0200',
                ]
            ],
            $dailyWeatherForecastByLocal->from(1020500)
                ->filterByRainfallProbabilityRange(85.0, 90.0)
                ->get()
        );
    }

    public function testFilterByMinTemperatureRange(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertEquals(
            [
                [
                    'precipitaProb' => '88.0',
                    'tMin' => '10.6',
                    'tMax' => '15.7',
                    'predWindDir' => 'NW',
                    'idWeatherType' => 6,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-08',
                    'classPrecInt' => 2,
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '4.0',
                    'tMin' => '10.2',
                    'tMax' => '18.2',
                    'predWindDir' => 'W',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-09',
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '7.0',
                    'tMin' => '10.8',
                    'tMax' => '18.3',
                    'predWindDir' => 'SE',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-10',
                    'latitude' => '38.0200',
                ],
            ],
            $dailyWeatherForecastByLocal->from(1020500)
                ->filterByMinTemperatureRange(10.0, 11.0)
                ->get()
        );
    }

    public function testFilterByMaxTemperatureRange(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertEquals(
            [
                [
                    'precipitaProb' => '4.0',
                    'tMin' => '10.2',
                    'tMax' => '18.2',
                    'predWindDir' => 'W',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-09',
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '7.0',
                    'tMin' => '10.8',
                    'tMax' => '18.3',
                    'predWindDir' => 'SE',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-10',
                    'latitude' => '38.0200',
                ],
            ],
            $dailyWeatherForecastByLocal->from(1020500)
                ->filterByMaxTemperatureRange(18.0, 19.0)
                ->get()
        );
    }

    public function testFilterByWindDirection(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertEquals(
            [
                [
                    'precipitaProb' => '4.0',
                    'tMin' => '10.2',
                    'tMax' => '18.2',
                    'predWindDir' => 'W',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-09',
                    'latitude' => '38.0200',
                ],
            ],
            $dailyWeatherForecastByLocal->from(1020500)
                ->filterByWindDirection('w')
                ->get()
        );
    }

    public function testFilterByWindSpeedClass()
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertEquals(
            [
                [
                    'precipitaProb' => '88.0',
                    'tMin' => '10.6',
                    'tMax' => '15.7',
                    'predWindDir' => 'NW',
                    'idWeatherType' => 6,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-08',
                    'classPrecInt' => 2,
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '17.0',
                    'tMin' => '12.8',
                    'tMax' => '19.8',
                    'predWindDir' => 'SW',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-12',
                    'latitude' => '38.0200',
                ],
            ],
            $dailyWeatherForecastByLocal->from(0)
                ->filterByWindSpeedClass(2)
                ->get()
        );
    }

    public function testFilterByIdWeatherType(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertEquals(
            [
                [
                    'precipitaProb' => '4.0',
                    'tMin' => '10.2',
                    'tMax' => '18.2',
                    'predWindDir' => 'W',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-09',
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '7.0',
                    'tMin' => '10.8',
                    'tMax' => '18.3',
                    'predWindDir' => 'SE',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 1,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-10',
                    'latitude' => '38.0200',
                ],
                [
                    'precipitaProb' => '17.0',
                    'tMin' => '12.8',
                    'tMax' => '19.8',
                    'predWindDir' => 'SW',
                    'idWeatherType' => 3,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-12',
                    'latitude' => '38.0200',
                ],
            ],
            $dailyWeatherForecastByLocal->from(1020500)
                ->filterByIdWeatherType(3)
                ->get()
        );
    }

    public function testFilterByRainIntensityClass(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertEquals(
            [
                [
                    'precipitaProb' => '88.0',
                    'tMin' => '10.6',
                    'tMax' => '15.7',
                    'predWindDir' => 'NW',
                    'idWeatherType' => 6,
                    'classWindSpeed' => 2,
                    'longitude' => '-7.8700',
                    'forecastDate' => '2023-12-08',
                    'classPrecInt' => 2,
                    'latitude' => '38.0200',
                ],
            ],
            $dailyWeatherForecastByLocal->from(1020500)
                ->filterByRainIntensityClass(2)
                ->get()
        );
    }

    public function testGetFileUpdatedAt(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertEquals(
            new DateTime('2023-12-08T15:31:04'),
            $dailyWeatherForecastByLocal->from(1020500)->getFileUpdatedAt()
        );
    }
}
