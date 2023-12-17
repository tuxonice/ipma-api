<?php

namespace Tlab\Tests\Observation\Meteorology;

use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Observation\Meteorology\WeatherStationObservationByHour;
use PHPUnit\Framework\TestCase;

class WeatherStationObservationByHourTest extends TestCase
{
    public function testFilterByWindDirection()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        self::assertEquals([
            'intensidadeVentoKM' => 11.5,
            'temperatura' => 15.4,
            'idDireccVento' => 9,
            'precAcumulada' => 0.1,
            'intensidadeVento' => 3.2,
            'humidade' => 96.0,
            'pressao' => 1022.5,
            'radiacao' => 185.6,
            'latitude' => 39.4582,
            'longitude' => -31.1301,
            'time' => '2023-12-17T13:00:00',
            'idEstacao' => 1200501,
            'localEstacao' => 'Flores (Aeroporto)',
            'descDirVento' => 'N',
        ], $weatherStationObservationByHour
            ->filterByWindDirection(9)
            ->get()[0]);
    }

    public function testFilterByAtmosphericPressure()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 4.7,
                'temperatura' => 16.3,
                'idDireccVento' => 6,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 1.3,
                'humidade' => 91.0,
                'pressao' => 1020.9,
                'radiacao' => null,
                'latitude' => 39.6739,
                'longitude' => -31.1136,
                'time' => '2023-12-17T15:00:00',
                'idEstacao' => 1200502,
                'localEstacao' => 'Corvo (Aeródromo)',
                'descDirVento' => 'SW',
            ],
        ], $weatherStationObservationByHour
            ->filterByAtmosphericPressure(1000.0, 1021.0)
            ->get());
    }

    public function testFilterByWindSpeed()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        self::assertEquals([
            [
                'intensidadeVentoKM' => 50.0,
                'temperatura' => 16.5,
                'idDireccVento' => 6,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 13.9,
                'humidade' => 100.0,
                'pressao' => null,
                'radiacao' => 329.1,
                'latitude' => 38.7002,
                'longitude' => -27.1031,
                'time' => '2023-12-17T14:00:00',
                'idEstacao' => 11217372,
                'localEstacao' => 'Terceira / Serra do Cume (DRAAC)',
                'descDirVento' => 'SW',

            ],
        ], $weatherStationObservationByHour
            ->filterByWindSpeed(50.0, 55.0)
            ->get());
    }

    public function testFilterByTemperature()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        $result = $weatherStationObservationByHour->filterByTemperature(16.5, 16.5)->get();

        self::assertEquals([
            [
                'intensidadeVentoKM' => 6.8,
                'temperatura' => 16.5,
                'idDireccVento' => 8,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 1.9,
                'humidade' => 42.0,
                'pressao' => null,
                'radiacao' => 2016.4,
                'latitude' => 37.5471,
                'longitude' => -8.729,
                'time' => '2023-12-17T13:00:00',
                'idEstacao' => 1210577,
                'localEstacao' => 'Odemira, S. Teotónio',
                'descDirVento' => 'NW',
            ],
            [
                'intensidadeVentoKM' => 7.6,
                'temperatura' => 16.5,
                'idDireccVento' => 8,
                'precAcumulada' => 0.0,
                'intensidadeVento' => 2.1,
                'humidade' => 53.0,
                'pressao' => 1035.3,
                'radiacao' => 1804.9,
                'latitude' => 39.1259,
                'longitude' => -9.379,
                'time' => '2023-12-17T14:00:00',
                'idEstacao' => 1210746,
                'localEstacao' => 'Santa Cruz (Aeródromo)',
                'descDirVento' => 'NW',
            ],
        ], array_slice($result, 0, 2));
    }

    public function testFilterByRain()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        $result = $weatherStationObservationByHour->filterByRain(1.4, 1.5)->get();

        self::assertEquals([
            [
                'intensidadeVentoKM' => 42.5,
                'temperatura' => 14.9,
                'idDireccVento' => 5,
                'precAcumulada' => 1.4,
                'intensidadeVento' => 11.8,
                'humidade' => 100.0,
                'pressao' => null,
                'radiacao' => 148.3,
                'latitude' => 38.6435,
                'longitude' => -28.0591,
                'time' => '2023-12-17T13:00:00',
                'idEstacao' => 11217510,
                'localEstacao' => 'São Jorge / Pico do Areeiro (DRAAC)',
                'descDirVento' => 'S',
            ],
        ], $result);
    }

    public function testFilterByIdStation()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        $result = $weatherStationObservationByHour->filterByIdStation(1210803)->get();

        self::assertEquals([
            [
                'time' => '2023-12-17T13:00:00',
                'idEstacao' => 1210803,
                'localEstacao' => 'Zebreira',
                'intensidadeVentoKM' => 11.2,
                'temperatura' => 11.7,
                'idDireccVento' => 3,
                'descDirVento' => 'E',
                'precAcumulada' => 0.0,
                'intensidadeVento' => 3.1,
                'humidade' => 65.0,
                'pressao' => null,
                'radiacao' => 1830.1,
                'latitude' => 39.8667,
                'longitude' => -7.0167,
            ],
            [
                'time' => '2023-12-17T14:00:00',
                'idEstacao' => 1210803,
                'localEstacao' => 'Zebreira',
                'intensidadeVentoKM' => 8.3,
                'temperatura' => 12.0,
                'idDireccVento' => 3,
                'descDirVento' => 'E',
                'precAcumulada' => 0.0,
                'intensidadeVento' => 2.3,
                'humidade' => 63.0,
                'pressao' => null,
                'radiacao' => 1687.1,
                'latitude' => 39.8667,
                'longitude' => -7.0167,

            ],
            [
                'time' => '2023-12-17T15:00:00',
                'idEstacao' => 1210803,
                'localEstacao' => 'Zebreira',
                'intensidadeVentoKM' => 8.6,
                'temperatura' => 12.3,
                'idDireccVento' => 2,
                'descDirVento' => 'NE',
                'precAcumulada' => 0.0,
                'intensidadeVento' => 2.4,
                'humidade' => 63.0,
                'pressao' => null,
                'radiacao' => 1319.8,
                'latitude' => 39.8667,
                'longitude' => -7.0167,
            ],
        ], $result);
    }

    public function testFilterByWindSpeedMetersSecond()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        self::assertEquals([
            [
                'time' => '2023-12-17T13:00:00',
                'idEstacao' => 11217255,
                'localEstacao' => 'São Miguel / Lagoa das Furnas (DRAAC)',
                'intensidadeVentoKM' => 14.8,
                'temperatura' => 17.1,
                'idDireccVento' => 5,
                'descDirVento' => 'S',
                'precAcumulada' => 0.0,
                'intensidadeVento' => 4.1,
                'humidade' => 92.0,
                'pressao' => null,
                'radiacao' => 608.4,
                'latitude' => 37.7619,
                'longitude' => -25.3291,
            ],
            [
                'time' => '2023-12-17T14:00:00',
                'idEstacao' => 1210773,
                'localEstacao' => 'Almada, P.Rainha',
                'intensidadeVentoKM' => 14.8,
                'temperatura' => 14.7,
                'idDireccVento' => 2,
                'descDirVento' => 'NE',
                'precAcumulada' => 0.0,
                'intensidadeVento' => 4.1,
                'humidade' => 61.0,
                'pressao' => null,
                'radiacao' => 1771.3,
                'latitude' => 38.6171,
                'longitude' => -9.2128,
            ],
            [
                'time' => '2023-12-17T15:00:00',
                'idEstacao' => 1200522,
                'localEstacao' => 'Funchal',
                'intensidadeVentoKM' => 14.4,
                'temperatura' => null,
                'idDireccVento' => 3,
                'descDirVento' => 'E',
                'precAcumulada' => null,
                'intensidadeVento' => 4.0,
                'humidade' => null,
                'pressao' => null,
                'radiacao' => null,
                'latitude' => 32.6479,
                'longitude' => -16.888,
            ],
            [
                'time' => '2023-12-17T15:00:00',
                'idEstacao' => 1200524,
                'localEstacao' => 'Porto Santo (Aeroporto)',
                'intensidadeVentoKM' => 14.4,
                'temperatura' => null,
                'idDireccVento' => 3,
                'descDirVento' => 'E',
                'precAcumulada' => null,
                'intensidadeVento' => 4.0,
                'humidade' => null,
                'pressao' => null,
                'radiacao' => null,
                'latitude' => 33.074,
                'longitude' => -16.3487,
            ],
            [
                'time' => '2023-12-17T15:00:00',
                'idEstacao' => 6213014,
                'localEstacao' => 'Mangualde / Chãs de Tavares  (CIM)',
                'intensidadeVentoKM' => 14.4,
                'temperatura' => 7.2,
                'idDireccVento' => 3,
                'descDirVento' => 'E',
                'precAcumulada' => 0.0,
                'intensidadeVento' => 4.0,
                'humidade' => 71.0,
                'pressao' => null,
                'radiacao' => null,
                'latitude' => 40.611,
                'longitude' => -7.6084,
            ],
        ], $weatherStationObservationByHour->filterByWindSpeedMetersSecond(4.0, 4.1)->get());
    }

    public function testFilterBySolarRadiation()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        self::assertEquals([
            [
                'time' => '2023-12-17T13:00:00',
                'idEstacao' => 1200515,
                'localEstacao' => 'Santa Maria (Aeroporto)',
                'intensidadeVentoKM' => 22.0,
                'temperatura' => 19.7,
                'idDireccVento' => 5,
                'descDirVento' => 'S',
                'precAcumulada' => 0.0,
                'intensidadeVento' => 6.1,
                'humidade' => 86.0,
                'pressao' => 1028.2,
                'radiacao' => 991.0,
                'latitude' => 36.9672,
                'longitude' => -25.1679,
            ],
            [
                'time' => '2023-12-17T13:00:00',
                'idEstacao' => 1210956,
                'localEstacao' => 'Madeira, Porto Moniz',
                'intensidadeVentoKM' => null,
                'temperatura' => 23.4,
                'idDireccVento' => null,
                'descDirVento' => '---',
                'precAcumulada' => 0.0,
                'intensidadeVento' => null,
                'humidade' => 54.0,
                'pressao' => null,
                'radiacao' => 954.5,
                'latitude' => 32.8675,
                'longitude' => -17.1714,
            ],
            [
                'time' => '2023-12-17T14:00:00',
                'idEstacao' => 1210956,
                'localEstacao' => 'Madeira, Porto Moniz',
                'intensidadeVentoKM' => null,
                'temperatura' => 23.8,
                'idDireccVento' => null,
                'descDirVento' => '---',
                'precAcumulada' => 0.0,
                'intensidadeVento' => null,
                'humidade' => 54.0,
                'pressao' => null,
                'radiacao' => 966.0,
                'latitude' => 32.8675,
                'longitude' => -17.1714,
            ],
        ], $weatherStationObservationByHour->filterBySolarRadiation(900.0, 1000.0)->get());
    }

    public function testFilterByHumidity()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Meteorology/obs-surface.geojson');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $weatherStationObservationByHour = new WeatherStationObservationByHour($apiConnectorMock);

        self::assertEquals([
            [
                'time' => '2023-12-17T13:00:00',
                'idEstacao' => 6213013,
                'localEstacao' => 'Castro Daire / Mézio (CIM)',
                'intensidadeVentoKM' => 6.8,
                'temperatura' => 17.1,
                'idDireccVento' => 6,
                'descDirVento' => 'SW',
                'precAcumulada' => null,
                'intensidadeVento' => 1.9,
                'humidade' => 21.0,
                'pressao' => null,
                'radiacao' => null,
                'latitude' => 40.9809,
                'longitude' => -7.8832,
            ],
            [
                'time' => '2023-12-17T14:00:00',
                'idEstacao' => 6213013,
                'localEstacao' => 'Castro Daire / Mézio (CIM)',
                'intensidadeVentoKM' => 10.1,
                'temperatura' => 16.8,
                'idDireccVento' => 8,
                'descDirVento' => 'NW',
                'precAcumulada' => null,
                'intensidadeVento' => 2.8,
                'humidade' => 28.0,
                'pressao' => null,
                'radiacao' => null,
                'latitude' => 40.9809,
                'longitude' => -7.8832,
            ],
            [
                'time' => '2023-12-17T15:00:00',
                'idEstacao' => 6213013,
                'localEstacao' => 'Castro Daire / Mézio (CIM)',
                'intensidadeVentoKM' => null,
                'temperatura' => 15.6,
                'idDireccVento' => null,
                'descDirVento' => '---',
                'precAcumulada' => null,
                'intensidadeVento' => null,
                'humidade' => 30.0,
                'pressao' => null,
                'radiacao' => null,
                'latitude' => 40.9809,
                'longitude' => -7.8832,
            ],
        ], $weatherStationObservationByHour->filterByHumidity(20, 30)->get());
    }
}
