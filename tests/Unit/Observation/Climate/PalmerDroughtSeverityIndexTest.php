<?php

namespace Tlab\Tests\Observation\Climate;

use League\Csv\Reader;
use Tlab\IpmaApi\ApiConnector;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Observation\Climate\PalmerDroughtSeverityIndex;

class PalmerDroughtSeverityIndexTest extends TestCase
{
    public function testFilterByDate(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $palmerDroughtSeverityIndex = new PalmerDroughtSeverityIndex($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-04-01',
                    'minimum' => '-4.73062181473',
                    'maximum' => '-4.26249408722',
                    'range' => '0.468127727509',
                    'mean' => '-4.50398913626',
                    'std' => '0.105748789386',
                ],
                [
                    'date' => '2023-05-01',
                    'minimum' => '-4.90404748917',
                    'maximum' => '-4.17447328568',
                    'range' => '0.729574203491',
                    'mean' => '-4.51484062019',
                    'std' => '0.188053237399',
                ],
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByDate('2023-01-01', '2023-05-01')
                ->get()
        );
    }

    public function testFilterByMinimum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $palmerDroughtSeverityIndex = new PalmerDroughtSeverityIndex($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-10-01',
                    'minimum' => '-1.06839191914',
                    'maximum' => '-1.01727044582',
                    'range' => '0.0511214733124',
                    'mean' => '-1.04493014923',
                    'std' => '0.0113067636071',
                ],
                [
                    'date' => '2023-11-01',
                    'minimum' => '-1.51545977592',
                    'maximum' => '-1.37347519398',
                    'range' => '0.141984581947',
                    'mean' => '-1.43936434713',
                    'std' => '0.0378179140969',
                ],
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByMinimum(-2.0, -1.0)
                ->get()
        );
    }

    public function testFilterByMaximum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $palmerDroughtSeverityIndex = new PalmerDroughtSeverityIndex($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-01',
                    'minimum' => '-2.41497445107',
                    'maximum' => '-2.30563569069',
                    'range' => '0.109338760376',
                    'mean' => '-2.3549714836',
                    'std' => '0.0271261757438',
                ],
                [
                    'date' => '2024-01-01',
                    'minimum' => '-2.16691803932',
                    'maximum' => '-2.03200626373',
                    'range' => '0.134911775589',
                    'mean' => '-2.08929791781',
                    'std' => '0.035531340147',
                ],
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByMaximum(-2.5, -1.5)
                ->get()
        );
    }

    public function testFilterByRange(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $palmerDroughtSeverityIndex = new PalmerDroughtSeverityIndex($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-04-01',
                    'minimum' => '-4.73062181473',
                    'maximum' => '-4.26249408722',
                    'range' => '0.468127727509',
                    'mean' => '-4.50398913626',
                    'std' => '0.105748789386',

                ],
                [
                    'date' => '2023-07-01',
                    'minimum' => '-4.58776140213',
                    'maximum' => '-4.2489938736',
                    'range' => '0.338767528534',
                    'mean' => '-4.40154316402',
                    'std' => '0.0885533592051',
                ],
                [
                    'date' => '2023-09-01',
                    'minimum' => '-4.03067064285',
                    'maximum' => '-3.66379380226',
                    'range' => '0.366876840591',
                    'mean' => '-3.83696694657',
                    'std' => '0.0969759287114',
                ],
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByRange(0.3, 0.6)
                ->get()
        );
    }

    public function testFilterByMean(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $palmerDroughtSeverityIndex = new PalmerDroughtSeverityIndex($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-09-01',
                    'minimum' => '-4.03067064285',
                    'maximum' => '-3.66379380226',
                    'range' => '0.366876840591',
                    'mean' => '-3.83696694657',
                    'std' => '0.0969759287114',
                ],
                [
                    'date' => '2023-12-01',
                    'minimum' => '-2.41497445107',
                    'maximum' => '-2.30563569069',
                    'range' => '0.109338760376',
                    'mean' => '-2.3549714836',
                    'std' => '0.0271261757438',
                ],
                [
                    'date' => '2024-01-01',
                    'minimum' => '-2.16691803932',
                    'maximum' => '-2.03200626373',
                    'range' => '0.134911775589',
                    'mean' => '-2.08929791781',
                    'std' => '0.035531340147',
                ],
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByMean(-4.0, -2.0)
                ->get()
        );
    }

    public function testFilterByStd(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $palmerDroughtSeverityIndex = new PalmerDroughtSeverityIndex($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-11-01',
                    'minimum' => '-1.51545977592',
                    'maximum' => '-1.37347519398',
                    'range' => '0.141984581947',
                    'mean' => '-1.43936434713',
                    'std' => '0.0378179140969',
                ],
                [
                    'date' => '2023-12-01',
                    'minimum' => '-2.41497445107',
                    'maximum' => '-2.30563569069',
                    'range' => '0.109338760376',
                    'mean' => '-2.3549714836',
                    'std' => '0.0271261757438',
                ],
                [
                    'date' => '2024-01-01',
                    'minimum' => '-2.16691803932',
                    'maximum' => '-2.03200626373',
                    'range' => '0.134911775589',
                    'mean' => '-2.08929791781',
                    'std' => '0.035531340147',
                ],
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByStd(0.02, 0.039)
                ->get()
        );
    }
}
