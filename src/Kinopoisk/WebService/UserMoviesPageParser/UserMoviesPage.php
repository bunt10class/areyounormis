<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

use Kinopoisk\KinopoiskUserMovies;

class UserMoviesPage
{
    protected bool $isCaptcha;
    protected ?KinopoiskUserMovies $userMoviesDto;

    public function __construct(bool $isCaptcha, ?KinopoiskUserMovies $userMoviesDto)
    {
        $this->isCaptcha = $isCaptcha;
        $this->userMoviesDto = $userMoviesDto;
    }

    public function isCaptcha(): bool
    {
        return $this->isCaptcha;
    }

    public function getUserMoviesDto(): ?KinopoiskUserMovies
    {
        return $this->userMoviesDto;
    }
}