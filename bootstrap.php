<?php

declare(strict_types=1);


use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/configs/php_constants.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require CONFIG_PATH . '/container.php';

AppFactory::setContainer($container);

return AppFactory::create();