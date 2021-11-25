<?php

declare(strict_types=1);


namespace App\Model;


class Destinations
{
    private array $destinations;

    public function __construct(string $destinations)
    {
        $destinationsArray = explode(",", $destinations);
        if ($destinationsArray) {
            foreach ($destinationsArray as $destination) {
                $this->destinations[] = new Zipcode($destination);
            }
        } else{
            throw new \InvalidArgumentException('No valid destinations given');
        }
    }

    public function getDestinations(): array
    {
        return $this->destinations;
    }
}