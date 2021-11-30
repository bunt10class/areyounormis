<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Kinopoisk\UserMovieRateRepository;
use Areyounormis\UserMovie\RelativeRates;
use Areyounormis\UserMovie\User;
use Areyounormis\UserMovie\UserMovieRates;

class UserReportService
{
    protected UserMovieRateRepository $userReportRepository;
    protected CoefficientCalculator $coefficientCalculator;
    protected RatesCollector $ratesCalculator;

    public function __construct(
        UserMovieRateRepository $userReportRepository,
        CoefficientCalculator $coefficientCalculator,
        RatesCollector $ratesCalculator,
    ) {
        $this->userReportRepository = $userReportRepository;
        $this->coefficientCalculator = $coefficientCalculator;
        $this->ratesCalculator = $ratesCalculator;
    }

    public function getUserReport(int $userId): UserReport
    {
        $user = new User($userId, null);

        $userMovies = $this->userReportRepository->getUserMovieRatesByUserId($user->getId());

        $overRateMovie = new UserMovieRates();
        $normRateMovies = new UserMovieRates();
        $underRateMovies = new UserMovieRates();
        $relativeRates = new RelativeRates();

        $this->ratesCalculator->collectRates(
            $userMovies,
            $overRateMovie,
            $normRateMovies,
            $underRateMovies,
            $relativeRates,
        );

        return new UserReport(
            $user,
            $this->coefficientCalculator->calculateNormCoefficient($relativeRates),
            $this->coefficientCalculator->calculateOverUnderRateCoefficient($relativeRates),
            $overRateMovie,
            $normRateMovies,
            $underRateMovies,
        );
    }
}