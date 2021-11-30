<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie;

class Movie
{
    protected ?string $ruName;
    protected ?string $enName;
    protected ?string $link;
    protected string $vote;

    public function __construct(?string $ruName, ?string $enName, ?string $link, string $vote)
    {
        $this->ruName = $ruName;
        $this->enName = $enName;
        $this->link = $link;
        $this->vote = $vote;
    }

    public function getRuName(): ?string
    {
        return $this->ruName;
    }

    public function getEnName(): ?string
    {
        return $this->enName;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getVote(): string
    {
        return $this->vote;
    }
}