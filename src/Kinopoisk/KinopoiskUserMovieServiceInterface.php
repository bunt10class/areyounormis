<?php

declare(strict_types=1);

namespace Kinopoisk;

interface KinopoiskUserMovieServiceInterface
{
    public function getUserMoviesById(int $userId): KinopoiskUserMovies;
}