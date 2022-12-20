<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entity\User;
use App\Services\AuthService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\UserService;
use Slim\Views\Twig;
use Symfony\Component\Mailer\MailerInterface;

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
        var_dump($data);

        $newUser = new User();
        $password_hash = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $newUser
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setPaaswordHash($password_hash);


        $this->authService->register($newUser);
        return $response;
    }

}