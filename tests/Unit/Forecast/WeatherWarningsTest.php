<?php

declare(strict_types=1);

namespace Tlab\Tests\Forecast;

use DateTime;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Forecast\Warnings\WeatherWarnings;

class WeatherWarningsTest extends TestCase
{
    private array $warningsFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Forecast/warnings_www.json');
        $this->warningsFixture = json_decode($contents, true);
    }

    private function createService(): WeatherWarnings
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn($this->warningsFixture);

        return new WeatherWarnings($apiConnector);
    }

    public function testFilterByWarningIdArea(): void
    {
        $warnings = $this->createService();

        self::assertSame([
            [
                'text' => '',
                'awarenessTypeName' => 'Agitação Marítima',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Nevoeiro',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Tempo Quente',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Tempo Frio',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Precipitação',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Neve',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Trovoada',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
        ], $warnings->query()->filterByWarningIdArea('FAR')->get());
    }

    public function testFilterByAwarenessTypeName(): void
    {
        $warnings = $this->createService();

        self::assertSame([
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'BGC',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'ACE',
                'startTime' => '2023-12-02T11:49:00',
                'endTime' => '2023-12-05T11:00:00',
                'awarenessLevelID' => 'green',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'VIS',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'EVR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'PTO',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'AOC',
                'startTime' => '2023-12-02T11:49:00',
                'endTime' => '2023-12-05T11:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'GDA',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'AOR',
                'startTime' => '2023-12-02T11:49:00',
                'endTime' => '2023-12-05T11:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'VRL',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'STB',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'STM',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'MRM',
                'startTime' => '2023-12-02T11:56:00',
                'endTime' => '2023-12-05T11:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'VCT',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'LSB',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'LRA',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'MCN',
                'startTime' => '2023-12-02T11:56:00',
                'endTime' => '2023-12-05T11:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'BJA',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'CBO',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'AVR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'CBR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'PTG',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'MPS',
                'startTime' => '2023-12-02T11:56:00',
                'endTime' => '2023-12-05T11:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'BRG',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'MCS',
                'startTime' => '2023-12-02T11:56:00',
                'endTime' => '2023-12-05T11:00:00',
                'awarenessLevelID' => 'green',
            ]
        ], $warnings->query()
            ->filterByAwarenessTypeName('Vento')
            ->get());
    }

    public function testFilterByAwarenessLevelId(): void
    {
        $warnings = $this->createService();

        self::assertSame([
            [
                'text' => '',
                'awarenessTypeName' => 'Precipitação',
                'warningIdArea' => 'MRM',
                'startTime' => '2023-12-02T11:56:00',
                'endTime' => '2023-12-05T11:00:00',
                'awarenessLevelID' => 'yellow',
            ],
        ], $warnings->query()
            ->filterByAwarenessLevelId('yellow')
            ->get());
    }

    public function testFilterByTimeRangeExactMatch(): void
    {
        $warnings = $this->createService();

        self::assertSame([
            [
                'text' => '',
                'awarenessTypeName' => 'Agitação Marítima',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Nevoeiro',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Tempo Quente',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Tempo Frio',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Precipitação',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Neve',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Trovoada',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'warningIdArea' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'endTime' => '2023-12-05T12:00:00',
                'awarenessLevelID' => 'green',
            ],
        ], $warnings->query()
            ->filterByWarningIdArea('FAR')
            ->filterByTimeRange(new DateTime('2023-12-02T12:23:00'), new DateTime('2023-12-05T12:00:00'))
            ->get());
    }

    public function testFilterByTimeRangeWithinRange(): void
    {
        $warnings = $this->createService();

        $result = $warnings->query()
            ->filterByWarningIdArea('FAR')
            ->filterByTimeRange(new DateTime('2023-12-03T00:00:00'), new DateTime('2023-12-04T00:00:00'))
            ->get();

        self::assertEmpty($result);
    }

    public function testFilterByTimeRangeExcludesWarningsOutsideRange(): void
    {
        $warnings = $this->createService();

        $result = $warnings->query()
            ->filterByTimeRange(new DateTime('2023-12-01T00:00:00'), new DateTime('2023-12-01T23:59:59'))
            ->get();

        self::assertEmpty($result);
    }

    public function testFilterByTimeRangeBroaderThanWarnings(): void
    {
        $warnings = $this->createService();

        $result = $warnings->query()
            ->filterByWarningIdArea('FAR')
            ->filterByTimeRange(new DateTime('2023-12-01T00:00:00'), new DateTime('2023-12-06T23:59:59'))
            ->get();

        self::assertCount(8, $result);
    }

    public function testFilterByTimeRangePartialOverlap(): void
    {
        $warnings = $this->createService();

        $result = $warnings->query()
            ->filterByWarningIdArea('ACE')
            ->filterByTimeRange(new DateTime('2023-12-02T11:49:00'), new DateTime('2023-12-05T11:00:00'))
            ->get();

        self::assertCount(8, $result);
        self::assertEquals('2023-12-02T11:49:00', $result[0]['startTime']);
        self::assertEquals('2023-12-05T11:00:00', $result[0]['endTime']);
    }
}
