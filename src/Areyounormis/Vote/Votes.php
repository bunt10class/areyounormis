<?php

declare(strict_types=1);

namespace Areyounormis\Vote;

class Votes
{
    /** @var Vote[] */
    private array $votes = [];

    public function addItem(Vote $vote): void
    {
        $this->votes[] = $vote;
    }

    public function getItems(): array
    {
        return $this->votes;
    }

    public function getCount(): int
    {
        return count($this->votes);
    }
}