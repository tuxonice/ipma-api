<?php

namespace Tlab\Tests\Observation\Seismic;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Enums\SeismicInformationAreaEnum;
use Tlab\IpmaApi\Observation\Seismic\SeismicInformation;
use PHPUnit\Framework\TestCase;

class SeismicInformationTest extends TestCase
{
    private array $seismicInformationFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Seismic/7.json');
        $this->seismicInformationFixture = json_decode($contents, true);
    }

    private function createService(): SeismicInformation
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->seismicInformationFixture);

        return new SeismicInformation($apiConnector);
    }

    public function testGetLastSeismicActivityDate(): void
    {
        $seismicInformation = $this->createService();

        self::assertEquals(
            new DateTime('2024-02-09T08:49:41'),
            $seismicInformation->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                ->getLastSeismicActivityDate()
        );
    }

    public function testGetUpdateDate()
    {
        $seismicInformation = $this->createService();

        self::assertEquals(
            new DateTime('2024-02-09T10:36:02'),
            $seismicInformation->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                ->getUpdateDate()
        );
    }

    public function testFilterByDepth()
    {
        $seismicInformation = $this->createService();

        self::assertSame(
            [
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 1.2,
                    'depth' => 26,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'SW Cabo S.Vicente',
                    'latitude' => 36.2990,
                    'longitude' => -9.8030,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-15T10:00:51',
                    'updateDate' => '2024-01-22T07:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 1.1,
                    'depth' => 26,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'SE Lagos',
                    'latitude' => 36.9470,
                    'longitude' => -8.602,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-23T13:09:17',
                    'updateDate' => '2024-01-30T12:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 2.4,
                    'depth' => 27,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'SW Cabo S.Vicente',
                    'latitude' => 36.2000,
                    'longitude' => -9.5910,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-14T11:01:34',
                    'updateDate' => '2024-01-21T06:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 2.2,
                    'depth' => 27,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'NW Fez (Marr)',
                    'latitude' => 34.5280,
                    'longitude' => -5.5820,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-30T09:11:48',
                    'updateDate' => '2024-02-06T06:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 2.3,
                    'depth' => 27,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'NW Fez (Marr)',
                    'latitude' => 34.5870,
                    'longitude' => -5.4160,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-30T09:40:27',
                    'updateDate' => '2024-02-06T06:00:00',
                ],
            ],
            array_map(fn ($d) => $d->toArray(), $seismicInformation->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                ->filterByDepth(26, 27)
                ->get())
        );
    }

    public function testFilterByMagnitude(): void
    {
        $seismicInformation = $this->createService();

        self::assertSame(
            [
                [
                    'seismId' => '20240117095931C',
                    'googleMapRef' => 'http://maps.google.com/maps?output=classic&q=38.0990+-8.2530(M3.0%20-%20NW%20FERREIRA%20DO%20ALENTEJO-2024%20Jan%2017%20%2009:59:31%20UTC)&ll=38.0990,-8.2530&spn=2,2&f=d&t=h&hl=e',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 3.0,
                    'depth' => 7,
                    'tensorRef' => '',
                    'shakeMapId' => '2024011709593101',
                    'shakeMapRef' => 'http://shakemap.ipma.pt/2024011709593101/intensity.html',
                    'location' => null,
                    'regionName' => 'NW Ferreira do Alentejo',
                    'latitude' => 38.0990,
                    'longitude' => -8.2530,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-17T09:59:32',
                    'updateDate' => '2024-01-23T18:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 3.0,
                    'depth' => 15,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'Morocco',
                    'latitude' => 31.1860,
                    'longitude' => -8.3790,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-25T21:22:37',
                    'updateDate' => '2024-02-01T18:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 3.0,
                    'depth' => 29,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'NW Fez (Marr)',
                    'latitude' => 34.6070,
                    'longitude' => -5.4650,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-02-04T12:50:18',
                    'updateDate' => '2024-02-09T06:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 3.1,
                    'depth' => 16,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'NW Fez (Marr)',
                    'latitude' => 34.5740,
                    'longitude' => -5.4900,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-02-04T23:04:40',
                    'updateDate' => '2024-02-09T06:00:00',
                ],
            ],
            array_map(fn ($d) => $d->toArray(), $seismicInformation->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                ->filterByMagnitude(3.0, 4.6)
                ->get())
        );
    }

    public function testFindLocationByNearDistance(): void
    {
        $seismicInformation = $this->createService();

        self::assertSame(
            [
                'seismId' => '',
                'googleMapRef' => '',
                'degree' => null,
                'magType' => 'L',
                'magnitude' => 1.0,
                'depth' => 7,
                'tensorRef' => '',
                'shakeMapId' => '0',
                'shakeMapRef' => '',
                'location' => null,
                'regionName' => 'NW Tavira',
                'latitude' => 37.1760,
                'longitude' => -7.7030,
                'source' => 'IPMA',
                'sensed' => null,
                'time' => '2024-02-01T15:10:35',
                'updateDate' => '2024-02-08T12:00:00',
            ],
            $seismicInformation->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                ->findLocationByNearDistance(37.101157, -7.831360)?->toArray()
        );
    }

    public function testFindLocationsByDistance(): void
    {
        $seismicInformation = $this->createService();

        self::assertSame(
            [
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 0.9,
                    'depth' => 20,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'W  Loulé',
                    'latitude' => 37.1350,
                    'longitude' => -8.0510,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-02-09T02:10:53',
                    'updateDate' => '2024-02-09T06:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 1.0,
                    'depth' => 7,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'NW Tavira',
                    'latitude' => 37.1760,
                    'longitude' => -7.7030,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-02-01T15:10:35',
                    'updateDate' => '2024-02-08T12:00:00',
                ],
            ],
            array_map(fn ($d) => $d->toArray(), $seismicInformation->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                ->findLocationsByDistance(37.101157, -7.831360, 20)
                ->get())
        );
    }

    public function testFilterByTime(): void
    {
        $seismicInformation = $this->createService();

        self::assertSame(
            [
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 0.2,
                    'depth' => 19,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'SW Evora',
                    'latitude' => 38.5050,
                    'longitude' => -7.9560,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-15T01:50:53',
                    'updateDate' => '2024-01-22T00:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 0.9,
                    'depth' => 5,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'SW Miranda do Douro',
                    'latitude' => 41.3610,
                    'longitude' => -6.4470,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-15T05:15:01',
                    'updateDate' => '2024-01-22T00:00:00',
                ],
                [
                    'seismId' => '',
                    'googleMapRef' => '',
                    'degree' => null,
                    'magType' => 'L',
                    'magnitude' => 2.2,
                    'depth' => 268,
                    'tensorRef' => '',
                    'shakeMapId' => '0',
                    'shakeMapRef' => '',
                    'location' => null,
                    'regionName' => 'Madeira-Tore',
                    'latitude' => 35.5110,
                    'longitude' => -16.0500,
                    'source' => 'IPMA',
                    'sensed' => null,
                    'time' => '2024-01-15T01:56:17',
                    'updateDate' => '2024-01-22T00:00:00',
                ],
            ],
            array_map(fn ($d) => $d->toArray(), $seismicInformation->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                ->filterByTime('2024-01-15T00:00:00', '2024-01-15T06:00:00')
                ->get())
        );
    }
}
