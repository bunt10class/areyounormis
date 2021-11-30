<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\UserRate\UserRate;
use Areyounormis\UserRate\UserRates;
use Faker\Factory;
use Faker\Generator;

class UserRateFactory
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function makeUserRate(array $data = []): UserRate
    {
        return new UserRate(
            $data['max_vote'] ?? 10,
            $data['min_vote'] ?? 0,
            $data['avg_vote'] ?? $this->faker->randomFloat(3, 0, 10),
            $data['user_vote'] ?? $this->faker->randomFloat(3, 0, 10),
        );
    }

    public function makeFromZeroToTenUserRate(float $avgVote, float $userVote): UserRate
    {
        return $this->makeUserRate([
            'avg_vote' => $avgVote,
            'user_vote' => $userVote,
        ]);
    }

    public function makeUserRatesWithChildren(int $number): UserRates
    {
        $userMovieRates = new UserRates();

        for ($i = 0; $i < $number; $i++) {
            $userMovieRates->addOne($this->makeUserRate());
        }

        return $userMovieRates;
    }

    public function makeEmptyUserRates(): UserRates
    {
        return $this->makeUserRatesWithChildren(0);
    }
}