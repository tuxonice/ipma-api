# IPMA-API

This PHP package is an interface for IPMA(Instituto Português do Mar e da Atmosfera, I. P.) API.

For more information check https://api.ipma.pt/ (only in Portuguese)

**Warning:** This is a work in progress package!

## Installation

- TODO

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
use Tlab\IpmaApi\IpmaForecast;

$api = IpmaForecast::createSeaStateForecastApi();
$result = $api->from(0)
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
$result = $warningsApi
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

### 🐠 2.1 Biology

#### 2.1.1 Prohibitions on harvesting in bivalve mollusc production areas (GeoJSON format)

(_Interdições à apanha nas zonas de produção de moluscos bivalves (formato GeoJSON)_)

> https://api.ipma.pt/open-data/observation/biology/bivalves/CI_SNMB.geojson

| Field                | Type   | Description                                                            |
|----------------------|--------|------------------------------------------------------------------------|
| name                 | text   | Zone name                                                              |
| code                 | text   | Zone code                                                              |
| zone_type            | text   | Zone type ("LITORAL": Zona Litoral, "EST_LAG": Zona Estuarino-lagunar) |
| region_name          | text   | Region name                                                            |
| representative_point | array  | Geographical coordinate where the zone, representative point           |
| status               | string | State of the Zone (see notes)                                          |
| interdictions        | array  | List of species regarding the interdiction (see notes)                 |

_Notes:_

**State of the Zone:**

- "Open": Situation of Personal Permission and Capture,
- "Partial_open": Situation of Partial Permission of caught and capture,
- "closed": situation of total interdiction of caught and capture,
- "partial_open",
- "noinfo": without information

**Interdictions**

- "Specie_S": scientific name (scientific name);
- "Specie_c": Common Name (Common Name);
- "Classification": Sanitary Statute ("A", "B", "C")

```php
use Tlab\IpmaApi\IpmaObservation;

$molluscHarvestingProhibition = IpmaObservation::createMolluscHarvestingProhibitionApi();
$result = $molluscHarvestingProhibition
    ->from()
    ->filterByName('tavira')
    ->get();
```

```php
[
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Litoral Tavira – Vila Real Santo António',
                        'code' => 'L9',
                        'zone_type' => 'LITORAL',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-7.521726250000002 37.094826)',
                        'status' => 'OPEN',
                        'interdictions' => [
                            'open' => [
                                [
                                    'specie_c' => 'Canilha',
                                    'specie_s' => 'Bolinus brandaris',
                                    'classification' => 'NA',
                                ],
                                [
                                    'specie_c' => 'Pé-de-burrinho',
                                    'specie_s' => 'Chamelea gallina',
                                    'classification' => 'A*',
                                ],
                                [
                                    'specie_c' => 'Buzina',
                                    'specie_s' => 'Charonia rubicunda',
                                    'classification' => 'NA',
                                ],
                                [
                                    'specie_c' => 'Conquilha',
                                    'specie_s' => 'Donax trunculus',
                                    'classification' => 'B',
                                ],
                                [
                                    'specie_c' => 'Amêijoa-branca',
                                    'specie_s' => 'Spisula solida',
                                    'classification' => 'B',
                                ],
                            ],
                            'close' => [],
                        ],
                        'coords' => [
                            'latitude' => '37.094826',
                            'longitude' => '-7.521726250000002',
                        ],
                    ],
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'name' => 'Ria Formosa, Tavira',
                        'code' => 'TAV',
                        'zone_type' => 'EST_LAG',
                        'region_name' => 'Algarve',
                        'representative_point' => 'POINT (-7.673624507077854 37.08832)',
                        'status' => 'OPEN',
                        'interdictions' => [
                            'open' => [
                                [
                                    'specie_c' => 'Berbigão',
                                    'specie_s' => 'Cerastoderma edule',
                                    'classification' => 'C',
                                ],
                                [
                                    'specie_c' => 'Ostra-japonesa/gigante',
                                    'specie_s' => 'Magallana gigas',
                                    'classification' => 'B',
                                ],
                                [
                                    'specie_c' => 'Mexilhão',
                                    'specie_s' => 'Mytilus spp.',
                                    'classification' => 'B',
                                ],
                                [
                                    'specie_c' => 'Amêijoa-boa',
                                    'specie_s' => 'Ruditapes decussatus',
                                    'classification' => 'C',
                                ],
                                [
                                    'specie_c' => 'Longueirão',
                                    'specie_s' => 'Solen marginatus',
                                    'classification' => 'C',
                                ],
                            ],
                            'close' => [],
                        ],
                        'coords' => [
                            'latitude' => '37.08832',
                            'longitude' => '-7.673624507077854',
                        ],
                    ],
                ],
```

### ⛈️ 2.2 Climate

#### 2.2.1 Daily reference evapotranspiration by municipality (CSV format)

(_Evapotranspiração de referência diária por concelho (formato CSV)_)

> https://api.ipma.pt/open-data/observation/climate/evapotranspiration/{distrito}/et0-{DICO}-{concelho}.csv

#### 2.2.2 Total daily precipitation by municipality (CSV format)

(_Precipitação total diária por concelho (formato CSV)_)

> https://api.ipma.pt/open-data/observation/climate/precipitation-total/{distrito}/mrrto-{DICO}-{concelho}.csv

#### 2.2.3 Minimum daily temperature by municipality (CSV format)

(_Temperatura mínima diária por concelho (formato CSV)_)

> https://api.ipma.pt/open-data/observation/climate/temperature-min/{distrito}/mtnmn-{DICO}-{concelho}.csv

#### 2.2.4 Maximum daily temperature by municipality (CSV format)

(_Temperatura máxima diária por concelho (formato CSV)_)

> https://api.ipma.pt/open-data/observation/climate/temperature-max/{distrito}/mtxmn-{DICO}-{concelho}.csv

#### 2.2.5 PDSI index (Palmer Drought Severity Index) monthly by municipality (CSV format)

(_Índice PDSI (Palmer Drought Severity Index) mensal por concelho (formato CSV)_)

> https://api.ipma.pt/open-data/observation/climate/mpdsi/{distrito}/mpdsi-{DICO}-{concelho}.csv

### 🌤️ 2.3 Meteorology

#### 2.3.1 Meteorological Observation of Stations (hourly data, last 24 hours)

(_Observação Meteorológica de Estações (dados horários, últimas 24 horas)_)

> https://api.ipma.pt/open-data/observation/meteorology/stations/observations.json

#### 2.3.2 Weather Observation of Stations, last 3 hours (GeoJSON format)

(_Observação Meteorológica de Estações, últimas 3 horas (formato GeoJSON)_)

> https://api.ipma.pt/open-data/observation/meteorology/stations/obs-surface.geojson

### 🌐 2.4 Seismic

#### Seismic information, Arch. Azores, Continente and Arch. Madeira. Includes 30 days of information

(_Informação sismicidade, Arq. Açores, Continente e Arq. Madeira. Integra 30 dias de informação_)

> https://api.ipma.pt/open-data/observation/seismic/{idArea}.json

## 3. Auxiliary services

### 3.1 List of identifiers for district capitals and islands

(_Lista de identificadores para as capitais distrito e ilhas_)

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
