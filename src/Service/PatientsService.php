<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\PatientsRepository;

class PatientsService
{
    private PatientsRepository $PatientsRepository;

    public function __construct(PatientsRepository $PatientsRepository)
    {
        $this->PatientsRepository = $PatientsRepository;
    }

    public function getPatientsNames(int $userId): array
    {
        return $this->PatientsRepository->getPatientsNames($userId);
    }
}