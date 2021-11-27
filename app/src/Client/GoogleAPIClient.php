<?php

declare(strict_types=1);


namespace App\Client;


use App\Model\Zipcode;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleAPIClient
{
    private string $APIKey;
    private string $baseURL;
    private HttpClientInterface $client;

    public function __construct(string $APIKey, string $baseURL, HttpClientInterface $client)
    {
        $this->APIKey = $APIKey;
        $this->baseURL = $baseURL;
        $this->client = $client;
    }

    public function sendRequest(Zipcode $startingPoint, Zipcode $destination):string
    {
        $request = $this->client->request(
            'POST',
            $this->baseURL,
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