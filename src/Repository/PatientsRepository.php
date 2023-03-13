<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\Connection;
use PDO;

class PatientsRepository
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }


    //PATIENT_CHOOSE
    public function getPatientsNames(int $userId): array
    {
        $statement = $this->db->prepare(
            <<<SQL
                SELECT
                    p.id,
                    p.name,
                    p.surname
                FROM
                    "user" as u
                INNER JOIN
                    patient AS p on u.id = p.user_id
                WHERE
                    u.id = :userId 
                ORDER BY
                    p.id DESC;
            SQL
        );
        $statement->execute([
            'userId' => $userId
        ]);

        return $statement->fetchAll();
    }
}