<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Mocks;

use Kinopoisk\WebService\Client\KinopoiskWebClient;
use Kinopoisk\WebService\Client\WebResponse;

class KinopoiskWebClientMock extends KinopoiskWebClient
{
    protected WebResponse $response;

    public function __construct(bool $isSuccess = true, bool $isCaptcha = false, string $content = '')
    {
        $this->response = new WebResponse($isSuccess, $isCaptcha, $content);
    }

    public function getUserVotesByPage(int $userId, int $page): WebResponse
    {
        return $this->response;
    }
}