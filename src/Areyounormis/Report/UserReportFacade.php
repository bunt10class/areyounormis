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

    public function getPrettyData(): array
    {
        $user = $this->userReport->getUser();

        return [
            'user' => [
                'id' => $user->getId(),
                'login' => $user->getLogin(),
            ],
            'norm_coefficient' => $this->userReport->getNormCoefficient(),
            'over_under_rate_coefficient' => $this->userReport->getOverUnderRateCoefficient(),
            'over_rates' => $this->getPrettyDataUserMovieRates($this->userReport->getOverRates()),
            'norm_rates' => $this->getPrettyDataUserMovieRates($this->userReport->getNormRates()),
            'under_rates' => $this->getPrettyDataUserMovieRates($this->userReport->getUnderRates()),
        ];
    }

    protected function getPrettyDataUserMovieRates(UserMovieRates $userMovieRates): array
    {
        $result = [];

        foreach ($userMovieRates->getUserMovieRates() as $userMovieRate) {
            $result[] = [

            ];
        }

        return $result;
    }
}