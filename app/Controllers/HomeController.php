<?php

namespace app\Controllers;

use app\Attributes\Get;
use app\Attributes\Post;
use app\Attributes\Put;
use app\Attributes\Route;
use app\Enums\HttpMethod;
use app\View;

class HomeController
{
    #[Get('/')]
    #[Route('/home', HttpMethod::Head)]
    public function index(): View
    {
        return View::make('index');
    }

    #[Post('/')]
    public function store(): void
    {

    }

    #[Put('/')]
    public function update(): void
    {

    }
}