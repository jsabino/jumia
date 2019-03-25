<?php
namespace App\Http\Controllers;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class BaseController
{

    protected function view($viewFile, $data = []) {
        extract($data);

        ob_start();
        include 'resources/views/' . $viewFile;
        $html = ob_get_clean();

        return new HtmlResponse($html);
    }

    protected function json($data = []) {
        return new JsonResponse($data);
    }
}
