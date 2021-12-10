<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Movie\MovieVotesCollector;

use Areyounormis\Movie\MovieVotesCollector;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\MovieVoteFactory;

class GetTheFirstNumberMaxDiffMovieVotesTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_votes_collector
     */
    public function testGetFromEmpty(): void
    {
        $movieVotes = MovieVoteFactory::getEmptyCollection();
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName1 = 'ru_name_1',
            'user_vote' => 7,
            'site_vote' => 2,
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName2 = 'ru_name_2',
            'user_vote' => 10,
            'site_vote' => 0,
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => 'ru_name_3',
            'user_vote' => 5,
            'site_vote' => 5,
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName4 = 'ru_name_4',
            'user_vote' => 4,
            'site_vote' => 6,
        ]));

        $result = MovieVotesCollector::getTheFirstNumberMaxDiffMovieVotes($movieVotes, $number = 3);

        self::assertCount($number, $result->getItems());
        self::assertEquals($ruName2, $result->getItems()[0]->getMovie()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[1]->getMovie()->getRuName());
        self::assertEquals($ruName4, $result->getItems()[2]->getMovie()->getRuName());
    }
}
