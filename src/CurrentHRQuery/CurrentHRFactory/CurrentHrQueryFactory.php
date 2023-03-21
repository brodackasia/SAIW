<?php

namespace App\CurrentHRQuery\CurrentHRFactory;

use App\CurrentHRQuery\CurrentHrQuery;

class CurrentHrQueryFactory
{


    public static function createFromCurrentQueryParameters(array $data): CurrentHrQuery
    {
        return (new CurrentHrQuery())
            ->setPatientId($data['patientId'] ?? null);
    }
}