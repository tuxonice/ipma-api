# IPMA-API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tuxonice/ipma-api.svg?style=flat-square)](https://packagist.org/packages/tuxonice/ipma-api)
[![GitHub Tests Action Status](https://github.com/tuxonice/ipma-api/actions/workflows/pipeline.yml/badge.svg?branch=main)](https://github.com/tuxonice/ipma-api/actions)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat-square)](phpstan.neon)
[![Total Downloads](https://img.shields.io/packagist/dt/tuxonice/ipma-api.svg?style=flat-square)](https://packagist.org/packages/tuxonice/ipma-api)
[![License](https://img.shields.io/packagist/l/tuxonice/ipma-api.svg?style=flat-square)](https://packagist.org/packages/tuxonice/ipma-api)

This PHP package provides an easy-to-use interface for the IPMA (Instituto Português do Mar e da Atmosfera, I. P.) API. It allows you to fetch weather forecasts, observation data, and other auxiliary information directly into your PHP application.

For more information about the official API, please visit https://api.ipma.pt/ (only in Portuguese).

**Warning:** This is a work in progress package! While it is actively maintained, some features may be incomplete or subject to change.

## Getting Started

### Prerequisites

- PHP 8.1 or higher
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

### Get Weather Stations (Service)

```php
use Tlab\IpmaApi\IpmaService;

$api = IpmaService::createWeatherStationsApi();
$stations = $api->filterByName('Lisboa', strict: false)->get();
```

All endpoints now return **typed DTOs** under `Tlab\IpmaApi\Dto\*`:

```php
use Tlab\IpmaApi\Enums\SeismicInformationAreaEnum;
use Tlab\IpmaApi\IpmaObservation;

$events = IpmaObservation::createSeismicInformationApi()
    ->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
    ->filterByMagnitude(2.0, 5.0)
    ->get();

foreach ($events as $event) {
    echo $event->regionName, ' -> ', $event->magnitude, "\n"; // typed access
}

// Call ->toArray() on any DTO to recover the old array shape.
$legacy = $events[0]->toArray();
```

For more detailed examples and a full list of available endpoints, please see the documentation folder.

---

## Caching responses (PSR-16)

Most IPMA endpoints change infrequently (locations, stations, forecasts). The
library ships with a PSR-16 caching decorator you can wrap around any
`ApiConnectorInterface`:

```php
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tlab\IpmaApi\ApiConnector;
use Tlab\IpmaApi\CachedApiConnector;
use Tlab\IpmaApi\IpmaService;

$cache = new Psr16Cache(new FilesystemAdapter());
$connector = new CachedApiConnector(new ApiConnector(), $cache, ttlSeconds: 3600);

// Pass the cached connector to any factory:
$api = IpmaService::createDistrictsIslandsLocationsApi($connector);
```

Only JSON responses (`fetchData`) are cached; CSV responses are passed through.

---

## Error handling

All errors raised by the library extend `Tlab\IpmaApi\Exception\IpmaApiException`:

- `IpmaTransportException` — network/TLS/timeout failures.
- `IpmaResponseException` — unexpected 3xx/4xx/5xx HTTP status.
- `IpmaDecodingException` — malformed JSON in the response body.

```php
use Tlab\IpmaApi\Exception\IpmaApiException;
use Tlab\IpmaApi\IpmaForecast;

try {
    $data = IpmaForecast::createDailyWeatherForecastByDayApi()->from(1020500)->get();
} catch (IpmaApiException $e) {
    // $e->getPrevious() returns the underlying Symfony exception, if any.
    error_log($e->getMessage());
}
```

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
