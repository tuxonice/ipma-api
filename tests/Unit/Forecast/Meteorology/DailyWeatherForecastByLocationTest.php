<?php

declare(strict_types=1);

namespace Tlab\Tests\Forecast\Meteorology;

use DateTime;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Forecast\Meteorology\DailyWeatherForecastByLocation;

class DailyWeatherForecastByLocationTest extends TestCase
{
    private array $dailyForecastFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/1020500.json');
        $this->dailyForecastFixture = json_decode($contents, true);
    }

    private function createService(): DailyWeatherForecastByLocation
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->dailyForecastFixture);

        return new DailyWeatherForecastByLocation($apiConnector);
    }

    public function testFilterByRainfallProbabilityRange(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

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
            array_map(fn ($d) => $d->toArray(), $dailyWeatherForecastByLocal->from(1020500)
                ->filterByRainfallProbabilityRange(85.0, 90.0)
                ->get())
        );
    }

    public function testFilterByMinTemperatureRange(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

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
            array_map(fn ($d) => $d->toArray(), $dailyWeatherForecastByLocal->from(1020500)
                ->filterByMinTemperatureRange(10.0, 11.0)
                ->get())
        );
    }

    public function testFilterByMaxTemperatureRange(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

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
            array_map(fn ($d) => $d->toArray(), $dailyWeatherForecastByLocal->from(1020500)
                ->filterByMaxTemperatureRange(18.0, 19.0)
                ->get())
        );
    }

    public function testFilterByWindDirection(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

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
            array_map(fn ($d) => $d->toArray(), $dailyWeatherForecastByLocal->from(1020500)
                ->filterByWindDirection('w')
                ->get())
        );
    }

    public function testFilterByWindSpeedClass(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

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
            array_map(fn ($d) => $d->toArray(), $dailyWeatherForecastByLocal->from(0)
                ->filterByWindSpeedClass(2)
                ->get())
        );
    }

    public function testFilterByIdWeatherType(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

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
            array_map(fn ($d) => $d->toArray(), $dailyWeatherForecastByLocal->from(1020500)
                ->filterByIdWeatherType(3)
                ->get())
        );
    }

    public function testFilterByRainIntensityClass(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

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
            array_map(fn ($d) => $d->toArray(), $dailyWeatherForecastByLocal->from(1020500)
                ->filterByRainIntensityClass(2)
                ->get())
        );
    }

    public function testFilterByForecastDate(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

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
            array_map(fn ($d) => $d->toArray(), $dailyWeatherForecastByLocal->from(1020500)
                ->filterByForecastDate('2023-12-12')
                ->get())
        );
    }

    public function testGetFileUpdatedAt(): void
    {
        $dailyWeatherForecastByLocal = $this->createService();

        self::assertEquals(
            new DateTime('2023-12-08T15:31:04'),
            $dailyWeatherForecastByLocal->from(1020500)->getFileUpdatedAt()
        );
    }
}
