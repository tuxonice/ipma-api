<?php

namespace Tlab\Tests\Observation\Climate;

use League\Csv\Reader;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Observation\Climate\PalmerDroughtSeverityIndex;

class PalmerDroughtSeverityIndexTest extends TestCase
{
    public function testFilterByDate(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::fromString($contents);

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
                ->filterByDate('2023-04-01', '2023-05-01')
                ->get()
        );
    }

    public function testFilterByMinimum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::fromString($contents);

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
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByMinimum(-1.1, -1.0)
                ->get()
        );
    }

    public function testFilterByMaximum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::fromString($contents);

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
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByMaximum(-3.7, -3.6)
                ->get()
        );
    }

    public function testFilterByRange(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::fromString($contents);

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
                [
                    'date' => '2023-06-01',
                    'minimum' => '-4.84110927582',
                    'maximum' => '-4.08193922043',
                    'range' => '0.759170055389',
                    'mean' => '-4.42997776164',
                    'std' => '0.196044223288',
                ],
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByRange(0.4, 0.8)
                ->get()
        );
    }

    public function testFilterByMean(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::fromString($contents);

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
                ->filterByMean(-1.5, -1.0)
                ->get()
        );
    }

    public function testFilterByStd(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mpdsi-0804-castro-marim.csv');
        $reader = Reader::fromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $palmerDroughtSeverityIndex = new PalmerDroughtSeverityIndex($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-05-01',
                    'minimum' => '-4.90404748917',
                    'maximum' => '-4.17447328568',
                    'range' => '0.729574203491',
                    'mean' => '-4.51484062019',
                    'std' => '0.188053237399',
                ],
                [
                    'date' => '2023-06-01',
                    'minimum' => '-4.84110927582',
                    'maximum' => '-4.08193922043',
                    'range' => '0.759170055389',
                    'mean' => '-4.42997776164',
                    'std' => '0.196044223288',
                ],
            ],
            $palmerDroughtSeverityIndex->from('faro', 'castro-marim', '0804')
                ->filterByStd(0.18, 0.2)
                ->get()
        );
    }
}
