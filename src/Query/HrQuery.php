<?php

namespace App\Query;

use App\Const\MatTypeConst;
use Symfony\Component\Validator\Constraints as Assert;

class HrQuery
{
    #[Assert\NotBlank(message: "Parameter 'patientId' must not be null!")]
    private ?int $patientId;

    #[Assert\NotBlank(message: "Parameter 'type' must not be null!")]
    #[Assert\Choice(MatTypeConst::ALL_TYPES, message: "Invalid parameter type!")]
    private ?string $type;

    #[Assert\NotBlank(message: "Parameter 'from' must not be null!")]
    private ?string $from;

    #[Assert\NotBlank(message: "Parameter 'to' must not be null!")]
    private ?string $to;

    public function getPatientId(): ?int
    {
        return $this->patientId;
    }

    public function setPatientId(?int $patientId): HrQuery
    {
        $this->patientId = $patientId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): HrQuery
    {
        $this->type = $type;

        return $this;
    }

    public function getFrom(): ?string
    {
        return $this->from;
    }

    public function setFrom(?string $from): HrQuery
    {
        $this->from = $from;

        return $this;
    }

    public function getTo(): ?string
    {
        return $this->to;
    }

    public function setTo(?string $to): HrQuery
    {
        $this->to = $to;

        return $this;
    }

    public function toArray(HrQuery $query): array
    {
        return ([
            'patientId' => $query->getPatientId(),
            'dateTimeFrom' => $query->getFrom(),
            'dateTimeTo' => $query->getTo()
        ]);
    }

}