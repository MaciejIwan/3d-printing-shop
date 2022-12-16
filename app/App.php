<?php

declare(strict_types=1);

namespace app;

use app\Exceptions\RouteNotFoundException;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class App
{
    private static Database $database;

    public function __construct(protected Container $container,
                                protected Router    $router,
                                protected array     $request,
                                protected Config    $config
    )
    {
        $this->container->set(MailerInterface::class, fn() => new CustomMailer($config->mailer['dsn']));
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

    public static function getDatabase(): Database
    {
        return static::$database;
    }

    public function boot(): static
    {
        $this->config = new Config($_ENV);

        static::$database = new Database($this->config->database ?? []);


        $twig = new Environment(
            new FilesystemLoader(VIEW_PATH),
            [
                'cache' => STORAGE_PATH . '/cache',
            ]
        );

        //todo bind customMailer here

//        $this->container->

        return $this;
    }

}