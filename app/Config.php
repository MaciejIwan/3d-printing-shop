<?php

namespace app;

/**
 * @property-read ?array $mailer
 * @property-read ?array $database
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {

        $this->config = [
            'database' => [
                'dbname' => $env['DB_DATABASE'],
                'user' => $env['DB_USER'],
                'password' => $env['DB_PASS'],
                'host' => $env['DB_HOST'],
                'port' => intval($env['DB_PORT']),
                'driver' => $env['DB_DRIVER'] ?? 'pdo_mysql',
            ],
            'mailer' => [
                'dsn' => $env['MAILER_DSN']
            ]
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}