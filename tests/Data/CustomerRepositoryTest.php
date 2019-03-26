<?php

use App\Data\CountryRepository;
use App\Data\CustomerRepository;
use App\Data\Filters\CustomerFilters;
use App\Domain\Country;
use App\Domain\Customer;
use App\Domain\Maps\CountryMap;
use App\Domain\Maps\CustomerMap;
use App\Domain\PhoneNumber;
use App\Enums\PhoneNumberState;
use App\Utils\Validators\RegexPhoneNumberValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CustomerRepositoryTest extends TestCase
{

    /**
     * @var CustomerRepository
     */
    private $repository;
    /**
     * @var MockObject
     */
    private $databaseMock;
    /**
     * @var Customer
     */
    private $customerFromBrazilValidNumber;
    /**
     * @var Customer
     */
    private $customerFromBrazilInvalidNumber;
    /**
     * @var Customer
     */
    private $customerFromCameroon;

    protected function setUp(): void
    {
        $this->databaseMock = $this->createMock(\App\Data\DatabaseInterface::class);

        $countryRepository = new CountryRepository($this->getCountries());

        $this->customerFromBrazilValidNumber = new Customer("Customer 1", new PhoneNumber("(55) 79999887766"));
        $this->customerFromBrazilInvalidNumber = new Customer("Customer 1", new PhoneNumber("(55) 123456"));
        $this->customerFromCameroon = new Customer("Customer 2", new PhoneNumber("(237) 654321"));

        $this->repository = new CustomerRepository($this->databaseMock, $countryRepository);
    }

    public function testGetTotalCount()
    {
        $this->databaseMock
            ->method('getOne')
            ->willReturn(2);

        $this->assertEquals(2, $this->repository->getTotalCount());
    }

    public function testFindWithoutFilters()
    {
        $allCustomers = new CustomerMap();
        $allCustomers->add($this->customerFromBrazilValidNumber);
        $allCustomers->add($this->customerFromCameroon);
        $queryResult = $this->mapToQueryResult($allCustomers);

        $this->databaseMock->method('getArray')
            ->with($this->stringEndsWith("WHERE 1 = 1"))
            ->willReturn($queryResult);

        $filters = new CustomerFilters();
        $customers = $this->repository->findByFilters($filters);

        $this->assertCount(2, $customers);
    }

    public function testCountryCodeFilter()
    {
        $brazilianCustomers = new CustomerMap();
        $brazilianCustomers->add($this->customerFromBrazilValidNumber);
        $brazilianCustomers->add($this->customerFromBrazilInvalidNumber);
        $queryResult = $this->mapToQueryResult($brazilianCustomers);

        $this->databaseMock->method('getArray')
            ->with($this->stringContains("AND phone LIKE ?"), $this->anything())
            ->willReturn($queryResult);

        $filters = new CustomerFilters();
        $filters->setCountryCode(55);
        $customers = $this->repository->findByFilters($filters);

        $this->assertCount(2, $customers);
        $this->assertEquals($this->customerFromBrazilValidNumber, $customers->current());
        $customers->next();
        $this->assertEquals($this->customerFromBrazilInvalidNumber, $customers->current());
    }

    public function testInvalidCountryCodeFilter()
    {
        $customerMap = new CustomerMap();
        $queryResult = $this->mapToQueryResult($customerMap);

        $this->databaseMock->method('getArray')
            ->with($this->stringContains("AND phone LIKE ?"), $this->anything())
            ->willReturn($queryResult);

        $filters = new CustomerFilters();
        $filters->setCountryCode(123);
        $filters->setPhoneNumberState(PhoneNumberState::VALID());
        $customers = $this->repository->findByFilters($filters);

        $this->assertCount(0, $customers);
    }

    public function testCountryCodeFilterAndValidNumberFilter()
    {
        $brazilianCustomersWithValidNumber = new CustomerMap();
        $brazilianCustomersWithValidNumber->add($this->customerFromBrazilValidNumber);
        $queryResult = $this->mapToQueryResult($brazilianCustomersWithValidNumber);

        $this->databaseMock->method('getArray')
            ->with($this->stringContains("AND phone LIKE ?"), $this->anything())
            ->willReturn($queryResult);

        $filters = new CustomerFilters();
        $filters->setCountryCode(55);
        $filters->setPhoneNumberState(PhoneNumberState::VALID());
        $customers = $this->repository->findByFilters($filters);

        $this->assertCount(1, $customers);
        $this->assertEquals($this->customerFromBrazilValidNumber, $customers->current());
    }

    public function testCountryCodeFilterAndInvalidNumberFilter()
    {
        $brazilianCustomersWithInvalidNumber = new CustomerMap();
        $brazilianCustomersWithInvalidNumber->add($this->customerFromBrazilInvalidNumber);
        $queryResult = $this->mapToQueryResult($brazilianCustomersWithInvalidNumber);

        $this->databaseMock->method('getArray')
            ->with($this->stringContains("AND phone LIKE ?"), $this->anything())
            ->willReturn($queryResult);

        $filters = new CustomerFilters();
        $filters->setCountryCode(55);
        $filters->setPhoneNumberState(PhoneNumberState::INVALID());
        $customers = $this->repository->findByFilters($filters);

        $this->assertCount(1, $customers);
        $this->assertEquals($this->customerFromBrazilInvalidNumber, $customers->current());
    }

    private function mapToQueryResult(CustomerMap $customers): array
    {
        return $customers->map(function (Customer $customer) {
            return [
                'id' => $customer->getId(),
                'name' => $customer->getName(),
                'phone' => $customer->getPhone()->getFullNumber(),
            ];
        });
    }

    private function getCountries(): CountryMap
    {
        $countries = new CountryMap();
        $countries->add(new Country(55, "Brazil", new RegexPhoneNumberValidator("/\(55\)\ ?\d{10,11}$/")));
        $countries->add(new Country(237, "Cameroon", new RegexPhoneNumberValidator("/\(237\)\ ?[2368]\d{7,8}$/")));
        return $countries;
    }
}