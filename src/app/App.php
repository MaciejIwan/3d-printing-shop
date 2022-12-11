<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use Symfony\Component\Mailer\MailerInterface;


class App
{
    private static Database $database;

    public function __construct(protected Container $container,
                                protected Router    $router,
                                protected array     $request,
                                protected Config $config
    )
    {
        $this->container->set(MailerInterface::class, fn()=> new CustomMailer($config->mailer['dsn']));
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

        static::$database = new Database($this->config->database ?? []);

        return $this;
    }

}