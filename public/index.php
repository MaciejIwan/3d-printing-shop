<?php

use App\Config;
use App\Controllers\HomeController;
use App\Controllers\UploadController;
use App\Controllers\UserController;


use App\CustomMailer;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Extra\Intl\IntlExtension;
use function DI\create;


require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Create DI container
$container = new Container();
$container->set(Config::class, create(Config::class)->constructor($_ENV));
$container->set(EntityManager::class, fn(Config $config) => EntityManager::create(
    $config->database,
    ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/../app/Entity'])
));
$container->set(MailerInterface::class, fn(Config $config) => new CustomMailer(
    $config->mailer['dsn']
));


AppFactory::setContainer($container);

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
$app->get('/register', [UserController::class, 'create']);
$app->post('/register', [UserController::class, 'register']);


$app->run();

