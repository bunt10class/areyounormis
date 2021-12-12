<?php

declare(strict_types=1);

namespace Areyounormis\Infrastructure\ResourceData;

use Areyounormis\Domain\Content\ContentVoteList;
use Areyounormis\Domain\Vote\VoteList;
use Areyounormis\Domain\Vote\VoteSystem;

class ResourceDataDto
{
    protected VoteSystem $voteSystem;
    protected VoteList $voteList;
    protected ContentVoteList $contentVoteList;

    public function __construct(VoteSystem $voteSystem, VoteList $voteList, ContentVoteList $contentVoteList)
    {
        $this->voteSystem = $voteSystem;
        $this->voteList = $voteList;
        $this->contentVoteList = $contentVoteList;
    }

    public function getVoteSystem(): VoteSystem
    {
        return $this->voteSystem;
    }

    public function getVoteList(): VoteList
    {
        return $this->voteList;
    }

    public function getContentVoteList(): ContentVoteList
    {
        return $this->contentVoteList;
    }
}