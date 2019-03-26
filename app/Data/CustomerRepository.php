<?php

namespace App\Data;

use App\Data\Filters\CustomerFilters;
use App\Domain\Customer;
use App\Domain\Maps\CustomerMap;

class CustomerRepository
{

    /**
     * @var DatabaseInterface
     */
    private $database;
    private $customersCount;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    public function getTotalCount(): int
    {
        if (!isset($this->customersCount)) {
            $sql = "SELECT COUNT(*) FROM customer";

            $this->customersCount = $this->database->getOne($sql) ?? 0;
        }

        return $this->customersCount;
    }

    public function findByFilters(CustomerFilters $filters): CustomerMap
    {
        $sql = "SELECT * FROM customer WHERE 1 = 1";

        $params = [];

        if (!empty($filters->getCountryCode())) {
            $sql .= " AND phone LIKE ?";
            $params[] = "({$filters->getCountryCode()})%";
        }

        $customersArray = $this->database->getArray($sql, $params);

        return $this->arrayToMap($customersArray);
    }

    private function arrayToMap(array $customersArray): CustomerMap
    {
        $customers = new CustomerMap();
        if (empty($customersArray)) {
            return $customers;
        }

        foreach ($customersArray as $customer) {
            $customers->add(Customer::createFromArray($customer));
        }

        return $customers;
    }
}
