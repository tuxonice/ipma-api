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

> **Heads up — breaking change:** every factory now **requires** a PSR-16
> `Psr\SimpleCache\CacheInterface`. This is intentional: IPMA asks consumers
> not to hammer their endpoints, and most of them change infrequently
> (locations, stations, forecasts). See [Caching responses (PSR-16)](#caching-responses-psr-16)
> below for setup.

Here are a few examples of how to use this package. All snippets assume
`$cache` is a `Psr\SimpleCache\CacheInterface` instance (e.g. a
`Symfony\Component\Cache\Psr16Cache` backed by any PSR-6 adapter).

### Get Daily Weather Forecast

```php
use Tlab\IpmaApi\IpmaForecast;

$api = IpmaForecast::createDailyWeatherForecastByLocalApi($cache);
$result = $api->from(1020500) // Location ID for Beja
              ->filterByMaxTemperatureRange(18.0, 19.0)
              ->get();
```

### Get Seismic Information

```php
use Tlab\IpmaApi\IpmaObservation;
use Tlab\IpmaApi\Enums\SeismicInformationAreaEnum;

$api = IpmaObservation::createSeismicInformationApi($cache);
$events = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
              ->get();
```

### Get Weather Stations (Service)

```php
use Tlab\IpmaApi\IpmaService;

$api = IpmaService::createWeatherStationsApi($cache);
$stations = $api->filterByName('Lisboa', strict: false)->get();
```

All endpoints now return **typed DTOs** under `Tlab\IpmaApi\Dto\*`:

```php
use Tlab\IpmaApi\Enums\SeismicInformationAreaEnum;
use Tlab\IpmaApi\IpmaObservation;

$events = IpmaObservation::createSeismicInformationApi($cache)
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

IPMA asks consumers to avoid hitting their endpoints too often. To enforce
this, a PSR-16 `Psr\SimpleCache\CacheInterface` is **required** by every
factory and by `ApiConnector` itself — there is no unbounded-request mode.

Any PSR-16 implementation works. Using `symfony/cache` as an example:

```php
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tlab\IpmaApi\IpmaService;

$cache = new Psr16Cache(new FilesystemAdapter());

// Share the same $cache instance across every factory call:
$locations = IpmaService::createDistrictsIslandsLocationsApi($cache);
$stations  = IpmaService::createWeatherStationsApi($cache, ttlSeconds: 86400);
```

Every factory accepts an optional `int $ttlSeconds = 3600` as its second
argument. You can also construct the connector directly:

```php
use Tlab\IpmaApi\ApiConnector;

$connector = new ApiConnector($cache, ttlSeconds: 3600);
```

Only JSON responses (`fetchData`) are cached; CSV responses (`fetchCsv`) are
passed through because `League\Csv\Reader` cannot be reliably serialised.
Cache keys are namespaced as `ipma_api.<sha256(url)>`.

### Migrating from previous versions

- `Tlab\IpmaApi\CachedApiConnector` has been **removed**. Its caching
  behaviour is now built into `ApiConnector`.
- `new ApiConnector()` (no arguments) no longer works: you must pass a
  `CacheInterface`.
- `IpmaForecast::create*Api()`, `IpmaObservation::create*Api()` and
  `IpmaService::create*Api()` no longer accept an `ApiConnectorInterface`;
  they take `(CacheInterface $cache, int $ttlSeconds = 3600)` instead.
- The shared lazy default `ApiConnector` singleton inside the facades has
  been removed. Instantiate and share your own `$cache` (and therefore your
  own connectors) at the composition root.

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
    $data = IpmaForecast::createDailyWeatherForecastByLocalApi($cache)->from(1020500)->get();
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
