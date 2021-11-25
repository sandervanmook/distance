<?php

declare(strict_types=1);


namespace App\Client;


use App\Model\Zipcode;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleAPIClient
{
    const BASEURL = "https://maps.googleapis.com/maps/api/distancematrix/json";

    private string $APIKey;
    private HttpClientInterface $client;

    public function __construct(string $APIKey, HttpClientInterface $client)
    {
        $this->APIKey = $APIKey;
        $this->client = $client;
    }

    public function sendRequest(string $startingPoint, string $destination):string
    {
        $request = $this->client->request(
            'POST',
            self::BASEURL,
            [
                'query' => [
                    'origins' => $startingPoint,
                    'destinations' => $destination,
                    'key' => $this->APIKey,
                ],
            ]
        );

        return $request->getContent();
    }
}