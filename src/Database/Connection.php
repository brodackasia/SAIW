<?php

namespace App\Database;

use PDO;

class Connection extends PDO
{
    public function __construct(
        string $driver,
        string $dbname,
        string $host,
        string $port,
        string $username = null,
        string $password = null
    ) {
        parent::__construct(
            sprintf(
                '%s:dbname=%s;host=%s;port=%s',
                $driver,
                $dbname,
                $host,
                $port,
            ),
            $username,
            $password
        );
    }
}