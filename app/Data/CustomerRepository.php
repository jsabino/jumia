<?php

namespace App\Data;

use App\Data\Filters\CustomerFilters;
use App\Domain\Customer;
use App\Domain\Maps\CustomerMap;
use App\Enums\PhoneNumberState;

class CustomerRepository
{

    /**
     * @var DatabaseInterface
     */
    private $database;
    private $customersCount;
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    public function __construct(DatabaseInterface $database, CountryRepository $countryRepository)
    {
        $this->database = $database;
        $this->countryRepository = $countryRepository;
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

        $customers = $this->arrayToMap($customersArray);

        if ($filters->hasPhoneNumberState()) {
            $customers = $this->filterCustomersPhoneNumberState($customers, $filters->getPhoneNumberState());
        }

        return $customers;
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

    private function filterCustomersPhoneNumberState(CustomerMap $customers, PhoneNumberState $filteredState): CustomerMap
    {
        if (count($customers) == 0) {
            return $customers;
        }

        return $customers->filter(function (Customer $customer) use ($filteredState) {
            $phoneNumber = $customer->getPhone();
            $country = $this->countryRepository->findCountryByCode($phoneNumber->getCountryCode());
            $state = $country->getPhoneNumberValidator()->validate($phoneNumber);

            return $state->getDescription() == $filteredState->getDescription();
        });
    }
}
