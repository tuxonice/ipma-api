<?php

namespace Tlab\Tests\Forecast\Oceanography;

use DateTime;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Forecast\Oceanography\SeaStateForecast;
use PHPUnit\Framework\TestCase;

class SeaStateForecastTest extends TestCase
{
    public function testFilterByGlobalIdLocal()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '5.5',
                    'globalIdLocal' => 2320126,
                    'totalSeaMax' => 2.5,
                    'waveHighMax' => '2.2',
                    'waveHighMin' => '1.6',
                    'longitude' => '-16.3400',
                    'wavePeriodMax' => '5.7',
                    'latitude' => '33.2500',
                    'totalSeaMin' => 2.0,
                    'sstMax' => '21.8',
                    'predWaveDir' => 'NE',
                    'sstMin' => '21.7',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterByGlobalIdLocal(2320126)
                ->get()
        );
    }

    public function testFilterByWavePeriodMin()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '2.8',
                    'globalIdLocal' => 1080526,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.0',
                    'waveHighMin' => '0.4',
                    'longitude' => '-8.0000',
                    'wavePeriodMax' => '4.0',
                    'latitude' => '37.1933',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '17.8',
                    'predWaveDir' => 'E',
                    'sstMin' => '17.5',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterByWavePeriodMin(2.0, 3.0)
                ->get()
        );
    }

    public function testFilterByWavePeriodMax()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '2.8',
                    'globalIdLocal' => 1080526,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.0',
                    'waveHighMin' => '0.4',
                    'longitude' => '-8.0000',
                    'wavePeriodMax' => '4.0',
                    'latitude' => '37.1933',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '17.8',
                    'predWaveDir' => 'E',
                    'sstMin' => '17.5',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterByWavePeriodMax(3.0, 4.0)
                ->get()
        );
    }

    public function testFilterByWaveHighMin()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '5.2',
                    'globalIdLocal' => 3420226,
                    'totalSeaMax' => 2.5,
                    'waveHighMax' => '1.9',
                    'waveHighMin' => '1.0',
                    'longitude' => '-25.6700',
                    'wavePeriodMax' => '5.5',
                    'latitude' => '37.9500',
                    'totalSeaMin' => 2.5,
                    'sstMax' => '18.6',
                    'predWaveDir' => 'SE',
                    'sstMin' => '18.5',
                ],
                [
                    'wavePeriodMin' => '4.4',
                    'globalIdLocal' => 2310326,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.4',
                    'waveHighMin' => '1.1',
                    'longitude' => '-16.9100',
                    'wavePeriodMax' => '4.9',
                    'latitude' => '32.7500',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '21.9',
                    'predWaveDir' => 'E',
                    'sstMin' => '21.8',

                ],
                [
                    'wavePeriodMin' => '4.3',
                    'globalIdLocal' => 1111026,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.6',
                    'waveHighMin' => '1.0',
                    'longitude' => '-9.3100',
                    'wavePeriodMax' => '7.3',
                    'latitude' => '38.6500',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '16.8',
                    'predWaveDir' => 'NW',
                    'sstMin' => '16.5',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterByWaveHighMin(1.0, 1.2)
                ->get()
        );
    }

    public function testFilterByWaveHighMax()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '4.4',
                    'globalIdLocal' => 2310326,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.4',
                    'waveHighMin' => '1.1',
                    'longitude' => '-16.9100',
                    'wavePeriodMax' => '4.9',
                    'latitude' => '32.7500',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '21.9',
                    'predWaveDir' => 'E',
                    'sstMin' => '21.8',
                ],
                [
                    'wavePeriodMin' => '2.8',
                    'globalIdLocal' => 1080526,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.0',
                    'waveHighMin' => '0.4',
                    'longitude' => '-8.0000',
                    'wavePeriodMax' => '4.0',
                    'latitude' => '37.1933',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '17.8',
                    'predWaveDir' => 'E',
                    'sstMin' => '17.5',
                ],
                [
                    'wavePeriodMin' => '4.6',
                    'globalIdLocal' => 1151326,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.5',
                    'waveHighMin' => '0.9',
                    'longitude' => '-8.8833',
                    'wavePeriodMax' => '6.9',
                    'latitude' => '37.9500',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '17.0',
                    'predWaveDir' => 'NW',
                    'sstMin' => '16.5',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterByWaveHighMax(1.0, 1.5)
                ->get()
        );
    }

    public function testFilterByTotalSeaMin()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '4.4',
                    'globalIdLocal' => 2310326,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.4',
                    'waveHighMin' => '1.1',
                    'longitude' => '-16.9100',
                    'wavePeriodMax' => '4.9',
                    'latitude' => '32.7500',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '21.9',
                    'predWaveDir' => 'E',
                    'sstMin' => '21.8',

                ],
                [
                    'wavePeriodMin' => '2.8',
                    'globalIdLocal' => 1080526,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.0',
                    'waveHighMin' => '0.4',
                    'longitude' => '-8.0000',
                    'wavePeriodMax' => '4.0',
                    'latitude' => '37.1933',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '17.8',
                    'predWaveDir' => 'E',
                    'sstMin' => '17.5',

                ],
                [
                    'wavePeriodMin' => '4.3',
                    'globalIdLocal' => 1111026,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.6',
                    'waveHighMin' => '1.0',
                    'longitude' => '-9.3100',
                    'wavePeriodMax' => '7.3',
                    'latitude' => '38.6500',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '16.8',
                    'predWaveDir' => 'NW',
                    'sstMin' => '16.5',

                ],
                [
                    'wavePeriodMin' => '4.6',
                    'globalIdLocal' => 1151326,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.5',
                    'waveHighMin' => '0.9',
                    'longitude' => '-8.8833',
                    'wavePeriodMax' => '6.9',
                    'latitude' => '37.9500',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '17.0',
                    'predWaveDir' => 'NW',
                    'sstMin' => '16.5',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterByTotalSeaMin(1.0, 1.2)
                ->get()
        );
    }

    public function testFilterByTotalSeaMax()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '5.4',
                    'globalIdLocal' => 3480226,
                    'totalSeaMax' => 3.0,
                    'waveHighMax' => '2.4',
                    'waveHighMin' => '1.8',
                    'longitude' => '-31.1200',
                    'wavePeriodMax' => '6.0',
                    'latitude' => '39.4600',
                    'totalSeaMin' => 2.0,
                    'sstMax' => '18.2',
                    'predWaveDir' => 'SE',
                    'sstMin' => '18.2',
                ],
                [
                    'wavePeriodMin' => '10.1',
                    'globalIdLocal' => 1060526,
                    'totalSeaMax' => 3.0,
                    'waveHighMax' => '2.7',
                    'waveHighMin' => '1.5',
                    'longitude' => '-8.8783',
                    'wavePeriodMax' => '9.5',
                    'latitude' => '40.1417',
                    'totalSeaMin' => 1.5,
                    'sstMax' => '16.1',
                    'predWaveDir' => 'NW',
                    'sstMin' => '15.9',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterByTotalSeaMax(3.0, 4.2)
                ->get()
        );
    }

    public function testFilterBySstMin()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '10.0',
                    'globalIdLocal' => 1130826,
                    'totalSeaMax' => 2.5,
                    'waveHighMax' => '2.6',
                    'waveHighMin' => '1.3',
                    'longitude' => '-8.7600',
                    'wavePeriodMax' => '9.8',
                    'latitude' => '41.1750',
                    'totalSeaMin' => 1.5,
                    'sstMax' => '15.6',
                    'predWaveDir' => 'NW',
                    'sstMin' => '15.4',
                ],
                [
                    'wavePeriodMin' => '10.1',
                    'globalIdLocal' => 1060526,
                    'totalSeaMax' => 3.0,
                    'waveHighMax' => '2.7',
                    'waveHighMin' => '1.5',
                    'longitude' => '-8.8783',
                    'wavePeriodMax' => '9.5',
                    'latitude' => '40.1417',
                    'totalSeaMin' => 1.5,
                    'sstMax' => '16.1',
                    'predWaveDir' => 'NW',
                    'sstMin' => '15.9',
                ],
                [
                    'wavePeriodMin' => '10.0',
                    'globalIdLocal' => 1160926,
                    'totalSeaMax' => 2.5,
                    'waveHighMax' => '2.6',
                    'waveHighMin' => '1.3',
                    'longitude' => '-8.8333',
                    'wavePeriodMax' => '9.8',
                    'latitude' => '41.7500',
                    'totalSeaMin' => 1.5,
                    'sstMax' => '15.6',
                    'predWaveDir' => 'NW',
                    'sstMin' => '15.4',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterBySstMin(15, 16)
                ->get()
        );
    }

    public function testFilterBySstMax()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '10.0',
                    'globalIdLocal' => 1130826,
                    'totalSeaMax' => 2.5,
                    'waveHighMax' => '2.6',
                    'waveHighMin' => '1.3',
                    'longitude' => '-8.7600',
                    'wavePeriodMax' => '9.8',
                    'latitude' => '41.1750',
                    'totalSeaMin' => 1.5,
                    'sstMax' => '15.6',
                    'predWaveDir' => 'NW',
                    'sstMin' => '15.4',
                ],
                [
                    'wavePeriodMin' => '10.0',
                    'globalIdLocal' => 1160926,
                    'totalSeaMax' => 2.5,
                    'waveHighMax' => '2.6',
                    'waveHighMin' => '1.3',
                    'longitude' => '-8.8333',
                    'wavePeriodMax' => '9.8',
                    'latitude' => '41.7500',
                    'totalSeaMin' => 1.5,
                    'sstMax' => '15.6',
                    'predWaveDir' => 'NW',
                    'sstMin' => '15.4',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterBySstMax(15, 16)
                ->get()
        );
    }

    public function testFilterByPredWaveDir()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '4.7',
                    'globalIdLocal' => 1081526,
                    'totalSeaMax' => 2.0,
                    'waveHighMax' => '2.0',
                    'waveHighMin' => '1.3',
                    'longitude' => '-8.9383',
                    'wavePeriodMax' => '6.1',
                    'latitude' => '37.0700',
                    'totalSeaMin' => 1.5,
                    'sstMax' => '17.1',
                    'predWaveDir' => 'N',
                    'sstMin' => '17.0',
                ],
            ],
            $seaStateForecast->from(0)
                ->filterByPredWaveDir('N')
                ->get()
        );
    }

    public function testFindLocationsByDistance()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'wavePeriodMin' => '2.8',
                    'globalIdLocal' => 1080526,
                    'totalSeaMax' => 1.5,
                    'waveHighMax' => '1.0',
                    'waveHighMin' => '0.4',
                    'longitude' => '-8.0000',
                    'wavePeriodMax' => '4.0',
                    'latitude' => '37.1933',
                    'totalSeaMin' => 1.0,
                    'sstMax' => '17.8',
                    'predWaveDir' => 'E',
                    'sstMin' => '17.5',
                ],
            ],
            $seaStateForecast->from(0)
                ->findLocationsByDistance(37.101157, -7.831360, 20)
                ->get()
        );
    }

    public function testFindLocationByNearDistance()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            [
                'wavePeriodMin' => '2.8',
                'globalIdLocal' => 1080526,
                'totalSeaMax' => 1.5,
                'waveHighMax' => '1.0',
                'waveHighMin' => '0.4',
                'longitude' => '-8.0000',
                'wavePeriodMax' => '4.0',
                'latitude' => '37.1933',
                'totalSeaMin' => 1.0,
                'sstMax' => '17.8',
                'predWaveDir' => 'E',
                'sstMin' => '17.5',
            ],
            $seaStateForecast->from(0)
                ->findLocationByNearDistance(37.101157, -7.831360)
        );
    }

    public function testGetUpdateAt()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            new DateTime('2023-12-15T10:31:03'),
            $seaStateForecast->from(0)
                ->getUpdateAt()
        );
    }

    public function testGetForecastDate()
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $seaStateForecast = new SeaStateForecast($apiConnectorMock);

        self::assertEquals(
            new DateTime('2023-12-15'),
            $seaStateForecast->from(0)
                ->getForecastDate()
        );
    }
}
