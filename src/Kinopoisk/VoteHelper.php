<?php

declare(strict_types=1);

namespace Kinopoisk;

class VoteHelper
{
    public const MAX_VOTE = 10;
    public const MIN_VOTE = 1;
    public const MAX_VOTES_DIFF = self::MAX_VOTE - self::MIN_VOTE;

    public static function isValidVote(mixed $vote): bool
    {
        if (!is_numeric($vote) || $vote < VoteHelper::MIN_VOTE || $vote > VoteHelper::MAX_VOTE) {
            return false;
        }

        return true;
    }
}