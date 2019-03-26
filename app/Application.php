<?php

namespace App;

use League\Container\Container;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
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
        $this->router = new Router;
    }

    public function registerRoutes(array $routes)
    {
        foreach ($routes as $route) {
            list($method, $uri, $handler) = $route;
            $this->router->map($method, $uri, $handler);
        }
    }

    public function registerDependencyContainer(Container $dependencyContainer)
    {
        $routerStrategy = new ApplicationStrategy();
        $routerStrategy->setContainer($dependencyContainer);
        $this->router->setStrategy($routerStrategy);
    }

    public function handleRequest(ServerRequest $request): ResponseInterface
    {
        return $this->router->dispatch($request);
    }
}
