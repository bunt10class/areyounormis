<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class KinopoiskWebClient
{
    protected GuzzleClient $guzzleClient;
    protected RequestServiceInterface $requestService;
    protected WebResponseProcessor $responseProcessor;

    public function __construct(
        GuzzleClient $guzzleClient,
        RequestServiceInterface $requestService,
        WebResponseProcessor $responseProcessor,
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->requestService = $requestService;
        $this->responseProcessor = $responseProcessor;
    }

    public function getUserVotesByPage(int $userId, int $page): WebResponse
    {
        $response = $this->sendRequest(
            'GET',
            EndpointCollector::collectUserVotesPage($userId, $page),
            [
                'headers' => $this->requestService->getHeaders(),
            ],
        );

        return $this->responseProcessor->process($response);
    }

    protected function sendRequest($method, $uri, $options): ?ResponseInterface
    {
        try {
            return $this->guzzleClient->request($method, $uri, $options);
        } catch (ClientException $exception) {
            //todo process, log
            return null;
        }
    }
}