<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Factories;

use Faker\Factory;
use Faker\Generator;
use Kinopoisk\UserMovieDto;

class UserMovieDtoFactory
{
    protected Generator $enFaker;
    protected Generator $ruFaker;

    public function __construct()
    {
        $this->enFaker = Factory::create();
        $this->ruFaker = Factory::create('ru_RU');
    }

    public function makeUserMovieDto(array $data = []): UserMovieDto
    {
        return new UserMovieDto(
            $data['ru_name'] ?? $this->ruFaker->domainName,
            $data['en_name'] ?? $this->enFaker->domainName,
            $data['link'] ?? 'https://' . $this->enFaker->domainName,
            $data['kp_vote'] ?? $this->enFaker->randomFloat(3, 1, 10),
            $data['vote_number'] ?? $this->enFaker->numberBetween(0, 1000000),
            $data['duration_in_minutes'] ?? $this->enFaker->numberBetween(1, 1000),
            $data['vote_date'] ?? $this->enFaker->date(),
            $data['user_vote'] ?? $this->enFaker->numberBetween(1, 10),
        );
    }
}