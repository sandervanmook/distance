<?php

declare(strict_types=1);

namespace App\Tests\Model;

use App\Model\Zipcode;
use PHPUnit\Framework\TestCase;

class ZipcodeTest extends TestCase
{
    public function test_it_throws_on_empty_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Zipcode("");
    }

    public function test_it_throws_on_too_long_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Zipcode("12345");
    }

    public function test_it_returns_on_valid_belgian_zip()
    {
        $zipcode = new Zipcode("4411");

        $this->assertEquals('4411', $zipcode);
    }

    public function test_it_returns_on_valid_dutch_zip()
    {
        $zipcode = new Zipcode("4411 gb");

        $this->assertEquals('4411gb', $zipcode);
    }

    public function test_it_throws_if_you_request_nl_on_be_value_function()
    {
        $zipcode = new Zipcode("4411 gb");
        $this->expectException(\InvalidArgumentException::class);
        $zipcode->getCompleteBelgianValue();
    }

    public function test_it_returns_complete_belgian_version()
    {
        $zipcode = new Zipcode("2910");
        $this->assertEquals('2910 Belgium',$zipcode->getCompleteBelgianValue());
    }
}
