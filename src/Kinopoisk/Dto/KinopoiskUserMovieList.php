<?php

declare(strict_types=1);

namespace Kinopoisk\Dto;

class KinopoiskUserMovieList
{
    /** @var KinopoiskUserMovie[] */
    protected array $userMovieList = [];

    public function addItem(KinopoiskUserMovie $userMovie): void
    {
        $this->userMovieList[] = $userMovie;
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
        return $this->userMovieList;
    }

    public function isEmpty(): bool
    {
        return empty($this->userMovieList);
    }
}