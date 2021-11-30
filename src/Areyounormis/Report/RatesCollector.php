<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\UserMovie\RelativeRates;
use Areyounormis\UserMovie\UserMovieRates;

class RatesCollector
{
    protected const OVER_RATE_COEFFICIENT = 0.5;
    protected const UNDER_RATE_COEFFICIENT = -0.5;
    protected const NORM_RATE_COEFFICIENT = 0.06;

    public function collectRates(
        UserMovieRates $userMovieRates,
        UserMovieRates &$overRateMovies,
        UserMovieRates &$normRateMovies,
        UserMovieRates &$underRateMovies,
        RelativeRates &$relativeRates,
    ): void {
        foreach ($userMovieRates->getUserMovieRates() as $userMovieRate) {
            $relativeRate = $userMovieRate->getRelativeRate();
            $relativeRates->addOne($relativeRate);

            $relativeRateValue = $relativeRate->getValue();
            if ($relativeRateValue > self::OVER_RATE_COEFFICIENT) {
                $overRateMovies->addOne($userMovieRate);
                continue;
            }
            if (abs($relativeRateValue) < self::NORM_RATE_COEFFICIENT) {
                $normRateMovies->addOne($userMovieRate);
                continue;
            }
            if ($relativeRateValue < self::UNDER_RATE_COEFFICIENT) {
                $underRateMovies->addOne($userMovieRate);
            }
        }
    }
}