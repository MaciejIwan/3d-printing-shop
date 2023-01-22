<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\ChartController;
use App\Controllers\HomeController;
use App\Controllers\OrderController;
use App\Controllers\PaymentController;
use App\Controllers\UploadController;
use App\Controllers\UserController;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\EveryoneMiddleware;
use App\Middleware\UserMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    //homepage
    $app->get('/', [HomeController::class, 'index'])->add(EveryoneMiddleware::class);
    $app->get('/dashboard', [HomeController::class, 'dashboard'])->add(AuthMiddleware::class);

    $app->group('/payments', function (RouteCollectorProxy $payments) {
        $payments->get('/success/{session_id}', [PaymentController::class, 'success']);
        $payments->get('/cancel', [PaymentController::class, 'cancel']);
        $payments->post('/create-checkout-session/{order_id}', [PaymentController::class, 'checkout']);
    })->add(AuthMiddleware::class);


    //guest subpages
    $app->group('', function (RouteCollectorProxy $guest) {
        $guest->get('/login', [AuthController::class, 'loginView']);
        $guest->get('/register', [AuthController::class, 'registerView']);
        $guest->post('/login', [AuthController::class, 'logIn']);
        $guest->post('/register', [AuthController::class, 'register']);
    })->add(GuestMiddleware::class);


    //upload
    $app->group('/upload', function (RouteCollectorProxy $guest) {
        $guest->get('', [UploadController::class, 'index']);
        $guest->get('/download/{filename}', [UploadController::class, 'download']);
        $guest->post('', [UploadController::class, 'store']);
    });

    $app->post('/logout', [AuthController::class, 'logOut'])->add(AuthMiddleware::class);


    $app->group('/chart', function (RouteCollectorProxy $chart) {
        $chart->get('', [ChartController::class, 'index']);
        $chart->post('', [ChartController::class, 'store']);
        $chart->delete('/{id:[0-9]+}', [ChartController::class, 'delete']);
        $chart->get('/{id:[0-9]+}', [ChartController::class, 'get']);
        $chart->post('/{id:[0-9]+}', [ChartController::class, 'update']);
        $chart->get('/submit', [ChartController::class, 'submit']);
    })->add(AuthMiddleware::class);

    $app->group('/orders', function (RouteCollectorProxy $orders) {
        $orders->get('/my', [OrderController::class, 'myOrders'])->add(UserMiddleware::class);
        $orders->get('', [OrderController::class, 'index'])->add(AdminMiddleware::class);
        $orders->post('', [OrderController::class, 'store'])->add(EveryoneMiddleware::class);
        $orders->delete('/{id:[0-9]+}', [OrderController::class, 'delete'])->add(AdminMiddleware::class);
        $orders->get('/{id:[0-9]+}', [OrderController::class, 'get']); //todo allow both but user only if is owner
        $orders->post('/{id:[0-9]+}', [OrderController::class, 'update'])->add(AdminMiddleware::class);
    });

    $app->group('/users', function (RouteCollectorProxy $users) {
        $users->get('', [UserController::class, 'index']);
        $users->post('', [UserController::class, 'store']);
        $users->delete('/{id:[0-9]+}', [UserController::class, 'delete']);
        $users->get('/{id:[0-9]+}', [UserController::class, 'get']);
        $users->post('/{id:[0-9]+}', [UserController::class, 'update']);
    })->add(AdminMiddleware::class);
};
