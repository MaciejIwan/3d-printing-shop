<?php

namespace App\Controllers;

use App\Repository\UserRepository;
use App\Services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class UserController
{
    public function __construct(
        private MailerInterface $mailer,
//        protected UserRepository  $userRepository,
        private UserService $userService
    )
    {

    }

public
function login(Request $request, Response $response, $args): Response
{
    return Twig::fromRequest($request)->render($response, 'login.twig');
}

public
function getById(Request $request, Response $response, $args): Response
{
//        $user = $this->userRepository->fetchUser($_GET['id']);

    $body = $response->getBody();
//        $body->write($user->getEmail());

    return $response;
}


public
function create(Request $request, Response $response, $args): Response
{
    return Twig::fromRequest($request)->render($response, 'users/register.twig');
}

public
function all(Request $request, Response $response, $args): Response
{
    //todo add service and repository fetch
    echo "<br>test_string";
    $users = $this->userService->getAllUsers();
    return Twig::fromRequest($request)->render($response, 'users/index.twig', ['users' => $users]);
}


public
function register(Request $request, Response $response, $args): Response
{
    $allPostPutVars = $request->getParsedBody();

    $name = $allPostPutVars['name'];
    $email = $allPostPutVars['email'];
    $firstName = explode(' ', $name)[0];


// todo move HTML to VIEW. Use Twing and check email templetes
    $text = <<<Body
Hello $firstName,
Thank you for signing up!
Body;

    $html = <<<HTMLBody
<h1 style="text-align: center; color: blue;">Welcome</h1>
Hello $firstName,
<br /><br />
Thank you for signing up!
HTMLBody;

    $email = (new Email())
        ->from('noreplay@3dprintingapp.com')
        ->to($email)
        ->subject('Welcome!')
        ->attach('Hello World!', 'welcome.txt')
        ->text($text)
        ->html($html);

    $this->mailer->send($email);


    $response->getBody()->write("Check your email!");
    return $response;
}

}