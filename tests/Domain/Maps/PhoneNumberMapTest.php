<?php

use App\Domain\PhoneNumber;
use App\Domain\Maps\PhoneNumberMap;
use PHPUnit\Framework\TestCase;

class PhoneNumberMapTest extends TestCase
{
    /**
     * @var PhoneNumberMap
     */
    private $phoneNumberMap;
    /**
     * @var PhoneNumber
     */
    private $phoneNumberFromBrazil;
    /**
     * @var PhoneNumber
     */
    private $phoneNumberFromCameroon;

    protected function setUp(): void
    {
        $this->phoneNumberMap = new PhoneNumberMap();
        $this->phoneNumberFromBrazil = new PhoneNumber("(55) 123456");
        $this->phoneNumberFromCameroon = new PhoneNumber("(237) 654321");
    }

    public function testAdd()
    {
        $this->phoneNumberMap->add($this->phoneNumberFromBrazil);
        $this->assertCount(1, $this->phoneNumberMap);
        $this->assertEquals($this->phoneNumberFromBrazil, $this->phoneNumberMap->current());

        $this->phoneNumberMap->add($this->phoneNumberFromCameroon);
        $this->phoneNumberMap->next();
        $this->assertCount(2, $this->phoneNumberMap);
        $this->assertEquals($this->phoneNumberFromCameroon, $this->phoneNumberMap->current());
    }

    public function testFilter()
    {
        $this->phoneNumberMap->add($this->phoneNumberFromBrazil);
        $this->phoneNumberMap->add($this->phoneNumberFromCameroon);

        $onlyBrazilianNumbers = $this->phoneNumberMap->filter(function (PhoneNumber $phoneNumber) {
            return $phoneNumber->getCountryCode() == 55;
        });

        $this->assertCount(1, $onlyBrazilianNumbers);
        $this->assertEquals($this->phoneNumberFromBrazil, $onlyBrazilianNumbers->current());
    }

    public function testSlice()
    {
        $this->phoneNumberMap->add($this->phoneNumberFromBrazil);
        $this->phoneNumberMap->add($this->phoneNumberFromCameroon);

        $mapLimit1 = $this->phoneNumberMap->slice(0, 1);
        $this->assertCount(1, $mapLimit1);
        $this->assertEquals($this->phoneNumberFromBrazil, $mapLimit1->current());

        $mapOffset1 = $this->phoneNumberMap->slice(1);
        $this->assertCount(1, $mapOffset1);
        $this->assertEquals($this->phoneNumberFromCameroon, $mapOffset1->current());
    }

    public function testMap()
    {
        $this->phoneNumberMap->add($this->phoneNumberFromBrazil);
        $this->phoneNumberMap->add($this->phoneNumberFromCameroon);

        $mapResult = $this->phoneNumberMap->map(function (PhoneNumber $phoneNumber) {
            return $phoneNumber->getFullNumber();
        });

        $expected = [
            $this->phoneNumberFromBrazil->getFullNumber(),
            $this->phoneNumberFromCameroon->getFullNumber(),
        ];

        $this->assertEquals($expected, $mapResult);
    }
}
