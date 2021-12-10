<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Coefficient\CoefficientValues;
use Areyounormis\User\User;
use Areyounormis\Movie\MovieVotes;
use Areyounormis\Vote\VoteSystem;

class UserReport
{
    protected User $user;
    protected CoefficientValues $coefficientValues;
    protected VoteSystem $voteSystem;
    protected MovieVotes $movieVotes;

    public function __construct(
        User $user,
        CoefficientValues $coefficientValues,
        VoteSystem $voteSystem,
        MovieVotes $movieVotes,
    ) {
        $this->user = $user;
        $this->coefficientValues = $coefficientValues;
        $this->voteSystem = $voteSystem;
        $this->movieVotes = $movieVotes;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCoefficientValues(): CoefficientValues
    {
        return $this->coefficientValues;
    }

    public function getVoteSystem(): VoteSystem
    {
        return $this->voteSystem;
    }

    public function getMovieVotes(): MovieVotes
    {
        return $this->movieVotes;
    }
}