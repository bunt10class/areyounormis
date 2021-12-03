<?php

declare(strict_types=1);

namespace Areyounormis\Movie;

use Areyounormis\Vote\Vote;

class MovieVote
{
    protected Movie $movie;
    protected Vote $vote;

    public function __construct(Movie $movie, Vote $vote)
    {
        $this->movie = $movie;
        $this->vote = $vote;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function getVote(): Vote
    {
        return $this->vote;
    }
}