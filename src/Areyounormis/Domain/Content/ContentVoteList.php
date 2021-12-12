<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Content;

class ContentVoteList
{
    /** @var ContentVote[] */
    private array $contentVotes = [];

    public function __construct(array $contentVotes = [])
    {
        $this->addItems($contentVotes);
    }

    public function addItem(ContentVote $contentVote): void
    {
        $this->contentVotes[] = $contentVote;
    }

    public function addItems(array $contentVotes): void
    {
        foreach ($contentVotes as $contentVote) {
            if(!$contentVote instanceof ContentVote) {
                continue;
            }
            $this->addItem($contentVote);
        }
    }

    public function getItems(): array
    {
        return $this->contentVotes;
    }

    public function count(): int
    {
        return count($this->getItems());
    }
}