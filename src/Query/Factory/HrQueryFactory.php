<?php

namespace App\Query\Factory;

use App\Query\HrQuery;

class HrQueryFactory
{
    public static function createFromQueryParameters(array $data): HrQuery
    {
        return (new HrQuery())
            ->setPatientId($data['patientId'] ?? null)
            ->setFrom($data['from'] ?? null)
            ->setTo($data['to'] ?? null);
    }
}
