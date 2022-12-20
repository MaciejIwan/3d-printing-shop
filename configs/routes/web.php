<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UploadController;
use App\Controllers\UserController;
use Slim\App;

return function(App $app){
    $app->get('/', [HomeController::class, 'index']);
    $app->get('/upload', [UploadController::class, 'index']);
    $app->post('/upload', [UploadController::class, 'store']);


    $app->get('/login', [AuthController::class, 'loginView']);
    $app->get('/register', [AuthController::class, 'registerView']);
    $app->post('/login', [AuthController::class, 'logIn']);
    $app->post('/register', [AuthController::class, 'register']);

//    $app->get('/login', [UserController::class, 'login']);
//    $app->get('/users', [UserController::class, 'all']);
//    $app->get('/register', [UserController::class, 'create']);
//    $app->post('/register', [UserController::class, 'register']);
};
