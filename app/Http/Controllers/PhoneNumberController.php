<?php

namespace App\Http\Controllers;

use App\Data\CountryRepository;
use App\Data\CustomerRepository;
use App\Data\Filters\CustomerFilters;
use App\Domain\Maps\CustomerMap;
use App\Domain\Maps\PhoneNumberMap;
use App\Domain\PhoneNumber;
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

        $filteredPhoneNumbers = $this->filterPhoneNumbers($customers, $queryParams);

        $data = $filteredPhoneNumbers
            ->slice($offset, $length)
            ->map(function (PhoneNumber $phoneNumber) {
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
            'recordsFiltered' => count($filteredPhoneNumbers),
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

        return $this->customerRepository->findByFilters($filters);
    }

    private function filterPhoneNumbers(CustomerMap $customers, array $queryParams): PhoneNumberMap
    {
        $phoneNumbers = $customers->getPhoneNumbers();

        if (empty($queryParams['phoneNumberState'])) {
            return $phoneNumbers;
        }

        $filteredState = new PhoneNumberState($queryParams['phoneNumberState']);

        return $phoneNumbers->filter(function (PhoneNumber $phoneNumber) use ($filteredState) {
            $country = $this->countryRepository->findCountryByCode($phoneNumber->getCountryCode());
            $state = $country->getPhoneNumberValidator()->validate($phoneNumber);

            return $state->getDescription() == $filteredState->getDescription();
        });
    }
}
