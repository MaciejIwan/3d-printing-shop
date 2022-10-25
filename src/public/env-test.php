<?php
//require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

var_dump($_ENV['DB_HOST']);