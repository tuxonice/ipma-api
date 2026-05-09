# IPMA API Data Relations

This diagram shows the relationships between different API endpoints and their data fields.

## Entity Relationship Diagram

```mermaid
erDiagram
    %% Core Location Entities
    DISTRICT_LOCATION {
        int globalIdLocal PK
        string name
        int idMunicipality FK
        int idDistrict FK
        int idRegion
        string idWarningArea
        float latitude
        float longitude
    }

    SEA_LOCATION {
        int globalIdLocal PK
        string name
        int idLocal
        int idRegion
        string idWarningArea
        float latitude
        float longitude
    }

    WEATHER_STATION {
        int id PK
        string name
        float latitude
        float longitude
    }

    MUNICIPALITY_AREA {
        string dico PK
        string nuts1
        string nuts2
        string nuts3
        string district
        string municipality
        float area
        float perimeter
        int altitudeMax
        int altitudeMin
        DistrictLocation location FK
    }

    %% Forecast Entities
    DAILY_FORECAST_BY_DAY {
        int globalIdLocal FK
        int idWeatherType
        int windSpeedClass
        int rainfallIntensity
        float rainfallProb
        float minTemp
        float maxTemp
        string winDir
        float latitude
        float longitude
    }

    DAILY_FORECAST_BY_LOCATION {
        string forecastDate
        int idWeatherType
        int windSpeedClass
        int rainfallIntensity
        float rainfallProb
        float minTemp
        float maxTemp
        string winDir
        float latitude
        float longitude
    }

    FIRE_RISK {
        int idArea
        string areaName
        int riskLevel
        string riskClass
        string date
    }

    ULTRAVIOLET_RISK {
        int globalIdLocal FK
        string area
        int riskLevel
        string riskClass
        string date
    }

    SEA_STATE {
        int globalIdLocal FK
        string area
        string waveHeight
        string waterTemp
        string windDirection
        string date
    }

    WEATHER_WARNING {
        string idArea
        string areaName
        string warningType
        string warningLevel
        string startTime
        string endTime
    }

    %% Observation Entities
    HOURLY_STATION_OBS {
        string time
        int idEstacao FK
        string localEstacao
        float temperatura
        float humidade
        float pressao
        float precAcumulada
        float intensidadeVentoKM
        float intensidadeVento
        int idDireccVento
        string descDirVento
        float radiacao
        float latitude
        float longitude
    }

    DAILY_STATION_OBS {
        int idEstacao FK
        string localEstacao
        float temperatura
        float humidade
        float pressao
        float precAcumulada
        float velocidadeVento
        string descDirVento
        float radiacao
        float latitude
        float longitude
    }

    CLIMATE_OBS {
        string date PK
        string minimum
        string maximum
        string range
        string mean
        string std
    }

    SEISMIC_EVENT {
        int eventId PK
        string time
        float latitude
        float longitude
        float depth
        float magnitude
        string region
        string idArea
    }

    MOLLUSC_FEATURE {
        string species
        string location
        string status
        string startDate
        string endDate
    }

    %% Relationships
    DISTRICT_LOCATION ||--o{ DAILY_FORECAST_BY_DAY : "globalIdLocal"
    DISTRICT_LOCATION ||--o{ ULTRAVIOLET_RISK : "globalIdLocal"
    DISTRICT_LOCATION ||--o{ SEA_STATE : "via location matching"
    DISTRICT_LOCATION ||--o{ MUNICIPALITY_AREA : "dico = concat(idDistrict, idMunicipality)"

    WEATHER_STATION ||--o{ HOURLY_STATION_OBS : "idEstacao"
    WEATHER_STATION ||--o{ DAILY_STATION_OBS : "idEstacao"

    DISTRICT_LOCATION ||--o{ FIRE_RISK : "via idWarningArea"
    DISTRICT_LOCATION ||--o{ WEATHER_WARNING : "via idWarningArea"
    DISTRICT_LOCATION ||--o{ SEISMIC_EVENT : "via idArea"

    MUNICIPALITY_AREA ||--o{ CLIMATE_OBS : "via DICO path param"
```

## API Endpoint Mapping

