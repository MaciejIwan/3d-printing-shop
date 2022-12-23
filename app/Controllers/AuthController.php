<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entity\User;
use App\Exceptions\ValidationException;
use App\Services\AuthService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\UserService;
use Slim\Views\Twig;
use Symfony\Component\Mailer\MailerInterface;
use Valitron\Validator;

class AuthController
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly Twig        $twig)
    {

    }

    public function loginView(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'auth/login.twig');
    }

    public function registerView(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'auth/register.twig');
    }

    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $this->authService->register($data);
        return $response;
    }

}