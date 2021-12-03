<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient;

use Areyounormis\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Vote\Votes;
use Areyounormis\Vote\VoteSystem;

class CoefficientCalculator
{
    /**
     * @throws InvalidCoefficientTypeException
     */
    public function calculateCoefficient(string $type, Votes $votes): float
    {
        switch ($type) {
            case CoefficientHelper::NORM_TYPE:
                return $this->calculateNormCoefficient($votes);
            case CoefficientHelper::OVER_UNDER_RATE_TYPE:
                return $this->calculateOverUnderRateCoefficient($votes);
        }
        throw new InvalidCoefficientTypeException($type);
    }

    public function calculateNormCoefficient(Votes $votes): float
    {
        $count = $votes->getCount();
        if (!$count) {
            return 1;
        }

        $moduleRelativeDiffSum = 0;
        foreach ($votes->getItems() as $vote) {
            $moduleRelativeDiffSum += $vote->getModuleRelativeDiff();
        }

        return 1 - round($moduleRelativeDiffSum / $count, VoteSystem::PRECISION);
    }

    public function calculateOverUnderRateCoefficient(Votes $votes): float
    {
        $count = $votes->getCount();
        if (!$count) {
            return 0;
        }

        $relativeDiffSum = 0;
        foreach ($votes->getItems() as $vote) {
            $relativeDiffSum += $vote->getRelativeDiff();
        }

        return round($relativeDiffSum / $count, VoteSystem::PRECISION);
    }
}