<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Content\ContentVoteListCollector;

use Areyounormis\Service\Content\ContentVoteListCollector;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ContentVoteFactory;

class SortMovieVotesByNameTest extends TestCase
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

        $result = ContentVoteListCollector::sortByContentName($list);

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

        $result = ContentVoteListCollector::sortByContentName($list);

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
            'ru_name' => $ruName1 = 'bbb',
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName2 = 'zzz',
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName3 = 'yyy',
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName4 = 'aaa',
        ]));

        $result = ContentVoteListCollector::sortByContentName($list, true);

        self::assertEquals($ruName4, $result->getItems()[0]->getContent()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[1]->getContent()->getRuName());
        self::assertEquals($ruName3, $result->getItems()[2]->getContent()->getRuName());
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
            'ru_name' => $ruName1 = 'bbb',
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName2 = 'zzz',
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName3 = 'yyy',
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName4 = 'aaa',
        ]));

        $result = ContentVoteListCollector::sortByContentName($list, false);

        self::assertEquals($ruName2, $result->getItems()[0]->getContent()->getRuName());
        self::assertEquals($ruName3, $result->getItems()[1]->getContent()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[2]->getContent()->getRuName());
        self::assertEquals($ruName4, $result->getItems()[3]->getContent()->getRuName());
    }
}
