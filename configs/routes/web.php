<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\OrderController;
use App\Controllers\UploadController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    //homepage
    $app->get('/', [HomeController::class, 'index'])->add(AuthMiddleware::class);

    //upload
    $app->get('/upload', [UploadController::class, 'index']);
    $app->post('/upload', [UploadController::class, 'store']);

    //guest subpages
    $app->group('', function (RouteCollectorProxy $guest) {
        $guest->get('/login', [AuthController::class, 'loginView']);
        $guest->post('/login', [AuthController::class, 'logIn']);
        $guest->get('/register', [AuthController::class, 'registerView']);
        $guest->post('/register', [AuthController::class, 'register']);
    })->add(GuestMiddleware::class);


    $app->post('/logout', [AuthController::class, 'logOut'])->add(AuthMiddleware::class);

    $app->group('/orders', function (RouteCollectorProxy $orders) {
        $orders->get('', [OrderController::class, 'index']);
        $orders->post('', [OrderController::class, 'store']);
        $orders->delete('/{id}', [OrderController::class, 'delete']);
    })->add(AuthMiddleware::class);

};
