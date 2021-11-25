<?php

declare(strict_types=1);


namespace App\Client;


use App\Model\Destinations;
use App\Model\Zipcode;
use Symfony\Component\HttpFoundation\JsonResponse;

class APIDistanceResult
{
    private GoogleAPIClient $googleAPIClient;

    public function __construct(GoogleAPIClient $googleAPIClient)
    {
        $this->googleAPIClient = $googleAPIClient;
    }

    public function generateResult(Zipcode $startingPointZipcode, Destinations $destinations): JsonResponse
    {
        $result = [];

        if ($startingPointZipcode->isBelgianZipcode()) {
            $startingPointZipcode = $startingPointZipcode->getValue().' Belgium';
        }

        foreach ($destinations->getDestinations() as $destination) {
            if ($destination->isBelgianZipcode()) {
                $destination = $destination->getValue().' Belgium';
            }

            $entry = new GoogleAPIResponse($this->googleAPIClient->sendRequest($startingPointZipcode, $destination));

            $result[] = [
                'destination' => $entry->getDestination(),
                'distance' => $entry->getDistance(),
                'duration' => $entry->getDuration(),
            ];
        }

        array_multisort($result, SORT_ASC);

        return new JsonResponse($result, 200);
    }




}