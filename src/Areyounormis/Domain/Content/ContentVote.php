<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Content;

use Areyounormis\Domain\Vote\Vote;

class ContentVote
{
    protected Content $content;
    protected Vote $vote;

    public function __construct(Content $content, Vote $vote)
    {
        $this->content = $content;
        $this->vote = $vote;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getVote(): Vote
    {
        return $this->vote;
    }
}