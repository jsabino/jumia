<?php

namespace App\Data;

interface DatabaseInterface
{

    public function getArray(string $query, array $params = []): array;

    /**
     * @param string $query
     * @param array $params
     * @return string|false
     */
    public function getOne(string $query, array $params = []);
}
