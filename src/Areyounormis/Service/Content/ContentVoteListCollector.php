<?php

declare(strict_types=1);

namespace Areyounormis\Service\Content;

use Areyounormis\Domain\Content\ContentVote;
use Areyounormis\Domain\Content\ContentVoteList;

class ContentVoteListCollector
{
    public static function getTheFirstNumber(ContentVoteList $list, int $number): ContentVoteList
    {
        return new ContentVoteList(array_slice($list->getItems(), 0, $number));
    }

    public static function getTheFirstNumberMaxDiff(ContentVoteList $list, int $number): ContentVoteList
    {
        $list = self::sortByModuleRelativeDiff($list, false);

        return self::getTheFirstNumber($list, $number);
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
            $name1 = ContentCollector::getFullName($contentVote1->getContent());;
            $name2 = ContentCollector::getFullName($contentVote2->getContent());;

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