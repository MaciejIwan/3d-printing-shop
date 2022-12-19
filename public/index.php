<?php

use App\App;
use App\Config;
use App\Controllers\HomeController;
use App\Controllers\UploadController;
use App\Controllers\UserController;
use App\Router;
//use Illuminate\Container\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Extra\Intl\IntlExtension;


require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$app = AppFactory::create();

// Create Twig
$twig = Twig::create(VIEW_PATH, ['cache' => false]);
$twig->addExtension(new IntlExtension());

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', [HomeController::class, 'index']);
$app->get('/upload', [UploadController::class, 'index']);
$app->post('/upload', [UploadController::class, 'store']);
$app->get('/login', [UserController::class, 'login']);
$app->get('/users', [UserController::class, 'all']);

$app->run();

