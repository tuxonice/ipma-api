<?php

namespace Tlab\Tests\Observation\Meteorology;

use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservation;
use PHPUnit\Framework\TestCase;

class WeatherStationObservationTest extends TestCase
{
    private array $weatherStationObservationFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $this->weatherStationObservationFixture = json_decode($contents, true);
    }

    private function createService(): WeatherStationObservation
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->weatherStationObservationFixture);

        return new WeatherStationObservation($apiConnector);
    }

    public function testFilterByDate(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 9.7,
                'temperature' => null,
                'solarRadiation' => null,
                'idWindDirection' => 3,
                'accumulatedRain' => 0.0,
                'windIntensity' => 2.7,
                'humidity' => null,
                'atmosphericPressure' => 1027.2,
                'date' => '2023-12-10T14:00',
            ],
            [
                'windSpeed' => 11.9,
                'temperature' => null,
                'solarRadiation' => null,
                'idWindDirection' => 3,
                'accumulatedRain' => 0.0,
                'windIntensity' => 3.3,
                'humidity' => null,
                'atmosphericPressure' => 1028.0,
                'date' => '2023-12-10T13:00',
            ],
            [
                'windSpeed' => 12.6,
                'temperature' => null,
                'solarRadiation' => null,
                'idWindDirection' => 3,
                'accumulatedRain' => 0.0,
                'windIntensity' => 3.5,
                'humidity' => null,
                'atmosphericPressure' => 1028.8,
                'date' => '2023-12-10T12:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(1210881)
            ->filterByDate('2023-12-10T12:00', '2023-12-10T14:00')
            ->get()));
    }

    public function testFilterByWindSpeed(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 11.9,
                'temperature' => null,
                'solarRadiation' => null,
                'idWindDirection' => 3,
                'accumulatedRain' => 0.0,
                'windIntensity' => 3.3,
                'humidity' => null,
                'atmosphericPressure' => 1028.0,
                'date' => '2023-12-10T13:00',
            ],
            [
                'windSpeed' => 13.0,
                'temperature' => null,
                'solarRadiation' => null,
                'idWindDirection' => 2,
                'accumulatedRain' => 0.0,
                'windIntensity' => 3.6,
                'humidity' => null,
                'atmosphericPressure' => 1029.2,
                'date' => '2023-12-10T11:00',
            ],
            [
                'windSpeed' => 12.6,
                'temperature' => null,
                'solarRadiation' => null,
                'idWindDirection' => 3,
                'accumulatedRain' => 0.0,
                'windIntensity' => 3.5,
                'humidity' => null,
                'atmosphericPressure' => 1028.8,
                'date' => '2023-12-10T12:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(1210881)
            ->filterByWindSpeed(10.0, 15.0)
            ->get()));
    }

    public function testFilterByTemperature(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 8.6,
                'temperature' => 17.5,
                'solarRadiation' => null,
                'idWindDirection' => 2,
                'accumulatedRain' => 0.0,
                'windIntensity' => 2.4,
                'humidity' => 78.0,
                'atmosphericPressure' => 1029.7,
                'date' => '2023-12-10T11:00',
            ],
            [
                'windSpeed' => 4.7,
                'temperature' => 16.8,
                'solarRadiation' => null,
                'idWindDirection' => 8,
                'accumulatedRain' => 0.0,
                'windIntensity' => 1.3,
                'humidity' => 78.0,
                'atmosphericPressure' => 1027.3,
                'date' => '2023-12-10T18:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(1210883)
            ->filterByTemperature(16.5, 18.0)
            ->get()));
    }

    public function testFilterBySolarRadiation(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 36.7,
                'temperature' => 14.8,
                'solarRadiation' => 707.7,
                'idWindDirection' => 7,
                'accumulatedRain' => 0.0,
                'windIntensity' => 10.2,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-10T14:00',
            ],
            [
                'windSpeed' => 36.7,
                'temperature' => 14.5,
                'solarRadiation' => 719.8,
                'idWindDirection' => 7,
                'accumulatedRain' => 0.0,
                'windIntensity' => 10.2,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-10T15:00',
            ],
            [
                'windSpeed' => 37.8,
                'temperature' => 14.4,
                'solarRadiation' => 623.0,
                'idWindDirection' => 7,
                'accumulatedRain' => 0.0,
                'windIntensity' => 10.5,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-10T12:00',
            ],
            [
                'windSpeed' => 33.1,
                'temperature' => 14.5,
                'solarRadiation' => 718.6,
                'idWindDirection' => 7,
                'accumulatedRain' => 0.0,
                'windIntensity' => 9.2,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-10T16:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(11217372)
            ->filterBySolarRadiation(600, 900)
            ->get()));
    }

    public function testFilterByWindDirection(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 46.1,
                'temperature' => 15.7,
                'solarRadiation' => 0.0,
                'idWindDirection' => 6,
                'accumulatedRain' => 0.1,
                'windIntensity' => 12.8,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-09T21:00',
            ],
            [
                'windSpeed' => 40.3,
                'temperature' => 14.3,
                'solarRadiation' => 335.5,
                'idWindDirection' => 6,
                'accumulatedRain' => 0.0,
                'windIntensity' => 11.2,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-10T17:00',
            ],
            [
                'windSpeed' => 38.5,
                'temperature' => 15.4,
                'solarRadiation' => 0.0,
                'idWindDirection' => 6,
                'accumulatedRain' => 0.0,
                'windIntensity' => 10.7,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-10T00:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(11217372)
            ->filterByWindDirection(6)
            ->get()));
    }

    public function testFilterByRain(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 46.1,
                'temperature' => 15.7,
                'solarRadiation' => 0.0,
                'idWindDirection' => 6,
                'accumulatedRain' => 0.1,
                'windIntensity' => 12.8,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-09T21:00',
            ],
            [
                'windSpeed' => 18.7,
                'temperature' => 13.7,
                'solarRadiation' => 0.0,
                'idWindDirection' => 7,
                'accumulatedRain' => 0.2,
                'windIntensity' => 5.2,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-10T20:00',
            ],
            [
                'windSpeed' => 46.8,
                'temperature' => 15.3,
                'solarRadiation' => 0.0,
                'idWindDirection' => 7,
                'accumulatedRain' => 0.1,
                'windIntensity' => 13.0,
                'humidity' => 100.0,
                'atmosphericPressure' => null,
                'date' => '2023-12-10T02:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(11217372)
            ->filterByRain(0.1, 0.6)
            ->get()));
    }

    public function testFilterByWindSpeedMetersSecond(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 9.4,
                'temperature' => 16.5,
                'solarRadiation' => 0.0,
                'idWindDirection' => 5,
                'accumulatedRain' => 0.0,
                'windIntensity' => 2.6,
                'humidity' => 100.0,
                'atmosphericPressure' => 1024.5,
                'date' => '2023-12-10T05:00',
            ],
            [
                'windSpeed' => 9.7,
                'temperature' => 16.1,
                'solarRadiation' => 2.1,
                'idWindDirection' => 5,
                'accumulatedRain' => 0.5,
                'windIntensity' => 2.7,
                'humidity' => 100.0,
                'atmosphericPressure' => 1025.0,
                'date' => '2023-12-10T08:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(1240546)
            ->filterByWindSpeedMetersSecond(1.0, 2.7)
            ->get()));
    }

    public function testFilterByHumidity(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 6.1,
                'temperature' => 13.6,
                'solarRadiation' => 0.0,
                'idWindDirection' => 5,
                'accumulatedRain' => 0.0,
                'windIntensity' => 1.7,
                'humidity' => 95.0,
                'atmosphericPressure' => 1025.0,
                'date' => '2023-12-10T19:00',
            ],
            [
                'windSpeed' => 3.2,
                'temperature' => 13.5,
                'solarRadiation' => 0.0,
                'idWindDirection' => 4,
                'accumulatedRain' => 0.0,
                'windIntensity' => 0.9,
                'humidity' => 91.0,
                'atmosphericPressure' => 1025.1,
                'date' => '2023-12-10T20:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(1200567)
            ->filterByHumidity(90, 95)
            ->get()));
    }

    public function testFilterByAtmosphericPressure(): void
    {
        $weatherStationObservation = $this->createService();

        self::assertSame([
            [
                'windSpeed' => 7.2,
                'temperature' => 15.0,
                'solarRadiation' => 858.9,
                'idWindDirection' => 5,
                'accumulatedRain' => 0.1,
                'windIntensity' => 2.0,
                'humidity' => 100.0,
                'atmosphericPressure' => 1023.9,
                'date' => '2023-12-10T14:00',
            ],
            [
                'windSpeed' => 5.8,
                'temperature' => 15.3,
                'solarRadiation' => 758.0,
                'idWindDirection' => 5,
                'accumulatedRain' => 0.0,
                'windIntensity' => 1.6,
                'humidity' => 100.0,
                'atmosphericPressure' => 1023.7,
                'date' => '2023-12-10T15:00',
            ],
            [
                'windSpeed' => 7.2,
                'temperature' => 15.4,
                'solarRadiation' => 629.9,
                'idWindDirection' => 6,
                'accumulatedRain' => 0.0,
                'windIntensity' => 2.0,
                'humidity' => 97.0,
                'atmosphericPressure' => 1023.8,
                'date' => '2023-12-10T16:00',
            ],
        ], array_map(fn ($d) => $d->toArray(), $weatherStationObservation
            ->from(1200567)
            ->filterByAtmosphericPressure(900, 1024)
            ->get()));
    }
}
