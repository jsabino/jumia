<?php

namespace App\Http\Controllers;

use App\Data\CountryRepository;
use App\Data\CustomerRepository;
use App\Data\Filters\CustomerFilters;
use App\Domain\Customer;
use App\Domain\Maps\CustomerMap;
use App\Enums\PhoneNumberState;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PhoneNumberController extends BaseController
{

    private $customerRepository;
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    public function __construct(CustomerRepository $customerRepository, CountryRepository $countryRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->countryRepository = $countryRepository;
    }

    public function searchPhoneNumbers(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $length = $queryParams['length'] ?? 10;
        $offset = $queryParams['start'] ?? 0;

        $customers = $this->searchCustomers($queryParams);

        $data = $customers
            ->slice($offset, $length)
            ->map(function (Customer $customer) {
                $phoneNumber = $customer->getPhone();
                $country = $this->countryRepository->findCountryByCode($phoneNumber->getCountryCode());
                $state = $country->getPhoneNumberValidator()->validate($phoneNumber);

                return [
                    $country->getName(),
                    $state->getDescription(),
                    $phoneNumber->getCountryCode(),
                    $phoneNumber->getNumber(),
                ];
            });

        $data = [
            'draw' => intval($queryParams['draw'] ?? 0),
            'recordsTotal' => $this->customerRepository->getTotalCount(),
            'recordsFiltered' => count($customers),
            'data' => $data,
        ];

        return $this->json($data);
    }

    private function searchCustomers(array $queryParams): CustomerMap
    {
        $filters = new CustomerFilters();
        if (!empty($queryParams['countryCode']) && is_numeric($queryParams['countryCode'])) {
            $filters->setCountryCode($queryParams['countryCode']);
        }
        if (!empty($queryParams['phoneNumberState'])) {
            $filters->setPhoneNumberState(new PhoneNumberState($queryParams['phoneNumberState']));
        }

        return $this->customerRepository->findByFilters($filters);
    }
}
