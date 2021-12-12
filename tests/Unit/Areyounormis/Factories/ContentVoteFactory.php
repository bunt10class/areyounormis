<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\Domain\Content\ContentVote;
use Areyounormis\Domain\Content\ContentVoteList;

class ContentVoteFactory
{
    public static function getItem(array $data): ContentVote
    {
        $content = ContentFactory::getItem($data);

        $vote = VoteFactory::getDefaultItem(
            $data['user_vote'] ?? 5,
            $data['site_vote'] ?? 5,
        );

        return new ContentVote($content, $vote);
    }

    public static function getListWithOneItem($data): ContentVoteList
    {
        $result = self::getEmptyList();
        $result->addItem(self::getItem($data));
        return $result;
    }

    public static function getListWithSomeItems(int $number): ContentVoteList
    {
        $result = new ContentVoteList();

        for ($i = 0; $i < $number; $i++) {
            $result->addItem(self::getItem([]));
        }

        return $result;
    }

    public static function getEmptyList(): ContentVoteList
    {
        return self::getListWithSomeItems(0);
    }
}