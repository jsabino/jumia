<?php

use App\Enums\PhoneNumberState;
use PHPUnit\Framework\TestCase;

class PhoneNumberStateTest extends TestCase
{

    public function test()
    {
        $valid = new PhoneNumberState(PhoneNumberState::VALID);
        $this->assertEquals(PhoneNumberState::VALID(), $valid);
        $this->assertEquals(PhoneNumberState::VALID, $valid->getDescription());

        $invalid = new PhoneNumberState(PhoneNumberState::INVALID);
        $this->assertEquals(PhoneNumberState::INVALID(), $invalid);
        $this->assertEquals(PhoneNumberState::INVALID, $invalid->getDescription());

        $this->expectException(InvalidArgumentException::class);
        new PhoneNumberState("NOT A STATE");
    }
}