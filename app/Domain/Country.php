<?php
namespace App\Domain;

use App\Utils\Validators\PhoneNumberValidator;

class Country
{

    private $code;
    private $name;
    /**
     * @var PhoneNumberValidator
     */
    private $phoneNumberValidator;

    public function __construct(int $code, string $name, PhoneNumberValidator $phoneNumberValidator)
    {
        $this->code = $code;
        $this->name = $name;
        $this->phoneNumberValidator = $phoneNumberValidator;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhoneNumberValidator(): PhoneNumberValidator
    {
        return $this->phoneNumberValidator;
    }
}
