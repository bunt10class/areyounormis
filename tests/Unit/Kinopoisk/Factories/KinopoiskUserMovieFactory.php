<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Factories;

use Faker\Factory;
use Faker\Generator;
use Kinopoisk\KinopoiskUserMovie;
use Kinopoisk\KinopoiskUserMovies;

class KinopoiskUserMovieFactory
{
    protected Generator $enFaker;
    protected Generator $ruFaker;

    public function __construct()
    {
        $this->enFaker = Factory::create();
        $this->ruFaker = Factory::create('ru_RU');
    }

    public function make(array $data = []): KinopoiskUserMovie
    {
        return new KinopoiskUserMovie(
            $data['ru_name'] ?? null,
            $data['en_name'] ?? null,
            $data['link'] ?? null,
            $data['kp_vote'] ?? null,
            $data['vote_number'] ?? null,
            $data['duration_in_minutes'] ?? null,
            $data['vote_date'] ?? null,
            $data['user_vote'] ?? null,
        );
    }

    public function makeListWithOne(array $data = []): KinopoiskUserMovies
    {
        $userMovie = $this->make($data);

        $result = $this->makeEmptyList();
        $result->addItem($userMovie);
        return $result;
    }

    public function makeListWithSome(int $number): KinopoiskUserMovies
    {
        $result = new KinopoiskUserMovies();

        for ($i = 0; $i < $number; $i++) {
            $result->addItem($this->make());
        }

        return $result;
    }

    public function makeEmptyList(): KinopoiskUserMovies
    {
        return $this->makeListWithSome(0);
    }
}