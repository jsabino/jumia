<?php

use App\Data\CountryRepository;
use App\Domain\Country;
use App\Domain\Maps\CountryMap;
use App\Utils\Validators\RegexPhoneNumberValidator;
use PHPUnit\Framework\TestCase;

class CountryRepositoryTest extends TestCase
{

    /**
     * @var CountryRepository
     */
    private $repository;
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
        $phoneValidator = new RegexPhoneNumberValidator("/\(55\)\ ?\d{10,11}$/");
        $this->country1 = new Country(55, "Brazil", $phoneValidator);
        $this->country2 = new Country(237, "Cameroon", $phoneValidator);

        $countries = new CountryMap();
        $countries->add($this->country1);
        $countries->add($this->country2);

        $this->repository = new CountryRepository($countries);
    }

    public function testFindCountryByCode()
    {
        $this->assertEquals($this->country1, $this->repository->findCountryByCode($this->country1->getCode()));
        $this->assertEquals($this->country2, $this->repository->findCountryByCode($this->country2->getCode()));

        $this->expectException(\App\Data\Exceptions\RecordNotFoundException::class);
        $this->repository->findCountryByCode(123);
    }

    public function testFindAll()
    {
        $countries = $this->repository->findAll();
        $this->assertCount(2, $countries);

        $this->assertEquals($this->country1, $countries->current());
        $countries->next();
        $this->assertEquals($this->country2, $countries->current());
    }
}