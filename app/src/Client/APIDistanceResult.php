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

        foreach ($destinations->getDestinations() as $destination) {
            $entry = new GoogleAPIResponse($this->googleAPIClient->sendRequest($startingPointZipcode, $destination));

            $result[] = [
                'destination' => $entry->getDestination(),
                'distance' => $entry->getDistance(),
                'duration' => $entry->getDuration(),
            ];
        }

        function duration_compare($element1, $element2) {
            $entry1 = (int)$element1['duration'];
            $entry2 = (int)$element2['duration'];
            return $entry1 - $entry2;
        }

        usort($result, "App\\Client\\duration_compare");

        return new JsonResponse($result, 200);
    }
}