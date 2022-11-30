<?php

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\Attributes\Put;
use App\Attributes\Route;
use App\Enums\HttpMethod;
use App\View;

class UserController
{
    #[Get('/login')]
    #[Route('/login2', HttpMethod::Head)]
    public function login(): View
    {
        return View::make('login');
    }

    #[Post('/login')]
    public function store(): void
    {

    }

    #[Put('/login')]
    public function update(): void
    {

    }
}