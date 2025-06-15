<?php

declare(strict_types=1);

namespace Tlab\Tests\Forecast\Oceanography;

use DateTime;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Enums\SeaStateForecastDayEnum;
use Tlab\IpmaApi\Forecast\Oceanography\SeaStateForecast;
use PHPUnit\Framework\TestCase;

class SeaStateForecastTest extends TestCase
{
    private array $seaStateForecastDay0Fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Oceanography/hp-daily-sea-forecast-day0.json');
        $this->seaStateForecastDay0Fixture = json_decode($contents, true);
    }

    private function createService(): SeaStateForecast
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $apiConnectorMock->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->seaStateForecastDay0Fixture);

        return new SeaStateForecast($apiConnectorMock);
    }

    public function testFilterByGlobalIdLocal(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
                [
                    'globalIdLocal' => 2320126,
                    'predWaveDir' => 'NE',
                    'waveHighMin' => 1.6,
                    'waveHighMax' => 2.2,
                    'wavePeriodMin' => 5.5,
                    'wavePeriodMax' => 5.7,
                    'totalSeaMin' => 2.0,
                    'totalSeaMax' => 2.5,
                    'sstMin' => 21.7,
                    'sstMax' => 21.8,
                    'latitude' => 33.2500,
                    'longitude' => -16.3400,
                ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterByGlobalIdLocal(2320126)
                ->get()
        );
    }

    public function testFilterByWavePeriodMin(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 1080526,
                'predWaveDir' => 'E',
                'waveHighMin' => 0.4,
                'waveHighMax' => 1.0,
                'wavePeriodMin' => 2.8,
                'wavePeriodMax' => 4.0,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 17.5,
                'sstMax' => 17.8,
                'latitude' => 37.1933,
                'longitude' => -8.0000,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterByWavePeriodMin(2.0, 3.0)
                ->get()
        );
    }

    public function testFilterByWavePeriodMax(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 1080526,
                'predWaveDir' => 'E',
                'waveHighMin' => 0.4,
                'waveHighMax' => 1.0,
                'wavePeriodMin' => 2.8,
                'wavePeriodMax' => 4.0,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 17.5,
                'sstMax' => 17.8,
                'latitude' => 37.1933,
                'longitude' => -8.0000,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterByWavePeriodMax(3.0, 4.0)
                ->get()
        );
    }

    public function testFilterByWaveHighMin(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 3420226,
                'predWaveDir' => 'SE',
                'waveHighMin' => 1.0,
                'waveHighMax' => 1.9,
                'wavePeriodMin' => 5.2,
                'wavePeriodMax' => 5.5,
                'totalSeaMin' => 2.5,
                'totalSeaMax' => 2.5,
                'sstMin' => 18.5,
                'sstMax' => 18.6,
                'latitude' => 37.9500,
                'longitude' => -25.6700,
            ],
            [
                'globalIdLocal' => 2310326,
                'predWaveDir' => 'E',
                'waveHighMin' => 1.1,
                'waveHighMax' => 1.4,
                'wavePeriodMin' => 4.4,
                'wavePeriodMax' => 4.9,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 21.8,
                'sstMax' => 21.9,
                'latitude' => 32.7500,
                'longitude' => -16.9100,

            ],
            [
                'globalIdLocal' => 1111026,
                'predWaveDir' => 'NW',
                'waveHighMin' => 1.0,
                'waveHighMax' => 1.6,
                'wavePeriodMin' => 4.3,
                'wavePeriodMax' => 7.3,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 16.5,
                'sstMax' => 16.8,
                'latitude' => 38.6500,
                'longitude' => -9.3100,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterByWaveHighMin(1.0, 1.2)
                ->get()
        );
    }

    public function testFilterByWaveHighMax(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 2310326,
                'predWaveDir' => 'E',
                'waveHighMin' => 1.1,
                'waveHighMax' => 1.4,
                'wavePeriodMin' => 4.4,
                'wavePeriodMax' => 4.9,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 21.8,
                'sstMax' => 21.9,
                'latitude' => 32.7500,
                'longitude' => -16.9100,
            ],
            [
                'globalIdLocal' => 1080526,
                'predWaveDir' => 'E',
                'waveHighMin' => 0.4,
                'waveHighMax' => 1.0,
                'wavePeriodMin' => 2.8,
                'wavePeriodMax' => 4.0,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 17.5,
                'sstMax' => 17.8,
                'latitude' => 37.1933,
                'longitude' => -8.0000,
            ],
            [
                'globalIdLocal' => 1151326,
                'predWaveDir' => 'NW',
                'waveHighMin' => 0.9,
                'waveHighMax' => 1.5,
                'wavePeriodMin' => 4.6,
                'wavePeriodMax' => 6.9,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 16.5,
                'sstMax' => 17.0,
                'latitude' => 37.9500,
                'longitude' => -8.8833,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterByWaveHighMax(1.0, 1.5)
                ->get()
        );
    }

    public function testFilterByTotalSeaMin(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 2310326,
                'predWaveDir' => 'E',
                'waveHighMin' => 1.1,
                'waveHighMax' => 1.4,
                'wavePeriodMin' => 4.4,
                'wavePeriodMax' => 4.9,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 21.8,
                'sstMax' => 21.9,
                'latitude' => 32.7500,
                'longitude' => -16.9100,

            ],
            [
                'globalIdLocal' => 1080526,
                'predWaveDir' => 'E',
                'waveHighMin' => 0.4,
                'waveHighMax' => 1.0,
                'wavePeriodMin' => 2.8,
                'wavePeriodMax' => 4.0,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 17.5,
                'sstMax' => 17.8,
                'latitude' => 37.1933,
                'longitude' => -8.0000,

            ],
            [
                'globalIdLocal' => 1111026,
                'predWaveDir' => 'NW',
                'waveHighMin' => 1.0,
                'waveHighMax' => 1.6,
                'wavePeriodMin' => 4.3,
                'wavePeriodMax' => 7.3,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 16.5,
                'sstMax' => 16.8,
                'latitude' => 38.6500,
                'longitude' => -9.3100,

            ],
            [
                'globalIdLocal' => 1151326,
                'predWaveDir' => 'NW',
                'waveHighMin' => 0.9,
                'waveHighMax' => 1.5,
                'wavePeriodMin' => 4.6,
                'wavePeriodMax' => 6.9,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 16.5,
                'sstMax' => 17.0,
                'latitude' => 37.9500,
                'longitude' => -8.8833,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterByTotalSeaMin(1.0, 1.2)
                ->get()
        );
    }

    public function testFilterByTotalSeaMax(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 3480226,
                'predWaveDir' => 'SE',
                'waveHighMin' => 1.8,
                'waveHighMax' => 2.4,
                'wavePeriodMin' => 5.4,
                'wavePeriodMax' => 6.0,
                'totalSeaMin' => 2.0,
                'totalSeaMax' => 3.0,
                'sstMin' => 18.2,
                'sstMax' => 18.2,
                'latitude' => 39.4600,
                'longitude' => -31.1200,
            ],
            [
                'globalIdLocal' => 1060526,
                'predWaveDir' => 'NW',
                'waveHighMin' => 1.5,
                'waveHighMax' => 2.7,
                'wavePeriodMin' => 10.1,
                'wavePeriodMax' => 9.5,
                'totalSeaMin' => 1.5,
                'totalSeaMax' => 3.0,
                'sstMin' => 15.9,
                'sstMax' => 16.1,
                'latitude' => 40.1417,
                'longitude' => -8.8783,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterByTotalSeaMax(3.0, 4.2)
                ->get()
        );
    }

    public function testFilterBySstMin(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 1130826,
                'predWaveDir' => 'NW',
                'waveHighMin' => 1.3,
                'waveHighMax' => 2.6,
                'wavePeriodMin' => 10.0,
                'wavePeriodMax' => 9.8,
                'totalSeaMin' => 1.5,
                'totalSeaMax' => 2.5,
                'sstMin' => 15.4,
                'sstMax' => 15.6,
                'latitude' => 41.1750,
                'longitude' => -8.7600,
            ],
            [
                'globalIdLocal' => 1060526,
                'predWaveDir' => 'NW',
                'waveHighMin' => 1.5,
                'waveHighMax' => 2.7,
                'wavePeriodMin' => 10.1,
                'wavePeriodMax' => 9.5,
                'totalSeaMin' => 1.5,
                'totalSeaMax' => 3.0,
                'sstMin' => 15.9,
                'sstMax' => 16.1,
                'latitude' => 40.1417,
                'longitude' => -8.8783,
            ],
            [
                'globalIdLocal' => 1160926,
                'predWaveDir' => 'NW',
                'waveHighMin' => 1.3,
                'waveHighMax' => 2.6,
                'wavePeriodMin' => 10.0,
                'wavePeriodMax' => 9.8,
                'totalSeaMin' => 1.5,
                'totalSeaMax' => 2.5,
                'sstMin' => 15.4,
                'sstMax' => 15.6,
                'latitude' => 41.7500,
                'longitude' => -8.8333,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterBySstMin(15, 16)
                ->get()
        );
    }

    public function testFilterBySstMax(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 1130826,
                'predWaveDir' => 'NW',
                'waveHighMin' => 1.3,
                'waveHighMax' => 2.6,
                'wavePeriodMin' => 10.0,
                'wavePeriodMax' => 9.8,
                'totalSeaMin' => 1.5,
                'totalSeaMax' => 2.5,
                'sstMin' => 15.4,
                'sstMax' => 15.6,
                'latitude' => 41.1750,
                'longitude' => -8.7600,
            ],
            [
                'globalIdLocal' => 1160926,
                'predWaveDir' => 'NW',
                'waveHighMin' => 1.3,
                'waveHighMax' => 2.6,
                'wavePeriodMin' => 10.0,
                'wavePeriodMax' => 9.8,
                'totalSeaMin' => 1.5,
                'totalSeaMax' => 2.5,
                'sstMin' => 15.4,
                'sstMax' => 15.6,
                'latitude' => 41.7500,
                'longitude' => -8.8333,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterBySstMax(15, 16)
                ->get()
        );
    }

    public function testFilterByPredWaveDir(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 1081526,
                'predWaveDir' => 'N',
                'waveHighMin' => 1.3,
                'waveHighMax' => 2.0,
                'wavePeriodMin' => 4.7,
                'wavePeriodMax' => 6.1,
                'totalSeaMin' => 1.5,
                'totalSeaMax' => 2.0,
                'sstMin' => 17.0,
                'sstMax' => 17.1,
                'latitude' => 37.0700,
                'longitude' => -8.9383,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->filterByPredWaveDir('N')
                ->get()
        );
    }

    public function testFindLocationsByDistance(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            [
                'globalIdLocal' => 1080526,
                'predWaveDir' => 'E',
                'waveHighMin' => 0.4,
                'waveHighMax' => 1.0,
                'wavePeriodMin' => 2.8,
                'wavePeriodMax' => 4.0,
                'totalSeaMin' => 1.0,
                'totalSeaMax' => 1.5,
                'sstMin' => 17.5,
                'sstMax' => 17.8,
                'latitude' => 37.1933,
                'longitude' => -8.0000,
            ],
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->findLocationsByDistance(37.101157, -7.831360, 20)
                ->get()
        );
    }

    public function testFindLocationByNearDistance(): void
    {
        $seaStateForecast = $this->createService();

        self::assertSame(
            [
            'globalIdLocal' => 1080526,
            'predWaveDir' => 'E',
            'waveHighMin' => 0.4,
            'waveHighMax' => 1.0,
            'wavePeriodMin' => 2.8,
            'wavePeriodMax' => 4.0,
            'totalSeaMin' => 1.0,
            'totalSeaMax' => 1.5,
            'sstMin' => 17.5,
            'sstMax' => 17.8,
            'latitude' => 37.1933,
            'longitude' => -8.0000,
            ],
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->findLocationByNearDistance(37.101157, -7.831360)
        );
    }

    public function testGetUpdateAt(): void
    {
        $seaStateForecast = $this->createService();

        self::assertEquals(
            new DateTime('2023-12-15T10:31:03'),
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->getUpdateAt()
        );
    }

    public function testGetForecastDate(): void
    {
        $seaStateForecast = $this->createService();

        self::assertEquals(
            new DateTime('2023-12-15'),
            $seaStateForecast->from(SeaStateForecastDayEnum::TODAY)
                ->getForecastDate()
        );
    }
}
