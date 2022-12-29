<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\HRRepository;
use DateTime;

class HRService
{
    private HRRepository $HRRepository;

    public function __construct(HRRepository $HRRepository)
    {
        $this->HRRepository = $HRRepository;
    }

    public function getAnalysisHR(string $type, DateTime $from, DateTime $to, int $patientId): array
    {
        return $this->HRRepository->getAnalysisHR($type, $patientId, $from, $to);
    }

    public function getCurrentHR(string $type, int $patientId): ?int
    {
        return $this->HRRepository->getCurrentHR($type, $patientId);
    }

    public function getMinimumHR(string $type, DateTime $from, DateTime $to, int $patientId): int
    {
        return $this->HRRepository->getMinimumHR($type, $patientId, $from, $to);
    }

    public function getMaximumHR(string $type, DateTime $from, DateTime $to, int $patientId): int
    {
        return $this->HRRepository->getMaximumHR($type, $patientId, $from, $to);
    }

    public function getAverageHR(string $type, DateTime $from, DateTime $to, int $patientId): int
    {
        return $this->HRRepository->getAverageHR($type, $patientId, $from, $to);
    }
}
