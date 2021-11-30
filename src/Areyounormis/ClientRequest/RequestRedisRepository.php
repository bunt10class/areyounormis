<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie\Models\ClientRequest;

use Predis\Client;

class RequestRedisRepository
{
    protected const HEADERS_KEY = 'request_headers';

    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getHeaders(): ?array
    {
        $result = $this->client->get(self::HEADERS_KEY);
        if (is_null($result)) {
            return null;
        }

        return (array)json_decode($result);
    }

    public function saveHeaders(array $headers): void
    {
        $this->client->set(self::HEADERS_KEY, json_encode($headers));
    }

    public function deleteHeaders(): void
    {
        $this->client->del(self::HEADERS_KEY);
    }
}