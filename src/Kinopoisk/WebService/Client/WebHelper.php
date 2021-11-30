<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\Client;

class WebHelper
{
    public const HOST = 'https://www.kinopoisk.ru';

    public static function getUserVotesPageEndpoint(int $userId, int $page): string
    {
        return self::HOST . '/user/' . $userId . '/votes/list/ord/date/page/' . $page;
    }
}