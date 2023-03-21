<?php

declare(strict_types=1);

namespace App\Repository;

use App\CurrentHRQuery\CurrentHrQuery;
use App\Database\Connection;
use App\Query\HrQuery;
use PDO;

class HRRepository
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    //CHART
    public function getChairChartData(HrQuery $query): array
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
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBathChartData(HrQuery $query): array
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
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //CURRENT
    public function getChairCurrentHR(CurrentHrQuery $currentQuery): ?int
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
                    AND chm."time" >= NOW() AT TIME ZONE 'UTC-1' - INTERVAL '2 minutes'
            WHERE
                    p.id = :patientId
            ORDER BY
                chm.id DESC
            LIMIT 1;
        SQL);

        $statement->execute([
            'patientId' => $currentQuery->getPatientId(),
        ]);

        return $statement->fetchColumn() ?: null;
    }

    public function getBathCurrentHR(CurrentHrQuery $currentQuery): ?int
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
            'patientId' => $currentQuery->getPatientId()
        ]);

        return $statement->fetchColumn() ?: null;
    }

    //MINIMUM
    public function getChairMinimumHR(HrQuery $query): int
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
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);

        return $statement->fetchColumn();
    }

    public function getBathMinimumHR(HrQuery $query): int
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
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);

        return $statement->fetchColumn();
    }

    //MAXIMUM
    public function getChairMaximumHR(HrQuery $query): int
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
                chm.hr DESC
            LIMIT 1;
        SQL);

        $statement->execute([
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);

        return $statement->fetchColumn();
    }

    public function getBathMaximumHR(HrQuery $query): int
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
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);

        return $statement->fetchColumn();
    }

    //AVERAGE
    public function getChairAverageHR(HrQuery $query): int
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
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);

        return $statement->fetchColumn();
    }

    public function getBathAverageHR(HrQuery $query): int
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
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);

        return $statement->fetchColumn();
    }
}