<?php

use App\Domain\Customer;
use App\Domain\PhoneNumber;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{

    public function testGetters()
    {
        $name = "Martin Fowler";
        $phone = new PhoneNumber("(55) 112727-2728");

        $customer = new Customer($name, $phone);
        $this->assertEquals($name, $customer->getName());
        $this->assertEquals($phone, $customer->getPhone());
    }

    public function testCreateFromArray()
    {
        $id = 123;
        $name = "Martin Fowler";
        $phone = "(55) 112727-2728";
        $customerData = compact('id', 'name', 'phone');

        $customer = Customer::createFromArray($customerData);
        $this->assertEquals($id, $customer->getId());
        $this->assertEquals($name, $customer->getName());
        $this->assertEquals(new PhoneNumber($phone), $customer->getPhone());
    }
}