<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\Connection;
use DateTime;

class HRRepository
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getCurrentHR(string $type): ?int
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
            SELECT 
                hr
            FROM 
                chair_measurements
            WHERE 
                "time" >= NOW() - INTERVAL '2 minutes'
            ORDER BY 
                id DESC
            LIMIT 1
        SQL);

            $statement->execute();
            return $statement->fetchColumn() ?: null;
        }
        else if($type === 'bath') {
            $statement = $this->db->prepare(<<<SQL
            SELECT 
                hr
            FROM 
                bathtub_measurements
            WHERE 
                "time" >= NOW() - INTERVAL '2 minutes'
            ORDER BY 
                id DESC
            LIMIT 1
        SQL);

            $statement->execute();
            return $statement->fetchColumn() ?: null;
        }
    }

    public function getMinimumHR(string $type, DateTime $from, DateTime $to): int
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
            SELECT
                hr
            FROM
                chair_measurements
            WHERE 
                time between :dateTimeFrom AND :dateTimeTo
            ORDER BY 
                hr 
            LIMIT 1
        SQL);

            $statement->execute([
                'dateTimeFrom' => $from->format('Y-m-d H:i:s'),
                'dateTimeTo' => $to->format('Y-m-d H:i:s'),
            ]);

            return $statement->fetchColumn();
        }
        else if($type === 'bath') {
            $statement = $this->db->prepare(<<<SQL
            SELECT
                hr
            FROM
                bathtub_measurements
            WHERE 
                time between :dateTimeFrom AND :dateTimeTo
            ORDER BY 
                hr 
            LIMIT 1
        SQL);

            $statement->execute([
                'dateTimeFrom' => $from->format('Y-m-d H:i:s'),
                'dateTimeTo' => $to->format('Y-m-d H:i:s'),
            ]);

            return $statement->fetchColumn();
        }
    }

    public function getMaximumHR(string $type, DateTime $from, DateTime $to): int
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
            SELECT
                hr
            FROM
                chair_measurements
            WHERE 
                time between :dateTimeFrom AND :dateTimeTo
            ORDER BY 
                hr DESC
            LIMIT 1
        SQL);

            $statement->execute([
                'dateTimeFrom' => $from->format('Y-m-d H:i:s'),
                'dateTimeTo' => $to->format('Y-m-d H:i:s'),
            ]);

            return $statement->fetchColumn();
        }
        else if($type === 'bath') {
            $statement = $this->db->prepare(<<<SQL
            SELECT
                hr
            FROM
                bathtub_measurements
            WHERE 
                time between :dateTimeFrom AND :dateTimeTo
            ORDER BY 
                hr DESC
            LIMIT 1
        SQL);

            $statement->execute([
                'dateTimeFrom' => $from->format('Y-m-d H:i:s'),
                'dateTimeTo' => $to->format('Y-m-d H:i:s'),
            ]);

            return $statement->fetchColumn();
        }
    }

    public function getAverageHR(string $type, DateTime $from, DateTime $to):int
    {
        if($type === 'chair') {
            $statement = $this->db->prepare(<<<SQL
            SELECT 
                (sum(hr)/count(hr))
            FROM 
                chair_measurements
            WHERE 
                time between :dateTimeFrom AND :dateTimeTo
            LIMIT 1
        SQL);

            $statement->execute([
                'dateTimeFrom' => $from->format('Y-m-d H:i:s'),
                'dateTimeTo' => $to->format('Y-m-d H:i:s'),
            ]);

            return $statement->fetchColumn();
        }
        else if($type === 'bath') {
            $statement = $this->db->prepare(<<<SQL
            SELECT 
                (sum(hr)/count(hr))
            FROM 
                bathtub_measurements
            WHERE 
                time between :dateTimeFrom AND :dateTimeTo
            LIMIT 1
        SQL);

            $statement->execute([
                'dateTimeFrom' => $from->format('Y-m-d H:i:s'),
                'dateTimeTo' => $to->format('Y-m-d H:i:s'),
            ]);

            return $statement->fetchColumn();
        }
    }
}