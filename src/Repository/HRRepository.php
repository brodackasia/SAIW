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
        $this->db = $db;
    }

    //CHART
    public function getChairChartData(int $patientId, DateTime $from, DateTime $to): array
    {
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
                    chm."time";
            SQL);

        $statement->execute([
            'patientId' => $patientId,
            'dateTimeFrom' => $from->format('Y-m-d H:i'),
            'dateTimeTo' => $to->format('Y-m-d H:i'),
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBathChartData(int $patientId, DateTime $from, DateTime $to): array
    {
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
                    bm."time";
            SQL);

        $statement->execute([
            'patientId' => $patientId,
            'dateTimeFrom' => $from->format('Y-m-d H:i'),
            'dateTimeTo' => $to->format('Y-m-d H:i'),
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //CURRENT
    public function getChairCurrentHR(int $patientId): ?int
    {
        $statement = $this->db->prepare(
            <<<SQL
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
        SQL
        );

        $statement->execute([
            'patientId' => $patientId
        ]);

        return $statement->fetchColumn() ?: null;
    }

    public function getBathCurrentHR(int $patientId): ?int
    {
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

        return $statement->fetchColumn() ?: null;
    }

    //MINIMUM
    public function getChairMinimumHR(int $patientId, DateTime $from, DateTime $to): int
    {
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

    public function getBathMinimumHR(int $patientId, DateTime $from, DateTime $to): int
    {
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

    //MAXIMUM
    public function getChairMaximumHR(int $patientId, DateTime $from, DateTime $to): int
    {
        $statement = $this->db->prepare(
            <<<SQL
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
        SQL
        );

        $statement->execute([
            'patientId' => $patientId,
            'dateTimeFrom' => $from->format('Y-m-d H:i'),
            'dateTimeTo' => $to->format('Y-m-d H:i'),
        ]);

        return $statement->fetchColumn();
    }

    public function getBathMaximumHR(int $patientId, DateTime $from, DateTime $to): int
    {
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

    //AVERAGE
    public function getChairAverageHR(int $patientId, DateTime $from, DateTime $to):int
    {
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

    public function getBathAverageHR(int $patientId, DateTime $from, DateTime $to):int
    {
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