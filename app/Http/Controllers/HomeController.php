<?php
namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends BaseController
{

    public function index(ServerRequestInterface $request): ResponseInterface {
        return $this->view('home/index.php');
    }
}
