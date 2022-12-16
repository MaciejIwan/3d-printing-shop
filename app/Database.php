<?php

namespace app;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * @mixin Connection
 */
class Database
{
    private Connection $connection;

    public function __construct(array $dbConfig)
    {
        $this->connection = DriverManager::getConnection($dbConfig);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }
}