<?php

namespace App\Models;

use App\Model;

class User extends Model
{

    public function fetchByID(int $id): array
    {
        $statement = $this->database->prepare("SELECT * FROM Persons WHERE PersonID = ?");
        $result = $statement->executeQuery([$id]);
        return $result->fetchAllAssociative();
    }
}