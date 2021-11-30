<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Kinopoisk\UserMovieRateRepository;
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

        $overRates = new UserMovieRates();
        $normRates = new UserMovieRates();
        $underRates = new UserMovieRates();

        $userRates = $this->ratesCalculator->collectUserRates(
            $userMovies,
            $overRates,
            $normRates,
            $underRates,
        );

        return new UserReport(
            $user,
            $this->coefficientCalculator->calculateNormCoefficient($userRates),
            $this->coefficientCalculator->calculateOverUnderRateCoefficient($userRates),
            $overRates,
            $normRates,
            $underRates,
        );
    }
}