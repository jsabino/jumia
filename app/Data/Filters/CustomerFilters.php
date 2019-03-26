<?php

namespace App\Data\Filters;

use App\Enums\PhoneNumberState;

class CustomerFilters
{

    private $countryCode;
    /**
     * @var PhoneNumberState
     */
    private $phoneNumberState;

    public function getCountryCode(): int
    {
        return $this->countryCode ?? 0;
    }

    public function setCountryCode(int $countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function hasPhoneNumberState(): bool
    {
        return isset($this->phoneNumberState);
    }

    public function getPhoneNumberState(): PhoneNumberState
    {
        return $this->phoneNumberState;
    }

    public function setPhoneNumberState(PhoneNumberState $phoneNumberState)
    {
        $this->phoneNumberState = $phoneNumberState;
    }
}
