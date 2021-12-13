<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Content\ContentVoteListFacade;

use Areyounormis\Service\Content\ContentVoteListFacade;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ContentVoteFactory;

class CollectTheFirstNumberMaxDiffTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_vote_list_collector
     */
    public function testWithSomeItems(): void
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
            'ru_name' => 'ru_name_3',
            'user_vote' => 5,
            'site_vote' => 5,
        ]));
        $list->addItem(ContentVoteFactory::getItem([
            'ru_name' => $ruName4 = 'ru_name_4',
            'user_vote' => 4,
            'site_vote' => 6,
        ]));

        $result = ContentVoteListFacade::collectTheFirstNumberMaxDiff($list, $number = 3);

        self::assertCount($number, $result->getItems());
        self::assertEquals($ruName2, $result->getItems()[0]->getContent()->getRuName());
        self::assertEquals($ruName1, $result->getItems()[1]->getContent()->getRuName());
        self::assertEquals($ruName4, $result->getItems()[2]->getContent()->getRuName());
    }
}
