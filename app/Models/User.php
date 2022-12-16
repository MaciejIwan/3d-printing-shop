<?php

namespace app\Models;

use app\Model;

class User extends Model
{

    public function fetchByID(int $id): array
    {
        $statement = $this->database->prepare("SELECT * FROM user WHERE id = ?");
        $result = $statement->executeQuery([$id]);
        return $result->fetchAllAssociative();
    }
}