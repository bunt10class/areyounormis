<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Mocks;

use Kinopoisk\KinopoiskUserMovies;
use Kinopoisk\KinopoiskUserMovieServiceInterface;

class KinopoiskUserMovieServiceMock implements KinopoiskUserMovieServiceInterface
{
    protected KinopoiskUserMovies $kinopoiskUserMovies;

    public function __construct(KinopoiskUserMovies $kinopoiskUserMovies)
    {
        $this->kinopoiskUserMovies = $kinopoiskUserMovies;
    }

    public function getUserMoviesById(int $userId): KinopoiskUserMovies
    {
        return $this->kinopoiskUserMovies;
    }
}