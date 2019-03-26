<?php

use App\Data\CountryRepository;
use App\Http\Controllers\HomeController;
use League\Container\Container;

$container = new Container();

$container->share(CountryRepository::class, function () {
    $countries = require 'countries.php';

    return new CountryRepository($countries);
});
$container->add(HomeController::class)->addArgument(CountryRepository::class);

return $container;
