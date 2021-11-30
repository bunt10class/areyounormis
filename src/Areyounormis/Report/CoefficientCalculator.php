<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\UserMovie\RelativeRates;

class CoefficientCalculator
{
    public const NORM_COEFFICIENT_PRECISION = 3;
    public const OVER_UNDER_RATE_COEFFICIENT_PRECISION = 3;

    public function calculateNormCoefficient(RelativeRates $relativeRates): float
    {
        $rateSum = 0;
        $count = 0;
        foreach ($relativeRates->getRelativeRates() as $relativeRate) {
            $count++;
            $rateSum += abs($relativeRate->getValue());
        }

        if ($count) {
            $unNormalCoefficient = $rateSum / $count;
        } else {
            $unNormalCoefficient = 0;
        }

        return 1 - round($unNormalCoefficient, self::NORM_COEFFICIENT_PRECISION);
    }

    public function calculateOverUnderRateCoefficient(RelativeRates $relativeRates): float
    {
        $rateSum = 0;
        $count = 0;
        foreach ($relativeRates->getRelativeRates() as $relativeRate) {
            $count++;
            $rateSum += $relativeRate->getValue();
        }

        if ($count) {
            $overUnderRateCoefficient = $rateSum / $count;
        } else {
            $overUnderRateCoefficient = 0;
        }

        return round($overUnderRateCoefficient, self::OVER_UNDER_RATE_COEFFICIENT_PRECISION);
    }
}