<?php

namespace Tlab\Tests\Observation\Climate;

use League\Csv\Reader;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Observation\Climate\MaximumDailyTemperature;
use PHPUnit\Framework\TestCase;

class MaximumDailyTemperatureTest extends TestCase
{
    public function testFilterByDate(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtxmx-0705-evora.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $maximumDailyTemperature = new MaximumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2024-01-05',
                    'minimum' => '11.6017684937',
                    'maximum' => '13.2800445557',
                    'range' => '1.67827606201',
                    'mean' => '12.3112091826',
                    'std' => '0.330223504884',
                ],
                [
                    'date' => '2024-01-06',
                    'minimum' => '10.9044961929',
                    'maximum' => '13.6778059006',
                    'range' => '2.77330970764',
                    'mean' => '12.3261002274',
                    'std' => '0.565485154943',
                ],
            ],
            $maximumDailyTemperature->from('evora', 'evora')
                ->filterByDate('2024-01-05', '2024-01-06')
                ->get()
        );
    }

    public function testFilterByMinimum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtxmx-0705-evora.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $maximumDailyTemperature = new MaximumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-26',
                    'minimum' => '7.70125579834',
                    'maximum' => '13.0285081863',
                    'range' => '5.327252388',
                    'mean' => '9.17962784124',
                    'std' => '1.21550569191',
                ],
                [
                    'date' => '2023-12-27',
                    'minimum' => '6.10160446167',
                    'maximum' => '9.27521705627',
                    'range' => '3.1736125946',
                    'mean' => '7.23507744505',
                    'std' => '0.742342138537',
                ],
            ],
            $maximumDailyTemperature->from('evora', 'evora')
                ->filterByMinimum(6.0, 8.0)
                ->get()
        );
    }

    public function testFilterByMaximum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtxmx-0705-evora.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $maximumDailyTemperature = new MaximumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2024-01-24',
                    'minimum' => '19.7382030487',
                    'maximum' => '23.735250473',
                    'range' => '3.99704742432',
                    'mean' => '21.322582393',
                    'std' => '0.641425269702',
                ],
                [
                    'date' => '2024-01-25',
                    'minimum' => '20.3589820862',
                    'maximum' => '24.6346511841',
                    'range' => '4.2756690979',
                    'mean' => '21.9526157074',
                    'std' => '0.662493788333',
                ],
                [
                    'date' => '2024-02-18',
                    'minimum' => '19.8648891449',
                    'maximum' => '22.562292099',
                    'range' => '2.6974029541',
                    'mean' => '20.8140866831',
                    'std' => '0.449723772497',
                ],
            ],
            $maximumDailyTemperature->from('evora', 'evora')
                ->filterByMaximum(22.5, 25.0)
                ->get()
        );
    }

    public function testFilterByRange(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtxmx-0705-evora.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $maximumDailyTemperature = new MaximumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-26',
                    'minimum' => '7.70125579834',
                    'maximum' => '13.0285081863',
                    'range' => '5.327252388',
                    'mean' => '9.17962784124',
                    'std' => '1.21550569191',
                ],
                [
                    'date' => '2023-12-30',
                    'minimum' => '11.9073467255',
                    'maximum' => '17.2577610016',
                    'range' => '5.35041427612',
                    'mean' => '15.1163066151',
                    'std' => '0.755823200975',
                ],
                [
                    'date' => '2023-12-31',
                    'minimum' => '12.2025785446',
                    'maximum' => '16.4561347961',
                    'range' => '4.25355625153',
                    'mean' => '13.6234763386',
                    'std' => '0.883116041592',
                ],
                [
                    'date' => '2024-01-25',
                    'minimum' => '20.3589820862',
                    'maximum' => '24.6346511841',
                    'range' => '4.2756690979',
                    'mean' => '21.9526157074',
                    'std' => '0.662493788333',
                ],
            ],
            $maximumDailyTemperature->from('evora', 'evora')
                ->filterByRange(4.2, 6.0)
                ->get()
        );
    }

    public function testFilterByMean(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtxmx-0705-evora.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $maximumDailyTemperature = new MaximumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-26',
                    'minimum' => '7.70125579834',
                    'maximum' => '13.0285081863',
                    'range' => '5.327252388',
                    'mean' => '9.17962784124',
                    'std' => '1.21550569191',
                ],
                [
                    'date' => '2023-12-27',
                    'minimum' => '6.10160446167',
                    'maximum' => '9.27521705627',
                    'range' => '3.1736125946',
                    'mean' => '7.23507744505',
                    'std' => '0.742342138537',
                ],
                [
                    'date' => '2024-01-08',
                    'minimum' => '8.90138816833',
                    'maximum' => '11.3687086105',
                    'range' => '2.4673204422',
                    'mean' => '9.61686188014',
                    'std' => '0.482344708049',
                ],
            ],
            $maximumDailyTemperature->from('evora', 'evora')
                ->filterByMean(7.0, 10.0)
                ->get()
        );
    }

    public function testFilterByStd(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/mtxmx-0705-evora.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $maximumDailyTemperature = new MaximumDailyTemperature($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-12-27',
                    'minimum' => '6.10160446167',
                    'maximum' => '9.27521705627',
                    'range' => '3.1736125946',
                    'mean' => '7.23507744505',
                    'std' => '0.742342138537',
                ],
                [
                    'date' => '2023-12-28',
                    'minimum' => '12.6025724411',
                    'maximum' => '16.4615249634',
                    'range' => '3.85895252228',
                    'mean' => '13.8303683471',
                    'std' => '0.858262969771',
                ],
                [
                    'date' => '2023-12-30',
                    'minimum' => '11.9073467255',
                    'maximum' => '17.2577610016',
                    'range' => '5.35041427612',
                    'mean' => '15.1163066151',
                    'std' => '0.755823200975',
                ],
                [
                    'date' => '2023-12-31',
                    'minimum' => '12.2025785446',
                    'maximum' => '16.4561347961',
                    'range' => '4.25355625153',
                    'mean' => '13.6234763386',
                    'std' => '0.883116041592',
                ],
            ],
            $maximumDailyTemperature->from('evora', 'evora')
                ->filterByStd(0.7, 1.0)
                ->get()
        );
    }
}
