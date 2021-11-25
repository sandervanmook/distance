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

    public function sendRequest(Zipcode $startingPoint, Zipcode $destination):string
    {
        $request = $this->client->request(
            'POST',
            self::BASEURL,
            [
                'query' => [
                    'origins' => $startingPoint->isBelgianZipcode()?$startingPoint->getCompleteBelgianValue():$startingPoint->getValue(),
                    'destinations' => $destination->isBelgianZipcode()?$destination->getCompleteBelgianValue():$destination->getValue(),
                    'key' => $this->APIKey,
                ],
            ]
        );
        return $request->getContent();
    }
}