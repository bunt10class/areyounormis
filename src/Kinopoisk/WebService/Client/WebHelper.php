<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\Client;

use Kinopoisk\KinopoiskHelper;

class WebHelper
{
    public const MAX_PER_PAGE = 200;

    public static function getUserVotesPageEndpoint(int $userId, int $page): string
    {
        return KinopoiskHelper::HOST . '/user/' . $userId . '/votes/list/ord/date/page/' . $page . '/perpage/' . self::MAX_PER_PAGE;
    }
}