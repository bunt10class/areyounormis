<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Mocks;

use DOMDocument;
use Kinopoisk\WebService\UserMoviesPageParser\CaptchaDetector;

class CaptchaDetectorMock extends CaptchaDetector
{
    protected bool $isCaptcha;

    public function __construct(bool $isCaptcha = false)
    {
        $this->isCaptcha = $isCaptcha;
    }

    public function isCaptcha(DOMDocument $dom): bool
    {
        return $this->isCaptcha;
    }
}