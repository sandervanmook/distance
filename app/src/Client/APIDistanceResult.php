<?php

declare(strict_types=1);


namespace App\Client;


use App\Model\Destinations;
use App\Model\Zipcode;
use Symfony\Component\HttpFoundation\JsonResponse;

class APIDistanceResult
{
    public const SORT_DISTANCE = 'distance';
    public const SORT_DURATION = 'duration';

    private GoogleAPIClient $googleAPIClient;

    public function __construct(GoogleAPIClient $googleAPIClient)
    {
        $this->googleAPIClient = $googleAPIClient;
    }

    public function generateResult(
        Zipcode $startingPointZipcode,
        Destinations $destinations,
        string $sort = self::SORT_DURATION
    ): JsonResponse {
        $result = [];

        foreach ($destinations->getDestinations() as $destination) {
            $entry = new GoogleAPIResponse($this->googleAPIClient->sendRequest($startingPointZipcode,
                $destination));

            $result[] = [
                'destination' => $entry->getDestination(),
                'distance' => $entry->getDistance(),
                'duration' => $entry->getDuration(),
            ];
        }

        return new JsonResponse($this->sort($result, $sort), 200);
    }

    private function sort(array $data, string $sortType): array
    {
        switch ($sortType) {
            case self::SORT_DURATION :
                {
                    usort($data, fn(
                        array $element1,
                        array $element2
                    ) => (int)$element1['duration'] - (int)$element2['duration']
                    );
                }
                break;
            case self::SORT_DISTANCE :
                {
                    usort($data, fn(
                        array $element1,
                        array $element2
                    ) => (int)$element1['distance'] - (int)$element2['distance']
                    );
                }
                break;
            default:
                throw new \InvalidArgumentException('Unknown sorting type');
        }

        return $data;
    }
}