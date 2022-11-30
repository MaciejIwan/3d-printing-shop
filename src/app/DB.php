<?php

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DB
{
    private Connection $connection;
    public function __construct(array $config)
    {
//        $this->connection = DriverManager::getConnection($config);
    }
}