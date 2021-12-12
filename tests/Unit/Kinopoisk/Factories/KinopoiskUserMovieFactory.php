<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Factories;

use Kinopoisk\Dto\KinopoiskUserMovie;
use Kinopoisk\Dto\KinopoiskUserMovieList;

class KinopoiskUserMovieFactory
{
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

    public function makeListWithOne(array $data = []): KinopoiskUserMovieList
    {
        $userMovie = $this->make($data);

        $result = $this->makeEmptyList();
        $result->addItem($userMovie);
        return $result;
    }

    public function makeListWithSome(int $number): KinopoiskUserMovieList
    {
        $result = new KinopoiskUserMovieList();

        for ($i = 0; $i < $number; $i++) {
            $result->addItem($this->make());
        }

        return $result;
    }

    public function makeEmptyList(): KinopoiskUserMovieList
    {
        return $this->makeListWithSome(0);
    }
}