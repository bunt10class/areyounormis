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

    public function makeKinopoiskUserMovie(array $data = []): KinopoiskUserMovie
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

    public function makeKinopoiskUserMovieWithOne(array $data = []): KinopoiskUserMovies
    {
        $userMovie = $this->makeKinopoiskUserMovie($data);

        $result = $this->makeEmptyKinopoiskUserMovies();
        $result->addItem($userMovie);
        return $result;
    }

    public function makeKinopoiskUserMoviesWithSome(int $number): KinopoiskUserMovies
    {
        $result = new KinopoiskUserMovies();

        for ($i = 0; $i < $number; $i++) {
            $result->addItem($this->makeKinopoiskUserMovie());
        }

        return $result;
    }

    public function makeEmptyKinopoiskUserMovies(): KinopoiskUserMovies
    {
        return $this->makeKinopoiskUserMoviesWithSome(0);
    }
}