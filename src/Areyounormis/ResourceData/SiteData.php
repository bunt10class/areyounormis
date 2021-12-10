<?php

declare(strict_types=1);

namespace Areyounormis\ResourceData;

use Areyounormis\Movie\MovieVotes;
use Areyounormis\Vote\Votes;
use Areyounormis\Vote\VoteSystem;

class SiteData
{
    protected VoteSystem $voteSystem;
    protected Votes $votes;
    protected MovieVotes $movieVotes;

    public function __construct(VoteSystem $voteSystem, Votes $votes, MovieVotes $movieVotes)
    {
        $this->voteSystem = $voteSystem;
        $this->votes = $votes;
        $this->movieVotes = $movieVotes;
    }

    public function getVoteSystem(): VoteSystem
    {
        return $this->voteSystem;
    }

    public function getVotes(): Votes
    {
        return $this->votes;
    }

    public function getMovieVotes(): MovieVotes
    {
        return $this->movieVotes;
    }
}