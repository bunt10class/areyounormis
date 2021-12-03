<?php

declare(strict_types=1);

namespace Kinopoisk;

class KinopoiskUserMovies
{
    /** @var KinopoiskUserMovie[] */
    protected array $userMovies = [];

    public function addItem(KinopoiskUserMovie $userMovie): void
    {
        $this->userMovies[] = $userMovie;
    }

    public function addItems(array $userMovies): void
    {
        foreach ($userMovies as $userMovie) {
            if (!$userMovie instanceof KinopoiskUserMovie) {
                continue;
            }

            $this->addItem($userMovie);
        }
    }

    public function getItems(): array
    {
        return $this->userMovies;
    }

    public function isEmpty(): bool
    {
        return empty($this->userMovies);
    }
}