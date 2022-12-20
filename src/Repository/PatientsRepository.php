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
                    ui.id,
                    ui.name,
                    ui.surname
                FROM
                    "user" as u
                INNER JOIN
                    patient AS ui on u.id = ui.user_id
                WHERE
                    u.id = :userId
                ORDER BY
                    ui.id DESC;
            SQL
        );
        $statement->execute([
            'userId' => $userId
        ]);

        return $statement->fetchAll();
    }
}