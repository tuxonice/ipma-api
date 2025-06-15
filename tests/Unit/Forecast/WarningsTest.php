<?php

namespace Tlab\Tests\Forecast;

use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Forecast\Warnings\WeatherWarnings;

class WarningsTest extends TestCase
{
    public function testFilterByIdAreaAviso(): void
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Forecast/warnings_www.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $warnings = new WeatherWarnings($apiConnector);

        self::assertEquals([
            [
                'text' => '',
                'awarenessTypeName' => 'Agitação Marítima',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Nevoeiro',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Tempo Quente',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Tempo Frio',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Precipitação',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Neve',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Trovoada',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
        ], $warnings->filterByWarningIdArea('FAR')->get());
    }

    public function testFilterByAwarenessTypeName(): void
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Forecast/warnings_www.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $warnings = new WeatherWarnings($apiConnector);

        self::assertEquals([
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'BGC',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'ACE',
                'startTime' => '2023-12-02T11:49:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T11:00:00',

            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'VIS',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'EVR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'PTO',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'AOC',
                'startTime' => '2023-12-02T11:49:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T11:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'GDA',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'FAR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'AOR',
                'startTime' => '2023-12-02T11:49:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T11:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'VRL',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'STB',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'STM',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'MRM',
                'startTime' => '2023-12-02T11:56:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T11:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'VCT',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'LSB',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'LRA',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'MCN',
                'startTime' => '2023-12-02T11:56:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T11:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'BJA',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'CBO',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'AVR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'CBR',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'PTG',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'MPS',
                'startTime' => '2023-12-02T11:56:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T11:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'BRG',
                'startTime' => '2023-12-02T12:23:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T12:00:00',
            ],
            [
                'text' => '',
                'awarenessTypeName' => 'Vento',
                'idAreaAviso' => 'MCS',
                'startTime' => '2023-12-02T11:56:00',
                'awarenessLevelID' => 'green',
                'endTime' => '2023-12-05T11:00:00',
            ]
        ], $warnings
            ->filterByAwarenessTypeName('Vento')
            ->get());
    }

    public function testFilterByAwarenessLevelId(): void
    {
        $apiConnector = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 2) . '/Data/Forecast/warnings_www.json');
        $apiConnector->expects(self::once())
            ->method('fetchData')
            ->willReturn(json_decode($contents, true));
        $warnings = new WeatherWarnings($apiConnector);

        self::assertEquals([
            [
                'text' => '',
                'awarenessTypeName' => 'Precipitação',
                'idAreaAviso' => 'MRM',
                'startTime' => '2023-12-02T11:56:00',
                'awarenessLevelID' => 'yellow',
                'endTime' => '2023-12-05T11:00:00',
            ],
        ], $warnings
            ->filterByAwarenessLevelId('yellow')
            ->get());
    }
}
