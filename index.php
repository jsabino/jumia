<?php

use App\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require 'vendor/autoload.php';
$routes = require 'config/routes.php';

$app = new Application();
$app->registerRoutes($routes);

$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

$response = $app->handleRequest($request);

(new SapiEmitter())->emit($response);
