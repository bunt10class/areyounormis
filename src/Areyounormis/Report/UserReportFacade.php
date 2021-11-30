<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\UserMovie\UserMovieRates;

class UserReportFacade
{
    private UserReport $userReport;

    public function __construct(UserReport $userReport)
    {
        $this->userReport = $userReport;
    }

    public function toArray(): array
    {
        $user = $this->userReport->getUser();

        return [
            'user' => [
                'id' => $user->getId(),
                'login' => $user->getLogin(),
            ],
            'norm_coefficient' => $this->userReport->getNormCoefficient(),
            'over_under_rate_coefficient' => $this->userReport->getOverUnderRateCoefficient(),
            'over_rate_movies' => [

            ]
        ];
    }

    protected function getMovieList(UserMovieRates $userMovieRates): array
    {
        $movieList = [];

//        foreach ($userMovieRates->getUserMovieRates() as $userMovieRate) {
//            $userMovieRate->
//        }

        return $movieList;
    }
}