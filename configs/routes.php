<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\UploadController;
use App\Controllers\UserController;
use Slim\App;

return function(App $app){
    $app->get('/', [HomeController::class, 'index']);
    $app->get('/upload', [UploadController::class, 'index']);
    $app->post('/upload', [UploadController::class, 'store']);
    $app->get('/login', [UserController::class, 'login']);
    $app->get('/users', [UserController::class, 'all']);
    $app->get('/register', [UserController::class, 'create']);
    $app->post('/register', [UserController::class, 'register']);
};
