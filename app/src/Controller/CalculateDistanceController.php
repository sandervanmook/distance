<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\APIDistanceResult;
use App\Model\Destinations;
use App\Model\Zipcode;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

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
        try {
            $startingPointZipcode = new Zipcode($request->query->get('startingpoint'));
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(sprintf('incorrect startingpoint: %s',$exception->getMessage()), 400);
        }

        try {
            $destinations = new Destinations($request->query->get('destinations'));
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(sprintf('incorrect destination(s), please use a comma separated list: %s',$exception->getMessage()), 400);
        }

        try {
            return $this->APIDistanceResult->generateResult($startingPointZipcode, $destinations);
        } catch (ClientExceptionInterface $exception) {
            return new JsonResponse($exception->getMessage(), 400);
        } catch (ServerExceptionInterface $exception) {
            return new JsonResponse($exception->getMessage(), 500);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse($exception->getMessage(), 400);
        }
    }
}