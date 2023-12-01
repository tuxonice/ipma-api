<?php

namespace Tlab\Tests\Observation\Meteorology;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservation;
use PHPUnit\Framework\TestCase;

class WeatherStationObservationTest extends TestCase
{
    public function testFilterByWindSpeed(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservation = new WeatherStationObservation($apiConnector);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 11.9,
                'temperatura' => null,
                'radiacao' => null,
                'idDireccVento' => 3,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 3.3,
                'humidade' => null,
                'pressao' => 1028.0,
                'date' => '2023-12-10T13:00',
            ],
            [
                'intensidadeVentoKM' => 13.0,
                'temperatura' => null,
                'radiacao' => null,
                'idDireccVento' => 2,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 3.6,
                'humidade' => null,
                'pressao' => 1029.2,
                'date' => '2023-12-10T11:00',
            ],
            [
                'intensidadeVentoKM' => 12.6,
                'temperatura' => null,
                'radiacao' => null,
                'idDireccVento' => 3,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 3.5,
                'humidade' => null,
                'pressao' => 1028.8,
                'date' => '2023-12-10T12:00',
            ],
        ], $weatherStationObservation
            ->from(1210881)
            ->filterByWindSpeed(10.0, 15.0)
            ->get());
    }

    public function testFilterByTemperature(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservation = new WeatherStationObservation($apiConnector);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 8.6,
                'temperatura' => 17.5,
                'radiacao' => null,
                'idDireccVento' => 2,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 2.4,
                'humidade' => 78.0,
                'pressao' => 1029.7,
                'date' => '2023-12-10T11:00',
            ],
            [
                'intensidadeVentoKM' => 4.7,
                'temperatura' => 16.8,
                'radiacao' => null,
                'idDireccVento' => 8,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 1.3,
                'humidade' => 78.0,
                'pressao' => 1027.3,
                'date' => '2023-12-10T18:00',
            ],
        ], $weatherStationObservation
            ->from(1210883)
            ->filterByTemperature(16.5, 18.0)
            ->get());
    }

    public function testFilterBySolarRadiation(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservation = new WeatherStationObservation($apiConnector);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 36.7,
                'temperatura' => 14.8,
                'radiacao' => 707.7,
                'idDireccVento' => 7,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 10.2,
                'humidade' => 100.0,
                'pressao' => null,
                'date' => '2023-12-10T14:00',
            ],
            [
                'intensidadeVentoKM' => 36.7,
                'temperatura' => 14.5,
                'radiacao' => 719.8,
                'idDireccVento' => 7,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 10.2,
                'humidade' => 100.0,
                'pressao' => null,
                'date' => '2023-12-10T15:00',
            ],
            [
                'intensidadeVentoKM' => 37.8,
                'temperatura' => 14.4,
                'radiacao' => 623.0,
                'idDireccVento' => 7,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 10.5,
                'humidade' => 100.0,
                'pressao' => null,
                'date' => '2023-12-10T12:00',
            ],
            [
                'intensidadeVentoKM' => 33.1,
                'temperatura' => 14.5,
                'radiacao' => 718.6,
                'idDireccVento' => 7,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 9.2,
                'humidade' => 100.0,
                'pressao' => null,
                'date' => '2023-12-10T16:00',
            ],
        ], $weatherStationObservation
            ->from(11217372)
            ->filterBySolarRadiation(600, 900)
            ->get());
    }

    public function testFilterByWindDirection(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservation = new WeatherStationObservation($apiConnector);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 46.1,
                'temperatura' => 15.7,
                'idDireccVento' => 6,
                'precAcumulada' => 0.1,
                'intensidadeVento' => 12.8,
                'humidade' => 100.0,
                'pressao' => null,
                'radiacao' => 0.0,
                'date' => '2023-12-09T21:00',
            ],
            [
                'intensidadeVentoKM' => 40.3,
                'temperatura' => 14.3,
                'idDireccVento' => 6,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 11.2,
                'humidade' => 100.0,
                'pressao' => null,
                'radiacao' => 335.5,
                'date' => '2023-12-10T17:00',
            ],
            [
                'intensidadeVentoKM' => 38.5,
                'temperatura' => 15.4,
                'idDireccVento' => 6,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 10.7,
                'humidade' => 100.0,
                'pressao' => null,
                'radiacao' => 0.0,
                'date' => '2023-12-10T00:00',
            ],
        ], $weatherStationObservation
            ->from(11217372)
            ->filterByWindDirection(6)
            ->get());
    }

    public function testFilterByRain(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservation = new WeatherStationObservation($apiConnector);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 46.1,
                'temperatura' => 15.7,
                'idDireccVento' => 6,
                'precAcumulada' => 0.1,
                'intensidadeVento' => 12.8,
                'humidade' => 100.0,
                'pressao' => null,
                'radiacao' => 0.0,
                'date' => '2023-12-09T21:00',
            ],
            [
                'intensidadeVentoKM' => 18.7,
                'temperatura' => 13.7,
                'idDireccVento' => 7,
                'precAcumulada' => 0.2,
                'intensidadeVento' => 5.2,
                'humidade' => 100.0,
                'pressao' => null,
                'radiacao' => 0.0,
                'date' => '2023-12-10T20:00',
            ],
            [
                'intensidadeVentoKM' => 46.8,
                'temperatura' => 15.3,
                'idDireccVento' => 7,
                'precAcumulada' => 0.1,
                'intensidadeVento' => 13.0,
                'humidade' => 100.0,
                'pressao' => null,
                'radiacao' => 0.0,
                'date' => '2023-12-10T02:00',
            ],
        ], $weatherStationObservation
            ->from(11217372)
            ->filterByRain(0.1, 0.6)
            ->get());
    }

    public function testFilterByWindSpeedMetersSecond(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservation = new WeatherStationObservation($apiConnector);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 9.4,
                'temperatura' => 16.5,
                'idDireccVento' => 5,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 2.6,
                'humidade' => 100.0,
                'pressao' => 1024.5,
                'radiacao' => 0.0,
                'date' => '2023-12-10T05:00',
            ],
            [
                'intensidadeVentoKM' => 9.7,
                'temperatura' => 16.1,
                'idDireccVento' => 5,
                'precAcumulada' => 0.5,
                'intensidadeVento' => 2.7,
                'humidade' => 100.0,
                'pressao' => 1025.0,
                'radiacao' => 2.1,
                'date' => '2023-12-10T08:00',
            ],
        ], $weatherStationObservation
            ->from(1240546)
            ->filterByWindSpeedMetersSecond(1.0, 2.7)
            ->get());
    }

    public function testFilterByHumidity(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservation = new WeatherStationObservation($apiConnector);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 6.1,
                'temperatura' => 13.6,
                'idDireccVento' => 5,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 1.7,
                'humidade' => 95.0,
                'pressao' => 1025.0,
                'radiacao' => 0.0,
                'date' => '2023-12-10T19:00',
            ],
            [
                'intensidadeVentoKM' => 3.2,
                'temperatura' => 13.5,
                'idDireccVento' => 4,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 0.9,
                'humidade' => 91.0,
                'pressao' => 1025.1,
                'radiacao' => 0.0,
                'date' => '2023-12-10T20:00',
            ],
        ], $weatherStationObservation
            ->from(1200567)
            ->filterByHumidity(90, 95)
            ->get());
    }

    public function testFilterByAtmosphericPressure(): void
    {
        $apiConnector = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/observations.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservation = new WeatherStationObservation($apiConnector);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 7.2,
                'temperatura' => 15.0,
                'idDireccVento' => 5,
                'precAcumulada' => 0.1,
                'intensidadeVento' => 2.0,
                'humidade' => 100.0,
                'pressao' => 1023.9,
                'radiacao' => 858.9,
                'date' => '2023-12-10T14:00',
            ],
            [
                'intensidadeVentoKM' => 5.8,
                'temperatura' => 15.3,
                'idDireccVento' => 5,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 1.6,
                'humidade' => 100.0,
                'pressao' => 1023.7,
                'radiacao' => 758.0,
                'date' => '2023-12-10T15:00',
            ],
            [
                'intensidadeVentoKM' => 7.2,
                'temperatura' => 15.4,
                'idDireccVento' => 6,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 2.0,
                'humidade' => 97.0,
                'pressao' => 1023.8,
                'radiacao' => 629.9,
                'date' => '2023-12-10T16:00',
            ],
        ], $weatherStationObservation
            ->from(1200567)
            ->filterByAtmosphericPressure(900, 1024)
            ->get());
    }
}
