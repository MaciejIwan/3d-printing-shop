<?php

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Dto\UserUpdateDto;
use App\RequestValidators\UpdateUserRequestValidator;
use App\ResponseFormatter;
use App\Services\UserProviderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Symfony\Component\Mailer\MailerInterface;


class UserController
{

    public function __construct(
        private readonly MailerInterface                  $mailer,
        private readonly RequestValidatorFactoryInterface $requestValidatorFactory,
        private readonly ResponseFormatter                $responseFormatter,
        private readonly UserProviderService              $userService,
        private readonly Twig                             $twig)
    {

    }

    public function index(Request $request, Response $response, $args): Response
    {
        return $this->twig->render($response, 'users/index.twig', ['users' => $this->userService->getAllUsers()]);
    }

    public function get(Request $request, Response $response, array $args): Response
    {
        $user = $this->userService->getById((int)$args['id']);

        if (!$user) {
            return $response->withStatus(404);
        }

        //todo replace array with userDTO
        $data = ['id' => $user->getId(), 'name' => $user->getName(), 'email' => $user->getEmail()];

        return $this->responseFormatter->asJson($response, $data);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->userService->delete((int)$args['id']);

        return $response->withHeader('Location', '/users')->withStatus(302);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $this->requestValidatorFactory->make(UpdateUserRequestValidator::class)->validate(
            $args + $request->getParsedBody()
        );

        $user = $this->userService->getById((int)$data['id']);

        if (!$user) {
            return $response->withStatus(404);
        }

        $updatedUser = $this->userService->update($user, UserUpdateDto::fromEditForm($data));

        $this->responseFormatter->asJson($response, [
            'message' => "user updated successfully",
            'data' => UserUpdateDto::fromEntity($updatedUser),
            'email' => $request->getAttribute('user')->getEmail()
        ]);
        return $response;
    }

}