```mermaid
flowchart TD
    subgraph Service["Service Endpoints"]
        DL["/distrits-islands.json<br/>DistrictsIslandsLocations"]
        SL["/sea-locations.json<br/>SeaLocations"]
        WS["/stations.json<br/>WeatherStations"]
        MA["dico.csv<br/>MunicipalityAreas"]
    end

    subgraph Forecast["Forecast Endpoints"]
        DF["/cities/daily/{globalIdLocal}.json<br/>DailyWeatherForecastByLocation"]
        FR["/rcm/rcm-d{idDay}.json<br/>FireRiskForecast"]
        UV["/uv/uv.json<br/>UltravioletRiskForecast"]
        SSF["/hp-daily-sea-forecast-day{idDay}.json<br/>SeaStateForecast"]
        WW["/warnings_www.json<br/>WeatherWarnings"]
    end

    subgraph Observation["Observation Endpoints"]
        SO["/observations.json<br/>WeatherStationObservation"]
        SE["/seismic/{idArea}.json<br/>SeismicInformation"]
        MO["/CI_SNMB.geojson<br/>MolluscHarvestingProhibition"]
    end

    subgraph Climate["Climate Endpoints (CSV)"]
        MT["/mtxmx-{DICO}-{municipality}.csv<br/>MaximumDailyTemperature"]
        MiT["/mtnmn-{DICO}-{municipality}.csv<br/>MinimumDailyTemperature"]
        TP["/mrrto-{DICO}-{municipality}.csv<br/>TotalDailyPrecipitation"]
        ET["/et0-{DICO}-{municipality}.csv<br/>DailyEvapotranspirationReference"]
        PD["/mpdsi-{DICO}-{municipality}.csv<br/>PalmerDroughtSeverityIndex"]
    end

    %% Key relationships
    DL -->|"globalIdLocal"| DF
    DL -->|"idWarningArea"| FR
    DL -->|"globalIdLocal"| UV
    DL -->|"globalIdLocal"| SSF
    DL -->|"idWarningArea"| WW
    DL -->|"dico mapping"| MA

    WS -->|"idEstacao"| SO

    DL -->|"idArea"| SE

    MA -->|"DICO"| MT
    MA -->|"DICO"| MiT
    MA -->|"DICO"| TP
    MA -->|"DICO"| ET
    MA -->|"DICO"| PD
```

## Key Field Relationships

| Source Entity | Field | Target Entity | Field | Relationship |
|--------------|-------|---------------|-------|--------------|
| DistrictLocation | globalIdLocal | DailyForecastByDay | globalIdLocal | 1:N Forecast per location |
| DistrictLocation | globalIdLocal | UltravioletRisk | globalIdLocal | 1:1 UV risk per location |
| DistrictLocation | idWarningArea | FireRisk | idArea | 1:N Risk areas |
| DistrictLocation | idWarningArea | WeatherWarning | idArea | 1:N Warnings per area |
| DistrictLocation | idDistrict + idMunicipality | MunicipalityArea | dico | 1:1 Area data |
| WeatherStation | id | HourlyStationObservation | idEstacao | 1:N Observations |
| MunicipalityArea | dico | Climate CSVs | DICO path param | 1:N Climate series |

## Data Flow Example

```mermaid
sequenceDiagram
    participant User
    participant MunicipalityAreas
    participant DistrictsIslandsLocations
    participant IPMA_API
    participant CSV

    User->>MunicipalityAreas: query()
    MunicipalityAreas->>IPMA_API: fetchData(distrits-islands.json)
    IPMA_API-->>MunicipalityAreas: locations data
    MunicipalityAreas->>CSV: load dico.csv
    CSV-->>MunicipalityAreas: area data
    MunicipalityAreas->>MunicipalityAreas: buildLocationsMap()
    MunicipalityAreas->>MunicipalityAreas: loadCsvData()
    Note over MunicipalityAreas: Match dico codes
    MunicipalityAreas-->>User: MunicipalityArea[] with location

    User->>MunicipalityAreas: filterByNuts2('Alentejo')
    MunicipalityAreas-->>User: filtered results

    User->>MunicipalityAreas: filterByIdRegion(1)
    MunicipalityAreas-->>User: results with DistrictLocation
```
