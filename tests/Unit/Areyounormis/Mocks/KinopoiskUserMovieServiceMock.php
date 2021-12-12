<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Mocks;

use Kinopoisk\Dto\KinopoiskUserMovieList;
use Kinopoisk\KinopoiskUserMovieServiceInterface;

class KinopoiskUserMovieServiceMock implements KinopoiskUserMovieServiceInterface
{
    protected KinopoiskUserMovieList $kinopoiskUserMovies;

    public function __construct(KinopoiskUserMovieList $kinopoiskUserMovies)
    {
        $this->kinopoiskUserMovies = $kinopoiskUserMovies;
    }

    public function getUserMoviesById(int $userId): KinopoiskUserMovieList
    {
        return $this->kinopoiskUserMovies;
    }
}