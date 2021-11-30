<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie;

class UserMovieRate
{
    protected string $userVote;
    protected RelativeRate $relativeRate;
    protected Movie $movie;

    public function __construct(string $userVote, RelativeRate $relativeRate, Movie $movie)
    {
        $this->userVote = $userVote;
        $this->relativeRate = $relativeRate;
        $this->movie = $movie;
    }

    public function getUserVote(): string
    {
        return $this->userVote;
    }

    public function getRelativeRate(): RelativeRate
    {
        return $this->relativeRate;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }
}