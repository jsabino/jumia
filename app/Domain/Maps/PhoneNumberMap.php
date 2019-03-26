<?php

namespace App\Domain\Maps;

use App\Domain\PhoneNumber;

/**
 * @method PhoneNumber current()
 */
class PhoneNumberMap extends AbstractMap
{

    public function add(PhoneNumber $phoneNumber)
    {
        $this->data[] = $phoneNumber;
    }
}
