<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneNumberController;

return [
    ['GET', '/', [HomeController::class, "index"]],
    ['GET', '/phoneNumbers', [PhoneNumberController::class, "searchPhoneNumbers"]],
];
