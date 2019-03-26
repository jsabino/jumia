<?php

namespace App\Domain;

class PhoneNumber
{

    const PHONE_NUMBER_PATTERN = "/^\((\d+)\) ?(.*)/";

    private $fullNumber;
    private $countryCode;
    private $number;

    public function __construct(string $fullNumber)
    {
        $this->fullNumber = trim($fullNumber);

        $this->separateCountryCodeAndNumber();
    }

    public function getCountryCode(): int
    {
        return $this->countryCode ?? 0;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getFullNumber(): string
    {
        return $this->fullNumber;
    }

    private function separateCountryCodeAndNumber()
    {
        $matches = [];
        if (!preg_match(self::PHONE_NUMBER_PATTERN, $this->fullNumber, $matches)) {
            $this->number = $this->fullNumber;
            return;
        }

        $this->countryCode = $matches[1];
        $this->number = $matches[2];
    }
}
