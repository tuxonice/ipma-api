# IPMA-API

This PHP package is an interface for IPMA(Instituto Português do Mar e da Atmosfera, I. P.) API.

For more information check https://api.ipma.pt/ (only in Portuguese)

**Warning:** This is a work in progress package!

## Installation

`composer require tuxonice/ipma-api`

---

# API

## 1. Forecast

### 🌤️ 1.1 Meteorology

#### 1.1.1 Daily weather forecast up to 5 days aggregated by location
(_Previsão meteorológica diária até 5 dias agregada por local_)

> https://api.ipma.pt/open-data/forecast/meteorology/cities/daily/{globalIdLocal}.json

| Field             | Type    | Description           |
|-------------------|---------|-----------------------|
| forecastDate      | string  | Forecast date         |
| idWeatherType     | integer | Weather type code     |
| windSpeedClass    | integer | Wind speed class type |
| rainfallIntensity | integer | Rainfall intensity    |
| rainfallProb      | string  | Rainfall probability  |
| minTemp           | string  | Minimum temperature   |
| maxTemp           | string  | Maximum temperature   |
| winDir            | string  | Wind direction        |
| latitude          | string  | Latitude              |
| longitude         | string  | Longitude             |

```php
use Tlab\IpmaApi\IpmaForecast;

$api = IpmaForecast::createDailyWeatherForecastByDayApi();
$result = $api->from(1020500)
              ->filterByMaxTemperatureRange(18.0, 19.0)
              ->get();
```

```php
[
        [
            'forecastDate' => '2023-12-09',
            'idWeatherType' => 3,
            'windSpeedClass' => 1,
            'rainfallIntensity' => null,
            'rainfallProb' => 4.0,
            'minTemp' => 10.2,
            'maxTemp' => 18.2,
            'winDir' => 'W',
            'latitude' => 38.02,
            'longitude' => -7.87,
        ],
        [
            'forecastDate' => '2023-12-10',
            'idWeatherType' => 3,
            'windSpeedClass' => 1,
            'rainfallIntensity' => null,
            'rainfallProb' => 7.0,
            'minTemp' => 10.8,
            'maxTemp' => 18.3,
            'winDir' => 'SE',
            'latitude' => 38.02,
            'longitude' => -7.87,
        ],
],
```

#### 1.1.2 Daily weather forecast for up to 3 days, aggregated information per day
(_Previsão meteorológica diária até 3 dias, informação agregada por dia_)

> https://api.ipma.pt/open-data/forecast/meteorology/cities/daily/hp-daily-forecast-day{idDay}.json

| Field             | Type    | Description           |
|-------------------|---------|-----------------------|
| globalIdLocal     | integer | Local ID              |
| idWeatherType     | integer | Weather type code     |
| windSpeedClass    | integer | Wind speed class type |
| rainfallIntensity | integer | Rainfall intensity    |
| rainfallProb      | float   | Rainfall probability  |
| minTemp           | float   | Minimum temperature   |
| maxTemp           | float   | Maximum temperature   |
| winDir            | string  | Wind direction        |
| latitude          | float   | Latitude              |
| longitude         | float   | Longitude             |

```php
use Tlab\IpmaApi\Enums\ForecastDayEnum;
use Tlab\IpmaApi\IpmaForecast;

$api = IpmaForecast::createDailyWeatherForecastByDayApi();
$result = $api
            ->from(ForecastDayEnum::TODAY)
            ->filterByIdWeatherType(3)
            ->get();
```

```php
[
                [
                    'globalIdLocal' => 1020500,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 1.0,
                    'minTemp' => 11.0,
                    'maxTemp' => 18.0,
                    'winDir' => 'W',
                    'latitude' => 38.0200,
                    'longitude' => -7.8700,
                ],
                [
                    'globalIdLocal' => 1080500,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 1,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 0.0,
                    'minTemp' => 12.0,
                    'maxTemp' => 20.0,
                    'winDir' => 'SW',
                    'latitude' => 37.0146,
                    'longitude' => -7.9331,
                ],
                [
                    'globalIdLocal' => 1151300,
                    'idWeatherType' => 3,
                    'windSpeedClass' => 2,
                    'rainfallIntensity' => null,
                    'rainfallProb' => 27.0,
                    'minTemp' => 14.0,
                    'maxTemp' => 19.0,
                    'winDir' => 'SW',
                    'latitude' => 37.9560,
                    'longitude' => -8.8643,
                ],
            ]
```

