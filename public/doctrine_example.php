<?php

use Doctrine\DBAL\DriverManager;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$connectionParams = [
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host' => $_ENV['DB_HOST'],
    'port' => intval($_ENV['DB_PORT']),
    'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];
$conn = DriverManager::getConnection($connectionParams);
$statement = $conn->prepare("SELECT * FROM user WHERE id = ?");

$result = $statement->executeQuery([1]);
var_dump($result->fetchAllAssociative());
echo("hello world");