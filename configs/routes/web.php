<?php

declare(strict_types = 1);

use App\Controllers\AuthController;
use App\Controllers\OrderController;
use App\Controllers\HomeController;
use App\Controllers\UploadController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\UserMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    //homepage
    $app->get('/', [HomeController::class, 'index'])->add(UserMiddleware::class);
    $app->get('/dashboard', [HomeController::class, 'dashboard'])->add(AuthMiddleware::class);

    //upload
    $app->get('/upload', [UploadController::class, 'index']);
    $app->post('/upload', [UploadController::class, 'store']);

    //guest subpages
    $app->group('', function (RouteCollectorProxy $guest) {
        $guest->get('/login', [AuthController::class, 'loginView']);
        $guest->get('/register', [AuthController::class, 'registerView']);
        $guest->post('/login', [AuthController::class, 'logIn']);
        $guest->post('/register', [AuthController::class, 'register']);
    })->add(GuestMiddleware::class);

    $app->post('/logout', [AuthController::class, 'logOut'])->add(AuthMiddleware::class);

    $app->group('/orders', function (RouteCollectorProxy $orders) {
        $orders->get('', [OrderController::class, 'index']);
        $orders->post('', [OrderController::class, 'store']);
        $orders->delete('/{id:[0-9]+}', [OrderController::class, 'delete']);
        $orders->get('/{id:[0-9]+}', [OrderController::class, 'get']);
        $orders->post('/{id:[0-9]+}', [OrderController::class, 'update']);
    })->add(AuthMiddleware::class);

    $app->group('/users', function (RouteCollectorProxy $users) {
        $users->get('', [UserController::class, 'index']);
        $users->post('', [UserController::class, 'store']);
        $users->delete('/{id:[0-9]+}', [UserController::class, 'delete']);
        $users->get('/{id:[0-9]+}', [UserController::class, 'get']);
        $users->post('/{id:[0-9]+}', [UserController::class, 'update']);
    })->add(AuthMiddleware::class);
};
