<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\WebService\Client;

use Faker\Factory;
use Faker\Generator;
use Kinopoisk\WebService\Client\WebResponseProcessor;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Kinopoisk\Mocks\ResponseGuzzleMock;

class KinopoiskResponseProcessorTest extends TestCase
{
    protected WebResponseProcessor $classUnderTest;
    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new WebResponseProcessor();
        $this->faker = Factory::create();
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group response_processor
     */
    public function testSuccessStringContentResponse(): void
    {
        $content = 'some_content';
        $response = new ResponseGuzzleMock(200, $content);

        $result = $this->classUnderTest->process($response);

        self::assertTrue($result->isSuccess());
        self::assertFalse($result->isCaptcha());
        self::assertEquals($content, $result->getContent());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group response_processor
     */
    public function testSuccessJsonObjectContentResponse(): void
    {
        $content = '{"field1":"value1", "field2":"value2"}';
        $response = new ResponseGuzzleMock(200, $content);

        $result = $this->classUnderTest->process($response);

        self::assertTrue($result->isSuccess());
        self::assertFalse($result->isCaptcha());
        self::assertEquals($content, $result->getContent());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group response_processor
     */
    public function testNotSuccessResponse(): void
    {
        $content = 'some_content';
        $statusCode = $this->faker->randomElement([
            $this->faker->numberBetween(0, 199),
            $this->faker->numberBetween(201, 599),
        ]);
        $response = new ResponseGuzzleMock($statusCode, $content);

        $result = $this->classUnderTest->process($response);

        self::assertFalse($result->isSuccess());
        self::assertFalse($result->isCaptcha());
        self::assertEquals($content, $result->getContent());
    }

    /**
     * @group unit
     * @group kinopoisk
     * @group response_processor
     */
    public function testCaptchaResponse(): void
    {
        $content = '{"type":"string_contain_captcha"}';
        $response = new ResponseGuzzleMock(200, $content);

        $result = $this->classUnderTest->process($response);

        self::assertTrue($result->isSuccess());
        self::assertTrue($result->isCaptcha());
        self::assertEquals($content, $result->getContent());
    }
}
