<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AuthInterface;
use App\Contracts\DataValidatorFactoryInterface;
use App\DataValidators\UserLoginDataValidator;
use App\DataValidators\UserRegisterDataValidator;
use App\Dto\UserRegisterDto;
use App\Exceptions\ValidationException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class AuthController
{
    public function __construct(
        private readonly Twig                          $twig,
        private readonly AuthInterface                 $auth,
        private readonly DataValidatorFactoryInterface $dataValidatorFactory
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
        $data = $this->dataValidatorFactory->make(UserRegisterDataValidator::class)->validate($request->getParsedBody());
        $this->auth->register(new UserRegisterDto($data['name'], $data['email'], $data['password']));

        return $response->withHeader('Location', '/')->withStatus(302);
    }

    public function logIn(Request $request, Response $response): Response
    {
        $data = $this->dataValidatorFactory->make(UserLoginDataValidator::class)->validate(
            $request->getParsedBody()
        );

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

}