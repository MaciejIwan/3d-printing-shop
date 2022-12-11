<?php

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Database
{
    private Connection $connection;

    public function __construct(array $dbConfig)
    {
        $this->connection = DriverManager::getConnection($dbConfig);
    }
}