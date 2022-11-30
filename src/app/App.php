<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class App
{
    private DB $database;
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


    public function boot(array $env): static
    {
        $this->config = new Config($_ENV);

        $this->database = new DB($this->config->db ?? []);

        return $this;
    }

}