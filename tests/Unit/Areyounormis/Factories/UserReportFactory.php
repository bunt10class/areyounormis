<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\Report\UserReport;
use Areyounormis\UserMovie\User;
use Areyounormis\UserMovie\MovieVote;
use Areyounormis\UserMovie\MovieVotes;
use Faker\Factory;
use Faker\Generator;

class UserReportFactory
{
    protected Generator $enFaker;
    protected Generator $ruFaker;
    protected UserMovieRateFactory $userMovieRateFactory;

    public function __construct()
    {
        $this->enFaker = Factory::create();
        $this->ruFaker = Factory::create('ru_RU');
        $this->userMovieRateFactory = new UserMovieRateFactory();
    }

    public function makeUserReport(array $data = []): UserReport
    {
        return new UserReport(
            new User(
                $data['user_id'] ?? $this->enFaker->numberBetween(1),
                $data['user_login'] ?? $this->enFaker->userName,
            ),
            $data['norm_coefficient'] ?? $this->enFaker->randomFloat(3, 0, 1),
            $data['over_under_rate_coefficient'] ?? $this->enFaker->randomFloat(3, -1, 1),
            $this->makeUserMovieRates($data['over_rates'] ?? null),
        );
    }

    protected function makeUserMovieRates(?array $userMovieRates): MovieVotes
    {
        $result = $this->userMovieRateFactory->makeEmptyUserMovieRates();

        if (is_null($userMovieRates)) {
            $result->addOne($this->userMovieRateFactory->makeUserMovieRate());
        } else {
            foreach ($userMovieRates as $userMovieRate) {
                if (!$userMovieRate instanceof MovieVote) {
                    continue;
                }

                $result->addOne($userMovieRate);
            }
        }

        return $result;
    }
}