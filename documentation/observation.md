# 2. Observation

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

### 🐠 2.2 Biology

#### 2.2.1 Prohibitions on harvesting in bivalve mollusc production areas (GeoJSON format)

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

### 🌦️ 2.3 Climate

#### 2.3.1 Daily Evapotranspiration Reference

> https://api.ipma.pt/open-data/observation/climate/evapotranspiration/{district}/et0-{DICO}-{municipality}.csv

| Field | Type | Description |
|---|---|---|
| date | string | Date of observation |
| et0 | float | Evapotranspiration value |

```php
use Tlab\IpmaApi\IpmaObservation;

$api = IpmaObservation::createDailyEvapotranspirationReferenceApi();
$result = $api->from('beja', 'castro-verde', '0206')
              ->filterByDate('2023-12-09', '2023-12-10')
              ->get();
```

#### 2.3.2 Maximum Daily Temperature

> https://api.ipma.pt/open-data/observation/climate/temperature-maximum/{district}/mtxmn-{DICO}-{municipality}.csv

| Field | Type | Description |
|---|---|---|
| date | string | Date of observation |
| tmax | float | Maximum temperature value |

```php
use Tlab\IpmaApi\IpmaObservation;

$api = IpmaObservation::createMaximumDailyTemperatureApi();
$result = $api->from('guarda', 'manteigas', '0908')
              ->filterByDate('2023-12-09', '2023-12-10')
              ->get();
```

#### 2.3.3 Minimum Daily Temperature

> https://api.ipma.pt/open-data/observation/climate/temperature-minimum/{district}/mtnmn-{DICO}-{municipality}.csv

| Field | Type | Description |
|---|---|---|
| date | string | Date of observation |
| tmin | float | Minimum temperature value |

```php
use Tlab\IpmaApi\IpmaObservation;

$api = IpmaObservation::createMinimumDailyTemperatureApi();
$result = $api->from('guarda', 'manteigas', '0908')
              ->filterByDate('2023-12-09', '2023-12-10')
              ->get();
```

#### 2.3.4 Palmer Drought Severity Index

> https://api.ipma.pt/open-data/observation/climate/pdsi/{district}/mpdsi-{DICO}-{municipality}.csv

| Field | Type | Description |
|---|---|---|
| date | string | Date of observation |
| pdsi | float | PDSI value |

```php
use Tlab\IpmaApi\IpmaObservation;

$api = IpmaObservation::createPalmerDroughtSeverityIndexApi();
$result = $api->from('faro', 'castro-marim', '0804')
              ->filterByDate('2023-12-01', '2023-12-31')
              ->get();
```

#### 2.3.5 Total Daily Precipitation

> https://api.ipma.pt/open-data/observation/climate/precipitation-total/{district}/mrrto-{DICO}-{municipality}.csv

| Field | Type | Description |
|---|---|---|
| date | string | Date of observation |
| prec | float | Precipitation value |

```php
use Tlab\IpmaApi\IpmaObservation;

$api = IpmaObservation::createTotalDailyPrecipitationApi();
$result = $api->from('beja', 'castro-verde', '0206')
              ->filterByDate('2023-12-09', '2023-12-10')
              ->get();
```

### 🌬️ 2.4 Meteorology

#### 2.4.1 Weather Station Observation

> https://api.ipma.pt/open-data/observation/meteorology/stations/observations.json

| Field | Type | Description |
|---|---|---|
| idEstacao | integer | Station ID |
| temperatura | float | Temperature value |
| humidade | float | Humidity value |
| direccaoVento | string | Wind direction |
| intensidadeVento | float | Wind speed value |
| intensidadeVentoKmh | float | Wind speed value in km/h |
| pressao | float | Atmospheric pressure value |
| precipitacao | float | Precipitation value |
| radiacao | float | Solar radiation value |
| data | string | Date of observation |

```php
use Tlab\IpmaApi\IpmaObservation;

$api = IpmaObservation::createWeatherStationObservationApi();
$result = $api->from()
              ->filterByDate('2023-12-09', '2023-12-10')
              ->get();
```

#### 2.4.2 Weather Station Observation by Hour

> https://api.ipma.pt/open-data/observation/meteorology/stations/observations-hour.json

| Field | Type | Description |
|---|---|---|
| idEstacao | integer | Station ID |
| temperatura | float | Temperature value |
| humidade | float | Humidity value |
| direccaoVento | string | Wind direction |
| intensidadeVento | float | Wind speed value |
| intensidadeVentoKmh | float | Wind speed value in km/h |
| pressao | float | Atmospheric pressure value |
| precipitacao | float | Precipitation value |
| radiacao | float | Solar radiation value |
| data | string | Date of observation |

```php
use Tlab\IpmaApi\IpmaObservation;

$api = IpmaObservation::createWeatherStationObservationByHourApi();
$result = $api->from()
              ->filterByDate('2023-12-09', '2023-12-10')
              ->get();
```
