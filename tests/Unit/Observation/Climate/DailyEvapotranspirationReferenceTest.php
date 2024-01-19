<?php

namespace Tlab\Tests\Observation\Climate;

use League\Csv\Reader;
use PHPUnit\Framework\TestCase;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\Observation\Climate\DailyEvapotranspirationReference;

class DailyEvapotranspirationReferenceTest extends TestCase
{
    public function testFilterByDate(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/et0-0206-castro-verde.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $dailyEvapotranspirationReference = new DailyEvapotranspirationReference($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2024-01-05',
                    'minimum' => '1.307999',
                    'maximum' => '1.379989',
                    'range' => '0.071988',
                    'mean' => '1.35149',
                    'std' => '0.019456',
                ],
                [
                    'date' => '2024-01-06',
                    'minimum' => '0.995235',
                    'maximum' => '1.06999',
                    'range' => '0.074752',
                    'mean' => '1.03547',
                    'std' => '0.019505',
                ],
            ],
            $dailyEvapotranspirationReference->from('beja', 'castro-verde', '0206')
                ->filterByDate('2024-01-05', '2024-01-06')
                ->get()
        );
    }

    public function testFilterByMinimum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/et0-0206-castro-verde.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $dailyEvapotranspirationReference = new DailyEvapotranspirationReference($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-11-01',
                    'minimum' => '2.01125',
                    'maximum' => '2.55988',
                    'range' => '0.548632',
                    'mean' => '2.27431',
                    'std' => '0.141111',
                ],
                [
                    'date' => '2023-11-02',
                    'minimum' => '2.04081',
                    'maximum' => '2.174079',
                    'range' => '0.133267',
                    'mean' => '2.08954',
                    'std' => '0.029659',
                ],
            ],
            $dailyEvapotranspirationReference->from('beja', 'castro-verde', '0206')
                ->filterByMinimum(2.0, 2.1)
                ->get()
        );
    }

    public function testFilterByMaximum(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/et0-0206-castro-verde.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $dailyEvapotranspirationReference = new DailyEvapotranspirationReference($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-10-24',
                    'minimum' => '2.1273',
                    'maximum' => '2.259959',
                    'range' => '0.132668',
                    'mean' => '2.183959',
                    'std' => '0.032287',
                ],
                [
                    'date' => '2023-10-27',
                    'minimum' => '2.20735',
                    'maximum' => '2.297669',
                    'range' => '0.090318',
                    'mean' => '2.247299',
                    'std' => '0.017705',
                ],
                [
                    'date' => '2023-11-02',
                    'minimum' => '2.04081',
                    'maximum' => '2.174079',
                    'range' => '0.133267',
                    'mean' => '2.08954',
                    'std' => '0.029659',
                ],
            ],
            $dailyEvapotranspirationReference->from('beja', 'castro-verde', '0206')
                ->filterByMaximum(2.0, 2.3)
                ->get()
        );
    }

    public function testFilterByRange(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/et0-0206-castro-verde.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $dailyEvapotranspirationReference = new DailyEvapotranspirationReference($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-11-05',
                    'minimum' => '1.700009',
                    'maximum' => '1.816879',
                    'range' => '0.116865',
                    'mean' => '1.7453',
                    'std' => '0.02706',
                ],
                [
                    'date' => '2023-11-06',
                    'minimum' => '1.64918',
                    'maximum' => '1.759989',
                    'range' => '0.110809',
                    'mean' => '1.729349',
                    'std' => '0.028579',
                ],
                [
                    'date' => '2023-11-15',
                    'minimum' => '1.509539',
                    'maximum' => '1.629369',
                    'range' => '0.119827',
                    'mean' => '1.585549',
                    'std' => '0.024878',
                ],
                [
                    'date' => '2023-12-19',
                    'minimum' => '0.989111',
                    'maximum' => '1.10097',
                    'range' => '0.111856',
                    'mean' => '1.05302',
                    'std' => '0.020473',
                ],
                [
                    'date' => '2024-01-15',
                    'minimum' => '1.021909',
                    'maximum' => '1.139889',
                    'range' => '0.117987',
                    'mean' => '1.06929',
                    'std' => '0.025242',
                ],
            ],
            $dailyEvapotranspirationReference->from('beja', 'castro-verde', '0206')
                ->filterByRange(0.11, 0.12)
                ->get()
        );
    }

    public function testFilterByMean(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/et0-0206-castro-verde.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $dailyEvapotranspirationReference = new DailyEvapotranspirationReference($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-11-17',
                    'minimum' => '1.01011',
                    'maximum' => '1.277169',
                    'range' => '0.267064',
                    'mean' => '1.189679',
                    'std' => '0.066482',
                ],
                [
                    'date' => '2023-12-03',
                    'minimum' => '1.14293',
                    'maximum' => '1.20999',
                    'range' => '0.067058',
                    'mean' => '1.17891',
                    'std' => '0.016842',

                ],
                [
                    'date' => '2023-12-17',
                    'minimum' => '1.10139',
                    'maximum' => '1.228659',
                    'range' => '0.127271',
                    'mean' => '1.162799',
                    'std' => '0.024145',
                ],
                [
                    'date' => '2023-12-22',
                    'minimum' => '1.05007',
                    'maximum' => '1.26627',
                    'range' => '0.216196',
                    'mean' => '1.18145',
                    'std' => '0.05134',
                ],
                [
                    'date' => '2024-01-13',
                    'minimum' => '1.070039',
                    'maximum' => '1.298359',
                    'range' => '0.228318',
                    'mean' => '1.188339',
                    'std' => '0.059815',
                ],
            ],
            $dailyEvapotranspirationReference->from('beja', 'castro-verde', '0206')
                ->filterByMean(1.15, 1.19)
                ->get()
        );
    }

    public function testFilterByStd(): void
    {
        $apiConnectorMock = $this->createMock(ApiConnector::class);
        $contents = file_get_contents(dirname(__DIR__, 3) . '/Data/Observation/Climate/et0-0206-castro-verde.csv');
        $reader = Reader::createFromString($contents);

        $apiConnectorMock->expects(self::once())
            ->method('fetchCsv')
            ->willReturn($reader);
        $dailyEvapotranspirationReference = new DailyEvapotranspirationReference($apiConnectorMock);

        self::assertEquals(
            [
                [
                    'date' => '2023-10-27',
                    'minimum' => '2.20735',
                    'maximum' => '2.297669',
                    'range' => '0.090318',
                    'mean' => '2.247299',
                    'std' => '0.017705',
                ],
                [
                    'date' => '2023-11-10',
                    'minimum' => '1.19113',
                    'maximum' => '1.284469',
                    'range' => '0.093344',
                    'mean' => '1.230029',
                    'std' => '0.017591',

                ],
                [
                    'date' => '2023-12-23',
                    'minimum' => '0.970022',
                    'maximum' => '1.043699',
                    'range' => '0.073678',
                    'mean' => '1.01232',
                    'std' => '0.017406',
                ],
                [
                    'date' => '2023-12-25',
                    'minimum' => '0.831393',
                    'maximum' => '0.899985',
                    'range' => '0.068591',
                    'mean' => '0.863502',
                    'std' => '0.01747',
                ],
                [
                    'date' => '2024-01-16',
                    'minimum' => '1.58044',
                    'maximum' => '1.667569',
                    'range' => '0.087137',
                    'mean' => '1.628859',
                    'std' => '0.017899',
                ],
            ],
            $dailyEvapotranspirationReference->from('beja', 'castro-verde', '0206')
                ->filterByStd(0.017, 0.018)
                ->get()
        );
    }
}
