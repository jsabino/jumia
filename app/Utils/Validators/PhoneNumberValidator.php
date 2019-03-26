<?php
namespace App\Utils\Validators;

use App\Domain\PhoneNumber;
use App\Enums\PhoneNumberState;

interface PhoneNumberValidator
{

    public function validate(PhoneNumber $phoneNumber): PhoneNumberState;
}
