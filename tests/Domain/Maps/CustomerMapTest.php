<?php

use App\Domain\Customer;
use App\Domain\Maps\CustomerMap;
use App\Domain\PhoneNumber;
use PHPUnit\Framework\TestCase;

class CustomerMapTest extends TestCase
{
    /**
     * @var CustomerMap
     */
    private $customerMap;

    protected function setUp(): void
    {
        $this->customerMap = new CustomerMap();
    }

    public function testAdd()
    {
        $customer1 = new Customer("Customer 1", new PhoneNumber("(55) 123456"));
        $this->customerMap->add($customer1);
        $this->assertCount(1, $this->customerMap);
        $this->assertEquals($customer1, $this->customerMap->current());

        $customer2 = new Customer("Customer 2", new PhoneNumber("(55) 654321"));
        $this->customerMap->add($customer2);
        $this->customerMap->next();
        $this->assertCount(2, $this->customerMap);
        $this->assertEquals($customer2, $this->customerMap->current());
    }

    public function testGetPhoneNumbers()
    {
        $customer1 = new Customer("Customer 1", new PhoneNumber("(55) 123456"));
        $this->customerMap->add($customer1);
        $customer2 = new Customer("Customer 2", new PhoneNumber("(55) 654321"));
        $this->customerMap->add($customer2);

        $phoneNumbers = $this->customerMap->getPhoneNumbers();
        $this->assertCount(2, $phoneNumbers);

        $this->assertEquals($customer1->getPhone(), $phoneNumbers->current());
        $phoneNumbers->next();
        $this->assertEquals($customer2->getPhone(), $phoneNumbers->current());
    }
}
