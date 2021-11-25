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