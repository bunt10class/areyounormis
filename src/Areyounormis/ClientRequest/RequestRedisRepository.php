<?php

declare(strict_types=1);

namespace Areyounormis\ClientRequest;

use Core\Config;
use Predis\Client;

class RequestRedisRepository
{
    protected const HEADERS_KEY = 'request_headers';

    protected Client $client;
    protected Config $config;

    public function __construct(
        Client $client,
        Config $config,
    ) {
        $this->client = $client;
        $this->config = $config;
    }

    public function getHeaders(): array
    {
        return $this->client->hGetAll(self::HEADERS_KEY);
    }

    public function saveHeaders(array $headers): void
    {
        $this->client->hmset(self::HEADERS_KEY, $headers);
        $this->client->expire(self::HEADERS_KEY, $this->config->get('report_storage_time'));
    }

    public function deleteHeaders(): void
    {
        $this->client->del(self::HEADERS_KEY);
    }
}