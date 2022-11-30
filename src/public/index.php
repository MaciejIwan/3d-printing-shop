<?php

use App\App;
use App\Container;
use App\Controllers\UserController;
use App\Router;
use App\Controllers\HomeController;


require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$container = new Container();
$router = new Router($container);

$router->registerRoutesFromControllerAttributes(
    [
        HomeController::class,
        UserController::class
    ]
);
(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
))->boot($_ENV)->run();
