<?php

declare(strict_types=1);


namespace App\Client;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleAPIClient
{
    const BASEURL = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=4411gb&destinations=4706nk&key=AIzaSyAUyX4psBJiaqlHqOnqR3fReyI63QZUlIo";

    private string $APIKey;
    private HttpClientInterface $client;

    public function __construct(string $APIKey, HttpClientInterface $client)
    {
        $this->APIKey = $APIKey;
        $this->client = $client;
    }

    public function sendRequest()
    {
        $request = $this->client->request('POST', self::BASEURL);

        return $request->getContent();
    }
}