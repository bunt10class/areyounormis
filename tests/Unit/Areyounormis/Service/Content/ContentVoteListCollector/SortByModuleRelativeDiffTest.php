<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Content\ContentVoteListCollector;

use Areyounormis\Service\Content\ContentVoteListCollector;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ContentVoteFactory;

class SortByModuleRelativeDiffTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_vote_list_collector
     */
    public function testWithEmptyMovieVotes(): void
    {
        $list = ContentVoteFactory::getEmptyList();

        $result = ContentVoteListCollector::sortByModuleRelativeDiff($list);

        self::assertEmpty($result->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_vote_list_collector
     */
    public function testGetTheSameCount(): void
    {
        $list = ContentVoteFactory::getListWithSomeItems($number = 3);

        $result = ContentVoteListCollector::sortByModuleRelativeDiff($list);

        self::assertCount($number, $result->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_vote_list_collector
     */
    public function testSortAsc(): void
    {
        $list = ContentVoteFactory::getEmptyList();
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName1 = 'ru_name_1',
            'user_vote' => 7,
            'site_vote' => 2,
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName2 = 'ru_name_2',
            'user_vote' => 10,
            'site_vote' => 0,
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName3 = 'ru_name_3',
            'user_vote' => 5,
            'site_vote' => 5,
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName4 = 'ru_name_4',
            'user_vote' => 4,
            'site_vote' => 6,
        ]));

        $result = ContentVoteListCollector::sortByModuleRelativeDiff($list, true);

        self::assertEquals($ruName3, $result->getItems()[0]->getContent()->getRuName());
        self::assertEquals($ruName4, $result->getItems()[1]->getContent()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[2]->getContent()->getRuName());
        self::assertEquals($ruName2, $result->getItems()[3]->getContent()->getRuName());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_vote_list_collector
     */
    public function testSortDesc(): void
    {
        $list = ContentVoteFactory::getEmptyList();
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName1 = 'ru_name_1',
            'user_vote' => 7,
            'site_vote' => 2,
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName2 = 'ru_name_2',
            'user_vote' => 10,
            'site_vote' => 0,
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName3 = 'ru_name_3',
            'user_vote' => 5,
            'site_vote' => 5,
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName4 = 'ru_name_4',
            'user_vote' => 4,
            'site_vote' => 6,
        ]));

        $result = ContentVoteListCollector::sortByModuleRelativeDiff($list, false);

        self::assertEquals($ruName2, $result->getItems()[0]->getContent()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[1]->getContent()->getRuName());
        self::assertEquals($ruName4, $result->getItems()[2]->getContent()->getRuName());
        self::assertEquals($ruName3, $result->getItems()[3]->getContent()->getRuName());
    }
}