#### 1.1.3 Fire risk forecast for up to 2 days, aggregated information per day

(_Previsão do risco de incêndio até 2 dias, informação agregada por dia_)

> https://api.ipma.pt/open-data/forecast/meteorology/rcm/rcm-d{idDay}.json

| Field         | Type    | Description                           |
|---------------|---------|---------------------------------------|
| forecastDate  | string  | Forecast date                         |
| runDate       | string  | Date of model run                     |
| fileUpdatedAt | string  | file update date (hourly update rate) |
| dico          | string  | Administrative Division code          |
| fireRiskLevel | integer | Fire risk level code                  |
| latitude      | float   | Latitude                              |
| longitude     | float   | Longitude                             |

Fire risk code

1 - Low risk
2 - Moderate risk
3 - High risk
4 - Very high risk
5 - Maximum risk

```php
use Tlab\IpmaApi\Enums\ForecastFireRiskDayEnum;
use Tlab\IpmaApi\Forecast\Meteorology\FireRiskForecast;

$api = IpmaForecast::createFireRiskForecastApi();
$result = $api
            ->from(ForecastFireRiskDayEnum::TODAY)
            ->filterByDico('1002')
            ->get()
```

```php
   [
        [
            'dico' => '1002',
            'fireRiskLevel' => 1,
            'latitude' => 39.8222,
            'longitude' => -8.3814,
        ],
    ],
```

#### 1.1.4 Ultraviolet risk forecast for up to 3 days (Ultraviolet Index)

(_Previsão do risco de ultravioletas até 3 dias (Índice Ultravioleta_)

> https://api.ipma.pt/open-data/forecast/meteorology/uv/uv.json

| Field         | Type    | Description                                        |
|---------------|---------|----------------------------------------------------|
| globalIdLocal | integer | Local ID                                           |
| forecastDate  | string  | Forecast date                                      |
| uvIndex       | float   | Ultraviolet index value  (see table below)         |
| timeInterval  | string  | Interval of hours relative to the maximum UV value |
| periodId      | integer | Internal period code                               |

| UV index | Description |
|----------|-------------|
| `>= 11`  | Extreme     |
| `>= 8`   | Very high   |
| `>= 6`   | High        |
| `>= 3`   | Moderate    |
| `>= 1`   | Low         |

```php
use Tlab\IpmaApi\IpmaForecast;

$api = IpmaForecast::createUltravioletRiskForecastApi();
$result = $api->filterByUvIndex(2.4, 2.4)
              ->get();
```

```php
[
        [
            'globalIdLocal' => 2320100,
            'forecastDate' => '2023-12-14',
            'uvIndex' => 2.4,
            'timeInterval' => '',
            'periodId' => 10,
        ],
],
```

### 🌊 1.2 Oceanography

#### 1.2.1 Sea state forecast for up to 3 days, aggregated information per day

(_Previsão do estado do mar até 3 dias, informação agregada por dia_))

> https://api.ipma.pt/open-data/forecast/oceanography/daily/hp-daily-sea-forecast-day{idDay}.json

| Field          | Type    | Description                                                                           |
|----------------|---------|---------------------------------------------------------------------------------------|
| forecastDate:  | string  | Date for which information is valid                                                   |
| dataUpdate:    | string  | File update date (hourly update rate)                                                 |
| globalIdLocal: | integer | Location identifier (see auxiliary service "List of identifiers for coastal regions") |
| wavePeriodMin: | float   | Daily minimum of the peak period, associated with the swell, in seconds               |
| wavePeriodMax: | float   | Daily maximum of the peak period, associated with the swell, in seconds               |
| waveHighMin:   | float   | Minimum daily swell height in meters                                                  |
| waveHighMax:   | float   | Maximum daily swell height in meters                                                  |
| predWaveDir:   | string  | Predominant wave direction (N, NE, E, SE, S, SW, W, NW)                               |
| totalSeaMin:   | float   | Minimum daily significant wave height in meters                                       |
| totalSeaMax:   | float   | Maximum daily significant wave height, in meters                                      |
| sstMin:        | float   | Daily minimum sea surface temperature in ºC                                           |
| sstMax:        | float   | Daily maximum sea surface temperature in ºC                                           |
| latitude:      | float   | Latitude                                                                              |
| longitude:     | float   | Longitude                                                                             |

