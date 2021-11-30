<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

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

    /**
     * @throws GuzzleException
     */
    public function getUserVotesByPage(int $userId, int $page): WebResponse
    {
        $response = $this->guzzleClient->request(
            'GET',
            WebHelper::getUserVotesPageEndpoint($userId, $page),
            [
                'headers' => $this->requestService->getHeaders(),
            ],
        );

        return $this->responseProcessor->process($response);
    }
}