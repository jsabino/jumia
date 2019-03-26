<?php

use App\Domain\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{

    public function testGetters()
    {
        $countryCode = 55;
        $number = "3212-3456";
        $fullNumber = "($countryCode) $number";

        $phoneNumber = new PhoneNumber($fullNumber);
        $this->assertEquals($countryCode, $phoneNumber->getCountryCode());
        $this->assertEquals($number, $phoneNumber->getNumber());
        $this->assertEquals($fullNumber, $phoneNumber->getFullNumber());
    }

    /**
     * @dataProvider provider
     * @param string $fullNumber
     * @param int $expectedCountryCode
     */
    public function testSeparationOfCountryCode(string $fullNumber, int $expectedCountryCode)
    {
        $phoneNumber = new PhoneNumber($fullNumber);
        $this->assertEquals($expectedCountryCode, $phoneNumber->getCountryCode());
    }

    public function provider()
    {
        return [
            ["(1) 123456", 1],
            ["(1) number", 1],
            ["(12) 123456", 12],
            ["(123) 123456", 123],
            ["(1234) 123456", 1234],
            ["123456", 0],
            ["number", 0],
        ];
    }
}