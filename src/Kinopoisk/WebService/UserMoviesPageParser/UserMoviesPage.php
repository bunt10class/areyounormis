<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

use Kinopoisk\Dto\KinopoiskUserMovieList;

class UserMoviesPage
{
    protected bool $isCaptcha;
    protected ?KinopoiskUserMovieList $userMoviesDto;

    public function __construct(bool $isCaptcha, ?KinopoiskUserMovieList $userMoviesDto)
    {
        $this->isCaptcha = $isCaptcha;
        $this->userMoviesDto = $userMoviesDto;
    }

    public function isCaptcha(): bool
    {
        return $this->isCaptcha;
    }

    public function getUserMoviesDto(): ?KinopoiskUserMovieList
    {
        return $this->userMoviesDto;
    }
}