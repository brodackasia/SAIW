<?php

declare(strict_types=1);

namespace App\Const;

class MatTypeConst
{
    public const BATHTUB = "bathtub";

    public const CHAIR = "chair";

    public const ALL_TYPES = [
        self::BATHTUB,
        self::CHAIR
    ];
}