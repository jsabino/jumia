<?php

use App\Domain\Country;
use App\Domain\Maps\CountryMap;
use App\Utils\Validators\RegexPhoneNumberValidator;
use PHPUnit\Framework\TestCase;

class CountryMapTest extends TestCase
{
    /**
     * @var CountryMap
     */
    private $countryMap;
    /**
     * @var Country
     */
    private $country1;
    /**
     * @var Country
     */
    private $country2;

    protected function setUp(): void
    {
        $this->countryMap = new CountryMap();

        $phoneValidator = new RegexPhoneNumberValidator("/\(55\)\ ?\d{10,11}$/");
        $this->country1 = new Country(55, "Brazil", $phoneValidator);
        $this->country2 = new Country(237, "Cameroon", $phoneValidator);
    }

    public function testAdd()
    {
        $this->countryMap->add($this->country1);
        $this->assertCount(1, $this->countryMap);
        $this->assertEquals($this->country1, $this->countryMap->current());

        $this->countryMap->add($this->country2);
        $this->countryMap->next();
        $this->assertCount(2, $this->countryMap);
        $this->assertEquals($this->country2, $this->countryMap->current());
    }

    public function testExists()
    {
        $this->countryMap->add($this->country1);
        $this->countryMap->add($this->country2);

        $this->assertTrue($this->countryMap->exists($this->country1->getCode()));
        $this->assertTrue($this->countryMap->exists($this->country2->getCode()));
        $this->assertFalse($this->countryMap->exists(123));
    }

    public function testGetByCode()
    {
        $this->countryMap->add($this->country1);
        $this->countryMap->add($this->country2);

        $this->assertEquals($this->country1, $this->countryMap->getByCode($this->country1->getCode()));
        $this->assertEquals($this->country2, $this->countryMap->getByCode($this->country2->getCode()));

        $this->expectException(\App\Data\Exceptions\RecordNotFoundException::class);
        $this->countryMap->getByCode(123);
    }
}
