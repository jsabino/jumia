<?php

use App\Domain\PhoneNumber;
use App\Enums\PhoneNumberState;
use App\Utils\Validators\RegexPhoneNumberValidator;
use PHPUnit\Framework\TestCase;

class RegexPhoneNumberValidatorTest extends TestCase
{

    /**
     * @dataProvider provider
     * @param string $pattern
     * @param PhoneNumber $phoneNumber
     * @param PhoneNumberState $expected
     */
    public function test(string $pattern, PhoneNumber $phoneNumber, PhoneNumberState $expected)
    {
        $validator = new RegexPhoneNumberValidator($pattern);

        $this->assertEquals($expected, $validator->validate($phoneNumber));
    }

    public function provider()
    {
        return [
            ["/\(237\)\ ?[2368]\d{7,8}$/", new PhoneNumber("(237)21234567"), PhoneNumberState::VALID()],
            ["/\(251\)\ ?[1-59]\d{8}$/", new PhoneNumber("(251) 911168450"), PhoneNumberState::VALID()],
            ["/\(212\)\ ?[5-9]\d{8}$/", new PhoneNumber("(212) 698054317"), PhoneNumberState::VALID()],
            ["/\(258\)\ ?[28]\d{7,8}$/", new PhoneNumber("(258) 848826725"), PhoneNumberState::VALID()],
            ["/\(256\)\ ?\d{9}$/", new PhoneNumber("(256) 714660221"), PhoneNumberState::VALID()],

            ["/\(237\)\ ?[2368]\d{7,8}$/", new PhoneNumber("(55)21234567"), PhoneNumberState::INVALID()],
            ["/\(251\)\ ?[1-59]\d{8}$/", new PhoneNumber("(55) 911168450"), PhoneNumberState::INVALID()],
            ["/\(212\)\ ?[5-9]\d{8}$/", new PhoneNumber("(55) 698054317"), PhoneNumberState::INVALID()],
            ["/\(258\)\ ?[28]\d{7,8}$/", new PhoneNumber("(55) 848826725"), PhoneNumberState::INVALID()],
            ["/\(256\)\ ?\d{9}$/", new PhoneNumber("(55) 714660221"), PhoneNumberState::INVALID()],
        ];
    }
}
