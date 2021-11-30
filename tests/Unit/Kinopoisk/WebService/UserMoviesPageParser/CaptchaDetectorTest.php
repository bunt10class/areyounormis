<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\WebService\UserMoviesPageParser;

use Kinopoisk\WebService\UserMoviesPageParser\CaptchaDetector;
use Tests\Unit\Kinopoisk\Factories\HtmlFactory;

class CaptchaDetectorTest extends ParserMain
{
    protected CaptchaDetector $classUnderTest;
    protected HtmlFactory $htmlFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new CaptchaDetector();
        $this->htmlFactory = new HtmlFactory();
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group captcha_detector
     */
    public function testIsCaptchaNotHtml(): void
    {
        $dom = $this->getDomDocument('not_html');

        $result = $this->classUnderTest->isCaptcha($dom);

        self::assertFalse($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group captcha_detector
     */
    public function testIsCaptchaWithoutCaptchaPresenceCriteria(): void
    {
        $dom = $this->getDomDocument('<div>some_value</div>');

        $result = $this->classUnderTest->isCaptcha($dom);

        self::assertFalse($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group captcha_detector
     */
    public function testIsCaptchaWithCaptchaPresenceCriteriaTitle(): void
    {
        $html = $this->htmlFactory->collectElement('title', [], 'Ой!');
        $dom = $this->getDomDocument($html);

        $result = $this->classUnderTest->isCaptcha($dom);

        self::assertTrue($result);
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group captcha_detector
     */
    public function testIsCaptchaWithCaptchaPresenceCriteriaScript(): void
    {
        $html = $this->htmlFactory->collectElement('script', ['src' => 'string_contain_captcha']);
        $dom = $this->getDomDocument($html);

        $result = $this->classUnderTest->isCaptcha($dom);

        self::assertTrue($result);
    }
}
