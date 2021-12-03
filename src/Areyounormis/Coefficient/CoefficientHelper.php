<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient;

use Areyounormis\Coefficient\Exceptions\InvalidCoefficientTypeException;

class CoefficientHelper
{
    public const NORM_TYPE = 'norm';
    public const OVER_UNDER_RATE_TYPE = 'over_under_rate';
    public const TYPES = [self::NORM_TYPE, self::OVER_UNDER_RATE_TYPE];

    public const DEFAULT_LEVEL_COLOR = 'grey';

    /**
     * @throws InvalidCoefficientTypeException
     */
    public static function validateType(string $type): void
    {
        if (!in_array($type, self::TYPES)) {
            throw new InvalidCoefficientTypeException($type);
        }
    }
}