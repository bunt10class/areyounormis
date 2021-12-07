<?php

declare(strict_types=1);

namespace Areyounormis\ClientRequest\Parser;

use Areyounormis\ClientRequest\RequestDto;

class CurlBashRequestParser implements RequestParserInterface
{
    /**
     * @throws InvalidRequestInString
     */
    public function parse(string $parsedString): RequestDto
    {
        //todo обработка пустой строки
        $endpoint = $this->retrieveEndpoint($parsedString);
        $headers = $this->retrieveHeaders($parsedString);

        return new RequestDto($endpoint, $headers);
    }

    /**
     * @throws InvalidRequestInString
     */
    protected function retrieveEndpoint(string &$parsedString): string
    {
        $quotationMarkPos = $this->findSymbolPosFromStartOrFail($parsedString, RequestParserHelper::QUOTATION_MARK);
        $parsedString = substr($parsedString, $quotationMarkPos + 1);

        $quotationMarkPos = $this->findSymbolPosFromStartOrFail($parsedString, RequestParserHelper::QUOTATION_MARK);
        $endpoint = substr($parsedString, 0, $quotationMarkPos);

        $parsedString = substr($parsedString, $quotationMarkPos + 1);

        return $endpoint;
    }

    /**
     * @throws InvalidRequestInString
     */
    protected function findSymbolPosFromStartOrFail(string $haystack, string $symbol): int
    {
        $symbolPos = strpos($haystack, $symbol);
        if ($symbolPos === false) {
            throw new InvalidRequestInString();
        }
        return $symbolPos;
    }

    /**
     * @throws InvalidRequestInString
     */
    protected function retrieveHeaders(string $parsedString): array
    {
        $headers = [];

        while (true) {
            if (!$this->isThereNextHeader($parsedString)) {
                break;
            }

            [$key, $value] = $this->retrieveHeader($parsedString);
            $headers[$key] = $value;
        }

        return $headers;
    }

    protected function isThereNextHeader(string $parsedString): bool
    {
        try {
            $this->findSymbolPosFromStartOrFail($parsedString, RequestParserHelper::QUOTATION_MARK);
            return true;
        } catch (InvalidRequestInString $exception) {
            return false;
        }
    }

    /**
     * @throws InvalidRequestInString
     */
    protected function retrieveHeader(string &$parsedString): array
    {
        $quotationMarkPos = $this->findSymbolPosFromStartOrFail($parsedString, RequestParserHelper::QUOTATION_MARK);
        $parsedString = substr($parsedString, $quotationMarkPos + 1);

        $colonPos = $this->findSymbolPosFromStartOrFail($parsedString, RequestParserHelper::COLON);
        $key = substr($parsedString, 0, $colonPos);

        $quotationMarkPos = $this->findSymbolPosFromStartOrFail($parsedString, RequestParserHelper::QUOTATION_MARK);
        $value = substr($parsedString, $colonPos + 2, $quotationMarkPos - ($colonPos + 2));

        $parsedString = substr($parsedString, $quotationMarkPos + 1);

        return [$key, $value];
    }
}