<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Service\Content\ContentVoteListFacade;

use Areyounormis\Service\Content\ContentVoteListFacade;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\ContentVoteFactory;

class CollectTheFirstNumberTest extends TestCase
{
    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_vote_list_collector
     */
    public function testWithSomeItems(): void
    {
        $ruName1 = 'ru_name1';
        $ruName2 = 'ru_name2';
        $list = ContentVoteFactory::getEmptyList();
        $list->addItem(ContentVoteFactory::getItem(['ru_name' => $ruName1]));
        $list->addItem(ContentVoteFactory::getItem(['ru_name' => $ruName2]));

        $result = ContentVoteListFacade::collectTheFirstNumber($list, $number = 2);

        self::assertCount($number, $result->getItems());
        self::assertEquals($ruName1, $result->getItems()[0]->getContent()->getRuName());
        self::assertEquals($ruName2, $result->getItems()[1]->getContent()->getRuName());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_vote_list_collector
     */
    public function testWithEmptyList(): void
    {
        $list = ContentVoteFactory::getEmptyList();

        $result = ContentVoteListFacade::collectTheFirstNumber($list, 5);

        self::assertEmpty($result->getItems());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group content
     * @group content_vote_list_collector
     */
    public function testWithMoreNumberThanExist(): void
    {
        $list = ContentVoteFactory::getListWithSomeItems($numberItems = 3);

        $result = ContentVoteListFacade::collectTheFirstNumber($list, 5);

        self::assertCount($numberItems, $result->getItems());
    }
}
