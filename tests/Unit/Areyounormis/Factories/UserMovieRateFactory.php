<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\UserMovie\Movie;
use Areyounormis\UserMovie\RelativeRate;
use Areyounormis\UserMovie\UserMovieRate;
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
        return new UserMovieRate(
            $data['user_vote'] ?? (string)$this->enFaker->numberBetween(1, 10),
            new RelativeRate(
                $data['relative_rate'] ?? $this->enFaker->randomFloat(3, -1, 1)
            ),
            new Movie(
                $data['ru_name'] ?? $this->ruFaker->domainName,
                $data['en_name'] ?? $this->enFaker->domainName,
                $data['link'] ?? 'https://' . $this->enFaker->domainName,
                $data['vote'] ?? (string)$this->enFaker->randomFloat(3, 1, 10),
            )
        );
    }
}