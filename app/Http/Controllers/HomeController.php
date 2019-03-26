<?php

namespace App\Http\Controllers;

use App\Data\CountryRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends BaseController
{

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository = null)
    {
        $this->countryRepository = $countryRepository;
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->view('home/index.php', [
            'countries' => $this->countryRepository->findAll()
        ]);
    }
}
