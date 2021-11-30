<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Mocks;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamInterface;

class ResponseGuzzleMock extends Response
{
    private int $statusCode;
    private string $content;

    public function __construct(int $statusCode, string $content)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): StreamInterface
    {
        return Utils::streamFor($this->content);
    }
}