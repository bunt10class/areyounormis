<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Movie\MovieVotesCollector;

use Areyounormis\Movie\MovieVotesCollector;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\MovieVoteFactory;

class SortMovieVotesByNameTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_votes_collector
     */
    public function testWithEmptyMovieVotes(): void
    {
        $movieVotes = MovieVoteFactory::getEmptyCollection();

        $result = MovieVotesCollector::sortMovieVotesByMovieName($movieVotes);

        self::assertEmpty($result->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_votes_collector
     */
    public function testGetTheSameCount(): void
    {
        $movieVotes = MovieVoteFactory::getCollectionWithSomeItems($number = 3);

        $result = MovieVotesCollector::sortMovieVotesByMovieName($movieVotes);

        self::assertCount($number, $result->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_votes_collector
     */
    public function testSortAsc(): void
    {
        $movieVotes = MovieVoteFactory::getEmptyCollection();
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName1 = 'bbb',
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName2 = 'zzz',
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName3 = 'yyy',
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName4 = 'aaa',
        ]));

        $result = MovieVotesCollector::sortMovieVotesByMovieName($movieVotes, true);

        self::assertEquals($ruName4, $result->getItems()[0]->getMovie()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[1]->getMovie()->getRuName());
        self::assertEquals($ruName3, $result->getItems()[2]->getMovie()->getRuName());
        self::assertEquals($ruName2, $result->getItems()[3]->getMovie()->getRuName());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_votes_collector
     */
    public function testSortDesc(): void
    {
        $movieVotes = MovieVoteFactory::getEmptyCollection();
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName1 = 'bbb',
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName2 = 'zzz',
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName3 = 'yyy',
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName4 = 'aaa',
        ]));

        $result = MovieVotesCollector::sortMovieVotesByMovieName($movieVotes, false);

        self::assertEquals($ruName2, $result->getItems()[0]->getMovie()->getRuName());
        self::assertEquals($ruName3, $result->getItems()[1]->getMovie()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[2]->getMovie()->getRuName());
        self::assertEquals($ruName4, $result->getItems()[3]->getMovie()->getRuName());
    }
}
