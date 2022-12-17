<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Illuminate\Container\Container;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment as Twig;
use Twig\Loader\FilesystemLoader;


class App
{
    private Config $config;

    public function __construct(protected Container $container,
                                protected Router    $router,
                                protected array     $request,
    )
    {
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve(
                $this->request['uri'],
                strtolower($this->request['method'])
            );
        } catch (RouteNotFoundException) {
            http_response_code(404);
            echo View::make('error/404');
        }
    }


    public function boot(): static
    {
        $this->config = new Config($_ENV);

        $this->initTwig();
        $this->initMailer();
        $this->initDb($this->config->database);

        return $this;
    }

    private function initDb(array $config)
    {
        $ormConfig = ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/Entity']);
        echo __DIR__ . '/Entity';
        $entityManager = EntityManager::create($config, $ormConfig);
        $this->container->bind(UserRepository::class, fn() => new UserRepository($entityManager));
    }

    private function initTwig(): void
    {
        //todo turn on cache to production or add dev and prod env in php project
        //'cache' => STORAGE_PATH . '/cache',
        $twig = new Twig(
            new FilesystemLoader(VIEW_PATH), [
            'cache' => false,
        ]);
        $this->container->singleton(Twig::class, fn() => $twig);
    }

    private function initMailer(): void
    {
        $this->container->bind(MailerInterface::class, fn() => new CustomMailer($this->config->mailer['dsn']));
    }

}