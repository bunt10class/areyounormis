<?php

declare(strict_types=1);

namespace Kinopoisk;

use Kinopoisk\Dto\KinopoiskUserMovieList;

interface KinopoiskUserMovieServiceInterface
{
    public function getUserMoviesById(int $userId): KinopoiskUserMovieList;
}