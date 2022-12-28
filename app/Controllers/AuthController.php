<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AuthInterface;
use App\Exceptions\ValidationException;
use App\Services\UserRegisterService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Valitron\Validator;

class AuthController
{
    public function __construct(
        private readonly UserRegisterService $userRegisterService,
        private readonly Twig                $twig,
        private readonly AuthInterface       $auth
    )
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
        $this->userRegisterService->register($data);

        return $response;
    }

    public function logIn(Request $request, Response $response): Response
    {
        // 1. Validate the request data
        $data = $request->getParsedBody();
        $this->validateLoginFormData($data);

        if (!$this->auth->attemptLogin($data)) {
            throw new ValidationException(['password' => ['You have entered an invalid username or password']]);
        }

        return $response->withHeader('Location', '/')->withStatus(302);
    }

    public function logOut(Request $request, Response $response): Response
    {
        $this->auth->logOut();
        return $response->withHeader('Location', '/')->withStatus(302);
    }

    private function validateLoginFormData(array $userData): void
    {
        $v = new Validator($userData);
        $v->rule('required', ['email', 'password']);
        $v->rule('email', 'email')->message(ValidationException::$EMAIL_NOT_CORRECT)->label('Email');;

        if (!$v->validate()) {
            throw new ValidationException(['password' => ['email or password is not valid']]);
        }
    }
}