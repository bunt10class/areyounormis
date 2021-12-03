<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Coefficient\Coefficients;
use Areyounormis\User\User;
use Areyounormis\Movie\MovieVotes;
use Areyounormis\Vote\VoteSystem;

class UserReport
{
    protected User $user;
    protected Coefficients $coefficients;
    protected VoteSystem $voteSystem;
    protected MovieVotes $movieVotes;

    public function __construct(
        User $user,
        Coefficients $coefficients,
        VoteSystem $voteSystem,
        MovieVotes $userMovieRates,
    ) {
        $this->user = $user;
        $this->coefficients = $coefficients;
        $this->voteSystem = $voteSystem;
        $this->movieVotes = $userMovieRates;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCoefficients(): Coefficients
    {
        return $this->coefficients;
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