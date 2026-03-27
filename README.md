# IPMA-API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tuxonice/ipma-api.svg?style=flat-square)](https://packagist.org/packages/tuxonice/ipma-api)
[![GitHub Tests Action Status](https://github.com/tuxonice/ipma-api/actions/workflows/pipeline.yml/badge.svg?branch=main)](https://github.com/tuxonice/ipma-api/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/tuxonice/ipma-api.svg?style=flat-square)](https://packagist.org/packages/tuxonice/ipma-api)
[![License](https://img.shields.io/packagist/l/tuxonice/ipma-api.svg?style=flat-square)](https://packagist.org/packages/tuxonice/ipma-api)

This PHP package provides an easy-to-use interface for the IPMA (Instituto Português do Mar e da Atmosfera, I. P.) API. It allows you to fetch weather forecasts, observation data, and other auxiliary information directly into your PHP application.

For more information about the official API, please visit https://api.ipma.pt/ (only in Portuguese).

**Warning:** This is a work in progress package! While it is actively maintained, some features may be incomplete or subject to change.

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer

### Installation

`composer require tuxonice/ipma-api`

---

## Usage

Here are a few examples of how to use this package.

### Get Daily Weather Forecast

```php
use Tlab\IpmaApi\IpmaForecast;

$api = IpmaForecast::createDailyWeatherForecastByDayApi();
$result = $api->from(1020500) // Location ID for Beja
              ->filterByMaxTemperatureRange(18.0, 19.0)
              ->get();
```

### Get Seismic Information

```php
use Tlab\IpmaApi\IpmaService;
use Tlab\IpmaApi\Enums\SeismicInformationAreaEnum;

$api = IpmaService::createSeismicInformationApi();
$events = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
              ->get();
```

For more detailed examples and a full list of available endpoints, please see the documentation folder.

---

## Running Tests

This project uses PHPUnit for testing. To run the test suite, you can use the provided Makefile command:

```bash
make test
```

To generate a code coverage report, run:

```bash
make coverage
```

The report will be generated in the `coverage/` directory.

---

## Contributing

Contributions are welcome! If you would like to contribute to this project, please follow these steps:

1.  Fork the repository.
2.  Create a new branch for your feature or bug fix.
3.  Make your changes and commit them with a descriptive message.
4.  Push your changes to your fork.
5.  Submit a pull request to the main repository.

Please ensure that your code follows the existing coding style and that all tests pass before submitting a pull request.
