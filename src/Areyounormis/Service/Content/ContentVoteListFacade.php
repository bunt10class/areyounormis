<?php

declare(strict_types=1);

namespace Areyounormis\Service\Content;

use Areyounormis\Domain\Content\ContentVote;
use Areyounormis\Domain\Content\ContentVoteList;

class ContentVoteListFacade
{
    public static function collectTheFirstNumber(ContentVoteList $list, int $number): ContentVoteList
    {
        return new ContentVoteList(array_slice($list->getItems(), 0, $number));
    }

    public static function collectTheFirstNumberMaxDiff(ContentVoteList $list, int $number): ContentVoteList
    {
        $list = self::sortByModuleRelativeDiff($list, false);

        return self::collectTheFirstNumber($list, $number);
    }

    public static function sortByModuleRelativeDiff(ContentVoteList $list, bool $isAsc = true): ContentVoteList
    {
        $list = $list->getItems();

        usort($list, function (ContentVote $contentVote1, ContentVote $contentVote2) use ($isAsc) {
            $diff1 = $contentVote1->getVote()->getModuleRelativeDiff();
            $diff2 = $contentVote2->getVote()->getModuleRelativeDiff();

            if ($diff1 === $diff2) {
                return 0;
            }

            $is1LessThan2 = $diff1 < $diff2;
            if ($isAsc) {
                return $is1LessThan2 ? -1 : 1;
            } else {
                return $is1LessThan2 ? 1 : -1;
            }
        });

        return new ContentVoteList($list);
    }

    public static function sortByContentName(ContentVoteList $list, bool $isAsc = true): ContentVoteList
    {
        $list = $list->getItems();

        usort($list, function (ContentVote $contentVote1, ContentVote $contentVote2) use ($isAsc) {
            $name1 = ContentFacade::collectFullName($contentVote1->getContent());;
            $name2 = ContentFacade::collectFullName($contentVote2->getContent());;

            $result = strnatcasecmp($name1, $name2);
            if ($isAsc) {
                return $result;
            } else {
                return $result * -1;
            }
        });

        return new ContentVoteList($list);
    }
}