Note: Only daily data is available. {idDay} ranges **from** 0 to 2, where:

- 0 - is the day equivalent to today
- 1 - tomorrow
- 2 - the day after tomorrow

```php
use Tlab\IpmaApi\Enums\SeaStateForecastDayEnum;
use Tlab\IpmaApi\IpmaForecast;

$api = IpmaForecast::createSeaStateForecastApi();
$result = $api->from(SeaStateForecastDayEnum::TODAY)
              ->filterByGlobalIdLocal(2320126)
              ->filterByWavePeriodMax(5.0,6.0)
              ->get();
```

```php
[
       [
            'wavePeriodMin' => '5.5',
            'globalIdLocal' => 2320126,
            'totalSeaMax' => 2.5,
            'waveHighMax' => '2.2',
            'waveHighMin' => '1.6',
            'longitude' => '-16.3400',
            'wavePeriodMax' => '5.7',
            'latitude' => '33.2500',
            'totalSeaMin' => 2.0,
            'sstMax' => '21.8',
            'predWaveDir' => 'NE',
            'sstMin' => '21.7',
       ],
],
```

### 🌀 1.3 Warnings

#### 1.3.1 Weather warnings for up to 3 days

(_Avisos meteorológicos até 3 dias_)

> https://api.ipma.pt/open-data/forecast/warnings/warnings_www.json

| Field             | Type     | Description                                                                                                                                          |
|-------------------|----------|------------------------------------------------------------------------------------------------------------------------------------------------------|
| text              | text     | Descriptive text of the warning (filled in only when the warning is yellow, orange or red)                                                           |
| awarenessTypeName | text     | Warning parameter (e.g. "Thunderstorm", "Rough Sea", "Precipitation", "Wind", "Fog", "Snow", "Cold Weather", "Hot Weather")                          |
| awarenessLevelID  | text     | Warning color/level (e.g. "green", "yellow", "orange", "red", there are only warnings for levels other than "green", i.e. "yellow", "orange", "red") |
| warningIdArea     | text     | Area identifier of the notices (see auxiliary service "List of identifiers for district capitals and islands")                                       |
| startTime         | datetime | Start date/time of the notice duration                                                                                                               |
| endTime           | datetime | End date/time of the notice duration                                                                                                                 |

```php
use Tlab\IpmaApi\IpmaService;

$warningsApi = IpmaService::createWarningsApi();
$result = $warningsApi->query()
    ->filterByWarningIdArea('BGC')
    ->filterByAwarenessTypeName('Nevoeiro')
    ->get();
```

```php
[
  [
    "text": "",
    "awarenessTypeName": "Agitação Marítima",
    "warningIdArea": "BGC",
    "startTime": "2021-03-25T07:25:00",
    "awarenessLevelID": "green",
    "endTime": "2021-03-28T07:00:00"
  ],
  [
    "text": "",
    "awarenessTypeName": "Nevoeiro",
    "warningIdArea": "BGC",
    "startTime": "2021-03-25T07:25:00",
    "awarenessLevelID": "green",
    "endTime": "2021-03-28T07:00:00"
  ]
]
```

## 2. Observation

### 🌐 2.1 Seismic

#### Seismic information, Arch. Azores, Main land and Arch. Madeira. Includes 30 days of information

(_Informação sismicidade, Arq. Açores, Continente e Arq. Madeira. Integra 30 dias de informação_)

> https://api.ipma.pt/open-data/observation/seismic/{idArea}.json

