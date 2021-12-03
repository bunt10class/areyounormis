<?php

declare(strict_types=1);

namespace Areyounormis\Movie;

class MovieVotes
{
    /** @var MovieVote[] */
    private array $movieVotes = [];

    public function addItem(MovieVote $movieVote): void
    {
        $this->movieVotes[] = $movieVote;
    }

    public function getItems(): array
    {
        return $this->movieVotes;
    }

    public function count(): int
    {
        return count($this->getItems());
    }
}