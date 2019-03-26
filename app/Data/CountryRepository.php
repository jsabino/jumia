<?php
namespace App\Data;

use App\Data\Exceptions\RecordNotFoundException;
use App\Domain\Country;
use App\Domain\Maps\CountryMap;

class CountryRepository
{

    private $countries;

    public function __construct(CountryMap $countries)
    {
        $this->countries = $countries;
    }

    public function findCountryByCode(int $code): Country
    {
        if (!$this->countries->exists($code)) {
            throw new RecordNotFoundException("The country with the code $code was not found.");
        }

        return $this->countries->getByCode($code);
    }

    public function findAll(): CountryMap
    {
        return $this->countries;
    }
}
