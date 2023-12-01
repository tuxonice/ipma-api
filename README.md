# IPMA-API

This PHP package is an interface for IPMA(Instituto Português do Mar e da Atmosfera, I. P.) API.

For more information check https://api.ipma.pt/ (only in Portuguese)

**Warning:** This is a work in progress package! 

## Installation

- TODO

## End Points

### Forecast

Weather warnings for up to 3 days

> https://api.ipma.pt/open-data/forecast/warnings/warnings_www.json

#### Meteorology

Daily Weather Forecast up to 5 days aggregated by Location

> https://api.ipma.pt/open-data/forecast/meteorology/cities/daily/{globalIdLocal}.json

Daily Weather Forecast for up to 3 days, aggregated information per day

> https://api.ipma.pt/open-data/forecast/meteorology/cities/daily/hp-daily-forecast-day{idDay}.json

Fire Risk Forecast for up to 2 days, aggregated information per day

> https://api.ipma.pt/open-data/forecast/meteorology/rcm/rcm-d{idDay}.json


Ultraviolet Risk Forecast for up to 3 days (Ultraviolet Index)

> https://api.ipma.pt/open-data/forecast/meteorology/uv/uv.json

#### Oceanography

Sea State forecast for up to 3 days, aggregated information per day

> https://api.ipma.pt/open-data/forecast/oceanography/daily/hp-daily-sea-forecast-day{idDay}.json


### Observation

#### Seismic

Seismic information, Arch. Azores, Continente and Arch. Madeira. Includes 30 days of information

> https://api.ipma.pt/open-data/observation/seismic/{idArea}.json

#### Meteorology

Meteorological Observation of Stations (hourly data, last 24 hours)

> https://api.ipma.pt/open-data/observation/meteorology/stations/observations.json

Weather Observation of Stations, last 3 hours (GeoJSON format)

> https://api.ipma.pt/open-data/observation/meteorology/stations/obs-surface.geojson

#### Biology

Prohibitions on harvesting in Bivalve Mollusc Production Areas (GeoJSON format)

> https://api.ipma.pt/open-data/observation/biology/bivalves/CI_SNMB.geojson

#### Climate

Daily reference evapotranspiration by municipality (CSV format)

> https://api.ipma.pt/open-data/observation/climate/evapotranspiration/{distrito}/et0-{DICO}-{concelho}.csv

Minimum daily temperature by municipality (CSV format)

> https://api.ipma.pt/open-data/observation/climate/temperature-min/{distrito}/mtnmn-{DICO}-{concelho}.csv

Maximum daily temperature by municipality (CSV format)

> https://api.ipma.pt/open-data/observation/climate/temperature-max/{distrito}/mtxmn-{DICO}-{concelho}.csv

PDSI index (Palmer Drought Severity Index) monthly by municipality (CSV format)

> https://api.ipma.pt/open-data/observation/climate/mpdsi/{distrito}/mpdsi-{DICO}-{concelho}.csv


### Auxiliary services

List of identifiers for district capitals and islands

> https://api.ipma.pt/open-data/distrits-islands.json

List of identifiers for coastal regions

> https://api.ipma.pt/open-data/sea-locations.json

List of weather station identifiers

> https://api.ipma.pt/open-data/observation/meteorology/stations/stations.json

List of Significant Time Identifiers

> https://api.ipma.pt/open-data/weather-type-classe.json

List of classes relating to wind intensity

> https://api.ipma.pt/open-data/wind-speed-daily-classe.json

List of classes relating to precipitation intensity

> https://api.ipma.pt/open-data/precipitation-classe.json