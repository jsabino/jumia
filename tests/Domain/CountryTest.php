<?php

use App\Domain\Country;
use App\Utils\Validators\RegexPhoneNumberValidator;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{

    public function testGetters()
    {
        $code = 55;
        $name = "Brazil";
        $phoneValidator = new RegexPhoneNumberValidator("/\(55\)\ ?\d{10,11}$/");
        $phone = new Country($code, $name, $phoneValidator);

        $this->assertEquals($code, $phone->getCode());
        $this->assertEquals($name, $phone->getName());
        $this->assertEquals($phoneValidator, $phone->getPhoneNumberValidator());
    }
}
