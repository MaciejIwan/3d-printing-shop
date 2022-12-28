<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UploadController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Slim\App;

return function (App $app) {
    //homepage
    $app->get('/', [HomeController::class, 'index'])
        ->add(AuthMiddleware::class);

    //upload
    $app->get('/upload', [UploadController::class, 'index']);
    $app->post('/upload', [UploadController::class, 'store']);

    //auth
    $app->get('/login', [AuthController::class, 'loginView'])
        ->add(GuestMiddleware::class);
    $app->post('/login', [AuthController::class, 'logIn'])
        ->add(GuestMiddleware::class);
    $app->post('/logout', [AuthController::class, 'logOut'])
        ->add(AuthMiddleware::class);
    $app->get('/register', [AuthController::class, 'registerView'])
        ->add(GuestMiddleware::class);
    $app->post('/register', [AuthController::class, 'register'])
        ->add(GuestMiddleware::class);

//    $app->get('/login', [UserController::class, 'login']);
//    $app->get('/users', [UserController::class, 'all']);
//    $app->get('/register', [UserController::class, 'create']);
//    $app->post('/register', [UserController::class, 'register']);
};
