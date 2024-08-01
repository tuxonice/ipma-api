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

        self::assertSame(
            [
                [
                    'forecastDate' => '2023-12-08',
                    'idWeatherType' => 6,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 88.0,
                    'minTemp' => 10.6,
                    'maxTemp' => 15.7,
                    'winDir' => 'NW',
                    'latitude' => 38.0200,
                    'longitude' => -7.8700,
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

        self::assertSame(
            [
                [
                    'forecastDate' => '2023-12-08',
                    'idWeatherType' => 6,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 88.0,
                    'minTemp' => 10.6,
                    'maxTemp' => 15.7,
                    'winDir' => 'NW',
                    'latitude' => 38.0200,
                    'longitude' => -7.8700,
                ],
                [
                    'forecastDate' => '2023-12-09',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 4.0,
                    'minTemp' => 10.2,
                    'maxTemp' => 18.2,
                    'winDir' => 'W',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
                ],
                [
                    'forecastDate' => '2023-12-10',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 7.0,
                    'minTemp' => 10.8,
                    'maxTemp' => 18.3,
                    'winDir' => 'SE',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
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

        self::assertSame(
            [
                [
                    'forecastDate' => '2023-12-09',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 4.0,
                    'minTemp' => 10.2,
                    'maxTemp' => 18.2,
                    'winDir' => 'W',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
                ],
                [
                    'forecastDate' => '2023-12-10',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 7.0,
                    'minTemp' => 10.8,
                    'maxTemp' => 18.3,
                    'winDir' => 'SE',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
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

        self::assertSame(
            [
                [
                    'forecastDate' => '2023-12-09',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 4.0,
                    'minTemp' => 10.2,
                    'maxTemp' => 18.2,
                    'winDir' => 'W',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
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

        self::assertSame(
            [
                [
                    'forecastDate' => '2023-12-08',
                    'idWeatherType' => 6,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 88.0,
                    'minTemp' => 10.6,
                    'maxTemp' => 15.7,
                    'winDir' => 'NW',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
                ],
                [
                    'forecastDate' => '2023-12-12',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 17.0,
                    'minTemp' => 12.8,
                    'maxTemp' => 19.8,
                    'winDir' => 'SW',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
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

        self::assertSame(
            [
                [
                    'forecastDate' => '2023-12-09',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 4.0,
                    'minTemp' => 10.2,
                    'maxTemp' => 18.2,
                    'winDir' => 'W',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
                ],
                [
                    'forecastDate' => '2023-12-10',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 7.0,
                    'minTemp' => 10.8,
                    'maxTemp' => 18.3,
                    'winDir' => 'SE',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
                ],
                [
                    'forecastDate' => '2023-12-12',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 17.0,
                    'minTemp' => 12.8,
                    'maxTemp' => 19.8,
                    'winDir' => 'SW',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
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

        self::assertSame(
            [
                [
                    'forecastDate' => '2023-12-08',
                    'idWeatherType' => 6,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => 2,
                    'rainfallProb' => 88.0,
                    'minTemp' => 10.6,
                    'maxTemp' => 15.7,
                    'winDir' => 'NW',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
                ],
            ],
            $dailyWeatherForecastByLocal->from(1020500)
                ->filterByRainIntensityClass(2)
                ->get()
        );
    }

    public function testFilterByForecastDate(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $dailyWeatherForecastByLocal = new DailyWeatherForecastByLocal($apiConnector);

        self::assertSame(
            [
                [
                    'forecastDate' => '2023-12-12',
                    'idWeatherType' => 3,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 17.0,
                    'minTemp' => 12.8,
                    'maxTemp' => 19.8,
                    'winDir' => 'SW',
                    'latitude' => 38.02,
                    'longitude' => -7.87,
                ],
            ],
            $dailyWeatherForecastByLocal->from(1020500)
                ->filterByForecastDate('2023-12-12')
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
