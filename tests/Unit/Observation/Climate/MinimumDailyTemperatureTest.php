<?php

namespace Tlab\Tests\Observation\Climate;

use League\Csv\Reader;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Observation\Climate\MinimumDailyTemperature;
use PHPUnit\Framework\TestCase;

class MinimumDailyTemperatureTest extends TestCase
{
    public function testFilterByDate(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2024-01-05',
                    'minimum' => '-1.19934260845',
                    'maximum' => '3.26835560799',
                    'range' => '4.46769821644',
                    'mean' => '0.202687019513',
                    'std' => '1.24470596371',
                ],
                [
                    'date' => '2024-01-06',
                    'minimum' => '-2.19961476326',
                    'maximum' => '0.766418814659',
                    'range' => '2.96603357792',
                    'mean' => '-1.37621658617',
                    'std' => '0.764082844939',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByDate('2024-01-05', '2024-01-06')
                ->get()
        );
    }

    public function testFilterByMinimum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-17',
                    'minimum' => '-0.842209815979',
                    'maximum' => '7.69876003265',
                    'range' => '8.54096984863',
                    'mean' => '4.93448976606',
                    'std' => '2.44411959239',
                ],
                [
                    'date' => '2023-12-25',
                    'minimum' => '-0.59434825182',
                    'maximum' => '4.99922657013',
                    'range' => '5.59357482195',
                    'mean' => '3.27065864073',
                    'std' => '1.54565779116',
                ],
                [
                    'date' => '2024-01-21',
                    'minimum' => '-0.780147433281',
                    'maximum' => '3.59939670563',
                    'range' => '4.37954413891',
                    'mean' => '2.22693876209',
                    'std' => '1.22269821553',
                ],
                [
                    'date' => '2024-03-06',
                    'minimum' => '-0.999750912189',
                    'maximum' => '0.202023014426',
                    'range' => '1.20177392662',
                    'mean' => '-0.571624845325',
                    'std' => '0.3700016954',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByMinimum(-1.0, -0.5)
                ->get()
        );
    }

    public function testFilterByMaximum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2024-01-06',
                    'minimum' => '-2.19961476326',
                    'maximum' => '0.766418814659',
                    'range' => '2.96603357792',
                    'mean' => '-1.37621658617',
                    'std' => '0.764082844939',
                ],
                [
                    'date' => '2024-01-07',
                    'minimum' => '-1.4928381443',
                    'maximum' => '0.49975207448',
                    'range' => '1.99259021878',
                    'mean' => '-0.102014378158',
                    'std' => '0.541604072502',
                ],
                [
                    'date' => '2024-03-06',
                    'minimum' => '-0.999750912189',
                    'maximum' => '0.202023014426',
                    'range' => '1.20177392662',
                    'mean' => '-0.571624845325',
                    'std' => '0.3700016954',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByMaximum(0.0, 1.0)
                ->get()
        );
    }

    public function testFilterByRange(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-17',
                    'minimum' => '-0.842209815979',
                    'maximum' => '7.69876003265',
                    'range' => '8.54096984863',
                    'mean' => '4.93448976606',
                    'std' => '2.44411959239',
                ],
                [
                    'date' => '2023-12-18',
                    'minimum' => '-2.09342336655',
                    'maximum' => '5.39896917343',
                    'range' => '7.49239253998',
                    'mean' => '3.12610347041',
                    'std' => '2.05820420621',
                ],
                [
                    'date' => '2023-12-19',
                    'minimum' => '-2.76048731804',
                    'maximum' => '6.19880580902',
                    'range' => '8.95929312706',
                    'mean' => '3.5104279222',
                    'std' => '2.4183470177',
                ],
                [
                    'date' => '2024-02-26',
                    'minimum' => '-2.0989048481',
                    'maximum' => '5.76479959488',
                    'range' => '7.86370444298',
                    'mean' => '0.295006914414',
                    'std' => '2.14372116446',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByRange(7.0, 9.0)
                ->get()
        );
    }

    public function testFilterByMean(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-12',
                    'minimum' => '4.0008020401',
                    'maximum' => '9.54661846161',
                    'range' => '5.54581642151',
                    'mean' => '5.71145947377',
                    'std' => '1.52442251473',
                ],
                [
                    'date' => '2023-12-29',
                    'minimum' => '5.60016775131',
                    'maximum' => '6.66608476639',
                    'range' => '1.06591701508',
                    'mean' => '5.91936833461',
                    'std' => '0.284475635992',
                ],
                [
                    'date' => '2024-02-05',
                    'minimum' => '3.63723397255',
                    'maximum' => '6.49969005585',
                    'range' => '2.8624560833',
                    'mean' => '5.69770616293',
                    'std' => '0.738864509692',
                ],
                [
                    'date' => '2024-02-12',
                    'minimum' => '5.20031833649',
                    'maximum' => '6.86643648148',
                    'range' => '1.66611814499',
                    'mean' => '5.76056379875',
                    'std' => '0.488563922725',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByMean(5.5, 6.0)
                ->get()
        );
    }

    public function testFilterByStd(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnectorInterface::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtnmn-0908-manteigas.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $minimumDailyTemperature = new MinimumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-18',
                    'minimum' => '-2.09342336655',
                    'maximum' => '5.39896917343',
                    'range' => '7.49239253998',
                    'mean' => '3.12610347041',
                    'std' => '2.05820420621',
                ],
                [
                    'date' => '2024-02-09',
                    'minimum' => '1.10089325905',
                    'maximum' => '7.46362304688',
                    'range' => '6.36272978783',
                    'mean' => '3.02633042733',
                    'std' => '1.72573453086',
                ],
                [
                    'date' => '2024-02-26',
                    'minimum' => '-2.0989048481',
                    'maximum' => '5.76479959488',
                    'range' => '7.86370444298',
                    'mean' => '0.295006914414',
                    'std' => '2.14372116446',
                ],
            ],
            $minimumDailyTemperature->from('guarda', 'manteigas', '0908')
                ->filterByStd(1.7, 2.4)
                ->get()
        );
    }
}
