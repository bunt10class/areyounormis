<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\ClientRequest\Parser;

use Areyounormis\ClientRequest\Parser\CurlBashRequestParser;
use Areyounormis\ClientRequest\Parser\InvalidRequestInString;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Factories\CurlBashRequestFactory;

class CurlBashRequestParserTest extends TestCase
{
    protected CurlBashRequestParser $classUnderTest;
    protected CurlBashRequestFactory $curlBashRequestFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new CurlBashRequestParser();
        $this->curlBashRequestFactory = new CurlBashRequestFactory();
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group curl_bash_request_parser
     */
    public function testParseEmptyString(): void
    {
        self::expectException(InvalidRequestInString::class);

        $this->classUnderTest->parse('');
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group curl_bash_request_parser
     */
    public function testParseStringWithoutAnyQuotationMark(): void
    {
        self::expectException(InvalidRequestInString::class);

        $string = $this->curlBashRequestFactory->getInvalidWithoutAnyQuotationMark();

        $this->classUnderTest->parse($string);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group curl_bash_request_parser
     */
    public function testParseStringWithoutEndpointClosedQuotationMark(): void
    {
        self::expectException(InvalidRequestInString::class);

        $string = $this->curlBashRequestFactory->getInvalidWithoutEndpointClosedQuotationMark();

        $this->classUnderTest->parse($string);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group curl_bash_request_parser
     */
    public function testParseEmptyHeaders(): void
    {
        $endpoint = 'some_endpoint';
        $string = $this->curlBashRequestFactory->getValid($endpoint, []);

        $result = $this->classUnderTest->parse($string);

        self::assertEquals($endpoint, $result->getEndpoint());
        self::assertEmpty($result->getHeaders());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group curl_bash_request_parser
     */
    public function testParseStringWithoutHeaderColon(): void
    {
        self::expectException(InvalidRequestInString::class);

        $string = $this->curlBashRequestFactory->getInvalidWithoutHeaderColon();

        $this->classUnderTest->parse($string);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group curl_bash_request_parser
     */
    public function testParseStringWithoutHeaderClosedQuotationMark(): void
    {
        self::expectException(InvalidRequestInString::class);

        $string = $this->curlBashRequestFactory->getInvalidWithoutHeaderClosedQuotationMark();

        $this->classUnderTest->parse($string);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group curl_bash_request_parser
     */
    public function testParseValidString(): void
    {
        $endpoint = 'some_endpoint';
        $headers = [
            'header1' => 'value1',
            'header2' => 'value2',
            'header3' => 'value3',
        ];
        $string = $this->curlBashRequestFactory->getValid($endpoint, $headers);

        $result = $this->classUnderTest->parse($string);

        self::assertEquals($endpoint, $result->getEndpoint());
        self::assertEquals($headers, $result->getHeaders());
    }
}