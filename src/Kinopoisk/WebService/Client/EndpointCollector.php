<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\Client;

use Kinopoisk\Helpers\KinopoiskHelper;

class EndpointCollector
{
    public static function collectUserVotesPage(int $userId, int $page): string
    {
        return KinopoiskHelper::HOST . '/user/' . $userId . '/votes/list/ord/date/page/' . $page . '/perpage/' . KinopoiskHelper::MAX_MOVIES_PER_PAGE;
    }
}