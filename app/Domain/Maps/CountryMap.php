<?php

namespace App\Domain\Maps;

use App\Data\Exceptions\RecordNotFoundException;
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
        if (empty($this->data[$code])) {
            throw new RecordNotFoundException("The country with the code $code was not found.");
        }

        return $this->data[$code];
    }
}
