<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie;

use Areyounormis\UserRate\UserRate;

class UserMovieRate
{
    protected UserRate $userRate;
    protected Movie $movie;

    public function __construct(UserRate $userRate, Movie $movie)
    {
        $this->userRate = $userRate;
        $this->movie = $movie;
    }

    public function getUserRate(): UserRate
    {
        return $this->userRate;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }
}