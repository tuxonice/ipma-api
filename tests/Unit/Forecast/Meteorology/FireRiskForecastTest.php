<?php

declare(strict_types=1);

namespace Tlab\Tests\Forecast\Meteorology;

use DateTime;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Enums\FireRiskLevelEnum;
use Tlab\IpmaApi\Enums\ForecastFireRiskDayEnum;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;

class FireRiskForecastTest extends TestCase
{
    private array $fireRiskForecastFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Forecast/Meteorology/rcm-d0.json');
        $this->fireRiskForecastFixture = json_decode($contents, true);
    }

    private function createService(): FireRiskForecast
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->fireRiskForecastFixture);

        return new FireRiskForecast($apiConnector);
    }

    public function testFilterByDico(): void
    {
        $fireRiskForecast = $this->createService();

        self::assertSame(
            [
                [
                    'dico' => '1002',
                    'fireRiskLevel' => 1,
                    'latitude' => 39.8222,
                    'longitude' => -8.3814,
                ],
            ],
            $fireRiskForecast->from(ForecastFireRiskDayEnum::TODAY)
                ->filterByDico('1002')
                ->get()
        );
    }

    public function testFilterByFireRiskLevel(): void
    {
        $fireRiskForecast = $this->createService();

        self::assertSame(
            [
                [
                    'dico' => '0901',
                    'fireRiskLevel' => 2,
                    'latitude' => 40.82,
                    'longitude' => -7.54,
                ],
            ],
            $fireRiskForecast->from(ForecastFireRiskDayEnum::TODAY)
                ->filterByFireRiskLevel(FireRiskLevelEnum::MODERATE_RISK)
                ->get()
        );
    }

    public function testFindLocationsByDistance(): void
    {
        $fireRiskForecast = $this->createService();

        self::assertSame([
            [
                'dico' => '0810',
                'fireRiskLevel' => 1,
                'latitude' => 37.03,
                'longitude' => -7.84,
            ],
            [
                'dico' => '0812',
                'fireRiskLevel' => 1,
                'latitude' => 37.15,
                'longitude' => -7.89,
            ],
        ], $fireRiskForecast->from(ForecastFireRiskDayEnum::TODAY)
            ->findLocationsByDistance(37.101157, -7.831360, 10)->get());
    }

    public function testFindLocationByNearDistance(): void
    {
        $fireRiskForecast = $this->createService();

        self::assertSame([
            'dico' => '0812',
            'fireRiskLevel' => 1,
            'latitude' => 37.15,
            'longitude' => -7.89,
        ], $fireRiskForecast->from(ForecastFireRiskDayEnum::TODAY)->findLocationByNearDistance(37.101157, -7.831360));
    }

    public function testGetFileUpdatedAt(): void
    {
        $fireRiskForecast = $this->createService();

        self::assertEquals(
            new DateTime('2023-12-09T00:05:02'),
            $fireRiskForecast->from(ForecastFireRiskDayEnum::TODAY)->getFileUpdatedAt()
        );
    }

    public function testGetForecastDate(): void
    {
        $fireRiskForecast = $this->createService();

        self::assertEquals(
            new DateTime('2023-12-09T00:00:00'),
            $fireRiskForecast->from(ForecastFireRiskDayEnum::TODAY)->getForecastDate()
        );
    }

    public function testGetRunDate(): void
    {
        $fireRiskForecast = $this->createService();

        self::assertEquals(
            new DateTime('2023-12-08T00:00:00'),
            $fireRiskForecast->from(ForecastFireRiskDayEnum::TODAY)->getRunDate()
        );
    }
}
