<?php

declare(strict_types=1);

namespace App\Service;

use App\Const\MatTypeConst;
use App\Repository\HRRepository;
use DateTime;
use Exception;
class HRService
{
    private HRRepository $HRRepository;

    public function __construct(HRRepository $HRRepository)
    {
        $this->HRRepository = $HRRepository;
    }

    public function getChartData(string $type, DateTime $from, DateTime $to, int $patientId): array
    {
        switch ($type) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathChartData($patientId, $from, $to);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairChartData($patientId, $from, $to);
            default:
                throw new Exception("Invalid parameter type!");
        }
    }

    public function getCurrentHR(string $type, int $patientId): ?int
    {
        switch ($type) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathCurrentHR($patientId);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairCurrentHR($patientId);
            default:
                throw new Exception("Invalid parameter type!");
        }
    }

    public function getMinimumHR(string $type, DateTime $from, DateTime $to, int $patientId): int
    {
        switch ($type) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathMinimumHR($patientId, $from, $to);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairMinimumHR($patientId, $from, $to);
            default:
                throw new Exception("Invalid parameter type!");
        }
    }

    public function getMaximumHR(string $type, DateTime $from, DateTime $to, int $patientId): int
    {
        switch ($type) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathMaximumHR($patientId, $from, $to);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairMaximumHR($patientId, $from, $to);
            default:
                throw new Exception("Invalid parameter type!");
        }
    }

    public function getAverageHR(string $type, DateTime $from, DateTime $to, int $patientId): int
    {
        switch ($type) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathAverageHR($patientId, $from, $to);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairAverageHR($patientId, $from, $to);
            default:
                throw new Exception("Invalid parameter type!");
        }
    }
}




