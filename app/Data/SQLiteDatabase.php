<?php

namespace App\Data;

use PDO;
use RuntimeException;

class SQLiteDatabase implements DatabaseInterface
{

    private $pdo;

    public function __construct(string $fileLocation)
    {
        if (!file_exists($fileLocation)) {
            throw new RuntimeException("Invalid database file");
        }

        $this->pdo = new PDO("sqlite:{$fileLocation}");

        if (empty($this->pdo)) {
            throw new RuntimeException("No database connection");
        }

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getArray(string $query, array $params = []): array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne(string $query, array $params = [])
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        $result = $statement->fetch();

        if (!$result) {
            return false;
        }

        return $result[0];
    }
}
