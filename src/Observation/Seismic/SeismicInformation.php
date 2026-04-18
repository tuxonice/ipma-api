<?php

namespace Tlab\IpmaApi\Observation\Seismic;

use DateTime;
use Exception;
use Tlab\IpmaApi\ApiConnectorInterface;
use Tlab\IpmaApi\Dto\Seismic\SeismicEvent;
use Tlab\IpmaApi\Endpoints;
use Tlab\IpmaApi\Enums\SeismicInformationAreaEnum;
use Tlab\IpmaApi\Utils;

class SeismicInformation
{
    private const END_POINT = Endpoints::SEISMIC_INFORMATION;

    /** @var list<SeismicEvent> */
    private array $data = [];

    private DateTime $lastSeismicActivityDate;

    private DateTime $updateDate;

    public function __construct(private readonly ApiConnectorInterface $apiConnector)
    {
    }

    /**
     * @throws Exception
     */
    public function from(SeismicInformationAreaEnum $area): self
    {
        $url = str_replace('{idArea}', (string)$area->value, self::END_POINT);
        $content = $this->apiConnector->fetchData($url);

        $this->updateDate = new DateTime($content['updateDate']);
        $this->lastSeismicActivityDate = new DateTime($content['lastSismicActivityDate']);
        $this->data = $this->map($content['data']);

        return $this;
    }

    public function filterByDepth(int $minValue, int $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (SeismicEvent $e) => $e->depth >= $minValue && $e->depth <= $maxValue
            )
        );

        return $this;
    }

    public function filterByTime(string $from, string $to): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (SeismicEvent $e) => $e->time >= $from && $e->time <= $to
            )
        );

        return $this;
    }

    public function filterByMagnitude(float $minValue, float $maxValue): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (SeismicEvent $e) => $e->magnitude >= $minValue && $e->magnitude <= $maxValue
            )
        );

        return $this;
    }

    public function findLocationsByDistance(float $latitude, float $longitude, float $radio): self
    {
        $this->data = array_values(
            array_filter(
                $this->data,
                fn (SeismicEvent $e) => Utils::distance($e->latitude, $e->longitude, $latitude, $longitude) <= $radio
            )
        );

        return $this;
    }

    public function findLocationByNearDistance(float $latitude, float $longitude): ?SeismicEvent
    {
        $nearest = null;
        $shortest = null;
        foreach ($this->data as $event) {
            $distance = Utils::distance($event->latitude, $event->longitude, $latitude, $longitude);
            if ($shortest === null || $distance < $shortest) {
                $shortest = $distance;
                $nearest = $event;
            }
        }

        return $nearest;
    }

    public function getLastSeismicActivityDate(): DateTime
    {
        return $this->lastSeismicActivityDate;
    }

    public function getUpdateDate(): DateTime
    {
        return $this->updateDate;
    }

    /**
     * @return list<SeismicEvent>
     */
    public function get(): array
    {
        return $this->data;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     * @return list<SeismicEvent>
     */
    private function map(array $data): array
    {
        $events = [];
        foreach ($data as $datum) {
            $events[] = new SeismicEvent(
                seismId: (string)$datum['sismoId'],
                googleMapRef: (string)$datum['googlemapref'],
                degree: $datum['degree'],
                magType: (string)$datum['magType'],
                magnitude: (float)$datum['magnitud'],
                depth: (int)$datum['depth'],
                tensorRef: (string)$datum['tensorRef'],
                shakeMapId: (string)$datum['shakemapid'],
                shakeMapRef: (string)$datum['shakemapref'],
                location: $datum['local'],
                regionName: (string)$datum['obsRegion'],
                latitude: (float)$datum['lat'],
                longitude: (float)$datum['lon'],
                source: (string)$datum['source'],
                sensed: $datum['sensed'],
                time: (string)$datum['time'],
                updateDate: (string)$datum['dataUpdate'],
            );
        }

        return $events;
    }
}
