<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie;

class UserMovieRates
{
    /** @var UserMovieRate[] */
    private array $userMovieRates = [];

    public function addOne(UserMovieRate $userMovieRate): void
    {
        $this->userMovieRates[] = $userMovieRate;
    }

    public function getUserMovieRates(): array
    {
        return $this->userMovieRates;
    }
}