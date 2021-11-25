<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\APIDistanceResult;
use App\Model\Destinations;
use App\Model\Zipcode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalculateDistanceController extends AbstractController
{
    private APIDistanceResult $APIDistanceResult;

    public function __construct(APIDistanceResult $APIDistanceResult)
    {
        $this->APIDistanceResult = $APIDistanceResult;
    }

    /**
    * @Route("/calculatedistance")
    */
    public function __invoke(Request $request): JsonResponse
    {
        $startingPointZipcode = new Zipcode($request->query->get('startingpoint'));

        $destinations = new Destinations($request->query->get('destinations'));

        return $this->APIDistanceResult->generateResult($startingPointZipcode, $destinations);
    }
}