<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Report\MovieVotesCollector;

use Areyounormis\Report\MovieVotesCollector;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\MovieVoteFactory;

class SortMovieVotesByModuleRelativeDiffTest extends TestCase
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

        $result = MovieVotesCollector::sortMovieVotesByModuleRelativeDiff($movieVotes, true);

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

        $result = MovieVotesCollector::sortMovieVotesByModuleRelativeDiff($movieVotes, true);

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
            'ru_name' => $ruName3 = 'ru_name_3',
            'user_vote' => 5,
            'site_vote' => 5,
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName4 = 'ru_name_4',
            'user_vote' => 4,
            'site_vote' => 6,
        ]));

        $result = MovieVotesCollector::sortMovieVotesByModuleRelativeDiff($movieVotes, true);

        self::assertEquals($ruName3, $result->getItems()[0]->getMovie()->getRuName());
        self::assertEquals($ruName4, $result->getItems()[1]->getMovie()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[2]->getMovie()->getRuName());
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
            'ru_name' => $ruName3 = 'ru_name_3',
            'user_vote' => 5,
            'site_vote' => 5,
        ]));
        $movieVotes->addItem(MovieVoteFactory::getItem([
            'ru_name' => $ruName4 = 'ru_name_4',
            'user_vote' => 4,
            'site_vote' => 6,
        ]));

        $result = MovieVotesCollector::sortMovieVotesByModuleRelativeDiff($movieVotes, true);

        self::assertEquals($ruName2, $result->getItems()[3]->getMovie()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[2]->getMovie()->getRuName());
        self::assertEquals($ruName4, $result->getItems()[1]->getMovie()->getRuName());
        self::assertEquals($ruName3, $result->getItems()[0]->getMovie()->getRuName());
    }
}
