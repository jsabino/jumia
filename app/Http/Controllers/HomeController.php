<?php
namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class HomeController
{

    public function index(ServerRequestInterface $request): ResponseInterface {
        $response = new Response;
        $response->getBody()->write('<h1>Hello, World!</h1>');
        return $response;
    }
}
