<?php
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
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
$statement = $conn->prepare("SELECT * FROM Persons WHERE PersonID = ?");

$result = $statement->executeQuery([0]);
var_dump($result->fetchAllAssociative());
echo("hello world");