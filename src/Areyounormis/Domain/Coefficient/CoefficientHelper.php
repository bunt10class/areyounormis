<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Coefficient;

class CoefficientHelper
{
    public const NORM_TYPE = 'norm';
    public const OVER_UNDER_RATE_TYPE = 'over_under_rate';
    public const TYPES = [self::NORM_TYPE, self::OVER_UNDER_RATE_TYPE];

    public const PRECISION = 3;
}