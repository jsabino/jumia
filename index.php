<?php

use App\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require 'vendor/autoload.php';

try {
    $routes = require 'config/routes.php';

    $app = new Application();
    $app->registerRoutes($routes);

    $request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
    $response = $app->handleRequest($request);
} catch (\League\Route\Http\Exception $e) {
    $response = (new \Zend\Diactoros\ResponseFactory())->createResponse($e->getStatusCode(), $e->getMessage());
} catch (Error $e) {
    $response = (new \Zend\Diactoros\ResponseFactory())->createResponse(500, "Internal server error");
} finally {
    (new SapiEmitter())->emit($response);
}
