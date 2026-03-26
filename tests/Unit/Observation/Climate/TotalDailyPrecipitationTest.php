<?php

namespace Tlab\Tests\Observation\Climate;

use League\Csv\Reader;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Observation\Climate\TotalDailyPrecipitation;

class TotalDailyPrecipitationTest extends TestCase
{
    public function testFilterByDate(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mrrto-0206-castro-verde.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $totalDailyPrecipitation = new TotalDailyPrecipitation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2024-01-05',
                    'minimum' => '0.0',
                    'maximum' => '0.0',
                    'range' => '0.0',
                    'mean' => '0.0',
                    'std' => '0.0',
                ],
                [
                    'date' => '2024-01-06',
                    'minimum' => '0.0',
                    'maximum' => '0.0',
                    'range' => '0.0',
                    'mean' => '0.0',
                    'std' => '0.0',
                ],
            ],
            $totalDailyPrecipitation->from('beja', 'castro-verde', '0206')
                ->filterByDate('2024-01-05', '2024-01-06')
                ->get()
        );
    }

    public function testFilterByMinimum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mrrto-0206-castro-verde.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $totalDailyPrecipitation = new TotalDailyPrecipitation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-11-01',
                    'minimum' => '5.0',
                    'maximum' => '6.5',
                    'range' => '1.5',
                    'mean' => '5.75',
                    'std' => '0.5',
                ],
                [
                    'date' => '2023-11-02',
                    'minimum' => '5.5',
                    'maximum' => '7.0',
                    'range' => '1.5',
                    'mean' => '6.25',
                    'std' => '0.6',
                ],
            ],
            $totalDailyPrecipitation->from('beja', 'castro-verde', '0206')
                ->filterByMinimum(5.0, 6.0)
                ->get()
        );
    }

    public function testFilterByMaximum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mrrto-0206-castro-verde.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $totalDailyPrecipitation = new TotalDailyPrecipitation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-10-24',
                    'minimum' => '0.0',
                    'maximum' => '1.0',
                    'range' => '1.0',
                    'mean' => '0.5',
                    'std' => '0.3',
                ],
                [
                    'date' => '2023-10-25',
                    'minimum' => '0.0',
                    'maximum' => '1.0',
                    'range' => '1.0',
                    'mean' => '0.5',
                    'std' => '0.3',
                ],
            ],
            $totalDailyPrecipitation->from('beja', 'castro-verde', '0206')
                ->filterByMaximum(1.0, 1.0)
                ->get()
        );
    }

    public function testFilterByRange(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mrrto-0206-castro-verde.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $totalDailyPrecipitation = new TotalDailyPrecipitation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-11-05',
                    'minimum' => '1.0',
                    'maximum' => '3.5',
                    'range' => '2.5',
                    'mean' => '2.25',
                    'std' => '0.9',
                ],
                [
                    'date' => '2023-11-06',
                    'minimum' => '0.5',
                    'maximum' => '3.0',
                    'range' => '2.5',
                    'mean' => '1.75',
                    'std' => '0.85',
                ],
            ],
            $totalDailyPrecipitation->from('beja', 'castro-verde', '0206')
                ->filterByRange(2.5, 2.5)
                ->get()
        );
    }

    public function testFilterByMean(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mrrto-0206-castro-verde.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $totalDailyPrecipitation = new TotalDailyPrecipitation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-11-17',
                    'minimum' => '3.0',
                    'maximum' => '8.0',
                    'range' => '5.0',
                    'mean' => '5.5',
                    'std' => '1.5',
                ],
                [
                    'date' => '2023-12-03',
                    'minimum' => '2.5',
                    'maximum' => '7.5',
                    'range' => '5.0',
                    'mean' => '5.0',
                    'std' => '1.4',
                ],
            ],
            $totalDailyPrecipitation->from('beja', 'castro-verde', '0206')
                ->filterByMean(5.0, 5.5)
                ->get()
        );
    }

    public function testFilterByStd(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mrrto-0206-castro-verde.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $totalDailyPrecipitation = new TotalDailyPrecipitation($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-11-01',
                    'minimum' => '5.0',
                    'maximum' => '6.5',
                    'range' => '1.5',
                    'mean' => '5.75',
                    'std' => '0.5',
                ],
                [
                    'date' => '2024-01-16',
                    'minimum' => '0.0',
                    'maximum' => '1.5',
                    'range' => '1.5',
                    'mean' => '0.75',
                    'std' => '0.5',
                ],
            ],
            $totalDailyPrecipitation->from('beja', 'castro-verde', '0206')
                ->filterByStd(0.5, 0.5)
                ->get()
        );
    }
}
