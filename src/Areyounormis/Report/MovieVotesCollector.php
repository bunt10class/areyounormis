<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Movie\MovieVote;
use Areyounormis\Movie\MovieVotes;

class MovieVotesCollector
{
    public static function getTheFirstNumberMaxDiffMovieVotes(MovieVotes $movieVotes, int $number): MovieVotes
    {
        $movieVotes = self::sortMovieVotesByModuleRelativeDiff($movieVotes, false);

        return self::getTheFirstNumberMovieVotes($movieVotes, $number);
    }

    public static function sortMovieVotesByModuleRelativeDiff(MovieVotes $movieVotes, bool $isAsc): MovieVotes
    {
        $movieVotes = $movieVotes->getItems();

        usort($movieVotes, function (MovieVote $movieVote1, MovieVote $movieVote2) use ($isAsc) {
            $diff1 = $movieVote1->getVote()->getModuleRelativeDiff();
            $diff2 = $movieVote2->getVote()->getModuleRelativeDiff();

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

        return new MovieVotes($movieVotes);
    }

    public static function getTheFirstNumberMovieVotes(MovieVotes $movieVotes, int $number): MovieVotes
    {
        return new MovieVotes(array_slice($movieVotes->getItems(), 0, $number));
    }
}