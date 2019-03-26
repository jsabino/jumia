<?php
return [
    ['GET', '/', [\App\Http\Controllers\HomeController::class, "index"]],
    ['GET', '/phoneNumbers', [\App\Http\Controllers\PhoneNumberController::class, "searchPhoneNumbers"]],
];
