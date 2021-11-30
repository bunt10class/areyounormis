<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\UserRate\UserRates;

class CoefficientCalculator
{
    public const NORM_COEFFICIENT_PRECISION = 3;
    public const OVER_UNDER_RATE_COEFFICIENT_PRECISION = 3;

    public function calculateNormCoefficient(UserRates $userRates): float
    {
        $count = $userRates->getCount();
        if (!$count) {
            return 1;
        }

        $moduleRelativeDiffSum = 0;
        foreach ($userRates->getUserRates() as $userRate) {
            $moduleRelativeDiffSum += $userRate->getModuleRelativeDiff();
        }

        return 1 - round($moduleRelativeDiffSum / $count, self::NORM_COEFFICIENT_PRECISION);
    }

    public function calculateOverUnderRateCoefficient(UserRates $userRates): float
    {
        $count = $userRates->getCount();
        if (!$count) {
            return 0;
        }

        $relativeDiffSum = 0;
        foreach ($userRates->getUserRates() as $userRate) {
            $relativeDiffSum += $userRate->getRelativeDiff();
        }

        return round($relativeDiffSum / $count, self::OVER_UNDER_RATE_COEFFICIENT_PRECISION);
    }
}