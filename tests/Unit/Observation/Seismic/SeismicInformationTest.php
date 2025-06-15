<?php

namespace Tlab\Tests\Observation\Seismic;

use DateTime;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;
use PHPUnit\Framework\TestCase;

class SeismicInformationTest extends TestCase
{
    public function testGetLastSismicActivityDate(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Seismic/7.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seismicInformation = new SeismicInformation($apiConnectorMock);

        self::assertEquals(
            new DateTime('2024-02-09T08:49:41'),
            $seismicInformation->from('7')
                ->getLastSismicActivityDate()
        );
    }

    public function testGetUpdateDate()
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Seismic/7.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seismicInformation = new SeismicInformation($apiConnectorMock);

        self::assertEquals(
            new DateTime('2024-02-09T10:36:02'),
            $seismicInformation->from('7')
                ->getUpdateDate()
        );
    }

    public function testFilterByDepth()
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Seismic/7.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seismicInformation = new SeismicInformation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-01-22T07:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'SW Cabo S.Vicente',
                    'lon' => '-9.8030',
                    'source' => 'IPMA',
                    'depth' => 26,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-15T10:00:51',
                    'lat' => '36.2990',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '1.2',
                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-01-30T12:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'SE Lagos',
                    'lon' => '-8.6020',
                    'source' => 'IPMA',
                    'depth' => 26,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-23T13:09:17',
                    'lat' => '36.9470',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '1.1',

                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-01-21T06:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'SW Cabo S.Vicente',
                    'lon' => '-9.5910',
                    'source' => 'IPMA',
                    'depth' => 27,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-14T11:01:34',
                    'lat' => '36.2000',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '2.4',
                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-02-06T06:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'NW Fez (Marr)',
                    'lon' => '-5.5820',
                    'source' => 'IPMA',
                    'depth' => 27,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-30T09:11:48',
                    'lat' => '34.5280',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '2.2',
                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-02-06T06:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'NW Fez (Marr)',
                    'lon' => '-5.4160',
                    'source' => 'IPMA',
                    'depth' => 27,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-30T09:40:27',
                    'lat' => '34.5870',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '2.3',
                ],
            ],
            $seismicInformation->from('7')
                ->filterByDepth(26, 27)
                ->get()
        );
    }

    public function testFilterByMagnitud(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Seismic/7.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seismicInformation = new SeismicInformation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'googlemapref' => 'http://maps.google.com/maps?output=classic&q=38.0990+-8.2530(M3.0%20-%20NW%20FERREIRA%20DO%20ALENTEJO-2024%20Jan%2017%20%2009:59:31%20UTC)&ll=38.0990,-8.2530&spn=2,2&f=d&t=h&hl=e',
                    'degree' => null,
                    'sismoId' => '20240117095931C',
                    'dataUpdate' => '2024-01-23T18:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'NW Ferreira do Alentejo',
                    'lon' => '-8.2530',
                    'source' => 'IPMA',
                    'depth' => 7,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '2024011709593101',
                    'time' => '2024-01-17T09:59:32',
                    'lat' => '38.0990',
                    'shakemapref' => 'http://shakemap.ipma.pt/2024011709593101/intensity.html',
                    'local' => null,
                    'magnitud' => '3.0',
                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-02-01T18:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'Morocco',
                    'lon' => '-8.3790',
                    'source' => 'IPMA',
                    'depth' => 15,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-25T21:22:37',
                    'lat' => '31.1860',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '3.0',
                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-02-09T06:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'NW Fez (Marr)',
                    'lon' => '-5.4650',
                    'source' => 'IPMA',
                    'depth' => 29,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-02-04T12:50:18',
                    'lat' => '34.6070',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '3.0',
                ],
                ['googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-02-09T06:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'NW Fez (Marr)',
                    'lon' => '-5.4900',
                    'source' => 'IPMA',
                    'depth' => 16,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-02-04T23:04:40',
                    'lat' => '34.5740',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '3.1',
                ],
            ],
            $seismicInformation->from('7')
                ->filterByMagnitud(3.0, 4.6)
                ->get()
        );
    }

    public function testFindLocationByNearDistance(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Seismic/7.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seismicInformation = new SeismicInformation($apiConnectorMock);

        self::assertEquals(
            [
                'googlemapref' => '',
                'degree' => null,
                'sismoId' => '',
                'dataUpdate' => '2024-02-08T12:00:00',
                'magType' => 'L',
                'obsRegion' => 'NW Tavira',
                'lon' => '-7.7030',
                'source' => 'IPMA',
                'depth' => 7,
                'tensorRef' => '',
                'sensed' => null,
                'shakemapid' => '0',
                'time' => '2024-02-01T15:10:35',
                'lat' => '37.1760',
                'shakemapref' => '',
                'local' => null,
                'magnitud' => '1.0',
            ],
            $seismicInformation->from('7')
                ->findLocationByNearDistance(37.101157, -7.831360)
        );
    }

    public function testFindLocationsByDistance(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Seismic/7.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seismicInformation = new SeismicInformation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-02-09T06:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'W  Loulé',
                    'lon' => '-8.0510',
                    'source' => 'IPMA',
                    'depth' => 20,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-02-09T02:10:53',
                    'lat' => '37.1350',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '0.9',
                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-02-08T12:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'NW Tavira',
                    'lon' => '-7.7030',
                    'source' => 'IPMA',
                    'depth' => 7,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-02-01T15:10:35',
                    'lat' => '37.1760',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '1.0',
                ],
            ],
            $seismicInformation->from('7')
                ->findLocationsByDistance(37.101157, -7.831360, 20)
                ->get()
        );
    }

    public function testFilterByTime(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Seismic/7.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seismicInformation = new SeismicInformation($apiConnectorMock);

        self::assertEquals(
            [
                ['googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-01-22T00:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'SW Evora',
                    'lon' => '-7.9560',
                    'source' => 'IPMA',
                    'depth' => 19,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-15T01:50:53',
                    'lat' => '38.5050',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '0.2',
                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-01-22T00:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'SW Miranda do Douro',
                    'lon' => '-6.4470',
                    'source' => 'IPMA',
                    'depth' => 5,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-15T05:15:01',
                    'lat' => '41.3610',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '0.9',
                ],
                [
                    'googlemapref' => '',
                    'degree' => null,
                    'sismoId' => '',
                    'dataUpdate' => '2024-01-22T00:00:00',
                    'magType' => 'L',
                    'obsRegion' => 'Madeira-Tore',
                    'lon' => '-16.0500',
                    'source' => 'IPMA',
                    'depth' => 268,
                    'tensorRef' => '',
                    'sensed' => null,
                    'shakemapid' => '0',
                    'time' => '2024-01-15T01:56:17',
                    'lat' => '35.5110',
                    'shakemapref' => '',
                    'local' => null,
                    'magnitud' => '2.2',
                ],
            ],
            $seismicInformation->from('7')
                ->filterByTime('2024-01-15T00:00:00', '2024-01-15T06:00:00')
                ->get()
        );
    }
}
