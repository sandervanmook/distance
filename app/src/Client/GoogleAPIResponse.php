<?php

declare(strict_types=1);


namespace App\Client;


class GoogleAPIResponse
{
    private string $distance;
    private string $duration;
    private string $destination;


    public function __construct(string $APIResult)
    {
        $resultArray = json_decode($APIResult, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(json_last_error());
        }

        if ("" === $resultArray['destination_addresses'][0]) {
            throw new \InvalidArgumentException('Destination address not found');
        }

        if ("" === $resultArray['origin_addresses'][0]) {
            throw new \InvalidArgumentException('Starting address not found');
        }

        $this->distance = $resultArray['rows'][0]['elements'][0]['distance']['text'];
        $this->duration = $resultArray['rows'][0]['elements'][0]['duration']['text'];
        $this->destination = $resultArray['destination_addresses'][0];
    }

    public function getDistance(): string
    {
        return $this->distance;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }
}