<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class HomeController
{
    public function __construct(private readonly Twig $twig)
    {
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'index.twig');
    }
    public function dashboard(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'dashboard.twig');
    }
}
