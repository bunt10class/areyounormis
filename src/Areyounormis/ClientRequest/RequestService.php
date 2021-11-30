<?php

declare(strict_types=1);

namespace Areyounormis\ClientRequest;

use Areyounormis\ClientRequest\Parser\InvalidRequestInString;
use Areyounormis\ClientRequest\Parser\RequestParserInterface;
use Kinopoisk\WebService\Client\RequestServiceInterface;

class RequestService implements RequestServiceInterface
{
    protected RequestRedisRepository $requestRedisRepository;
    protected RequestParserInterface $requestParser;

    public function __construct(
        RequestRedisRepository $requestRepository,
        RequestParserInterface $requestParser
    ) {
        $this->requestRedisRepository = $requestRepository;
        $this->requestParser = $requestParser;
    }

    /**
     * @throws InvalidRequestInString
     */
    public function getHeaders(): array
    {
        $headers = $this->requestRedisRepository->getHeaders();

        if (is_null($headers)) {
            $headers = $this->parseRequest()->getHeaders();
            $this->requestRedisRepository->saveHeaders($headers);
        }

        return $headers;
    }

    /**
     * @throws InvalidRequestInString
     */
    protected function parseRequest(): RequestDto
    {
        $filePath = 'storage/app/kinopoisk_requests/curl_bash.txt';
        $contents = file_get_contents($filePath);

        return $this->requestParser->parse($contents);
    }
}