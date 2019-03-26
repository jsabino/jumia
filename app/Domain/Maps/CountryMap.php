<?php

namespace App\Domain\Maps;

use App\Domain\Country;

/**
 * @method Country current()
 */
class CountryMap extends AbstractMap
{

    public function add(Country $country)
    {
        $this->data[$country->getCode()] = $country;
    }

    public function exists(int $code): bool
    {
        return isset($this->data[$code]);
    }

    public function getByCode(int $code): Country
    {
        return $this->data[$code];
    }
}
