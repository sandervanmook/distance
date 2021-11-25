<?php

declare(strict_types=1);

namespace App\Tests\Model;

use App\Model\Destinations;
use App\Model\Zipcode;
use PHPUnit\Framework\TestCase;

class DestinationsTest extends TestCase
{
    public function test_it_gets_1_destination()
    {
        $destination = new Destinations('2910');
        $zipcode = new Zipcode('2910');

        $this->assertEquals([$zipcode], $destination->getDestinations());
    }

    public function test_it_gets_multiple_destinations()
    {
        $destinations = new Destinations('2910,4411gb');
        $zipcode1 = new Zipcode('2910');
        $zipcode2 = new Zipcode('4411gb');

        $this->assertEquals([$zipcode1,$zipcode2], $destinations->getDestinations());
    }

    public function test_it_throws_on_invalid_destination()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Destinations('');
    }
}
