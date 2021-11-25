<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\GoogleAPIClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalculateDistanceController extends AbstractController
{
    private GoogleAPIClient $googleAPIClient;

    public function __construct(GoogleAPIClient $googleAPIClient)
    {
        $this->googleAPIClient = $googleAPIClient;
    }


    /**
    * @Route("/calculatedistance")
    */
    public function __invoke(Request $request): JsonResponse
    {
        $startingPoint = $request->query->get('startingpoint');

        $storeLocationsString = $request->query->get('storeLocations');
        $storelocationsArray = explode(",", $storeLocationsString);

        $request = $this->googleAPIClient->sendRequest();


        return new JsonResponse('ok');
    }
}