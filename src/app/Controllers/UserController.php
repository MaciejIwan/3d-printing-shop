<?php

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\Attributes\Put;
use App\Attributes\Route;
use App\Enums\HttpMethod;
use App\Models\User;
use App\View;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
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