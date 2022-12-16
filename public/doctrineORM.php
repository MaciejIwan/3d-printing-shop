<?php

use app\Entity\Order;
use app\Entity\OrderItem;
use app\Enums\OrderStatus;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

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

$config = ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/Entity']);
$entityManager = EntityManager::create($connectionParams, $config);

$items = [['item 1', 1, 15], ['item 2', 2, 7.5], ['item 3', 4, 3.75]];
$invoice = (new Order())
    ->setAmount(45)
    ->setStatus(OrderStatus::Waiting)
    ->setCreatedAt(new DateTime());

foreach ($items as [$description, $quantity, $unitPrice]) {
    $item = (new OrderItem())
        ->setDescription($description)
        ->setQuantity($quantity)
        ->setUnitPrice($unitPrice);
    $invoice->addItem($item);
}


$entityManager->persist($invoice);
echo("hello world");
$entityManager->flush();
//fetch example
$invoice = $entityManager->find(Order::class, 1);
$invoice->setStatus(OrderStatus::Done);
$entityManager->flush();
var_dump($invoice);