# IPMA-API

This PHP package is an interface for IPMA(Instituto Português do Mar e da Atmosfera, I. P.) API.

For more information check https://api.ipma.pt/ (only in Portuguese)

**Warning:** This is a work in progress package!

## Installation

- TODO

## End Points

### Forecast -> Meteorology

#### Daily Weather Forecast for up to 3 days, aggregated information per day

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
use Tlab\IpmaApi\IpmaForecast;

$api = IpmaForecast::createDailyWeatherForecastByDayApi();
$result = $api
            ->from(0)
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

#### Daily Weather Forecast up to 5 days aggregated by Location

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

#### Fire Risk Forecast for up to 2 days, aggregated information per day

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

#### Ultraviolet Risk Forecast for up to 3 days (Ultraviolet Index)

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

### Forecast -> Oceanography

#### Sea State forecast for up to 3 days, aggregated information per day

> https://api.ipma.pt/open-data/forecast/oceanography/daily/hp-daily-sea-forecast-day{idDay}.json

### Observation -> Seismic

#### Seismic information, Arch. Azores, Continente and Arch. Madeira. Includes 30 days of information

> https://api.ipma.pt/open-data/observation/seismic/{idArea}.json

### Observation -> Meteorology

#### Meteorological Observation of Stations (hourly data, last 24 hours)

> https://api.ipma.pt/open-data/observation/meteorology/stations/observations.json

#### Weather Observation of Stations, last 3 hours (GeoJSON format)

> https://api.ipma.pt/open-data/observation/meteorology/stations/obs-surface.geojson

### Observation -> Biology

#### Prohibitions on harvesting in Bivalve Mollusc Production Areas (GeoJSON format)

> https://api.ipma.pt/open-data/observation/biology/bivalves/CI_SNMB.geojson

### Observation -> Climate

#### Daily reference evapotranspiration by municipality (CSV format)

> https://api.ipma.pt/open-data/observation/climate/evapotranspiration/{distrito}/et0-{DICO}-{concelho}.csv

#### Minimum daily temperature by municipality (CSV format)

> https://api.ipma.pt/open-data/observation/climate/temperature-min/{distrito}/mtnmn-{DICO}-{concelho}.csv

#### Maximum daily temperature by municipality (CSV format)

> https://api.ipma.pt/open-data/observation/climate/temperature-max/{distrito}/mtxmn-{DICO}-{concelho}.csv

#### PDSI index (Palmer Drought Severity Index) monthly by municipality (CSV format)

> https://api.ipma.pt/open-data/observation/climate/mpdsi/{distrito}/mpdsi-{DICO}-{concelho}.csv

#### Weather warnings for up to 3 days

> https://api.ipma.pt/open-data/forecast/warnings/warnings_www.json

``` json
[
  {
    "text": "",
    "awarenessTypeName": "Agitação Marítima",
    "idAreaAviso": "BGC",
    "startTime": "2021-03-25T07:25:00",
    "awarenessLevelID": "green",
    "endTime": "2021-03-28T07:00:00"
  },
  {
    "text": "",
    "awarenessTypeName": "Nevoeiro",
    "idAreaAviso": "BGC",
    "startTime": "2021-03-25T07:25:00",
    "awarenessLevelID": "green",
    "endTime": "2021-03-28T07:00:00"
  }
]
```

| Field             | Type     | Description                                                                                                                                             |
|-------------------|----------|---------------------------------------------------------------------------------------------------------------------------------------------------------|
| text              | text     | texto descritivo do aviso (preenchido apenas quando o aviso é amarelo, laranja ou vermelho)                                                             |
| awarenessTypeName | text     | parâmetro do aviso (e.g. "Trovoada", "Agitação Marítima", "Precipitação", "Vento", "Nevoeiro", "Neve", "Tempo Frio", "Tempo Quente")                    |
| awarenessLevelID  | text     | cor / nível do aviso (e.g. "green", "yellow", "orange", "red", só existem avisos para níveis diferentes de "green", ou seja, "yellow", "orange", "red") |
| idAreaAviso       | text     | identificador da área dos avisos (consultar serviço auxiliar "Lista de identificadores para as capitais distrito e ilhas")                              |
| startTime         | datetime | data/hora de início da duração do aviso                                                                                                                 |
| endTime           | datetime | data/hora de fim da duração do aviso                                                                                                                    |

```php
use Tlab\IpmaApi\IpmaService;

$warningsApi = IpmaService::createWarningsApi();
$result = $warningsApi
    ->filterByWarningIdArea('BGC')
    ->filterByAwarenessTypeName('Nevoeiro')
    ->get();

```

### Auxiliary services

#### List of identifiers for district capitals and islands

> https://api.ipma.pt/open-data/distrits-islands.json

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
$result = $api->filterByIdRegion(1)
              ->filterByIdWarningArea('AVR')
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

#### List of identifiers for coastal regions

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
$result = $api->filterByIdRegiao(1)
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

#### List of weather station identifiers

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

#### List of Weather Type Identifiers

> https://api.ipma.pt/open-data/weather-type-classe.json

#### List of classes relating to wind intensity

> https://api.ipma.pt/open-data/wind-speed-daily-classe.json

#### List of classes relating to precipitation intensity

> https://api.ipma.pt/open-data/precipitation-classe.json