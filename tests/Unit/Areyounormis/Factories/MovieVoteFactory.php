<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

use Areyounormis\Movie\Movie;
use Areyounormis\Movie\MovieVote;
use Areyounormis\Movie\MovieVotes;

class MovieVoteFactory
{
    public static function getItem($data): MovieVote
    {
        $movie = new Movie(
            $data['ru_name'] ?? null,
            $data['en_name'] ?? null,
            $data['link'] ?? null,
        );

        $vote = VoteFactory::getTenZeroOneVote(
            $data['user_vote'] ?? 5,
            $data['site_vote'] ?? 5,
        );

        return new MovieVote($movie, $vote);
    }

    public static function getCollectionWithOneItem($data): MovieVotes
    {
        $result = self::getEmptyCollection();
        $result->addItem(self::getItem($data));
        return $result;
    }

    public static function getCollectionWithSomeItems(int $number): MovieVotes
    {
        $result = new MovieVotes();

        for ($i = 0; $i < $number; $i++) {
            $result->addItem(self::getItem([]));
        }

        return $result;
    }

    public static function getEmptyCollection(): MovieVotes
    {
        return self::getCollectionWithSomeItems(0);
    }
}