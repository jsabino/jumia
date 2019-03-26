<?php

namespace App\Domain\Maps;

use App\Domain\Customer;

/**
 * @method Customer current()
 */
class CustomerMap extends AbstractMap
{

    public function add(Customer $customer)
    {
        $this->data[] = $customer;
    }

    public function getPhoneNumbers(): PhoneNumberMap
    {
        $phoneNumbers = new PhoneNumberMap();

        foreach ($this as $customer) {
            $phoneNumbers->add($customer->getPhone());
        }

        return $phoneNumbers;
    }
}
