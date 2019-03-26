<?php

namespace App\Data\Filters;

class CustomerFilters
{

    private $countryCode;

    public function getCountryCode(): int
    {
        return $this->countryCode ?? 0;
    }

    public function setCountryCode(int $countryCode)
    {
        $this->countryCode = $countryCode;
    }
}
