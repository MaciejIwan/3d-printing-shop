<?php

declare(strict_types=1);

namespace App;

// todo wrtie more code in Model class
abstract class Model
{
    protected Database $database;


    public function __construct()
    {
        $this->database = App::getDatabase();
    }

}