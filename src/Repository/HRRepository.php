<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\Connection;
use DateTime;
use PDO;

class HRRepository
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db; //dependency injection, przy zmianie sposobu komunikacji z bazą, można zmienić obiekt $db na inny, zamiast zmieniać samą klasę
    }

    //CHART1
    public function getChartHR(string $type, int $patientId, DateTime $from, DateTime $to): array
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
                SELECT
                    chm.hr,
                    TO_CHAR(chm."time", 'yyyy-mm-dd hh24:mi') AS time
                FROM
                    patient AS p
                INNER JOIN
                    hub_assignment_date AS had ON had.patient_id = p.id 
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                    e4l_id_conv AS h ON h.id = had.hub_id
                INNER JOIN
                    chair_measurements AS chm ON chm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                        p.id = :patientId
                ORDER BY
                    chm.id;
            SQL);
            //ON to warunek łączenia

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
                    TO_CHAR(bm."time", 'yyyy-mm-dd hh24:mi') AS time
                FROM
                    patient AS p
                INNER JOIN
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                    e4l_id_conv AS h ON h.id = had.hub_id
                INNER JOIN
                    bathtub_measurements AS bm ON bm.host = h.hub
                        AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
                WHERE
                        p.id = :patientId
                ORDER BY
                    bm.id;
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //HRV
    public function getHRV(string $type, int $patientId, DateTime $from, DateTime $to): string
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
            SELECT
                round(stddev_pop(chm.hr), 2)
            FROM
                patient AS p
            INNER JOIN
                hub_assignment_date AS had ON had.patient_id = p.id
                    AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                    AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
            INNER JOIN
                e4l_id_conv AS h ON h.id = had.hub_id
            INNER JOIN
                chair_measurements AS chm ON chm.host = h.hub
                    AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
            WHERE
                p.id = :patientId
            GROUP BY
                had.patient_id;
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
                round(stddev_pop(bm.hr), 2)
            FROM
                patient AS p
            INNER JOIN
                hub_assignment_date AS had ON had.patient_id = p.id
                    AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                    AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
            INNER JOIN
                e4l_id_conv AS h ON h.id = had.hub_id
            INNER JOIN
                bathtub_measurements AS bm ON bm.host = h.hub
                    AND time AT TIME ZONE 'UTC-1' between :dateTimeFrom AND :dateTimeTo
            WHERE
                    p.id = :patientId
            GROUP BY
                had.patient_id;
        SQL);

            $statement->execute([
                'patientId' => $patientId,
                'dateTimeFrom' => $from->format('Y-m-d H:i'),
                'dateTimeTo' => $to->format('Y-m-d H:i'),
            ]);

            return $statement->fetchColumn();
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
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                   e4l_id_conv AS h ON h.id = had.hub_id
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
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                   e4l_id_conv AS h ON h.id = had.hub_id
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

            //Jeśli metoda `fetchColumn()` zwróci wartość różną od null, zostanie ona zwrócona.
            // W przeciwnym wypadku zostanie zwrócona wartość null.
//            return $statement->fetchColumn() else return null;
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
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                    e4l_id_conv AS h ON h.id = had.hub_id
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
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                    e4l_id_conv AS h ON h.id = had.hub_id
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
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                    e4l_id_conv AS h ON h.id = had.hub_id
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
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                    e4l_id_conv AS h ON h.id = had.hub_id
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
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                    e4l_id_conv AS h ON h.id = had.hub_id
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
                    hub_assignment_date AS had ON had.patient_id = p.id
                        AND had.ends_at AT TIME ZONE 'UTC-1' >= NOW()
                        AND had.starts_at AT TIME ZONE 'UTC-1' <= NOW()
                INNER JOIN
                    e4l_id_conv AS h ON h.id = had.hub_id
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