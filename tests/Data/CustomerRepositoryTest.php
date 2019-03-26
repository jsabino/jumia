<?php

use App\Data\CustomerRepository;
use App\Data\Filters\CustomerFilters;
use App\Domain\Customer;
use App\Domain\Maps\CustomerMap;
use App\Domain\PhoneNumber;
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
    private $customerFromBrazil;
    /**
     * @var Customer
     */
    private $customerFromCameroon;

    protected function setUp(): void
    {
        $this->databaseMock = $this->createMock(\App\Data\DatabaseInterface::class);

        $this->customerFromBrazil = new Customer("Customer 1", new PhoneNumber("(55) 123456"));
        $this->customerFromCameroon = new Customer("Customer 2", new PhoneNumber("(237) 654321"));

        $this->repository = new CustomerRepository($this->databaseMock);
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
        $allCustomers->add($this->customerFromBrazil);
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
        $brazilianCustomers->add($this->customerFromBrazil);
        $queryResult = $this->mapToQueryResult($brazilianCustomers);

        $this->databaseMock->method('getArray')
            ->with($this->stringContains("AND phone LIKE ?"), $this->anything())
            ->willReturn($queryResult);

        $filters = new CustomerFilters();
        $filters->setCountryCode(55);
        $customers = $this->repository->findByFilters($filters);

        $this->assertCount(1, $customers);
        $this->assertEquals($this->customerFromBrazil, $customers->current());
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
}