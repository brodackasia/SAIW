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

    public function getCurrentHR(string $type): ?int
    {
        return $this->HRRepository->getCurrentHR($type);
    }

    public function getMinimumHR(string $type, DateTime $from, DateTime $to): int
    {
        return $this->HRRepository->getMinimumHR( $type, $from, $to);
    }

    public function getMaximumHR(string $type, DateTime $from, DateTime $to): int
    {
        return $this->HRRepository->getMaximumHR($type, $from, $to);
    }

    public function getAverageHR(string $type, DateTime $from, DateTime $to): int
    {
        return $this->HRRepository->getAverageHR($type, $from, $to);
    }
}
