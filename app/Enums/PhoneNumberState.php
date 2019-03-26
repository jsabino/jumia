<?php
namespace App\Enums;

final class PhoneNumberState
{

    const VALID = "OK";
    const INVALID = "NOK";

    private $state;

    private function __construct(string $state)
    {
        $this->state = $state;
    }

    public static function VALID(): PhoneNumberState
    {
        return new PhoneNumberState(self::VALID);
    }

    public static function INVALID(): PhoneNumberState
    {
        return new PhoneNumberState(self::INVALID);
    }

    public function getDescription(): string
    {
        return $this->state;
    }
}
