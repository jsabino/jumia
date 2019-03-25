<?php

namespace App;

use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequest;

class Application
{

    /**
     * @var Router
     */
    private $router;

    public function __construct()
    {
    }

    public function registerRoutes(array $routes)
    {
        $this->router = new Router;
        foreach ($routes as $route) {
            list($method, $uri, $handler) = $route;
            $this->router->map($method, $uri, $handler);
        }
    }

    public function handleRequest(ServerRequest $request): ResponseInterface
    {
        return $this->router->dispatch($request);
    }
}
