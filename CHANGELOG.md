# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- **Typed DTOs** under `Tlab\IpmaApi\Dto\` for every endpoint response. All
  `get()` calls now return `list<Dto>` and every `find*LocationByNearDistance()`
  returns `?Dto` instead of an array. Each DTO exposes `toArray()` (via
  `Tlab\IpmaApi\Dto\ToArrayTrait`) for round-tripping to arrays. Shared
  `Dto\Climate\ClimateObservation` covers all five climate CSV endpoints.
- `Tlab\IpmaApi\Endpoints` — central catalog of all IPMA open-data endpoints.
- `Tlab\IpmaApi\CachedApiConnector` — PSR-16 caching decorator for `ApiConnectorInterface`
  (caches `fetchData()` responses; `fetchCsv()` is passed through).
- Domain exception hierarchy under `Tlab\IpmaApi\Exception\`:
  `IpmaApiException` (base), `IpmaTransportException`, `IpmaResponseException`,
  `IpmaDecodingException`. `ApiConnector` now wraps Symfony HTTP client exceptions
  into these.
- `ApiConnector::__construct()` accepts an optional `HttpClientInterface` for
  injection and reuse across calls.
- `IpmaForecast`, `IpmaService`, `IpmaObservation` factory methods accept an
  optional `ApiConnectorInterface`; when omitted a single shared default instance
  is reused.
- Coverage gate in CI (`bin/check-coverage.php`) enforcing a minimum line
  coverage threshold against a Clover report.
- `psr/simple-cache` added as a runtime dependency.

### Changed
- **BC:** Every endpoint's `get()` now returns `list<Dto>` instead of
  `array<array-key, mixed>`. Array-based consumers should either switch to DTO
  property access (e.g. `$event->magnitude`) or call `$event->toArray()` to keep
  the old shape.
- **BC:** `findLocationByNearDistance()` / `filterLocationByNearDistance()`
  now return `?Dto` (null when no data) instead of `array` / `[]`.
- PHPStan analysis bumped from level 5 to level 8 (no iterable-value
  suppressions — typed DTOs cover it).
- `Utils::compareString()` now uses `mb_strtolower` so accented Portuguese
  characters compare correctly.
- README PHP requirement corrected to match `composer.json` (`^8.1`) and the
  CI matrix (8.1–8.4).
- `ApiConnectorInterface` now documents a single `@throws IpmaApiException`
  instead of leaking Symfony contracts.

### Fixed
- `ApiConnector::fetchData()` missing `@throws` annotations on the PHPDoc.

### Notes
- **Breaking for direct exception handlers:** code that previously caught
  `Symfony\Contracts\HttpClient\Exception\*` from `fetchData()`/`fetchCsv()`
  must now catch `Tlab\IpmaApi\Exception\IpmaApiException` (or a subclass).
  The original Symfony exception is available via `Throwable::getPrevious()`.
- **Breaking return types:** the DTO migration changes every endpoint's public
  signatures. Consumers should migrate to property access or call `toArray()`
  on DTOs to restore the old array shape:
  ```php
  $events = $api->get();                    // list<SeismicEvent>
  $first = $events[0];
  $mag = $first->magnitude;                 // typed access
  $legacy = $first->toArray();              // same shape as before
  ```