**Available Areas:**
- `SeismicInformationAreaEnum::AZORES` (3) - Azores Archipelago
- `SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA` (7) - Mainland Portugal and Madeira

**Response Fields:**

| Field         | Type   | Description                                      |
|---------------|--------|--------------------------------------------------|
| seismId       | string | Seismic event ID                                 |
| googleMapRef  | string | Google Maps reference URL                        |
| degree        | mixed  | Degree information                               |
| magType       | string | Magnitude type (e.g., 'L' for local magnitude)   |
| magnitude     | float  | Earthquake magnitude                             |
| depth         | int    | Depth in kilometers                              |
| tensorRef     | string | Tensor reference                                 |
| shakeMapId    | string | ShakeMap ID                                      |
| shakeMapRef   | string | ShakeMap reference URL                           |
| location      | mixed  | Location description                             |
| regionName    | string | Region name                                      |
| latitude      | float  | Latitude (decimal degrees)                       |
| longitude     | float  | Longitude (decimal degrees)                      |
| source        | string | Data source (e.g., 'IPMA')                       |
| sensed        | mixed  | Whether the event was felt                       |
| time          | string | Event time (ISO 8601 format)                     |
| updateDate    | string | Data update time (ISO 8601 format)               |

**Available Methods:**
- `from(SeismicInformationAreaEnum $area)` - Fetch seismic data for a specific area
- `filterByDepth(int $minValue, int $maxValue)` - Filter by depth range
- `filterByMagnitude(float $minValue, float $maxValue)` - Filter by magnitude range
- `filterByTime(string $from, string $to)` - Filter by time range
- `findLocationsByDistance(float $latitude, float $longitude, float $radio)` - Find events within distance (km)
- `findLocationByNearDistance(float $latitude, float $longitude)` - Find nearest event to coordinates
- `getLastSeismicActivityDate()` - Get last seismic activity date
- `getUpdateDate()` - Get data update date
- `get()` - Get filtered results

**Example Usage:**

```php
use Tlab\IpmaApi\IpmaService;
use Tlab\IpmaApi\Enums\SeismicInformationAreaEnum;

$api = IpmaService::createSeismicInformationApi();

// Get all seismic events for mainland and Madeira
$events = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
              ->get();

// Filter by magnitude range
$strongEvents = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                    ->filterByMagnitude(3.0, 5.0)
                    ->get();

// Filter by depth range
$shallowEvents = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                     ->filterByDepth(0, 30)
                     ->get();

// Find events near specific coordinates (within 50km radius)
$nearbyEvents = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                    ->findLocationsByDistance(38.7223, -9.1393, 50)
                    ->get();

// Find the nearest event to specific coordinates
$nearestEvent = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                    ->findLocationByNearDistance(38.7223, -9.1393);

// Filter by time range
$recentEvents = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                    ->filterByTime('2024-01-01T00:00:00', '2024-01-31T23:59:59')
                    ->get();

// Combine multiple filters
$filteredEvents = $api->from(SeismicInformationAreaEnum::AZORES)
                      ->filterByMagnitude(2.0, 4.0)
                      ->filterByDepth(10, 50)
                      ->get();

// Get metadata
$lastActivity = $api->from(SeismicInformationAreaEnum::MAIN_LAND_AND_MADEIRA)
                    ->getLastSeismicActivityDate();
$updateDate = $api->getUpdateDate();
```

**Example Response:**

```php
[
    [
        'seismId' => '20240117095931C',
        'googleMapRef' => 'http://maps.google.com/maps?output=classic&q=38.0990+-8.2530...',
        'degree' => null,
        'magType' => 'L',
        'magnitude' => 3.0,
        'depth' => 7,
        'tensorRef' => '',
        'shakeMapId' => '2024011709593101',
        'shakeMapRef' => 'http://shakemap.ipma.pt/2024011709593101/intensity.html',
        'location' => null,
        'regionName' => 'NW Ferreira do Alentejo',
        'latitude' => 38.0990,
        'longitude' => -8.2530,
        'source' => 'IPMA',
        'sensed' => null,
        'time' => '2024-01-17T09:59:32',
        'updateDate' => '2024-01-23T18:00:00',
    ],
]
```


