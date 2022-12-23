<?php

declare(strict_types=1);


require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/configs/php_constants.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return require CONFIG_PATH . '/container/container.php';

