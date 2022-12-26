<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Services\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
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

    public function logIn(Request $request, Response $response): Response
    {
        // 1. Validate the request data
        $data = $request->getParsedBody();
        $this->authService->validateLoginData($data);

        // 2. Check user credentials
        $user = $this->authService->checkCredentials($data);

        // 3. save user id in the session
        session_regenerate_id();
        $_SESSION['user'] = $user->getId();



        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    }

    public function logOut(Request $request, Response $response): Response
    {
        return $response;
    }

}