<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;



class App
{
    private static Database $database;
    private Config $config;


    public function __construct(protected Container $container,
                                protected Router    $router,
                                protected array     $request
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

        static::$database = new Database($this->config->database ?? []);

        return $this;
    }

}