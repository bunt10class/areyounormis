<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\UserMovie\UserMovieRates;
use Areyounormis\UserRate\UserRateFactory;
use Areyounormis\UserRate\UserRates;

class RatesCollector
{
    protected const OVER_RATE_COEFFICIENT = 0.5;
    protected const UNDER_RATE_COEFFICIENT = -0.5;
    protected const NORM_RATE_COEFFICIENT = 0.06;

    public function collectUserRates(
        UserMovieRates $userMovieRates,
        UserMovieRates &$overRates,
        UserMovieRates &$normRates,
        UserMovieRates &$underRates,
    ): UserRates {
        $userRates = UserRateFactory::makeUserRates();

        foreach ($userMovieRates->getUserMovieRates() as $userMovieRate) {
            $userRate = $userMovieRate->getUserRate();
            $userRates->addOne($userRate);

            $relativeDiff = $userRate->getRelativeDiff();
            if ($relativeDiff > self::OVER_RATE_COEFFICIENT) {
                $overRates->addOne($userMovieRate);
            } elseif ($relativeDiff < self::UNDER_RATE_COEFFICIENT) {
                $underRates->addOne($userMovieRate);
            } elseif ($userRate->getModuleRelativeDiff() < self::NORM_RATE_COEFFICIENT) {
                $normRates->addOne($userMovieRate);
            }
        }

        return $userRates;
    }
}