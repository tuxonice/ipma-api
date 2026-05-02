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
- Domain exception hierarchy under `Tlab\IpmaApi\Exception\`:
  `IpmaApiException` (base), `IpmaTransportException`, `IpmaResponseException`,
  `IpmaDecodingException`. `ApiConnector` now wraps Symfony HTTP client exceptions
  into these.
- `ApiConnector::__construct()` accepts an optional `HttpClientInterface` for
  injection and reuse across calls.
- Coverage gate in CI (`bin/check-coverage.php`) enforcing a minimum line
  coverage threshold against a Clover report.
- `psr/simple-cache` added as a runtime dependency — a PSR-16 cache is now
  **required** to use the library (see *Changed* / *Removed* below).

### Changed
- **BC:** Caching is now mandatory. `ApiConnector::__construct()` takes a
  required `Psr\SimpleCache\CacheInterface $cache` as its first argument
  (followed by `int $ttlSeconds = 3600`, `string $keyPrefix = 'ipma_api.',
  and an optional `HttpClientInterface`). Caching is built in and applied to
  both JSON (`fetchData()`) and CSV (`fetchCsv()`) responses — the raw CSV
  string is stored and reconstructed as a `Reader` on hit. Cache keys are
  `ipma_api.<sha256(url)>`. This change is deliberate to protect IPMA's
  open-data endpoints from excessive traffic.
- **BC:** `IpmaForecast::create*Api()`, `IpmaObservation::create*Api()` and
  `IpmaService::create*Api()` no longer accept an
  `?ApiConnectorInterface $apiConnector = null`. Their new signature is
  `(CacheInterface $cache, int $ttlSeconds = 3600)`. Each call instantiates
  a fresh `ApiConnector` wired to the provided cache; the previous shared
  lazy default `ApiConnector` singleton has been removed.
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

### Removed
- **BC:** `Tlab\IpmaApi\CachedApiConnector` has been removed. Its behaviour
  was folded into `ApiConnector` itself — pass your PSR-16 cache directly
  to `new ApiConnector($cache, $ttlSeconds)` (or to the facade factories).
- **BC:** The parameterless `new ApiConnector()` constructor is gone; a
  `CacheInterface` is now required.

### Fixed
- `ApiConnector::fetchData()` missing `@throws` annotations on the PHPDoc.

### Notes
- **Major breaking release.** At minimum, every call site must now pass a
  PSR-16 `CacheInterface` to the facade factories (or to `ApiConnector`
  directly). See the *Migrating from previous versions* section of the
  README for the full rewrite pattern.
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
