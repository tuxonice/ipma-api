<?php

declare(strict_types=1);

namespace Tlab\IpmaApi;

/**
 * Central catalog of IPMA open-data endpoints.
 *
 * Keeping every URL in a single place makes the library easier to audit,
 * simplifies upstream URL changes, and leaves the door open for a future
 * configurable base URL (staging, mirrors, offline snapshots).
 *
 * Placeholders enclosed in curly braces (e.g. {idDay}, {DICO}) are resolved
 * at request time by the corresponding endpoint class.
 */
final class Endpoints
{
    public const BASE_URL = 'https://api.ipma.pt/open-data';

    // Service
    public const DISTRICTS_ISLANDS_LOCATIONS = self::BASE_URL . '/distrits-islands.json';
    public const SEA_LOCATIONS               = self::BASE_URL . '/sea-locations.json';
    public const WEATHER_STATIONS            = self::BASE_URL . '/observation/meteorology/stations/stations.json';

    // Observation
    public const SEISMIC_INFORMATION              = self::BASE_URL . '/observation/seismic/{idArea}.json';
    public const MOLLUSC_HARVESTING_PROHIBITION   = self::BASE_URL . '/observation/biology/bivalves/CI_SNMB.geojson';
    public const WEATHER_STATION_OBSERVATION      = self::BASE_URL . '/observation/meteorology/stations/observations.json';
    public const WEATHER_STATION_OBSERVATION_BY_HOUR
        = self::BASE_URL . '/observation/meteorology/stations/obs-surface.geojson';

    // Observation - climate (CSV)
    public const MAXIMUM_DAILY_TEMPERATURE
        = self::BASE_URL . '/observation/climate/temperature-max/{district}/mtxmn-{DICO}-{municipality}.csv';
    public const MINIMUM_DAILY_TEMPERATURE
        = self::BASE_URL . '/observation/climate/temperature-min/{district}/mtxmn-{DICO}-{municipality}.csv';
    public const TOTAL_DAILY_PRECIPITATION
        = self::BASE_URL . '/observation/climate/precipitation-total/{district}/mrrto-{DICO}-{municipality}.csv';
    public const DAILY_EVAPOTRANSPIRATION_REFERENCE
        = self::BASE_URL . '/observation/climate/evapotranspiration/{district}/et0-{DICO}-{municipality}.csv';
    public const PALMER_DROUGHT_SEVERITY_INDEX
        = self::BASE_URL . '/observation/climate/mpdsi/{district}/mpdsi-{DICO}-{municipality}.csv';

    // Forecast
    public const DAILY_WEATHER_FORECAST_BY_DAY
        = self::BASE_URL . '/forecast/meteorology/cities/daily/hp-daily-forecast-day{idDay}.json';
    public const DAILY_WEATHER_FORECAST_BY_LOCATION
        = self::BASE_URL . '/forecast/meteorology/cities/daily/{globalIdLocal}.json';
    public const FIRE_RISK_FORECAST        = self::BASE_URL . '/forecast/meteorology/rcm/rcm-d{idDay}.json';
    public const ULTRAVIOLET_RISK_FORECAST = self::BASE_URL . '/forecast/meteorology/uv/uv.json';
    public const SEA_STATE_FORECAST
        = self::BASE_URL . '/forecast/oceanography/daily/hp-daily-sea-forecast-day{idDay}.json';
    public const WEATHER_WARNINGS          = self::BASE_URL . '/forecast/warnings/warnings_www.json';
}
