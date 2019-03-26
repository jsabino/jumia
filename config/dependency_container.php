<?php

use App\Data\CountryRepository;
use App\Data\CustomerRepository;
use App\Data\DatabaseInterface;
use App\Data\SQLiteDatabase;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneNumberController;
use League\Container\Container;

$container = new Container();

$container->share(CountryRepository::class, function () {
    $countries = require 'countries.php';

    return new CountryRepository($countries);
});

$container->share(DatabaseInterface::class, function () {
    $databaseLocation = getenv("DB_LOCATION");
    if (empty($databaseLocation)) {
        throw new RuntimeException("Environment variable DB_LOCATION is missing");
    }
    return new SQLiteDatabase($databaseLocation ?? "");
});

$container->share(CustomerRepository::class)
    ->addArgument(DatabaseInterface::class);

$container->add(HomeController::class)
    ->addArgument(CountryRepository::class);

$container->add(PhoneNumberController::class)
    ->addArgument(CustomerRepository::class)
    ->addArgument(CountryRepository::class);

return $container;
