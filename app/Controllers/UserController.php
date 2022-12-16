<?php

namespace app\Controllers;

use app\Attributes\Get;
use app\Attributes\Post;
use app\Attributes\Put;
use app\Attributes\Route;
use app\Enums\HttpMethod;
use app\Models\User;
use app\View;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UserController
{
    public function __construct(protected MailerInterface $mailer){

    }
    #[Get('/login')]
    #[Route('/login2', HttpMethod::Head)]
    public function login(): View
    {
        return View::make('login');
    }

    #[Get('/users/id')]
    public function getById(): string
    {
        $userModel = new User();
        $user = $userModel->fetchByID($_GET['id']);
        return implode(" ",$user[0]);
    }

    #[Post('/login')]
    public function store(): void
    {

    }

    #[Put('/login')]
    public function update(): void
    {

    }

    #[Get('/users/create')]
    public function create(): View
    {
        return View::make('register');
    }

    #[Get('/orders/all')]
    public function all(): View
    {
        return View::make('ordersAll');
    }

    #[Post('/users')]
    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
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
    }

}