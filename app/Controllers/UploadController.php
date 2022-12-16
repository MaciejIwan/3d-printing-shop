<?php

namespace app\Controllers;

use app\Attributes\Get;
use app\Attributes\Post;
use app\Attributes\Put;
use app\Attributes\Route;
use app\Enums\HttpMethod;
use app\View;


class UploadController
{
    #[Get('/upload')]
    #[Route('/home', HttpMethod::Head)]
    public function index(): View
    {
        return View::make('uploadFile');
    }

    #[Post('/upload')]
    public function store(): void
    {
        echo '<pre>';
        var_dump($_FILES);
        echo '</pre>';

        $saveFilePath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];
        move_uploaded_file($_FILES['receipt']['tmp_name'], $saveFilePath);

        echo '<pre>';
        $saveFilePath;
        echo '</pre>';
    }

    #[Put('/')]
    public function update(): void
    {

    }
}