## 3. Auxiliary services

### 3.1 List of identifiers for district capitals and islands

| Field          | Type    | Description                                                   |
|----------------|---------|---------------------------------------------------------------|
| globalIdLocal  | integer | Local identification                                          |
| name           | string  | Local name                                                    |
| idMunicipality | integer | Municipality ID (identificador definido no âmbito DICO)       |
| idDistrict     | integer | District ID (identificador definido no âmbito DICO)           |
| idRegion       | integer | Region ID [1 "Continente", 2 "Arq. Madeira", 3 "Arq. Açores"] |
| idWarningArea  | string  | Warning area ID                                               |
| latitude       | float   | Latitude (decimal degrees)                                    |
| longitude      | float   | Longitude (decimal degrees)                                   |

```php
$api = IpmaService::createDistrictsIslandsLocationsApi();
$result = $api->query()
              ->filterByIdRegion(1)
              ->filterByIdWarningArea('MCS')
              ->get();
```

```php
[
    [
        'globalIdLocal' => 2310300,
        'name' => 'Funchal',
        'idMunicipality' => 3,
        'idDistrict' => 31,
        'idRegion' => 2,
        'idWarningArea' => 'MCS',
        'latitude' => 32.6485,
        'longitude' => -16.9084,
    ],
    [
        'globalIdLocal' => 2320100,
        'name' => 'Porto Santo',
        'idMunicipality' => 1,
        'idDistrict' => 32,
        'idRegion' => 2,
        'idWarningArea' => 'MPS',
        'latitude' => 33.0700,
        'longitude' => -16.3400,
    ],
],
```

### 3.2 List of identifiers for coastal regions

(_Lista de identificadores para as regiões costeiras_)

> https://api.ipma.pt/open-data/sea-locations.json

| Field         | Type    | Description                                                   |
|---------------|---------|---------------------------------------------------------------|
| globalIdLocal | integer | Global local ID                                               |
| name          | string  | Local name                                                    |
| idLocal       | integer | Local ID                                                      |
| idRegion      | integer | Region ID [1 "Continente", 2 "Arq. Madeira", 3 "Arq. Açores"] |
| idWarningArea | string  | Warning area ID                                               |
| latitude      | string  | latitude (decimal degrees)                                    |
| longitude     | string  | longitude (decimal degrees)                                   |

```php
$api = IpmaService::createSeaLocationsApi();
$result = $api->query()
              ->filterByIdRegiao(1)
              ->filterByIdAreaAviso('AVR')
              ->get();
```

```json
[
  {
    "globalIdLocal": 1060526,
    "name": "Figueira da Foz, Costa",
    "idLocal": 302,
    "idRegion": 1,
    "idWarningArea": "CBR",
    "latitude": "40.1417",
    "longitude": "-8.8783"
  }
]
```

### 3.3 List of weather station identifiers

(_Lista de identificadores das estações meteorológicas_)

> https://api.ipma.pt/open-data/observation/meteorology/stations/stations.json

| Field     | Type    | Description                 |
|-----------|---------|-----------------------------|
| id        | integer | Weather station ID          |
| name      | string  | Name                        |
| latitude  | float   | latitude (decimal degrees)  |
| longitude | float   | longitude (decimal degrees) |

```php
$api = IpmaService::createWeatherStationsApi();
$result = $api->filterByName('selvagens')
              ->get();
```

```php
[
    [
        'id' => 1210520,
        'name' => 'Ilhas selvagens',
        'latitude' => 30.140595,
        'longitude' => -15.869153,
    ]
]
```

### 3.4 List of Weather Type Identifiers

(_Lista de identificadores do tempo significativo_)

> https://api.ipma.pt/open-data/weather-type-classe.json

### 3.5 List of classes relating to wind intensity

(_Lista de classes relativa à intensidade vento_)

> https://api.ipma.pt/open-data/wind-speed-daily-classe.json

### 3.6 List of classes relating to precipitation intensity

(_Lista de classes relativa à intensidade precipitação_)

> https://api.ipma.pt/open-data/precipitation-classe.json
