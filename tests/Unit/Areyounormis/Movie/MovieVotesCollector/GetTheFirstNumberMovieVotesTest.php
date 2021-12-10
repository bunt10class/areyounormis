<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Movie\MovieVotesCollector;

use Areyounormis\Movie\MovieVotesCollector;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\MovieVoteFactory;

class GetTheFirstNumberMovieVotesTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_votes_collector
     */
    public function testGetSomeFirstNumber(): void
    {
        $ruName1 = 'ru_name1';
        $ruName2 = 'ru_name2';
        $movieVotes = MovieVoteFactory::getEmptyCollection();
        $movieVotes->addItem(MovieVoteFactory::getItem(['ru_name' => $ruName1]));
        $movieVotes->addItem(MovieVoteFactory::getItem(['ru_name' => $ruName2]));

        $result = MovieVotesCollector::getTheFirstNumberMovieVotes($movieVotes, $number = 2);

        self::assertCount($number, $result->getItems());
        self::assertEquals($ruName1, $result->getItems()[0]->getMovie()->getRuName());
        self::assertEquals($ruName2, $result->getItems()[1]->getMovie()->getRuName());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_votes_collector
     */
    public function testGetFromEmpty(): void
    {
        $movieVotes = MovieVoteFactory::getEmptyCollection();

        $result = MovieVotesCollector::getTheFirstNumberMovieVotes($movieVotes, 5);

        self::assertEmpty($result->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group movie
     * @group movie_votes_collector
     */
    public function testGetMoreNumberThanExist(): void
    {
        $movieVotes = MovieVoteFactory::getCollectionWithSomeItems($numberItems = 3);

        $result = MovieVotesCollector::getTheFirstNumberMovieVotes($movieVotes, 5);

        self::assertCount($numberItems, $result->getItems());
    }
}
