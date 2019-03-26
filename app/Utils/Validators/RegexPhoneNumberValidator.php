<?php
namespace App\Utils\Validators;

use App\Domain\PhoneNumber;
use App\Enums\PhoneNumberState;

class RegexPhoneNumberValidator implements PhoneNumberValidator
{

    /**
     * @var string
     */
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function validate(PhoneNumber $phoneNumber): PhoneNumberState
    {
        if (preg_match($this->pattern, $phoneNumber->getFullNumber())) {
            return PhoneNumberState::VALID();
        }

        return PhoneNumberState::INVALID();
    }
}
