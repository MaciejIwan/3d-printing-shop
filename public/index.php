<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;


require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../configs/php_constants.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$container = require CONFIG_PATH . '/container.php';
$router = require CONFIG_PATH . '/routes.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$router($app);

$app->add(TwigMiddleware::create($app, $container->get(Twig::class)));

$app->run();

