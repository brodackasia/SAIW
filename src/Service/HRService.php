<?php

declare(strict_types=1);

namespace App\Service;

use App\Const\MatTypeConst;
use App\CurrentHRQuery\CurrentHrQuery;
use App\Query\HrQuery;
use App\Repository\HRRepository;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HRService
{
    private HRRepository $HRRepository;

    private ValidatorInterface $validator;

    public function __construct(HRRepository $HRRepository, ValidatorInterface $validator)
    {
        $this->HRRepository = $HRRepository;
        $this->validator = $validator;
    }

    public function getChartData(HrQuery $query): array
    {
        $this->validateMeasurementParameters($query);

        switch ($query->getType()) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathChartData($query);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairChartData($query);
            default:
                throw new Exception("Invalid parameter 'type'!");
        }
    }

    public function getCurrentHR(CurrentHrQuery $currentQuery): ?int
    {
        $this->validateCurrentMeasurementParameters($currentQuery);

        switch ($currentQuery->getType()) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathCurrentHR($currentQuery);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairCurrentHR($currentQuery);
            default:
                throw new Exception("Invalid parameter 'type'!");
        }
    }

    public function getMinimumHR(HrQuery $query): int
    {
        $this->validateMeasurementParameters($query);

        switch ($query->getType()) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathMinimumHR($query);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairMinimumHR($query);
            default:
                throw new Exception("Invalid parameter 'type'!");
        }
    }

    public function getMaximumHR(HrQuery $query): int
    {
        $this->validateMeasurementParameters($query);

        switch ($query->getType()) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathMaximumHR($query);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairMaximumHR($query);
            default:
                throw new Exception("Invalid parameter 'type'!");
        }
    }

    public function getAverageHR(HrQuery $query): int
    {
        $this->validateMeasurementParameters($query);

        switch ($query->getType()) {
            case MatTypeConst::BATHTUB:
                return $this->HRRepository->getBathAverageHR($query);
            case MatTypeConst::CHAIR:
                return $this->HRRepository->getChairAverageHR($query);
            default:
                throw new Exception("Invalid parameter 'type'!");
        }
    }

    private function validateMeasurementParameters(HrQuery $query): ?string
    {
        $errors = $this->validator->validate($query);

        if (count($errors) > 0) {
            throw new Exception(
                $errors[0]->getMessageTemplate()
            );
        }

        return null;
    }

    private function validateCurrentMeasurementParameters(CurrentHrQuery $currentQuery): ?string
    {
        $errors = $this->validator->validate($currentQuery);

        if (count($errors) > 0) {
            throw new Exception(
                $errors[0]->getMessageTemplate()
            );
        }

        return null;
    }
}