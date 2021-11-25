<?php

declare(strict_types=1);


namespace App\Model;


use InvalidArgumentException;

/**
 * A proper zipcode in NL is ddddss or dddd ss
 * A proper zipcode in BE is dddd
 */
final class Zipcode
{
    private $zipcode;

    public function __construct(string $zipcode)
    {
        $strippedString = preg_replace('/\s+/', '', $zipcode);

        if (!$this->isValidZipcode($strippedString)) {
            throw new InvalidArgumentException("No valid dutch or belgian zipcode");
        }

        $this->zipcode = $strippedString;
    }

    public function isDutchZipcode($stringToTest) : bool
    {
        $regex = '/^[1-9][0-9]{3}[\s]?[A-Za-z]{2}$/i';

        if (preg_match($regex, $stringToTest)) {
            return true;
        }

        return false;
    }


    public function isBelgianZipcode($stringToTest) : bool
    {
        $regex = '/^\d{4}$/';

        if (preg_match($regex, $stringToTest)) {
            return true;
        }

        return false;
    }

    private function isValidZipcode($stringToTest): bool
    {
        // Dutch case
        $regex = '/^[1-9][0-9]{3}[\s]?[A-Za-z]{2}$/i';

        if (preg_match($regex, $stringToTest)) {
            return true;
        }

        // Belgian case
        $regex = '/^\d{4}$/';

        if (preg_match($regex, $stringToTest)) {
            return true;
        }

        return false;
    }

    public function __toString(): string
    {
        return $this->zipcode;
    }


}