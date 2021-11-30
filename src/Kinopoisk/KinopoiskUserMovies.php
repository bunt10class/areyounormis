<?php

declare(strict_types=1);

namespace Kinopoisk;

class KinopoiskUserMovies
{
    /** @var KinopoiskUserMovie[] */
    protected array $userMovies = [];

    public function addOne(KinopoiskUserMovie $userMovie): void
    {
        $this->userMovies[] = $userMovie;
    }

    public function addMany(array $userMovies): void
    {
        foreach ($userMovies as $userMovie) {
            if (!$userMovie instanceof KinopoiskUserMovie) {
                continue;
            }

            $this->addOne($userMovie);
        }
    }

    public function getUserMovies(): array
    {
        return $this->userMovies;
    }

    public function isEmpty(): bool
    {
        return empty($this->userMovies);
    }
}