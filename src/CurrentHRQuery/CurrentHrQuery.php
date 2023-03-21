<?php

namespace App\CurrentHRQuery;

use App\Const\MatTypeConst;
use Symfony\Component\Validator\Constraints as Assert;

class CurrentHrQuery
{
    #[Assert\NotBlank(message: "Parameter 'patientId' must not be null!")]
    private ?int $patientId;

    #[Assert\NotBlank(message: "Parameter 'type' must not be null!")]
    #[Assert\Choice(MatTypeConst::ALL_TYPES, message: "Invalid parameter 'type'!")]
    private ?string $type;

    public function getPatientId(): ?int
    {
        return $this->patientId;
    }

    public function setPatientId(?int $patientId): CurrentHrQuery
    {
        $this->patientId = $patientId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): CurrentHrQuery
    {
        $this->type = $type;

        return $this;
    }
}