<?php
use App\Domain\Country;
use App\Domain\Maps\CountryMap;
use App\Utils\Validators\RegexPhoneNumberValidator;

$countryList = new CountryMap();

$countryList->add(new Country(237, "Cameroon", new RegexPhoneNumberValidator("\(237\)\ ?[2368]\d{7,8}$")));
$countryList->add(new Country(251, "Ethiopia", new RegexPhoneNumberValidator("\(251\)\ ?[1-59]\d{8}$")));
$countryList->add(new Country(212, "Morocco", new RegexPhoneNumberValidator("\(212\)\ ?[5-9]\d{8}$")));
$countryList->add(new Country(258, "Mozambique", new RegexPhoneNumberValidator("\(258\)\ ?[28]\d{7,8}$")));
$countryList->add(new Country(256, "Uganda", new RegexPhoneNumberValidator("\(256\)\ ?\d{9}$")));

return $countryList;