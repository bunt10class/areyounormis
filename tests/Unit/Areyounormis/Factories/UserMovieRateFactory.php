<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\UserMovie\Movie;
use Areyounormis\UserMovie\UserMovieRate;
use Areyounormis\UserMovie\UserMovieRates;
use Areyounormis\UserRate\UserRate;
use Faker\Factory;
use Faker\Generator;

class UserMovieRateFactory
{
    protected Generator $enFaker;
    protected Generator $ruFaker;

    public function __construct()
    {
        $this->enFaker = Factory::create();
        $this->ruFaker = Factory::create('ru_RU');
    }

    public function makeUserMovieRate(array $data = []): UserMovieRate
    {
        $userRate = new UserRate(
            $data['max_vote'] ?? 10,
            $data['min_vote'] ?? 0,
            $data['avg_vote'] ?? $this->enFaker->randomFloat(3, 0, 10),
            $data['user_vote'] ?? $this->enFaker->randomFloat(3, 0, 10),
        );

        $movie = new Movie(
            $data['ru_name'] ?? $this->ruFaker->domainName,
            $data['en_name'] ?? $this->enFaker->domainName,
            $data['link'] ?? 'https://' . $this->enFaker->domainName,
        );

        return new UserMovieRate($userRate, $movie);
    }

    public function makeUserMovieRatesWithChildren(int $number): UserMovieRates
    {
        $userMovieRates = new UserMovieRates();

        for ($i = 0; $i < $number; $i++) {
            $userMovieRates->addOne($this->makeUserMovieRate());
        }

        return $userMovieRates;
    }

    public function makeEmptyUserMovieRates(): UserMovieRates
    {
        return $this->makeUserMovieRatesWithChildren(0);
    }
}