<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\Connection;
use DateTime;
use PDO;
use Symfony\Component\Validator\Constraints\Date;

class HRRepository
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    //CHART
    public function getChartHR(string $type, int $patientId, DateTime $from, DateTime $to): array
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    chm.hr,
                    chm."time"
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    chair_measurements AS chm ON chm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                    p.id = :patientId
                ORDER BY
                    chm.id DESC
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else if($type === 'bathtub') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    bm.hr,
                    TO_CHAR(bm."time", 'yyyy-mm-dd hh:mi') AS time
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    bathtub_measurements AS bm ON bm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                    p.id = :patientId
                ORDER BY
                    bm.id DESC
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //CURRENT
    public function getCurrentHR(string $type, int $patientId): ?int
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    chm.hr
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    chair_measurements AS chm ON chm.host = h.hub
                        AND chm."time" >= NOW() AT TIME ZONE 'UTC-1' - INTERVAL '2 minutes'
                WHERE
                    p.id = :patientId
                ORDER BY
                    chm.id DESC
                LIMIT 1;
            SQL);

            $statement->execute([
                'patientId' => $patientId
            ]);

            return $statement->fetchColumn() ?: null;

        } else if($type === 'bathtub') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    bm.hr
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    bathtub_measurements AS bm ON bm.host = h.hub
                        AND bm."time" >= NOW() AT TIME ZONE 'UTC-1' - INTERVAL '2 minutes'
                WHERE
                    p.id = :patientId
                ORDER BY
                    bm.id DESC
                LIMIT 1;
        SQL);

            $statement->execute([
                'patientId' => $patientId
            ]);

            return $statement->fetchColumn() ?: null;
        }
    }

    //MINIMUM
    public function getMinimumHR(string $type, int $patientId, DateTime $from, DateTime $to): int
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    chm.hr
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    chair_measurements AS chm ON chm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                    p.id = :patientId
                ORDER BY
                    chm.hr 
                LIMIT 1;
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchColumn();
        }
        else if($type === 'bathtub') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    bm.hr
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    bathtub_measurements AS bm ON bm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                    p.id = :patientId
                ORDER BY
                    bm.hr 
                LIMIT 1;
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchColumn();
        }
    }

    //MAXIMUM
    public function getMaximumHR(string $type, int $patientId, DateTime $from, DateTime $to): int
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    chm.hr
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    chair_measurements AS chm ON chm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                    p.id = :patientId
                ORDER BY
                    chm.hr DESC 
                LIMIT 1;
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchColumn();
        }
        else if($type === 'bathtub') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    bm.hr
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    bathtub_measurements AS bm ON bm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                    p.id = :patientId
                ORDER BY
                    bm.hr DESC 
                LIMIT 1;
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchColumn();
        }
    }

    //AVERAGE
    public function getAverageHR(string $type, int $patientId, DateTime $from, DateTime $to):int
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    (sum(chm.hr)/count(chm.hr)) as av
                FROM
                    patient AS p
                INNER JOIN
                    e4l_id_conv AS h on p.id = h.patient_id
                INNER JOIN
                    chair_measurements AS chm ON chm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                    p.id = :patientId
                LIMIT 1;
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchColumn();
        }
        else if($type === 'bathtub') {
            $statement = $this->db->prepare(<<<SQL
            SELECT
                (sum(bm.hr)/count(bm.hr)) as av
            FROM
                patient AS p
            INNER JOIN
                e4l_id_conv AS h on p.id = h.patient_id
            INNER JOIN
                bathtub_measurements AS bm ON bm.host = h.hub
                    AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
            WHERE
                p.id = :patientId
            LIMIT 1;
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchColumn();
        }
    }
}