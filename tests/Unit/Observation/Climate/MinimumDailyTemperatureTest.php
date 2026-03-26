<?php

namespace Tlab\Tests\Observation\Climate;

use League\Csv\Reader;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Observation\Climate\MinimumDailyTemperature;

class MinimumDailyTemperatureTest extends TestCase
{
    public function testFilterByDate(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-09',
                    'minimum' => '5.70042896271',
                    'maximum' => '8.19582462311',
                    'range' => '2.4953956604',
                    'mean' => '6.54996325572',
                    'std' => '0.739884989435',
                ],
                [
                    'date' => '2023-12-10',
                    'minimum' => '6.20044946671',
                    'maximum' => '8.98331642151',
                    'range' => '2.7828669548',
                    'mean' => '7.05298433701',
                    'std' => '0.757533529567',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByDate('2023-12-09', '2023-12-10')
                ->get()
        );
    }

    public function testFilterByMinimum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-09',
                    'minimum' => '5.70042896271',
                    'maximum' => '8.19582462311',
                    'range' => '2.4953956604',
                    'mean' => '6.54996325572',
                    'std' => '0.739884989435',
                ],
                [
                    'date' => '2023-12-10',
                    'minimum' => '6.20044946671',
                    'maximum' => '8.98331642151',
                    'range' => '2.7828669548',
                    'mean' => '7.05298433701',
                    'std' => '0.757533529567',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByDate('2023-12-09', '2023-12-10')
                ->filterByMinimum(5.0, 7.0)
                ->get()
        );
    }

    public function testFilterByMaximum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-11',
                    'minimum' => '5.30069351196',
                    'maximum' => '10.4441518784',
                    'range' => '5.14345836639',
                    'mean' => '6.77413284779',
                    'std' => '1.34733945631',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByMaximum(10.4, 10.5)
                ->get()
        );
    }

    public function testFilterByRange(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-11',
                    'minimum' => '5.30069351196',
                    'maximum' => '10.4441518784',
                    'range' => '5.14345836639',
                    'mean' => '6.77413284779',
                    'std' => '1.34733945631',
                ],
                [
                    'date' => '2023-12-12',
                    'minimum' => '4.0008020401',
                    'maximum' => '9.54661846161',
                    'range' => '5.54581642151',
                    'mean' => '5.71145947377',
                    'std' => '1.52442251473',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByDate('2023-12-11', '2023-12-12')
                ->filterByRange(5.0, 6.0)
                ->get()
        );
    }

    public function testFilterByMean(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-09',
                    'minimum' => '5.70042896271',
                    'maximum' => '8.19582462311',
                    'range' => '2.4953956604',
                    'mean' => '6.54996325572',
                    'std' => '0.739884989435',
                ],
                [
                    'date' => '2023-12-11',
                    'minimum' => '5.30069351196',
                    'maximum' => '10.4441518784',
                    'range' => '5.14345836639',
                    'mean' => '6.77413284779',
                    'std' => '1.34733945631',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByDate('2023-12-09', '2023-12-11')
                ->filterByMean(6.5, 7.0)
                ->get()
        );
    }

    public function testFilterByStd(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-09',
                    'minimum' => '5.70042896271',
                    'maximum' => '8.19582462311',
                    'range' => '2.4953956604',
                    'mean' => '6.54996325572',
                    'std' => '0.739884989435',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByStd(0.739, 0.740)
                ->get()
        );
    }
}
