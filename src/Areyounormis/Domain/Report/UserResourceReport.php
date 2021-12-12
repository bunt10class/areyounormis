<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Report;

use Areyounormis\Domain\Coefficient\CoefficientValueList;
use Areyounormis\Domain\Content\ContentVoteList;
use Areyounormis\Domain\User\User;
use Areyounormis\Domain\Vote\VoteSystem;

class UserResourceReport
{
    protected User $user;
    protected CoefficientValueList $coefficientValues;
    protected VoteSystem $voteSystem;
    protected ContentVoteList $contentVoteList;

    public function __construct(
        User $user,
        CoefficientValueList $coefficientValues,
        VoteSystem $voteSystem,
        ContentVoteList $contentVoteList,
    ) {
        $this->user = $user;
        $this->coefficientValues = $coefficientValues;
        $this->voteSystem = $voteSystem;
        $this->contentVoteList = $contentVoteList;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCoefficientValues(): CoefficientValueList
    {
        return $this->coefficientValues;
    }

    public function getVoteSystem(): VoteSystem
    {
        return $this->voteSystem;
    }

    public function getContentVoteList(): ContentVoteList
    {
        return $this->contentVoteList;
    }
}