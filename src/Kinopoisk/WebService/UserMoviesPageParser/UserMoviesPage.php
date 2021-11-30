<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

use Kinopoisk\UserMoviesDto;

class UserMoviesPage
{
    protected bool $isCaptcha;
    protected ?UserMoviesDto $userMoviesDto;

    public function __construct(bool $isCaptcha, ?UserMoviesDto $userMoviesDto)
    {
        $this->isCaptcha = $isCaptcha;
        $this->userMoviesDto = $userMoviesDto;
    }

    public function isCaptcha(): bool
    {
        return $this->isCaptcha;
    }

    public function getUserMoviesDto(): ?UserMoviesDto
    {
        return $this->userMoviesDto;
    }
}