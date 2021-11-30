<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\Client;

class WebResponse
{
    private bool $isSuccess;
    private bool $isCaptcha;
    private string $content;

    public function __construct(bool $isSuccess, bool $isCaptcha, string $content)
    {
        $this->isSuccess = $isSuccess;
        $this->isCaptcha = $isCaptcha;
        $this->content = $content;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function isCaptcha(): bool
    {
        return $this->isCaptcha;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}